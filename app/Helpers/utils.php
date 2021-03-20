<?php

function generateUID() {
    $seed = str_split('abcdefghijklmnopqrstuvwxyz'.'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.'0123456789');
    shuffle($seed);
    foreach (array_rand($seed, 5) as $k)
        $rand .= $seed[$k];

    return $rand;
}
