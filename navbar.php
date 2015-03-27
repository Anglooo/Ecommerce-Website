<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php" style="color:#3399CC;">YourFootballShirts.co.uk</a>
    </div>

    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">

        <li class="dropdown">
          <a class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
            Leagues
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
            <?php

            $sqlLeagues = "SELECT leagueName, leagueID FROM LeagueNameJoin";
            $resultLeagues = $conn->query($sqlLeagues);

            while($rowLeagues = $resultLeagues->fetch_assoc()) {

              echo '<li role = "link"><a role = "menuitem" tabindex="-1" href="leagueCat.php?id='.$rowLeagues["leagueID"].'">'.$rowLeagues["leagueName"].'</a></li>';

            }

            ?>
          </ul>
        </li>

        <li>
          <form class = "navbar-form" role = "search">
            <div class = "form-group">
              <label for "searchBar">Search</label>
              <input id = "searchBar" type = "text" class = "form-control" placeholder = ".....">
              </div
              <span class = "input-group-btn">
                <button class = "btn btn-default" type="submit">Go</button>
              </span>
            </form>
          </li>
        </ul>

        <ul class="nav navbar-nav navbar-right">

          <?php if(empty($_SESSION['user'])): ?>

          <li>

            <a href="register.php">Register <span class="glyphicon glyphicon-plus-sign"></span></a>

          </li>

          <li class="dropdown" id="menuLogin">
            <a class="dropdown-toggle" href="#" data-toggle="dropdown" id="navLogin">Login <span class = "caret"></span></a>
            <div class="dropdown-menu" style="padding:17px;">
              <form class="form" action = "login.php" method ="POST" id="formLogin">
                <input name="username" class = "form-control" id="username" type="text" placeholder="Username" style="margin-bottom:5px;">
                <input name="password" class = "form-control" id="password" type="password" placeholder="Password"><br>
                <button type="submit" id="btnLogin" class="btn btn-default">Login</button>
              </form>
            </div>
          </li>

        <?php else: ?>

          <li class="dropdown">
           <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Welcome <?php echo $_SESSION['user']['username'] ?> <span class="caret"></span></a>
           <ul class="dropdown-menu" role="menu">
             <li><a href="myAccount.php"><span class="glyphicon glyphicon-cog"></span> Account</a></li>
             <li class="divider"></li>
             <li><a href="logout.php"><span class="glyphicon glyphicon-remove-circle"></span> Logout</a></li>

           </ul>
         </li>

        <?php endif; ?>

          <li class="dropdown" id="menuBasket">
            <a class="dropdown-toggle" href="#" data-toggle="dropdown" id="navBasket"><span class="glyphicon glyphicon-shopping-cart"></span> My basket (<?php echo $basketTotalQuantity; ?>)</a>
            <div class="dropdown-menu" style="width:550px;">
              <div class = "container-fluid">

                  <?php

                  $maxBasket = 0;
                  $totalQuantity = 0;
                  $totalPrice = 0;

                  if(isset($_SESSION['cart'])){

                    $maxBasket = 0;
                    $maxBasket = count($_SESSION['cart']);
                    $i = 0;

                    if($maxBasket != 0){
                      while($i < $maxBasket){

                        $basketID = $_SESSION['cart'][$i]['prodID'];
                        $basketSize = $_SESSION['cart'][$i]['size'];

                        $sqlBasket = "SELECT ID, Name, homeAway,price FROM Products WHERE ID = $basketID";
                        $resultBasket = $conn->query($sqlBasket);

                        $rowBasket = $resultBasket->fetch_assoc();

                        echo '<ul style = "padding:0px;">';

                        echo '<form class = "form-inline" action = "shoppingBasket.php?id=updateQuantity" method = "POST" id = "prodI">';

                          echo '<input type= "hidden" name="indexUpdate" value = "'.$i.'">';
                          echo '<input type= "hidden" name="prevPage" value = "'.$referer.'">';

                        echo '<div class = "row">';

                          echo '<div class = "col-lg-2 text-center" width = "75">';

                            echo '<img src="/Ecommerce/images/'.$rowBasket["ID"].'.jpg" width = "100">';

                          echo '</div>';

                          echo '<div class = "col-lg-4 text-center">';

                            echo '<label for="prodName1">Product</label>';
                            echo '</br>';
                            echo '<a class = "form-control-static" href="productPage.php?id='.$rowBasket["ID"].'" id=prodName'.$i.'>'.$rowBasket["Name"].'</a>';
                            echo '<br>';
                            echo $rowBasket["homeAway"] .' ('.$basketSize.')';


                          echo '</div>';

                          echo '<div class = "col-lg-2 text-center">';

                            echo '<label for="prodQuan1">Quantity</label>';
                            echo '  ';
                            echo '<input type = "text" name = "quantity" class = "form-control" id="prodQuan1" style = "width:40px;" value = "'.$_SESSION['cart'][$i]['quantity'].'">';

                          echo '</div>';

                          echo '<div class = "col-lg-2 text-center">';

                            echo '</br>';

                            echo '<button type="submit" class="btn btn-default">Update</button>';

                          echo '</div>';

                          echo '<div class = "col-lg-1 text-center">';

                            echo '</br>';

                            echo '<button type="submit" formaction="shoppingBasket.php?id=deleteItem" class="btn btn-default"><span class = "glyphicon glyphicon-trash"></span></button>';

                          echo '</div>';


                        echo '</div>';
                        echo '</form>';



                        echo '<li class = "divider"></li>';
                        echo '</ul>';


                        $totalPrice = $totalPrice + ($_SESSION['cart'][$i]['quantity'] * $rowBasket["price"]);
                        $totalQuantity = $totalQuantity + $_SESSION['cart'][$i]['quantity'];
                        $i++;

                      }


                      echo '<div class = "row">';

                        echo '<div class = "col-lg-6" >';
                          echo '<h4>Total Items: '.$totalQuantity.'<h4>';
                          echo '<h4>Total Price: £'.$totalPrice.' <h4>';

                        echo '</div>';

                        echo '<div class = "col-lg-6" >';

                          echo '<br>';
                          echo '<a href="shoppingBasket.php?id=buy" class="btn btn-default">Checkout</a>';

                        echo '</div>';

                      echo '</div>';




                    }else{

                      echo '<ul style = "padding:0px;">';

                        echo '<h4 style="padding-left:10px;"> There is nothing in your basket </h4>';

                      echo '</ul>';

                    }

                  }else{

                      echo '<ul style = "padding:0px;">';

                        echo '<h4 style="padding-left:10px;"> There is nothing in your basket </h4>';

                      echo '</ul>';

                    }

                  ?>
            </div>
          </li>
      </div>
    </div>
  </nav>


<div class="container">

<div class="row">

  <div class="col-lg-12">

    <?php if(isset($_GET['error'])){

        switch($_GET['error']){

          case "login":

            echo '<div class="alert alert-danger" role="alert">There has been an error logging in.</div>';
            break;

          case "notLoggedInCheckout":

            echo '<div class="alert alert-danger" role="alert">You need to be logged in to checkout. Please log in and try again.</div>';
            break;

          case "success":

            echo '<div class="alert alert-success" role="alert">You have logged in successfully.</div>';
            break;

          case "emailUsed":

            echo '<div class="alert alert-danger" role="alert">Email has already been used. Please try again.</div>';
            break;

          case "usernameUsed":

            echo '<div class="alert alert-danger" role="alert">Username has already been used. Please try again.</div>';
            break;

          case "saleConfirmed":

            unset($_SESSION['cart']);

            echo '<div class="alert alert-success" role="alert">Payment Confirmed.</div>';
            break;

            case "registered":

              $username = $_GET['user'];

              echo '<div class="alert alert-success" role="alert">User '.$username.' Registered. Please log in.</div>';
              break;
        }

      }
    ?>


  </div>

</div>
