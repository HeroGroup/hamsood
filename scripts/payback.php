<?php

try {
    echo "script started...".PHP_EOL;
    $conn = new mysqli("127.0.0.1", "root", "root", "hamsod", 8889);

    // Check connection
    if ($conn->connect_error)
        die("Connection failed: " . $conn->connect_error);

    if ($conn) {
        $products = $conn->query("SELECT * FROM available_products WHERE is_active=1;");
        while($product = $products->fetch_assoc()) {
            $productId = $product["id"];
            $realPrice = $product["price"];
            $maximumMembers = $product["maximum_group_members"];
            $totalBuyers = 0;
            $maxDiscount = 0;
            $lastDiscount = 0;

            $orderItems = $conn->query("SELECT MAX(order_items.nth_buyer) AS total_buyers FROM order_items,orders WHERE order_items.order_id=orders.id AND orders.status=1 AND order_items.available_product_id=$productId;") or die($conn->error);
            while($orderItem = $orderItems->fetch_assoc()) {
                $totalBuyers = $orderItem['total_buyers'];
            }

            $numberOfCompletedGroups = intdiv($totalBuyers,$maximumMembers);
            $discounts = $conn->query("SELECT MAX(`discount`) AS max_discount FROM `available_product_details` WHERE `available_product_id`=$productId");
            while($discount = $discounts->fetch_assoc()) {
                $maxDiscount = $discount['max_discount'];
            }

            $level = $totalBuyers - ($numberOfCompletedGroups*$maximumMembers);
            $discounts = $conn->query("SELECT `discount` FROM `available_product_details` WHERE `available_product_id`=$productId AND `level`=$level");
            while($discount = $discounts->fetch_assoc()) {
                $lastDiscount = $discount['discount'];
            }

            $x = $numberOfCompletedGroups*$maximumMembers;

            $max_discount_amount = ($maxDiscount*$real_price);
            $sql = "UPDATE `order_items` SET `extra_discount`=$max_discount_amount-`discount` WHERE `available_product_id`=$productId AND `nth_buyer` <= $x";
            echo $sql.PHP_EOL; // $update = $conn->query(sql);

            $last_discount_amount = ($lastDiscount*$real_price);
            $sql = "UPDATE `order_items` SET `extra_discount`=$last_discount_amount-`discount` WHERE `available_product_id`=$productId AND `nth_buyer` > $x";
            echo $sql.PHP_EOL; // $update = $conn->query(sql);
        }

    }
} catch (Exception $exception) { // log exception
    echo $exception->getMessage().PHP_EOL;
}
