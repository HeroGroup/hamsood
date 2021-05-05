<?php

function finalPayback()
{
    try {
        $conn = new mysqli("127.0.0.1", "root", "", "hamsod");

        // Check connection
        if ($conn->connect_error)
            die("Connection failed: " . $conn->connect_error);

        if ($conn) {
            $orders = "";
            $products = $conn->query("SELECT * FROM available_products WHERE is_active=1;");
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

                        $level = $totalBuyers - ($numberOfCompletedGroups * $maximumMembers);
                        $discounts = $conn->query("SELECT CONVERT(discount,DECIMAL) AS discount FROM available_product_details WHERE available_product_id=$productId AND level=$level") or die($conn->error);
                        while ($row = $discounts->fetch_assoc()) {
                            $lastDiscount = $row['discount'];
                        }

                        $x = $numberOfCompletedGroups * $maximumMembers;

                        $max_discount_amount = ($maxDiscount * $realPrice) / 100;
                        $sql = "UPDATE order_items SET extra_discount=$max_discount_amount-discount WHERE available_product_id=$productId AND nth_buyer <= $x";
                        $update = $conn->query($sql) or die($conn->error);

                        $last_discount_amount = ($lastDiscount * $realPrice) / 100;
                        $sql = "UPDATE order_items SET extra_discount=$last_discount_amount-discount WHERE available_product_id=$productId AND nth_buyer > $x";
                        $update = $conn->query($sql) or die($conn->error);

                        // select order ids of this product
                        $orderIds = $conn->query("SELECT orders.id FROM orders,order_items WHERE orders.id=order_items.order_id AND order_items.available_product_id=$productId") or die($conn->error);
                        while ($row = $orderIds->fetch_assoc()) {
                            $orders .= ($row['id'] . ',');
                        }
                    }
                }
            }
            $orders = substr($orders, 0, strlen($orders) - 1);
            if (strlen($orders) > 0)
                $conn->query("UPDATE orders SET status=2 WHERE id IN ($orders)") or die($conn->error);
        }
    } catch (Exception $exception) { // log exception
        echo $exception->getMessage() . PHP_EOL;
    }
}
