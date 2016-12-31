<?php
$spots = 1;
//var_dump($_POST);

//if reservation is submitted
if(isset($_POST['submit'])) {

         $date = $_POST['date'];
         $arrival = $_POST['arrival'];
         $departure = $_POST['departure'];
         $name = $_POST['name'];
         $email = $_POST['email'];
         $phone = $_POST['phone'];
         $facility = $_POST['facility'];
         $comments = $_POST['comments'];
         
         $reservationdate = $date . " " . $arrival;
         $departuredate = $date . " " . $departure;

  //detecting reserved spots for selected date
  $db = new PDO('mysql:host=localhost;dbname=dbname;charset=utf8mb4', 'user', 'pass');

           $stmt = $db->prepare("SELECT COUNT(id) FROM reservations WHERE (((reservationdate BETWEEN :field1 AND :field2) OR (departuredate BETWEEN :field3 AND :field4)) AND facility = :field5)");

         $stmt->execute(array(
          ':field1' => $reservationdate,
          ':field2' => $departuredate,
          ':field3' => $reservationdate,
          ':field5' => $facility,
          ':field4' => $departuredate));

         $bookedseats = $stmt->fetchColumn();
         //echo("BOOKED: " . $bookedseats);

//seats available
if(($bookedseats + 1) <= $spots) {

  if($reservationdate > $departuredate) {
    echo('<div class="alert alert-danger">Arrival can not be later than departure / wrong date format '.$reservationdate. ' '.$departuredate.'</div>');
  } else {

    //all okay, redirecting user to confirmation page
    header('Location: reservation-confirmation.php?date='.$date.'&time='.$time.'&people='.$people.'&name='.$name.'&email='.$email.'&phone='.$phone.'&facility='.$facility.'&comments='.$comments.'&reservationdate='.$reservationdate.'&departuredate='.$departuredate.'');

  }
} else {
  //seats taken
            echo("<div class='alert alert-danger'>Unfortunately we can't fulfill your reservation, facility is already booked for that timeframe!</div>");
}
}
?>
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

<html>
<style>
html {
  overflow: hidden;
}
body {
  background-color: transparent;
}
</style>
<script>
    $(document).ready(function(){
      var date_input=$('input[name="date"]'); //our date input has the name "date"
      var container=$('.form-wrapper form').length>0 ? $('.form-wrapper form').parent() : "body";
      var options={
        format: 'yyyy-mm-dd',
        container: container,
        todayHighlight: true,
        autoclose: true,
      };
      date_input.datepicker(options);
    })
</script>
<div class="form-wrapper">
<div class="container">
<form class="form-horizontal" method="post" action="">
<fieldset>

<!-- Select Basic -->
<div class="form-group">
  <div class="col-md-6 col-md-offset-3">
    <select id="facility" name="facility" class="form-control" readonly="readonly">
      <option value="Football">Football pitch</option>
    </select>
  </div>
</div>

<div class="form-group"> <!-- Date input -->
  <div class="col-md-6 col-md-offset-3">
    <input class="form-control" id="date" name="date" placeholder="YYYY-MM-DD" required="" type="text"/>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <div class="col-md-6 col-md-offset-3">
    <select id="arrival" name="arrival" class="form-control">
      <option value="10:00">Arrival time 10:00</option>
      <option value="10:15">Arrival time 10:15</option>
      <option value="10:30">Arrival time 10:30</option>
      <option value="10:45">Arrival time 10:45</option>
      <option value="11:00">Arrival time 11:00</option>
      <option value="11:15">Arrival time 11:15</option>
      <option value="11:30">Arrival time 11:30</option>
      <option value="11:45">Arrival time 11:45</option>
      <option value="12:00">Arrival time 12:00</option>
      <option value="12:15">Arrival time 12:15</option>
      <option value="12:30">Arrival time 12:30</option>
      <option value="12:45">Arrival time 12:45</option>
      <option value="13:00">Arrival time 13:00</option>
      <option value="13:15">Arrival time 13:15</option>
      <option value="13:30">Arrival time 13:30</option>
      <option value="13:45">Arrival time 13:45</option>
      <option value="14:00">Arrival time 14:00</option>
      <option value="14:15">Arrival time 14:15</option>
      <option value="14:30">Arrival time 14:30</option>
      <option value="14:45">Arrival time 14:45</option>
      <option value="15:00">Arrival time 15:00</option>
      <option value="15:15">Arrival time 15:15</option>
      <option value="15:30">Arrival time 15:30</option>
      <option value="15:45">Arrival time 15:45</option>
      <option value="16:00">Arrival time 16:00</option>
      <option value="16:15">Arrival time 16:15</option>
      <option value="16:30">Arrival time 16:30</option>
      <option value="16:45">Arrival time 16:45</option>
      <option value="17:00">Arrival time 17:00</option>
      <option value="17:15">Arrival time 17:15</option>
      <option value="17:30">Arrival time 17:30</option>
      <option value="17:45">Arrival time 17:45</option>
      <option value="18:00">Arrival time 18:00</option>
      <option value="18:15">Arrival time 18:15</option>
      <option value="18:30">Arrival time 18:30</option>
      <option value="18:45">Arrival time 18:45</option>
      <option value="19:00">Arrival time 19:00</option>
      <option value="19:15">Arrival time 19:15</option>
      <option value="19:30">Arrival time 19:30</option>
      <option value="19:45">Arrival time 19:45</option>
      <option value="20:00">Arrival time 20:00</option>
      <option value="20:15">Arrival time 20:15</option>
      <option value="20:30">Arrival time 20:30</option>
      <option value="20:45">Arrival time 20:45</option>
      <option value="21:00">Arrival time 21:00</option>
      <option value="21:15">Arrival time 21:15</option>
      <option value="21:30">Arrival time 21:30</option>
      <option value="21:45">Arrival time 21:45</option>
      <option value="22:00">Arrival time 22:00</option>
      <option value="22:15">Arrival time 22:15</option>
      <option value="22:30">Arrival time 22:30</option>
      <option value="22:45">Arrival time 22:45</option>
      <option value="23:00">Arrival time 23:00</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <div class="col-md-6 col-md-offset-3">
    <select id="departure" name="departure" class="form-control">
      <option value="11:00">Departure time 11:00</option>
      <option value="11:15">Departure time 11:15</option>
      <option value="11:30">Departure time 11:30</option>
      <option value="11:45">Departure time 11:45</option>
      <option value="12:00">Departure time 12:00</option>
      <option value="12:15">Departure time 12:15</option>
      <option value="12:30">Departure time 12:30</option>
      <option value="12:45">Departure time 12:45</option>
      <option value="13:00">Departure time 13:00</option>
      <option value="13:15">Departure time 13:15</option>
      <option value="13:30">Departure time 13:30</option>
      <option value="13:45">Departure time 13:45</option>
      <option value="14:00">Departure time 14:00</option>
      <option value="14:15">Departure time 14:15</option>
      <option value="14:30">Departure time 14:30</option>
      <option value="14:45">Departure time 14:45</option>
      <option value="15:00">Departure time 15:00</option>
      <option value="15:15">Departure time 15:15</option>
      <option value="15:30">Departure time 15:30</option>
      <option value="15:45">Departure time 15:45</option>
      <option value="16:00">Departure time 16:00</option>
      <option value="16:15">Departure time 16:15</option>
      <option value="16:30">Departure time 16:30</option>
      <option value="16:45">Departure time 16:45</option>
      <option value="17:00">Departure time 17:00</option>
      <option value="17:15">Departure time 17:15</option>
      <option value="17:30">Departure time 17:30</option>
      <option value="17:45">Departure time 17:45</option>
      <option value="18:00">Departure time 18:00</option>
      <option value="18:15">Departure time 18:15</option>
      <option value="18:30">Departure time 18:30</option>
      <option value="18:45">Departure time 18:45</option>
      <option value="19:00">Departure time 19:00</option>
      <option value="19:15">Departure time 19:15</option>
      <option value="19:30">Departure time 19:30</option>
      <option value="19:45">Departure time 19:45</option>
      <option value="20:00">Departure time 20:00</option>
      <option value="20:15">Departure time 20:15</option>
      <option value="20:30">Departure time 20:30</option>
      <option value="20:45">Departure time 20:45</option>
      <option value="21:00">Departure time 21:00</option>
      <option value="21:15">Departure time 21:15</option>
      <option value="21:30">Departure time 21:30</option>
      <option value="21:45">Departure time 21:45</option>
      <option value="22:00">Departure time 22:00</option>
      <option value="22:15">Departure time 22:15</option>
      <option value="22:30">Departure time 22:30</option>
      <option value="22:45">Departure time 22:45</option>
      <option value="23:00">Departure time 23:00</option>
    </select>
  </div>
</div>

<!-- Text input-->
<div class="form-group"> 
  <div class="col-md-offset-3 col-md-6">
  <input id="name" name="name" type="text" placeholder="Your full name" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <div class="col-md-6 col-md-offset-3">
  <input id="email" name="email" type="text" placeholder="Your email address" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group"> 
  <div class="col-md-6 col-md-offset-3">
  <input id="phone" name="phone" type="text" placeholder="(+xxx) Your phone number" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <div class="col-md-6 col-md-offset-3">                     
    <textarea class="form-control" id="comments" name="comments" placeholder="If you wish to leave us additional info, please let us know by typing here"></textarea>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <div class="col-md-6 col-md-offset-3">
    <button id="submit" name="submit" class="btn btn-block btn-primary">Submit reservation</button>
  </div>
</div>

</fieldset>
</form>
</div>
</div>
</html>