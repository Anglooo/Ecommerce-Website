<!DOCTYPE html>
<html>

<?php
include 'common.php';
include 'phpConnect.php';



if(empty($_SESSION['user']))
{
    $loc = "index.php?error=notLoggedInCheckout";
    header("Location: ".$loc);

    die("Redirecting to index.php");
}


if(isset($_SESSION['recentViewed'])){

}else{
  $_SESSION['recentViewed'] = array();
}

if(isset($_POST['updateQuan'])){
  $_SESSION['updateQuan'];
}

$basketTotalQuantity = 0;

$referer = 'checkout.php';

if(isset($_POST['prevPage'])){
  $prevPage = $_POST['prevPage'];
}

if(isset($_SESSION['cart'])){

  $basketTotalQuantity = count($_SESSION['cart']);

}




?>

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Ecommerce: Checkout</title>

  <!--Bootstrap Files-->
  <link href = "css/bootstrap.min.css" rel = "stylesheet">
  <script src = "http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src = "js/bootstrap.js"></script>



  <!--Other Files-->
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">


  <!--My Loading Scripts-->


  <!--My External Scripts-->

  <link href = "css/Styles.css" rel = "stylesheet">

</head>

<?php include "navbar.php" ?>



<div class="container">

  <div class = "row">

      <div class = "col-lg-2">

      </div>

      <div class = "col-lg-8">

        <div class = "panel panel-default">

          <div class = "panel-heading">

            <h1>Confirm your order</h1>

          </div>


            <?php

            if(isset($_SESSION['cart'])){

              $maxBasket = count($_SESSION['cart']);
              $i = 0;

              if($maxBasket != 0){
                //echo '<div class = "panel-body">';

                echo '<table class = "table">';

                echo '<tr>';

                  echo '<th class = "text-center">';

                    echo '';

                  echo '</th>';

                  echo '<th class = "text-center">';

                    echo 'Team';

                  echo '</th>';

                  echo '<th class = "text-center">';

                    echo 'Home/Away';

                  echo '</th>';

                  echo '<th class = "text-center">';

                    echo 'Size';

                  echo '</th>';

                  echo '<th class = "text-center">';

                    echo 'Quantity';

                  echo '</th>';

                  echo '<th class = "text-center">';

                    echo 'Price';

                  echo '</th>';

                echo '</tr>';

                while($i < $maxBasket){

                  $basketID = $_SESSION['cart'][$i]['prodID'];
                  $basketSize = $_SESSION['cart'][$i]['size'];

                  $sqlBasket = "SELECT ID, Name, homeAway,price FROM Products WHERE ID = $basketID";
                  $resultBasket = $conn->query($sqlBasket);

                  $rowBasket = $resultBasket->fetch_assoc();

                  echo '<tr>';

                    echo '<td class = "text-center">';

                      echo '<img src="/Ecommerce/images/'.$rowBasket["ID"].'.jpg" width = "100">';

                    echo '</td>';
                    echo '<td class = "text-center">';

                      echo '<a href="productPage.php?id='.$rowBasket["ID"].'" id=prodName'.$i.'>'.$rowBasket["Name"].'</a>';

                    echo '</td>';
                    echo '<td class = "text-center">';

                      echo $rowBasket["homeAway"];

                    echo '</td>';

                    echo '<td class = "text-center">';

                      echo $basketSize;

                    echo '</td>';

                    echo '<td class = "text-center">';

                      echo $_SESSION['cart'][$i]['quantity'];

                    echo '</td>';

                    echo '<td class = "text-center">';

                      $rowPrice = $rowBasket["price"] * $_SESSION['cart'][$i]['quantity'];

                      echo "£".$rowPrice;

                    echo '</td>';



                  echo '</tr>';

                  $i++;

                }

                echo '<tr>';

                  echo '<td>';
                    echo '<h4>Total Items: '.$totalQuantity.'<h4>';
                    echo '<h4>Total Price: £'.$totalPrice.' <h4>';

                  echo '</td>';

                  echo '<td>';

                    echo '<br>';
                    echo '<a href="shoppingBasket.php?id=empty" class="btn btn-default">Confirm Basket</a>';

                  echo '</td>';

                  echo '<td/>';
                  echo '<td/>';
                  echo '<td/>';
                  echo '<td/>';

                  echo '</tr>';

                echo '</table>';


              }else{
                echo '<div class = "panel-body">';

                  echo '<p>';

                    echo 'There is nothing in your basket. Please add items to the basket.';

                  echo '</p>';

                echo '</div>';
              }

            }?>

          </div>

        </div>

      </div>
</div>

<footer class="text-center"><hr>
    © MyeCommerceSite 2015 &nbsp; | &nbsp;
    <a href="/index.html">Terms &amp; Conditions</a> &nbsp; | &nbsp;
    <a href="/index.html">Privacy Policy</a> &nbsp; | &nbsp;
    <a href="/index.html">Cookie Policy</a> &nbsp; | &nbsp;
    <a href="/index.html">Help</a>
  </br>
</footer>

<script type="text/javascript">
$('.dropdown-menu')find('form').click(function(e) {
  e.stopPropagation();
  windows.alert("running");
});
</script>

</body></html>
