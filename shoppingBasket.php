<?php
include 'common.php';
include 'phpConnect.php';

switch($_GET['id']){

  case "buy":
    header("Location: checkout.php");
    die();
    break;

  case "empty":
    unset($_SESSION['cart']);
    echo 'remove all items';
    header("Location: index.php?error=saleConfirmed");
    break;

  case "updateQuantity":
    echo "loaded Page";


    $indexToUpdate = $_POST['indexUpdate'];
    $quantity = $_POST['quantity'];
    $prevPage = $_POST['prevPage'];

    if($quantity < 0){
      header("Location:".$prevPage);
      break;
    }

    if($quantity == 0){

      unset($_SESSION['cart'][$indexToUpdate]);
      $_SESSION['cart'] = array_values($_SESSION['cart']);

      header("Location:".$prevPage);
      break;
    }


    $_SESSION['cart'][$indexToUpdate]['quantity'] = $quantity;

    echo $_SESSION['cart'][$indexToUpdate]['quantity'];



    header("Location:".$prevPage);
    break;

  case "deleteItem":
    $indexToUpdate = $_POST['indexUpdate'];
    $prevPage = $_POST['prevPage'];

    unset($_SESSION['cart'][$indexToUpdate]);
    $_SESSION['cart'] = array_values($_SESSION['cart']);

    header("Location:".$prevPage);


    break;
}

?>
