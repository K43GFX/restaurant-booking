<!DOCTYPE html>
<?php
   $spots = 50;
   $tennis = 2;
   $squash = 2;
   $football = 1;
   
   //var_dump($_GET);
   //var_dump($_POST);
   
   ?>
<meta charset="UTF-8">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
<!--  jQuery -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>

<script type="text/javascript">
   function confirm_delete() {
     return confirm('Are you sure you wish to delete that reservation?');
   }
</script>
<style>
   .panel-table .panel-body{
   padding:0;
   }
   .panel-table .panel-body .table-bordered{
   border-style: none;
   margin:0;
   }
   .panel-table .panel-body .table-bordered > thead > tr > th:first-of-type {
   text-align:center;
   width: 100px;
   }
   .panel-table .panel-body .table-bordered > thead > tr > th:last-of-type,
   .panel-table .panel-body .table-bordered > tbody > tr > td:last-of-type {
   border-right: 0px;
   }
   .panel-table .panel-body .table-bordered > thead > tr > th:first-of-type,
   .panel-table .panel-body .table-bordered > tbody > tr > td:first-of-type {
   border-left: 0px;
   }
   .panel-table .panel-body .table-bordered > tbody > tr:first-of-type > td{
   border-bottom: 0px;
   }
   .panel-table .panel-body .table-bordered > thead > tr:first-of-type > th{
   border-top: 0px;
   }
   .panel-table .panel-footer .pagination{
   margin:0; 
   }
   /*
   used to vertically center elements, may need modification if you're not using default sizes.
   */
   .panel-table .panel-footer .col{
   line-height: 34px;
   height: 34px;
   }
   .panel-table .panel-heading .col h3{
   line-height: 30px;
   height: 30px;
   }
   .panel-table .panel-body .table-bordered > tbody > tr > td{
   line-height: 34px;
   }
   body {
   background-color: transparent;
   overflow: hidden;
   }
</style>
<br>
<div class="row">
   <div class="col-md-10 col-md-offset-1">
      <?php
         $server = new mysqli("localhost", "dbuser", "dbpass", "dbname"); 
         
         if ($server->connect_error) {
         die('<div class="alert alert-danger">Failed to establish connection to backend: ' .$server->connect_error. '
         </div>');
         } 
         
         if(isset($_GET['delete_reservation']) && $_GET['auth'] == "xdsfDFJd54ds3fe") {
            $id = $_GET['delete_reservation'];
            //echo "ok1";
            $delete_query = "DELETE FROM reservations WHERE id='".$id."'";
            if($server->query($delete_query) === TRUE) {
                 echo('<div class="alert alert-success">Reservation #'.$id.' successfully deleted!
         </div>');
            } else {
               echo('<div class="alert alert-danger">Failed to launch a query to backend: unknown error
         </div>');
            }
         }
         if(isset($_POST['submit_view'])) {
            unset($_GET['view_reservation']);
         
         $db = new PDO('mysql:host=localhost;dbname=dbname;charset=utf8mb4', 'dbuser', 'dbpass');
         $stmt = $db->prepare('UPDATE reservations SET
         reservationdate = :field1,
         departuredate = :field2,
         name = :field3,
         email = :field4,
         phone = :field5,
         people = :field6,
         facility = :field7,
         comments = :field8 WHERE id = :field9');
         
         $update = $stmt->execute(array(
          ':field1' => $_POST['arrival'],
          ':field2' => $_POST['departure'],
          ':field3' => $_POST['name'],
          ':field4' => $_POST['email'],
          ':field5' => $_POST['phone'],
          ':field6' => $_POST['people'],
          ':field7' => $_POST['facility'],
          ':field8' => $_POST['comments'],
          ':field9' => $_POST['id']));
         
         if($_POST['arrival'] > $_POST['departure']) {
         echo('<div class="alert alert-danger">Arrival can not be later than departure / wrong date format</div>');
         } else {
            if($update) {
               echo('<div class="alert alert-success">Reservation successfully updated!</div>');
            } else {
               echo('<div class="alert alert-danger">An error occurred.</div>');
            }
         }
         }
         
         if(isset($_POST['submit_dining'])) {
         
         $date = $_POST['date'];
         $time = $_POST['time'];
         $people = $_POST['people'];
         $name = $_POST['name'];
         $email = $_POST['email'];
         $phone = $_POST['phone'];
         $facility = "Dining";
         $comments = $_POST['comments'];
         unset($_GET['new_dining']);
         
         $reservationdate = $date . " " . $time;
         $departuredate = date("Y-m-d H:i", strtotime("+2 hours" . $reservationdate));
         
         $db = new PDO('mysql:host=localhost;dbname=vhost51562s1;charset=utf8mb4', 'vhost51562s1', 'Kilpkalkun420');
         
         $stmt = $db->prepare("SELECT SUM(people) FROM reservations WHERE ((reservationdate BETWEEN :field1 AND :field2) OR (departuredate BETWEEN :field3 AND :field4))");
         $stmt->execute(array(
          ':field1' => $reservationdate,
          ':field2' => $departuredate,
          ':field3' => $reservationdate,
          ':field4' => $departuredate));
         
          $bookedseats = $stmt->fetchColumn();
         
          if(($bookedseats + $people) <= $spots) {
            //seats available
              $stmt = $db->prepare("INSERT INTO reservations(reservationdate,departuredate,people,name,email,phone,facility,comments) VALUES(:field1,:field2,:field3,:field4,:field5,:field6,:field7,:field8)");
         $update2 = $stmt->execute(array(
          ':field1' => $reservationdate,
          ':field2' => $departuredate,
          ':field3' => $people,
          ':field4' => $name,
          ':field5' => $email,
          ':field6' => $phone,
          ':field7' => $facility,
          ':field8' => $comments));
         
         if($reservationdate > $departuredate) {
         echo('<div class="alert alert-danger">Arrival can not be later than departure / wrong date format</div>');
         } else {
            if($update2) {
               echo('<div class="alert alert-success">Dining reservation successfully added!</div>');
            } else {
               echo('<div class="alert alert-danger">An error occurred.</div>');
            }
         }
          } else {
            //all seats taken
            echo("<div class='alert alert-danger'>Unfortunately we can't fulfill your reservation, too many seats reserved for that time! (".$bookedseats." out of ".$spots.")</div>");
          }
         }
         
         if(isset($_POST['submit_facility'])) {
         
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
         unset($_GET['new_facility']);
         $db = new PDO('mysql:host=localhost;dbname=vhost51562s1;charset=utf8mb4', 'vhost51562s1', 'Kilpkalkun420');
         
         
         if($facility == "Tennis") {
         $queryy = 'SELECT id FROM reservations WHERE facility = "Tennis" AND ((reservationdate BETWEEN :field1 AND :field2) OR (departuredate BETWEEN :field3 AND :field4))';
         $limiter = $tennis;
         
         } elseif($facility == "Squash") {
         $queryy = 'SELECT id FROM reservations WHERE facility = "Squash" AND ((reservationdate BETWEEN :field1 AND :field2) OR (departuredate BETWEEN :field3 AND :field4))';
         $limiter = $squash;
         } elseif($facility == "Football") {
         $queryy = 'SELECT id FROM reservations WHERE facility = "Football" AND ((reservationdate BETWEEN :field1 AND :field2) OR (departuredate BETWEEN :field3 AND :field4))';
         $limiter = $football;
         }
         
         $stmt = $db->prepare($queryy);
         $stmt->execute(array(
          ':field1' => $reservationdate,
          ':field2' => $departuredate,
          ':field3' => $reservationdate,
          ':field4' => $departuredate));
         
         $count = $stmt->rowCount();
         //echo("TÜRAAAA: " . $count);
         
         if($count < $limiter) {
         
         $stmt = $db->prepare("INSERT INTO reservations(reservationdate,departuredate,name,email,phone,facility,comments) VALUES(:field1,:field2,:field3,:field4,:field5,:field6,:field7)");
         $update3 = $stmt->execute(array(
          ':field1' => $reservationdate,
          ':field2' => $departuredate,
          ':field3' => $name,
          ':field4' => $email,
          ':field5' => $phone,
          ':field6' => $facility,
          ':field7' => $comments));
         
         if($reservationdate > $departuredate) {
         echo('<div class="alert alert-danger">Arrival can not be later than departure / wrong date format</div>');
         } else {
            if($update3) {
               echo('<div class="alert alert-success">Facility reservation successfully updated!</div>');
            } else {
               echo('<div class="alert alert-danger">An error occurred.</div>');
            }
         }
         
         } else {
         echo('<div class="alert alert-danger">Facility is not available at chosen time.</div>');
         }
         }
         
         if(isset($_GET['view_reservation'])) {
            $id = $_GET['view_reservation'];
            //echo("FUKKK");
            $query_view = "SELECT * FROM reservations WHERE id = $id";
            $result = $server->query($query_view);
         
            while ($row = $result->fetch_assoc()) {
            $v_id = $row['id'];
            $v_facility = $row['facility'];
            $v_arrival = $row['reservationdate'];
            $v_departure = $row['departuredate'];
            if($row['people'] == "") {
               $v_people = "not set";
            } else {
               $v_people = $row['people'];
            }
            $v_name = $row['name'];
            $v_email = $row['email'];
            $v_phone = $row['phone'];
            $v_comments = $row['comments'];
         }?>
      <script> $(function() {
         $('#viewreservation').modal('show');
         });
      </script>
      <?php
         }
         
            if(isset($_GET['new_dining'])) {?>
      <script> $(function() {
         $('#newdining').modal('show');
         });
      </script>
      <?php
         }
         if(isset($_GET['new_facility'])) {?>
      <script> $(function() {
         $('#newfacility').modal('show');
         });
      </script>
      <?php
         }
         ?>
   </div>
</div>

<?php
$today_1 = date('Y-m-d') . ' 00:00:00';
$today_2 = date('Y-m-d'). ' 23:59:59';
$diningreserv = 'SELECT id FROM reservations WHERE facility = "Dining" AND reservationdate >= "'.$today_1.'" AND departuredate <= "'.$today_2.'"';
$tennisreserv = 'SELECT id FROM reservations WHERE facility = "Tennis" AND reservationdate >= "'.$today_1.'" AND departuredate <= "'.$today_2.'"';
$squashreserv = 'SELECT id FROM reservations WHERE facility = "Squash" AND reservationdate >= "'.$today_1.'" AND departuredate <= "'.$today_2.'"';
$footballreserv = 'SELECT id FROM reservations WHERE facility = "Football" AND reservationdate >= "'.$today_1.'" AND departuredate <= "'.$today_2.'"';

         $db = new PDO('mysql:host=localhost;dbname=vhost51562s1;charset=utf8mb4', 'vhost51562s1', 'Kilpkalkun420');
         
         $stmt = $db->prepare("SELECT SUM(people) FROM reservations WHERE ((reservationdate BETWEEN :field1 AND :field2) OR (departuredate BETWEEN :field3 AND :field4))");
         $stmt->execute(array(
          ':field1' => $today_1,
          ':field2' => $today_2,
          ':field3' => $today_1,
          ':field4' => $today_2));
         
          $bookedseats = $stmt->fetchColumn();

$today_1 = date('Y-m-d H:') . '00:00';
$today_2 = date('Y-m-d H:'). '59:59';


         $stmt = $db->prepare("SELECT SUM(people) FROM reservations WHERE ((reservationdate BETWEEN :field1 AND :field2) OR (departuredate BETWEEN :field3 AND :field4))");
         $stmt->execute(array(
          ':field1' => $today_1,
          ':field2' => $today_2,
          ':field3' => $today_1,
          ':field4' => $today_2));
         
          $bookedhour = $stmt->fetchColumn();

          if($bookedhour <= 1) {
            $bookedhour = "0";
          }

//dining data       
$diningreservations = $server->query($diningreserv);
$dining_total = $diningreservations->num_rows;

//tennis data
$tennisreservations = $server->query($tennisreserv);
$tennis_total = $tennisreservations->num_rows;

//squash data
$squashreservations = $server->query($squashreserv);
$squash_total = $squashreservations->num_rows;

//football data
$footballreservations = $server->query($footballreserv);
$football_total = $footballreservations->num_rows;
?>
<div class='row'>
   <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default panel-table">
         <div class="panel-heading">
                     <div class="row">
               <div class="col col-xs-6">
                  <h3 class="panel-title">Live Statistics</h3>
               </div>
            </div>
         </div>
         <div class="panel-body">
         <div class='container'>
         <br>
           <div class='row'>
           <div class='col-md-6'>
             <p>Dining reservations for today: <?php echo($dining_total); ?></p>
             <p>Spots reserved for current hour: <?php echo($bookedhour); ?></p>
             <p>Total spots reserved for today: <?php echo($bookedseats); ?></p>
           </div>
           <div class='col-md-6'>
             <p>Tennis reservations for today: <?php echo($tennis_total); ?></p>
             <p>Squash reservations for today: <?php echo($squash_total); ?></p>
             <p>Football reservations for today: <?php echo($football_total); ?></p>
           </div>
           </div>
         </div>
         </div>
         </div>
         </div>
</div>

<div class="row">
   <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default panel-table">
         <div class="panel-heading">
            <div class="row">
               <div class="col col-xs-6">
                  <h3 class="panel-title">Dining Reservations</h3>
               </div>
               <div class="col col-xs-6 text-right">
                  <button type="button" href="?dining_reservation" data-toggle="modal" onclick="window.location.href='?new_dining'" class="btn btn-sm btn-primary btn-create">Create New</button>
               </div>
            </div>
         </div>
         <div class="panel-body">
            <table class="table table-striped table-bordered table-list">
               <thead>
                  <tr>
                     <th>Arrival</th>
                     <th>Departure</th>
                     <th>People</th>
                     <th>Full name</th>
                     <th>Phone</th>
                     <th>Email</th>
                     <th>Comment</th>
                     <th><em class="fa fa-cog"></em></th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                     $today = date('Y-m-d H:i');
                        $query1 = 'SELECT id FROM reservations WHERE facility = "Dining" AND departuredate >= "'.$today.'"'; 
                     
                        $result = $server->query($query1);
                        $limit1 = 4;
                        $total1 = $result->num_rows;
                        //echo $total1;
                        if(isset($_GET['page1'])) {
                           $page1 = $_GET['page1'];
                           $start1 = $limit1 * ($page1-1);
                        } else {
                           $page1 = 1;
                           $start1 = 0;
                     
                        }
                        $num_page1=ceil($total1/$limit1);
                     
                        $today = date('Y-m-d H:i');
                        $query1 = ('SELECT * from reservations where departuredate >= "'.$today.'" AND facility = "Dining" order by departuredate LIMIT ' . $limit1 . ' OFFSET ' . $start1);
                     
                        $result = $server->query($query1);
                        while ($row = $result->fetch_assoc()) {
                        
                     
                        echo "<tr>";
                        //echo "<td>".$row['facility']."</td>";
                        echo "<td>".$row['reservationdate']."</td>";
                        echo "<td>".$row['departuredate']."</td>";
                        //echo "<td>15:00</td>";
                        echo "<td>".$row['people']."</td>";
                        echo "<td>".$row['name']."</td>";
                        echo "<td>".$row['phone']."</td>";
                        echo "<td>".$row['email']."</td>";
                        if($row['comments'] == "") {
                        echo "<td>none</td>";
                        } else {
                        echo "<td>Yes</td>";
                        }
                        echo "<td align='center'>
                                    <a class='btn btn-default' href='?view_reservation=".$row['id']."'><em class='fa fa-pencil'></em></a>
                                    <a href='?delete_reservation=".$row['id']."&auth=xdsfDFJd54ds3fe' onclick='return confirm_delete()' class='btn btn-danger'><em class='fa fa-trash'></em></a>
                                  </td>";
                        echo "</tr>";
                        
                        }
                        ?>
               </tbody>
            </table>
         </div>
         <div class="panel-footer">
            <div class="row">
               <div class="col col-xs-4"><?php echo("Page " . $page1 . " of " . $num_page1)?>
               </div>
               <div class="col col-xs-8">
                  <ul class="pagination hidden-xs pull-right">
                     <?
                        if(isset($_GET['page2'])) {
                           $page2 = $_GET['page2'];
                        } else {
                           $page2 = 1;
                        }
                        for($i=1; $i<=$num_page1; $i++) {
                           if($i == $page1) {
                              echo("<li class='active'><a href='?page1=".$i."&page2=".$page2."'>".$i."</a></li>");
                           } else {
                              echo("<li><a href='?page1=".$i."&page2=".$page2."'>".$i."</a></li>");
                           }
                        }
                        ?>
                  </ul>
                  <ul class="pagination visible-xs pull-right">
                     <li><a href="#">«</a></li>
                     <li><a href="#">»</a></li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
      <div class="panel panel-default panel-table">
         <div class="panel-heading">
            <div class="row">
               <div class="col col-xs-6">
                  <h3 class="panel-title">Facility Reservations</h3>
               </div>
               <div class="col col-xs-6 text-right">
                  <button type="button" href="?dining_reservation" data-toggle="modal" onclick="window.location.href='?new_facility'" class="btn btn-sm btn-primary btn-create">Create New</button>
               </div>
            </div>
         </div>
         <div class="panel-body">
            <table class="table table-striped table-bordered table-list">
               <thead>
                  <tr>
                     <th>Facility</th>
                     <th>Arrival</th>
                     <th>Departure</th>
                     <th>Full name</th>
                     <th>Phone</th>
                     <th>Email</th>
                     <th>Comment</th>
                     <th><em class="fa fa-cog"></em></th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                     $today = date('Y-m-d H:i');
                     $query2 = 'SELECT id FROM reservations WHERE facility != "Dining" AND departuredate >= "'.$today.'"';
                     
                     $result = $server->query($query2);
                     $limit2 = 4;
                     $total2 = $result->num_rows;
                     
                     if(isset($_GET['page2'])) {
                        $page2 = $_GET['page2'];
                        $start2 = $limit2 * ($page2-1);
                     } else {
                        $page2 = 1;
                        $start2 = 0;
                     
                     }
                     $num_page2=ceil($total2/$limit2);
                     
                     $today = date('Y-m-d H:i');
                     $query2 = ('SELECT * from reservations where departuredate >= "'.$today.'" AND facility != "Dining" order by departuredate LIMIT ' . $limit2 . ' OFFSET ' . $start2);
                     
                     $result = $server->query($query2);
                     while ($row = $result->fetch_assoc()) {
                     echo "<tr>";
                     echo "<td>".$row['facility']."</td>";
                     echo "<td>".$row['reservationdate']."</td>";
                     echo "<td>".$row['departuredate']."</td>";
                     echo "<td>".$row['name']."</td>";
                     echo "<td>".$row['phone']."</td>";
                     echo "<td>".$row['email']."</td>";
                     
                     if($row['comments'] == "") {
                     echo "<td>none</td>";
                     } else {
                     echo "<td>Yes</td>";
                     }
                     echo "<td align='center'>
                                 <a class='btn btn-default' href='?view_reservation=".$row['id']."'><em class='fa fa-pencil'></em></a>
                                 <a href='?delete_reservation=".$row['id']."&auth=xdsfDFJd54ds3fe' onclick='return confirm_delete()' class='btn btn-danger'><em class='fa fa-trash'></em></a>
                               </td>";
                     echo "</tr>";
                     mysql_close();
                     }
                     ?>
               </tbody>
            </table>
         </div>
         <div class="panel-footer">
            <div class="row">
               <div class="col col-xs-4"><?php echo("Page " . $page2 . " of " . $num_page2)?>
               </div>
               <div class="col col-xs-8">
                  <ul class="pagination hidden-xs pull-right">
                     <?
                        for($i=1; $i<=$num_page2; $i++) {
                           if($i == $page2) {
                              echo("<li class='active'><a href='?page2=".$i."&page1=".$page1."'>".$i."</a></li>");
                           } else {
                              echo("<li><a href='?page2=".$i."&page1=".$page1."'>".$i."</a></li>");
                           }
                        }
                        ?>
                  </ul>
                  <ul class="pagination visible-xs pull-right">
                     <li><a href="#">«</a></li>
                     <li><a href="#">»</a></li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="newdining">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">New dining reservation</h4>
         </div>
         <div class="modal-body">
            <div class="form-wrapper dining2">
               <form class="form-horizontal" method="post" action="admin-reservations.php">
                  <fieldset>
                     <div class="form-group">
                        <!-- Date input -->
                        <div class="col-md-6 col-md-offset-3">
                           <input class="form-control" id="date" class="datepicker" name="date" placeholder="YYYY-MM-DD" required="" type="text"/>
                        </div>
                     </div>
                     <!-- Select Basic -->
                     <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                           <select id="time" name="time" class="form-control">
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
                           <select id="people" name="people" class="form-control">
                              <option value="1">1 people</option>
                              <option value="2">2 people</option>
                              <option value="3">3 people</option>
                              <option value="4">4 people</option>
                              <option value="5">5 people</option>
                              <option value="6">6 people</option>
                              <option value="7">7 people</option>
                              <option value="8">8 people</option>
                              <option value="9">9 people</option>
                              <option value="10">10 people</option>
                              <option value="11">11 people</option>
                              <option value="12">12 people</option>
                              <option value="13">13 people</option>
                              <option value="14">14 people</option>
                              <option value="15">15 people</option>
                              <option value="16">16 people</option>
                              <option value="17">17 people</option>
                              <option value="18">18 people</option>
                              <option value="19">19 people</option>
                              <option value="20">20 people</option>
                              <option value="21">21 people</option>
                              <option value="22">22 people</option>
                              <option value="23">23 people</option>
                              <option value="24">24 people</option>
                              <option value="25">25 people</option>
                              <option value="26">26 people</option>
                              <option value="27">27 people</option>
                              <option value="28">28 people</option>
                              <option value="29">29 people</option>
                              <option value="30">30 p1eople</option>
                              <option value="31">31 people</option>
                              <option value="32">32 people</option>
                              <option value="33">33 people</option>
                              <option value="34">34 people</option>
                              <option value="35">35 people</option>
                              <option value="36">36 people</option>
                              <option value="37">37 people</option>
                              <option value="38">38 people</option>
                              <option value="39">39 people</option>
                              <option value="40">40 people</option>
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
                           <button id="submit_dining" name="submit_dining" class="btn btn-block btn-primary">Submit reservation</button>
                        </div>
                     </div>
                  </fieldset>
               </form>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='admin-reservations.php'" data-dismiss="modal">Close</button>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade" id="newfacility">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">New facility reservation</h4>
         </div>
         <div class="modal-body">
            <div class="form-wrapper">
               <form class="form-horizontal" method="post" action="">
                  <fieldset>
                     <!-- Select Basic -->
                     <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                           <select id="facility" name="facility" class="form-control">
                              <option value="Tennis">Tennis court</option>
                              <option value="Squas">Squash court</option>
                              <option value="Football">Football pitch</option>
                           </select>
                        </div>
                     </div>
                     <div class="form-group">
                        <!-- Date input -->
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
                           <button id="submit_facility" name="submit_facility" class="btn btn-block btn-primary">Submit reservation</button>
                        </div>
                     </div>
                  </fieldset>
               </form>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='admin-reservations.php'" data-dismiss="modal">Close</button>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade" id="viewreservation">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">View/Edit Reservation</h4>
         </div>
         <div class="modal-body">
            <div class="form-wrapper">
               <form class="form-horizontal" method="post" action="">
                  <fieldset>
                     <!-- Text input-->
                     <div class="form-group">
                           
                        <div class="col-md-offset-3 col-md-6">
                           <input id="facility" name="facility" value="<?php echo($v_facility); ?>" type="text" placeholder="Tennis/Dining/Squash/Football" class="form-control input-md" required="">
                        </div>
                     </div>
                     <!-- Text input-->
                     <div class="form-group">
                        <div class="col-md-offset-3 col-md-6">
                           <input id="arrival" name="arrival" type="text" value="<?php echo($v_arrival); ?>" placeholder="Arrival time" class="form-control input-md" required="">
                        </div>
                     </div>
                     <!-- Text input-->
                     <div class="form-group">
                        <div class="col-md-offset-3 col-md-6">
                           <input id="departure" name="departure" type="text" value="<?php echo($v_departure); ?>" placeholder="Departure time" class="form-control input-md" required="">
                        </div>
                     </div>
                     <!-- Text input-->
                     <?php if($v_facility != "Dining") {
                      $style = "visibility: hidden;";
                    } else {
                      $style = "";
                    }
                      ?>
                     <div class="form-group">
                        <div class="col-md-offset-3 col-md-6">
                           <input id="people" name="people" style="<?php echo($style); ?>" type="text" value="<?php echo($v_people); ?>" placeholder="Count of people" class="form-control input-md" required="">
                        </div>
                     </div>
                     <!-- Text input-->
                     <div class="form-group">
                        <div class="col-md-offset-3 col-md-6">
                           <input id="name" name="name" type="text" placeholder="Full name" value="<?php echo($v_name); ?>" class="form-control input-md" required="">
                        </div>
                     </div>
                     <!-- Text input-->
                     <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                           <input id="email" name="email" type="text" value="<?php echo($v_email); ?>" placeholder="mail address" class="form-control input-md" required="">
                        </div>
                     </div>
                     <!-- Text input-->
                     <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                           <input id="phone" name="phone" type="text" value="<?php echo($v_phone); ?>" placeholder="Phone number" class="form-control input-md" required="">
                        </div>
                     </div>
                     <!-- Text input-->
                     <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                           <input id="id" name="id" type="text" value="<?php echo($v_id); ?>" placeholder="User ID" readonly="" class="form-control input-md" required="">
                        </div>
                     </div>
                     <!-- Textarea -->
                     <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">                     
                           <textarea class="form-control" id="comments" name="comments" placeholder="Comments"><?php echo($v_comments); ?></textarea>
                        </div>
                     </div>
                     <!-- Button -->
                     <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                           <button id="submit_view" name="submit_view" class="btn btn-block btn-primary">Save changes</button>
                        </div>
                     </div>
                  </fieldset>
               </form>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='admin-reservations.php'" data-dismiss="modal">Close without saving</button>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->