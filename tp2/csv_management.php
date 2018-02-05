<?php

function saveData(array $lineToSave, $filename) {
    $f = fopen($filename, "a");
    fputcsv($f, array_values($lineToSave), ";");
    fclose($f);
}

function findData($filename): array {
    $f = fopen($filename, "r");
    $keys = ['name', 'price', 'quantity', 'img_path'];
    $all = [];
    $line = fgetcsv($f, 0, ";");
    while ($line != null) {
        $all[] = array_combine($keys, $line);
        $line = fgetcsv($f, 0, ";");
    }
    return $all;
}

function canSell($productName, $data) {
    foreach ($data as $product) {
        if ($product['name'] == $productName) {
            return $product['quantity'] > 0;
        }
    }
    return false;
}

function sellProduct($productName, $data) {
    foreach ($data as &$product) {
        if ($product['name'] == $productName) {
            $product['quantity']--;
        }
    }
    return $data;
}

function replaceData($data, $fileName) {
    $f = fopen($fileName, 'w');
    ftruncate($f, 0);
    fclose($f);
    foreach($data as $d) {
        saveData($d, $fileName);
    }
}