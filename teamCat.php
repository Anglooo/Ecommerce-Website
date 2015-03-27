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

$teamNameID = $_GET["id"];


$sql3 = "SELECT leagueID FROM Products WHERE TeamID = '$teamNameID'";
$result3 = $conn->query($sql3);

$row3 = $result3->fetch_assoc();

$leagueID = $row3["leagueID"];



$sql2 = "SELECT leagueName FROM LeagueNameJoin WHERE leagueID = '$leagueID'";
$result2 = $conn->query($sql2);

$row2 = $result2->fetch_assoc();
$leagueName = $row2["leagueName"];


$sql = "SELECT teamName FROM TeamNameJoin WHERE teamID = '$teamNameID'";
$result = $conn->query($sql);

$row = $result->fetch_assoc();
$teamName = $row["teamName"];

$sql4 = "SELECT ID, Name,Price, colour, homeAway, year, leagueID, teamID FROM Products WHERE TeamID = '$teamNameID'";
$result4 = $conn->query($sql4);

if(isset($_SESSION['cart'])){

  $basketTotalQuantity = count($_SESSION['cart']);

}


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
 <?php include 'navbar.php'; ?>

    <div class="container">

      <ol class="breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li><?php echo '<a href=/Ecommerce/leagueCat.php?id='.$leagueID.'>'.$leagueName.'</a>'; ?></li>
        <li class = "active"><?php echo $teamName; ?></li>

      </ol>

      <div class = "panel panel-default">

        <div class = "panel-heading">

          <h1>All <?php echo $teamName; ?> Football Shirts </h1>

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

                echo '<h5>Team: '.$row["Name"].'</h5>';
                echo '<h5>Kit: '.$row["homeAway"].'</h5>';
                echo '<h5>Year: '.$row["year"].'</h5>';

                echo '<h5>Price: £'.$row["Price"].'</h5>';


                echo '<a href ="productPage.php?id='.$row["ID"].'" class="btn btn-default">View</a>';

                echo '</div>';
                echo '</div>';
              }

              ?>

            </div>

          </div>


        </div>

        <?php include 'footer.php'; ?>


      <script type="text/javascript">
        $('.dropdown-menu')find('form').click(function(e) {
          e.stopPropagation();
          windows.alert("running");
        });
      </script>

    </body></html>
