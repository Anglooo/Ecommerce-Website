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

// This if statement checks to determine whether the edit form has been submitted
// If it has, then the account updating code is run, otherwise the form is displayed
if(!empty($_POST))
{
    // Make sure the user entered a valid E-Mail address
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
    {
        die("Invalid E-Mail Address");
    }

    // If the user is changing their E-Mail address, we need to make sure that
    // the new value does not conflict with a value that is already in the system.
    // If the user is not changing their E-Mail address this check is not needed.
    if($_POST['email'] != $_SESSION['user']['email'])
    {
        // Define our SQL query
        $query = "
            SELECT
                1
            FROM users
            WHERE
                email = :email
        ";

        // Define our query parameter values
        $query_params = array(
            ':email' => $_POST['email']
        );

        try
        {
            // Execute the query
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            // Note: On a production website, you should not output $ex->getMessage().
            // It may provide an attacker with helpful information about your code.
            die("Failed to run query: " . $ex->getMessage());
        }

        // Retrieve results (if any)
        $row = $stmt->fetch();
        if($row)
        {
            die("This E-Mail address is already in use");
        }
    }

    // If the user entered a new password, we need to hash it and generate a fresh salt
    // for good measure.
    if(!empty($_POST['password']))
    {
        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
        $password = hash('sha256', $_POST['password'] . $salt);
        for($round = 0; $round < 65536; $round++)
        {
            $password = hash('sha256', $password . $salt);
        }
    }
    else
    {
        // If the user did not enter a new password we will not update their old one.
        $password = null;
        $salt = null;
    }

    // Initial query parameter values
    $query_params = array(
        ':email' => $_POST['email'],
        ':user_id' => $_SESSION['user']['id'],
    );

    // If the user is changing their password, then we need parameter values
    // for the new password hash and salt too.
    if($password !== null)
    {
        $query_params[':password'] = $password;
        $query_params[':salt'] = $salt;
    }

    // Note how this is only first half of the necessary update query.  We will dynamically
    // construct the rest of it depending on whether or not the user is changing
    // their password.
    $query = "
        UPDATE users
        SET
            email = :email
    ";

    // If the user is changing their password, then we extend the SQL query
    // to include the password and salt columns and parameter tokens too.
    if($password !== null)
    {
        $query .= "
            , password = :password
            , salt = :salt
        ";
    }

    // Finally we finish the update query by specifying that we only wish
    // to update the one record with for the current user.
    $query .= "
        WHERE
            id = :user_id
    ";

    try
    {
        // Execute the query
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch(PDOException $ex)
    {
        // Note: On a production website, you should not output $ex->getMessage().
        // It may provide an attacker with helpful information about your code.
        die("Failed to run query: " . $ex->getMessage());
    }

    // Now that the user's E-Mail address has changed, the data stored in the $_SESSION
    // array is stale; we need to update it so that it is accurate.
    $_SESSION['user']['email'] = $_POST['email'];

    // This redirects the user back to the members-only page after they register
    header("Location: private.php");

    // Calling die or exit after performing a redirect using the header function
    // is critical.  The rest of your PHP script will continue to execute and
    // will be sent to the user if you do not die or exit.
    die("Redirecting to private.php");
}


?>

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>YourFootballShirts: My Account</title>

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

    <div class="col-lg-12">

      <?php if(isset($_GET['error'])){

          switch($_GET['error']){

            case "login":

              echo '<div class="alert alert-danger" role="alert">There has been an error logging in.</div>';
              break;

            case "notLoggedInCheckout":

              echo '<div class="alert alert-danger" role="alert">You need to be logged in to checkout. Please log in and try again.</div>';
              break;
          }

        }
      ?>

    </div>

    <div class = "row">

      <div class = "col-lg-2">

      </div>

      <div class = "col-lg-6">

        <div class = "panel panel-default">

          <div class = "panel-heading">

            <h2> Welcome <?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?></h2>

          </div>

          <div class = "panel-body">

            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style = "margin-bottom:0px;">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      View Current Orders <span class = "caret"></span>
                    </a>
                  </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                  <table class = "table">

                    <tr>

                      <th>
                        Order No.
                      </th>

                      <th>
                        Date
                      </th>

                      <th>
                        Total Price
                      </th>

                      <th>
                        Status
                      </th>


                    </tr>

                    <tr>

                      <td>
                        021324912
                      </td>

                      <td>
                        2/8/2014
                      </td>

                      <td>
                        £98.99
                      </td>

                      <td>
                        Dispatched
                      </td>


                    </tr>

                  </table>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                  <h4 class="panel-title">
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      View Closed Orders<span class = "caret"></span>
                    </a>
                  </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">

                  <table class = "table">

                    <tr>

                      <th>
                        Order No.
                      </th>

                      <th>
                        Status
                      </th>

                      <th>
                        Total Price
                      </th>

                      <th>
                        Status
                      </th>


                    </tr>

                    <tr>

                      <td>
                        021308912
                      </td>

                      <td>
                        1/1/2001
                      </td>

                      <td>
                        £98.99
                      </td>

                      <td>
                        Delivered
                      </td>


                    </tr>

                  </table>

                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                  <h4 class="panel-title">
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      Edit Account Information <span class = "caret"></span>
                    </a>
                  </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                  <div class="panel-body">
                    <form action="myAccount.php" method="post">
                      <div class="form-group">
                        <label>Email address</label>
                        <input type="email" class="form-control" name = "email" placeholder="Enter email">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1">
                        (Leave blank if not changing password)
                      </div>
                      <button type="submit" class="btn btn-default">Update Details</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

          </div>

        </div>

      </div>

      <div class = "col-lg-4">

        <div class = "panel panel-default">

          <div class = "panel-heading">

            <h2> User Details </h2>

          </div>

          <table class = "table">

            <tr>

                <img class = "img-circle img-responsive" width = "150" src = "http://placehold.it/100x100" style="margin-left:25%; margin-top:10px; margin-bottom:10px;" >

            </tr>

            <tr>
              <td width = "100px">
                Username:
              </td>
              <td>
                <?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?>
              </td>
            </tr>

            <tr>
              <td width = "100px">
                Email:
              </td>
              <td>
                <?php echo htmlentities($_SESSION['user']['email'], ENT_QUOTES, 'UTF-8'); ?>
              </td>
            </tr>

          </table>

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
