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

$leagueID = $_GET["id"];

$sql3 = "SELECT * FROM Products WHERE LeagueID = '$leagueID'";
$result3 = $conn->query($sql3);

$row3 = $result3->fetch_assoc();


$sql = "SELECT leagueName FROM LeagueNameJoin WHERE leagueID = '$leagueID'";
$result = $conn->query($sql);

$row = $result->fetch_assoc();
$leagueName = $row["leagueName"];


$sql4 = "SELECT ID, Name, TeamID, max(ID) as Name1, COUNT(Name) AS A
FROM Products AS C
WHERE leagueID = '$leagueID'
GROUP BY Name";

$result4 = $conn->query($sql4);

if(isset($_SESSION['cart'])){

  $basketTotalQuantity = count($_SESSION['cart']);

}

$referer = "index.php"

?>

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?php echo "Ecommerce: ".$leagueName ;?></title>

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
        <li class = "active"><?php echo $leagueName; ?></li>

      </ol>

      <div class = "panel panel-default">

        <div class = "panel-heading">

          <h1> Teams From <?php echo $leagueName; ?> </h1>

        </div>

        <div class = "panel-body">

          <?php

          while($row4 = $result4->fetch_assoc()) {

            writeWell($row4);

          }

          function writeWell($row){
            echo '<div class = "col-lg-4">';
            echo '<div class = "well well-small text-center">';

            echo '<img src="/Ecommerce/images/'.$row["ID"].'.jpg" width="100%"></img>';

            echo '<h5>'.$row["Name"].'</h5>';
            echo '<h5>Number Of Products: '.$row["A"].'</h5>';

            echo '<a href ="teamCat.php?id='.$row["TeamID"].'" class="btn btn-default">View</a>';

            echo '</div>';
            echo '</div>';
          }

          ?>

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
