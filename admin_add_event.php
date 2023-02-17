<?php 
session_start();

include("Connection.php");
include("afunctions.php");
$user_data_studentnumber = check_login($con);
$user_data_password = check_login($con);
$user_data_name = check_login($con);
$message = '';
$event_name = '';
$time_in = '';
$time_out = '';
$date = '';

if(isset($_POST["submit1"]))
{
$event_name = $_POST["event_name"];
$time_in = $_POST["time_in"];
$time_out = $_POST["time_out"];
$date = $_POST["event_date"];


    $query = "SELECT event_id 
                FROM event_tbl 
                    WHERE event_name = '$event_name'";
    $result = mysqli_query($con, $query);
    if(mysqli_affected_rows($con)>0)
    {

        $message = "Event name already exists. Try new event name.";
    }
    else
    {
        $query_data = "INSERT INTO event_tbl  VALUES ('NULL','$event_name', '$time_in', 
          '$time_out', '$date');"; 
        $insert = mysqli_query($con, $query_data)
        or die("Could not insert data because ".mysqli_connect_error());
  
        if(mysqli_affected_rows($con)==1)
        {
            $message = 'Event successfully created.';
        }
    }
}


?>  

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LPU Laguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="style2.css">
    <script src="https://kit.fontawesome.com/cc984e4696.js" crossorigin="anonymous"></script>
</head>
<body onload="startTime()">
    <div class="container">
        <div class="login">
        <img src="lpulogo.png" alt="logo" width="150" height="150" class="center">
        <h2 style="font-family: Bahnschrift;">Lyceum of the Philippines - Laguna</h2>
            <div class="info">
                <span></span>
                <div id= "txt"></div>
    <div style="text-align: center;">
    <span id='ct7' style="font-family:'Bahnschrift';font-size:x-large"></span>
    </div>
            <form action="" method="POST">
            <div class="padding">
	        <div class="row">
            <center><h2 class=" _700 l-s-n-1x m-b-md">Add <span style="color: #98282a">Event</span></h2></center>
            <div class="center-block w-xxl w-auto-xs p-y-md">
             <center>      <span  id="custom4" class="text-u-c _800">
                </span> </center>
   
        

             <input name="event_name" width="120px" type="text" class="form-control rounded" placeholder="Event Name" required>     
             <input type="date" name="event_date" width="120px" class="form-control rounded" placeholder="Event Date" required>          
             <input type="time" name="time_in" width="120px" class="form-control rounded" placeholder="Time Start" required>
             <input type="time" name="time_out" width="120px" class="form-control rounded" placeholder="Time End" required>
            <button type="submit" class="btn btn-primary" name="submit1">Add Event</button>
            
            </form>

</body>
</html>