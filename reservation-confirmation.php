<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<!--  jQuery -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

<!-- Bootstrap Date-Picker Plugin -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
<?php
//var_dump($_POST);
//echo("<br>");
//var_dump($_GET);
?>
<html>
<style>
html {
  overflow: hidden;
}
body {
  background-color: transparent;
}
</style>

<?php
if (isset($_POST['confirm'])) {
    
    $db = new PDO('mysql:host=localhost;dbname=dbname;charset=utf8mb4', 'dbuser', 'dbpass');
    
    $stmt  = $db->prepare("INSERT INTO reservations(reservationdate,departuredate,people,name,email,phone,facility,comments) VALUES(:field1,:field2,:field3,:field4,:field5,:field6,:field7,:field8)");
    $entry = $stmt->execute(array(
        ':field1' => $_POST['reservationdate'],
        ':field2' => $_POST['departuredate'],
        ':field3' => $_POST['people'],
        ':field4' => $_POST['name'],
        ':field5' => $_POST['email'],
        ':field6' => $_POST['phone'],
        ':field7' => $_POST['facility'],
        ':field8' => $_POST['comments']
    ));
    
    if ($entry) {
        echo ('<div class="alert alert-success"><strong>Thank you!</strong> We have received your reservation application. See you at ' . $_POST['reservationdate'] . '!</div>');
    } else {
        echo ('<div class="alert alert-danger">An error occurred.</div>');
    }
    
} elseif (isset($_POST['back'])) {
    if ($_GET['facility'] == "Dining") {
        header('Location: diningreservation.php');
    }
?>
<div class="alert alert-success" role="alert">Seats available! Please review your reservation before submitting it.</div>
<?php
} elseif ($_GET['facility'] == "Dining") {
?>
<div class="form-wrapper">
<div class="container">
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">Reservation review</div>
  <div class="panel-body">
  <div class='row'>
  <div class='col-md-6'>
    <p><b>Contact information:</b></p>
    <p>Name: <?php echo ($_GET['name']);?></p>
    <p>Phone: <?php echo ($_GET['phone']);?></p>
    <p>Email: <?php echo ($_GET['email']);?></p>
  </div>
  <div class='col-md-6'>
    <p><b>Reservation:</b></p>
    <p>Type: <?php echo ($_GET['facility']); ?></p>
    <p>Party size: <?php echo ($_GET['people']); ?></p>
    <p>Time: <?php echo ($_GET['reservationdate']); ?></p>
    <?php if($_GET['comments'] != "") {
    echo("<p>Comments: " . $_GET['comments'] . "</p>");
    }
    ?>
  </div>
  </div>
  <div class='row'>
  <br>
  	<div class='col-md-12' style='text-align: center;'><p><b>Is everything correct?</b></p></div>
  <div class="form-group">
  <form method='post' action=''>
  <div style='visibility: hidden;'>
  <?php
    foreach ($_GET as $key => $value) {
        echo ('<input id="' . $key . '" name="' . $key . '" type="text" value="' . $value . '">');
    }
?>
  </div>
  <div class="col-md-6">
    <button id="confirm" name="confirm" class="btn btn-block btn-success">Yes! Place reservation</button>
  </div>
    <div class="col-md-6">
    <button id="back" name="back" class="btn btn-block btn-warning">No. Take me back</button>
  </div>
  </form>
</div>
  </div>
  </div>
</div>
</div>
</div>
<?php
} elseif($_GET['facility'] == "Tennis" || $_GET['facility'] == "Squash" || $_GET['facility'] == "Football") {
?>

<div class="form-wrapper">
<div class="container">
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">Reservation review</div>
  <div class="panel-body">
  <div class='row'>
  <div class='col-md-6'>
    <p><b>Contact information:</b></p>
    <p>Name: <?php echo ($_GET['name']);?></p>
    <p>Phone: <?php echo ($_GET['phone']);?></p>
    <p>Email: <?php echo ($_GET['email']);?></p>
  </div>
  <div class='col-md-6'>
    <p><b>Reservation: <?php echo ($_GET['facility']); ?></b></p>
    <p>Arrival time: <?php echo ($_GET['reservationdate']); ?></p>
    <p>Departure time: <?php echo ($_GET['departuredate']); ?></p>
    <?php if($_GET['comments'] != "") {
    echo("<p>Comments: " . $_GET['comments'] . "</p>");
    }
    ?>
  </div>
  </div>
  <div class='row'>
  <br>
  	<div class='col-md-12' style='text-align: center;'><p><b>Is everything correct?</b></p></div>
  <div class="form-group">
  <form method='post' action=''>
  <div style='visibility: hidden;'>
  <?php
    foreach ($_GET as $key => $value) {
        echo ('<input id="' . $key . '" name="' . $key . '" type="text" value="' . $value . '">');
    }
?>
  </div>
  <div class="col-md-6">
    <button id="confirm" name="confirm" class="btn btn-block btn-success">Yes! Place reservation</button>
  </div>
    <div class="col-md-6">
    <button id="back" name="back" class="btn btn-block btn-warning">No. Take me back</button>
  </div>
  </form>
</div>
  </div>
  </div>
</div>
</div>
</div>
<?php
} else {
    echo ("Not available yet.");
}
?>
</html>