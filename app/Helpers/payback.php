<?php

function finalPayback()
{
    try {
        $result = "";
        $conn = new mysqli("127.0.0.1", "hamsodco_root", "12Root34", "hamsodco_hamdsod", 3306);

        // Check connection
        if ($conn->connect_error)
            die("Connection failed: " . $conn->connect_error);

        if ($conn) {
            $orders = "";
            $notToUpdate = "";
            $products = $conn->query("SELECT * FROM available_products WHERE is_active=1;") or die($conn->error);
            while ($product = $products->fetch_assoc()) {
                $productId = $product["id"];
                $realPrice = $product["price"];
                if ($productId > 0 && $realPrice > 0) {
                    $maximumMembers = $product["maximum_group_members"];
                    $totalBuyers = 0;
                    $maxDiscount = 0;
                    $lastDiscount = 0;

                    $orderItems = $conn->query("SELECT MAX(order_items.nth_buyer) AS total_buyers FROM order_items,orders WHERE order_items.order_id=orders.id AND orders.status=1 AND order_items.available_product_id=$productId;") or die($conn->error);
                    while ($orderItem = $orderItems->fetch_assoc()) {
                        $totalBuyers = $orderItem['total_buyers'] > 0 ? $orderItem['total_buyers'] : 0;
                    }

                    if ($totalBuyers > 0) {
                        $numberOfCompletedGroups = intdiv($totalBuyers, $maximumMembers);
                        $discounts = $conn->query("SELECT MAX(CONVERT(discount,DECIMAL)) AS max_discount FROM available_product_details WHERE available_product_id=$productId") or die($conn->error);
                        while ($row = $discounts->fetch_assoc()) {
                            $maxDiscount = $row['max_discount'];
                        }

                        $level = $totalBuyers - ($numberOfCompletedGroups * $maximumMembers) - 1;
                        $discounts = $conn->query("SELECT CONVERT(discount,DECIMAL) AS discount FROM available_product_details WHERE available_product_id=$productId AND level=$level") or die($conn->error);
                        while ($row = $discounts->fetch_assoc()) {
                            $lastDiscount = $row['discount'];
                        }

                        $x = $numberOfCompletedGroups * $maximumMembers;

                        $max_discount_amount = ($maxDiscount * $realPrice) / 100;
                        $sql = "UPDATE order_items SET extra_discount=($max_discount_amount-discount)*weight WHERE available_product_id=$productId AND nth_buyer <= $x";
                        $update = $conn->query($sql) or die($conn->error);

                        $last_discount_amount = ($lastDiscount * $realPrice) / 100;
                        $sql = "UPDATE order_items SET extra_discount=($last_discount_amount-discount)*weight WHERE available_product_id=$productId AND nth_buyer > $x";
                        $update = $conn->query($sql) or die($conn->error);

                        // select order ids of this product
                        $orderIds = $conn->query("SELECT DISTINCT orders.id FROM orders,order_items WHERE orders.id=order_items.order_id AND orders.status=1 AND order_items.available_product_id=$productId") or die($conn->error);
                        while ($row = $orderIds->fetch_assoc()) {
                            $orders .= ($row['id'] . ',');
                        }

                        $sql = $conn->query("SELECT DISTINCT orders.id FROM orders,order_items WHERE orders.id=order_items.order_id AND orders.status<>1 AND order_items.available_product_id=$productId") or die($conn->error);
                        while ($row = $sql->fetch_assoc()) {
                            $notToUpdate .= ($row['id'] . ',');
                        }
                    }
                }
            }
            $orders = substr($orders, 0, strlen($orders) - 1);
            $notToUpdate = substr($notToUpdate, 0, strlen($notToUpdate) - 1);
            // $result .= ($orders . "   " . $notToUpdate . "   ");
            if (strlen($orders) > 0) {
                $conn->query("UPDATE orders SET status=11 WHERE id IN($orders)") or die($conn->error);

                // INSERT INTO NOTIFICATIONS AND TRANSACTIONS
                $customersOrderArray = [];
                $sql = $conn->query("SELECT CONCAT(id,'-',customer_id) AS customer_order FROM orders WHERE id IN($orders)") or die($conn->error);
                while ($row = $sql->fetch_assoc()) {
                    $customerOrderId = $row['customer_order'];
                    if(!in_array($customerOrderId,$customersOrderArray,true))
                        array_push($customersOrderArray,$customerOrderId);
                }

                for($i=0;$i<count($customersOrderArray);$i++) {
                    $sumExtraDiscount = 0;
                    $item = explode('-', $customersOrderArray[$i]);
                    $orderId = $item[0];
                    $customerId = $item[1];
                    $sql = $conn->query("SELECT SUM(extra_discount) as sum_extra_discount FROM order_items WHERE order_id=$orderId") or die($conn->error);
                    while ($row = $sql->fetch_assoc()) {
                        $sumExtraDiscount = $row['sum_extra_discount'];
                    }

                    if($sumExtraDiscount > 0) {
                        // INSERT INTO TRANSACTIONS
                        // $trTitle = "برگشت به کیف پول بابت تسویه حساب سفارش شماره $orderId";
                        $insert = $conn->query("INSERT INTO transactions(customer_id,transaction_sign,transaction_type,title,amount,tr_status) VALUES($customerId,1,4,$orderId,$sumExtraDiscount,1);") or die($conn->error);
                        $update = $conn->query("UPDATE customers SET balance=balance+$sumExtraDiscount WHERE id=$customerId;") or die($conn->error);

                        // INSERT INTO NOTIFICATIONS
                        // $notifTitle = "تسویه حساب";
                        // $notifText = "تسویه حساب نهایی انجام شد و مبلغ $sumExtraDiscount به کیف پول شما برگشت داده شد.";
                        $insert = $conn->query("INSERT INTO notifications(customer_id,notification_text,notification_type,save_inbox) VALUES($customerId,$sumExtraDiscount,1,1);") or die($conn->error);
                    }
                }
            }
            if (strlen($notToUpdate) > 0) {
                $conn->query("UPDATE order_items SET extra_discount=NULL,nth_buyer=NULL WHERE order_id IN($notToUpdate)");
            }
        }
        return "$result payback successful";
    } catch (Exception $exception) {
        return $exception->getLine() . ": " . $exception->getMessage();
    }
}
