<?php
session_start();

include("connection.php");
include("afunctions.php");

?>

<!DOCTYPE html>
<HTML>

<HEAD>
    <meta a charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <title> Log in </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style2.css">
    <script src="https://kit.fontawesome.com/cc984e4696.js" crossorigin="anonymous"></script>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</HEAD>

<BODY>
    <div class="container">
        <div class="row row-cols-1 row-cols-md-2 g-4">


            <?php
            $queryEvent = "SELECT * FROM event_tbl";
            $resultEvent = mysqli_query($con, $queryEvent);

            while ($rowEvent = mysqli_fetch_assoc($resultEvent)) {
                $event_id = $rowEvent['event_id'];
                $event_name = $rowEvent['event_name'];
                $event_date = $rowEvent['date'];
                $event_timein = $rowEvent['time_in'];
                $event_timeout = $rowEvent['time_out'];
            ?>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $event_name ?></h5>
                        <p class="card-text"><strong>Date:</strong> <?php echo $event_date ?></p>
                        <p class="card-text"><strong>Time in:</strong> <?php echo $event_timein ?></p>
                        <p class="card-text"><strong>Time out:</strong> <?php echo $event_timeout ?></p>
                        <a href="Main.php?event_id=<?php echo $event_id ?>" class="btn btn-primary">Select</a>
                        <a href="test.php?event_id=<?php echo $event_id ?>" class="btn btn-primary">Export data</a>
                    </div>
                </div>
            </div>

            <?php
            }
            ?>


        </div>

    </div>


</BODY>

</HTML>