<!DOCTYPE html>
<html>

<?php
include 'common.php';
include 'phpConnect.php';



if(isset($_SESSION['recentViewed'])){

}else{
  $_SESSION['recentViewed'] = array();
}

if(isset($_POST['updateQuan'])){
  $_SESSION['updateQuan'];
}

$basketTotalQuantity = 0;

$referer = 'index.php';

if(isset($_SESSION['cart'])){

  $basketTotalQuantity = count($_SESSION['cart']);

}


?>

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Ecommerce</title>

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

  <?php include 'navbar.php'; ?>

  <div class="jumbotron">
    <h1>Your Football Shirts</h1>
  	<div class="row">
      <div class="col-sm-4">&nbsp;</div>
      <div class="col-sm-8"><p class="text-right">Our online football shop sells the latest official football kits and training merchandise from around the world. We stock the new home and away football shirts from all the leading club and international teams including Barcelona, Real Madrid, Arsenal, Chelsea, Manchester United, Man City, Liverpool, Tottenham, AC Milan, Juventus, Spain, Brazil, England, Scotland, Holland, Germany and more.</p>

            <p class="text-right">We stock only official, licensed products from the leading brands including Nike, Adidas, Puma, Umbro, Kappa, Lotto, Under Armour, Warrior Sports, Legea, Hummel, Errea, Macron and many more.</p>
    </div>
        </div>
      </div>

    <div class="col-md-8">
      <div class = "panel panel-default">
        <div class = "panel-heading">
            <h2>Offers <span class = "label label-info">New!</span></h2>
        </div>
        <table class="table">
          <tr>
            <td>
            <div class ="row" id = "offerI">
              <div class = "col-md-3">
              </br>
                <img src="http://placehold.it/100x100" alt="" class = "img-rounded"></img>
              </div>
              <div class = "col-md-5">
                <a href="#">
                  <h4>Product Name</h4>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque purus eros, aliquam.</p>
                </a>
              </div>
              <div class = "col-md-2">
                <h4>Price</h4>
                <p>£19.99<small></br> RRP £50.00</small></p>
              </div>
              <div class = "col-md-2">
              </br>
                <button class = "btn btn-default">View</button>
            </div>
          </div>
        </td>
        </tr>
        <tr>
          <td>
          <div class ="row" id = "offerI">
            <div class = "col-md-3">
            </br>
            <img src="http://placehold.it/100x100" alt="" class = "img-rounded"></img>
          </div>
          <div class = "col-md-5">
            <a href="#">
              <h4>Product Name</h5>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque purus eros, aliquam.</p>
            </a>
          </div>
          <div class = "col-md-2">
            <h4>Price</h4>
            <p>£19.99<small></br> RRP £50.00</small></p>
              </div>
              <div class = "col-md-2">
              </br>
              <button class = "btn btn-default">View</button>
            </div>
          </div>
        </td>
        </tr>
        <tr>
          <td>
          <div class ="row" id = "offerI">
            <div class = "col-md-3">
            </br>
            <img src="http://placehold.it/100x100" alt="" class = "img-rounded"></img>
          </div>
          <div class = "col-md-5">
            <a href="#">
              <h4>Product Name</h5>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque purus eros, aliquam.</p>
            </a>
          </div>
          <div class = "col-md-2">
            <h4>Price</h4>
            <p>£19.99<small></br> RRP £50.00</small></p>
              </div>
              <div class = "col-md-2">
              </br>
              <button class = "btn btn-default">View</button>
            </div>
          </div>
        </td>
        </tr>
        </table>
      </div>
    </div>

    <div class="col-lg-4">
      <div class = "panel panel-default">
        <div class = "panel-heading">
          <h2>Recently Viewed</h2>
        </div>

        <div class = "panel-body">

          <?php

          $i=0;

          $i2 = count($_SESSION['recentViewed']);

          if($i2 != 0){

            while($i < $i2){

              $itemID = $_SESSION['recentViewed'][$i];



              $sql4 = "SELECT ID, Name, Price, colour, homeAway, year FROM Products WHERE ID = $itemID";
              $result4 = $conn->query($sql4);

              $row4 = $result4->fetch_assoc();

              echo '<div class = "row">';
                echo '<div class = "col-lg-5">';
                  echo '<img src="/Ecommerce/images/'.$row4["ID"].'.jpg" height = "100"></img>';
                  echo '</div>';
                  echo '<div class = "col-lg-7">';
                    echo '<a href="productPage.php?id='.$row4["ID"].'">';
                      echo '<br/>';
                      $title = $row4["Name"] . " " . $row4["homeAway"] . " " . $row4["year"];
                      echo $title.'<br/>';
                      echo 'Price: £'.$row4["Price"];
                      echo '</br>';
                      echo 'Colour: ' . $row4["colour"];
                      echo '</a>';
                      echo '</div>';

                      echo '</div>';
                      echo '<hr/>';

                $i++;
            }
          }else{

          }





          ?>

        </div>

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
