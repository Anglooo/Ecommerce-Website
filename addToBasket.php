<?php
include 'common.php';
include 'phpConnect.php';


if(isset($_POST['prodID'])){



  $prodID = $_POST['prodID'];
  $quantity = $_POST['quantity'];
  $size = $_POST['size'];


  $_SESSION['cart'][] = array("ID","prodID" => $prodID,"quantity" => $quantity,"size" => $size);
  //print_r($_SESSION['cart']);

}

if(isset($_SESSION['cart'])){

  $basketTotalQuantity = count($_SESSION['cart']);

}

$referer = "index.php"

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


                              <div class="container">

                                <div class="row">
                                  <div class = "panel panel-default">

                                    <div class = "panel-heading">

                                      <h2>Your item has been added to the basket, What's next?</h2>

                                    </div>

                                    <div class = "panel-body">

                                      <div class = "row">

                                        <div class = "col-lg-3">

                                          <div class = "well text-center">

                                            <?php

                                            $sqlPrevProd = "SELECT ID, Name, Price, colour, homeAway, year FROM Products WHERE ID = $prodID";
                                            $resultPrevProd = $conn->query($sqlPrevProd);

                                            $rowPrevProd = $resultPrevProd->fetch_assoc();

                                            echo '<img src="/Ecommerce/images/'.$rowPrevProd["ID"].'.jpg" height = "200" class = "img-rounded"></img>';
                                            echo '<h3>';
                                            echo $rowPrevProd["Name"]. ' '. $rowPrevProd["homeAway"]. ' ' . $rowPrevProd["year"];
                                            echo '</h3>';
                                            echo '<h4>';
                                            echo 'Quantity: '. $quantity;
                                            echo '</h4>';
                                            echo '<h4>';
                                            echo 'Size: '.$size;
                                            echo '</h4>';

                                            ?>

                                          </div>

                                        </div>

                                        <div class = "col-lg-8">

                                            <h3>Would you like to?</h3>
                                            <?php
                                            echo '<a href="productPage.php?id='.$rowBasket["ID"].'" class = "btn btn-default">Continue Shopping</a>';

                                            ?>
                                            <a href="shoppingBasket.php?id=buy" class = "btn btn-default"> Go To Checkout</a>

                                        </div>

                                      </div>


                                    </div>

                                  </div>
                                </div>

                                <div class = "row">
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
