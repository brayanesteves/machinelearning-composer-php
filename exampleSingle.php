<?php
    require "vendor/autoload.php";

    function calculatePrice($size, $numberOfRoom) {
        $basePrice = 1000;
        $price     = $size * $basePrice;
        $price     = $price * ($numberOfRoom / 10);
        return $price;
    }
?>