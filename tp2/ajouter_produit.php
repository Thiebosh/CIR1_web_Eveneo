<?php
include('csv_management.php'); // include model
function handleProductImage() {
    if(!empty($_FILES['image'])) {
       if($_FILES['image']['error'] != UPLOAD_ERR_OK) {
           return "";
       }
       $exts = ['png', 'gif', 'jpg', 'jpeg', 'svg'];
       if (!in_array(strtolower(pathinfo($_FILES['image']['name'])['extension']), $exts)) {
           return "";
       }
       $id = sha1(file_get_contents($_FILES['image']['tmp_name']));
       $path = './images/'. $id . "." . pathinfo($_FILES['image']['name'])['extension'];
       move_uploaded_file($_FILES['image']['tmp_name'], $path);
       return $path;
    }
    return '';
}
function handleFormErrors(): array {
    $errors = [];
    if (isset($_FILES['image']) && $_FILES['image']['error'] != UPLOAD_ERR_OK) {
        $errors['image'] = 'Erreur durant le téléchargement';
    }
    $nameError = getNameResult()['error'];
    if($nameError) {
        $errors['name'] = $nameError;
    }
    $quantityError = getQuantityResult()['error'];
    if($nameError) {
        $errors['quantity'] = $quantityError;
    }
    $priceError = getPriceResult()['error'];
    if($nameError) {
        $errors['price'] = $priceError;
    }
    if(!isset($_POST['price'], $_POST['quantity'], $_POST['name'])){
        $errors['missing'] = "element";  // we mark that we miss an element but do not report it on html
    }
    return $errors;
}

function getNameResult(): array {
    if(!isset($_POST['name'])) {
        return ['result' => '', 'error' => ''];
    }
    $ok = filter_input(INPUT_POST, 'name', FILTER_CALLBACK, ['options' => 'ctype_alnum']);
    if (!$ok) {
        return ['result' => '', 'error' => 'Le nom n\'est pas correct'];
    }
    return ['result' => $_POST['name'], 'error' => null];
}

function getPriceResult(): array {
    if(!isset($_POST['price'])) {
        return ['result' => '', 'error' => ''];
    }
    $ok = filter_input(INPUT_POST, 'price', FILTER_CALLBACK, ['options' => function($data) {
        return floatval($data) > 0.0 && (strpos($data, '.') == -1 || strlen(explode('.', $data)[1]) <= 2);
    }]);
    if (!$ok) {
        return ['result' => '', 'error' => 'Le prix n\'est pas correct'];
    }
    return ['result' => $_POST['price'], 'error' => null];
}

function getQuantityResult(): array {
    if(!isset($_POST['price'])) {
        return ['result' => '', 'error' => ''];
    }
    $ok = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
    
    if (!$ok || $_POST['quantity'] <= 0) {
        return ['result' => '', 'error' => 'La quantité n\'est pas correcte'];
    }
    return ['result' => $_POST['quantity'], 'error' => null];
}

$errors = handleFormErrors();
if(empty($errors)) {
    $path = handleProductImage();
    $name = getNameResult()['result'];
    $price = getPriceResult()['result'];
    $quantity = getQuantityResult()['result'];
    saveData(['name' => $name, 'price' => $price, 'quantity' => $quantity, 'img_path' => $path], 'save.csv');
}
$csrf = md5(time());
$_SESSION['csrf'] = $csrf;
include('form_ajout_produit.html');