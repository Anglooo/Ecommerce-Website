<?php

include 'common.php';
include 'phpConnect.php';


if (count($_GET) == 0){
  header("Location: http://localhost/ecommerce/index.php");
  die();
}

?>

<!DOCTYPE html>
<html>

<?php
include 'phpConnect.php';

$prodID = $_GET["id"];

if(($key = array_search($prodID, $_SESSION['recentViewed'])) == false) {

  array_push($_SESSION['recentViewed'],$prodID);

}


if(count($_SESSION['recentViewed']) > 3){

  Array_Shift($_SESSION['recentViewed']);

}


$sql = "SELECT Name, Price, colour,homeAway,year, TeamID, LeagueID FROM Products WHERE ID = '$prodID'";
$result = $conn->query($sql);

$row = $result->fetch_assoc();

$prodName = $row["Name"];
$prodPrice = $row["Price"];
$prodColour = $row["colour"];
$prodHomeAway = $row["homeAway"];
$prodYear = $row["year"];
$prodTeamID = $row["TeamID"];
$prodLeagueID = $row["LeagueID"];


$sql3 = "SELECT leagueName FROM LeagueNameJoin WHERE leagueID = '$prodLeagueID'";
$result3 = $conn->query($sql3);

$row3 = $result3->fetch_assoc();
$leagueName = $row3["leagueName"];

$sql4 = "SELECT ID, Name, Price, colour, homeAway, year FROM Products WHERE TeamID = '$prodTeamID'";
$result4 = $conn->query($sql4);

$sql5 = "SELECT ID, Name, Price, colour, homeAway, year, teamID FROM Products WHERE leagueID = '$prodLeagueID'";
$result5 = $conn->query($sql5);

if(isset($_SESSION['cart'])){

  $basketTotalQuantity = count($_SESSION['cart']);

}

$referer = "index.php"

?>

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?php echo "Ecommerce: ".$prodName; ?></title>

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

<body>
   <?php include "navbar.php"; ?>
<div class="container">

  <ol class="breadcrumb">
    <li><a href="index.php">Home</a></li>
    <li><?php echo '<a href=/Ecommerce/leagueCat.php?id='.$prodLeagueID.'>'.$leagueName.'</a>'; ?></li>
    <li><?php echo '<a href=/Ecommerce/teamCat.php?id='.$prodTeamID.'>'.$prodName.'</a>'; ?></li>
    <li class="active"><?php echo $prodHomeAway." ".$prodYear ;?></li>
  </ol>

  <div class = "row">

    <div class = "panel panel-default">

      <div class= "panel-body">

        <div class = "col-md-4">

          <?php echo '<img src=/Ecommerce/images/'.$prodID.'.jpg height = "350" class = "img-rounded"></img>'; ?>

          <img src=""class =""></img>

        </div>

        <div class = "col-md-6">

          <h2><?php echo $prodName; ?></h2>
          <h4>Price : £<?php echo $prodPrice;?></h4>
          </br>
          <h4>Colour</h4>
          <p id = "productDesc"><?php echo $prodColour; ?></p>
          <h4>Home/Away</h4>
          <p id = "productDesc"><?php echo $prodHomeAway; ?></p>
          <h4>Year</h4>
          <p id = "productDesc"><?php echo $prodYear; ?></p>

        </div>

        <div class = "col-md-2">
          </br>
          </br>
          </br>

          <div class = "well">

            <form action="addToBasket.php" method="POST">

              <input type="hidden" name="prodID" value=<?php echo $prodID; ?>>

              <div class="form-group">

                <label>Size: </label>

                <select name  = "size" class="form-control">
                  <option>Small</option>
                  <option>Medium</option>
                  <option>Large</option>
                  <option>X Large</option>
                  <option>XX Large</option>
                </select>

                <label>Quantity:</label>

                <select name = "quantity" class = "form-control">

                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                  <option>6</option>
                  <option>7</option>
                  <option>8</option>
                  <option>9</option>
                  <option>10</option>

                </select>

              </div>

              <button type="submit" class="btn btn-default">
                Add to basket
              </button>

            </form>

          </div>

        </div>

      </div>

    </div>

  </div>

  <div class = "row">

    <div class = "col-lg-6">

      <div class = "panel panel-default">

        <div class = "panel-heading">

          <h4> Other Products For <?php echo $prodName; ?> </h4>

        </div>

        <div class = "panel-body">

          <?php
          // output product data.
          while($row4 = $result4->fetch_assoc()) {

            if($row4["ID"] != $prodID){

            echo '<div class = "row" style = "margin:10px;">';
              echo '<div class = "col-lg-4">';
                echo '<img src="/Ecommerce/images/'.$row4["ID"].'.jpg" height = "150"></img>';
                echo '</div>';

                echo '<div class = "col-lg-6">';
                  echo '<h5>Team: '.$row4["Name"].'</h5>';
                  echo '<h5>Kit: '.$row4["homeAway"].'</h5>';
                  echo '<h5>Year: '.$row4["year"].'</h5>';
                  echo '<h5>Colour: '.$row4["colour"].'</h5>';
                  echo '<h5>Price: '.$row4["Price"].'</h5>';
                  echo '</div>';

                  echo '<div class = "col-lg-2">';
                    echo '</br></br>';
                    echo '<a href ="productPage.php?id='.$row4["ID"].'" class="btn btn-default">View</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '<hr/>';
                }

              }

            ?>

        </div>

      </div>

    </div>
    <div class = "col-lg-6">

      <div class = "panel panel-default">

        <div class = "panel-heading">

          <h4> Other Products For <?php echo $leagueName; ?> </h4>

        </div>

        <div class = "panel-body" style="max-height: 250px;overflow-y: scroll;">


          <?php
          // output product data.
          while($row5 = $result5->fetch_assoc()) {

            if($row5["ID"] != $prodID){
              if($row5["teamID"] != $prodTeamID){

              echo '<div class = "row" style = "margin:10px;">';
                echo '<div class = "col-lg-4">';
                  echo '<img src="/Ecommerce/images/'.$row5["ID"].'.jpg" height = "150"></img>';
                  echo '</div>';

                  echo '<div class = "col-lg-6">';
                    echo '<h5>Team: '.$row5["Name"].'</h5>';
                    echo '<h5>Kit: '.$row5["homeAway"].'</h5>';
                    echo '<h5>Year: '.$row5["year"].'</h5>';
                    echo '<h5>Colour: '.$row5["colour"].'</h5>';
                    echo '<h5>Price: '.$row5["Price"].'</h5>';
                    echo '</div>';

                    echo '<div class = "col-lg-2">';
                      echo '</br></br>';
                      echo '<a href ="productPage.php?id='.$row5["ID"].'" class="btn btn-default">View</a>';
                      echo '</div>';
                      echo '</div>';
                      echo '<hr/>';
                    }
                  }

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
