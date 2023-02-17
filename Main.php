<?php
session_start();

include("connection.php");
include("functions.php");
$event_id = $_GET["event_id"];


$query = "SELECT * FROM event_tbl 
    WHERE event_id = '$event_id'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
$event_name = $row['event_name'];
$time_in = $row['time_in'];
$time_out = $row['time_out'];
$date = $row['date'];
$message = '';

date_default_timezone_set('Asia/Manila');

// Get current date and time
$current_time = time();
$current_date = date('Y-m-d');

// Convert UNIX timestamp to normal time string
$normal_time = date('Y-m-d H:i:s', $current_time);

// Convert $time_in and $time_out to UNIX timestamps
$time_in_unix = strtotime($date . ' ' . $time_in);
$time_out_unix = strtotime($date . ' ' . $time_out);

// Subtract 1 hour from the time in
$new_time_in = strtotime('-1 hour', $time_in_unix);

// Add 30 minutes from the time out
$new_time_out = strtotime('+30 minutes', $time_out_unix);

// Calculate time differences in minutes
$time_in_diff = round(abs($current_time - $new_time_in) / 60);
$time_out_diff = round(($new_time_out - $current_time) / 60);
$time_in_and_out_diff = round(abs($new_time_in - $new_time_out) / 60);

// Determine button states based on time differences and current date
if ($current_date != $date) {
    $time_in_disabled = true;
    $time_out_disabled = true;
} else {
    $time_in_disabled = ($time_in_diff > $time_in_and_out_diff || $time_out_diff < 0);
    $time_out_disabled = ($time_out_diff < 0);
}

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip_address = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip_address = $_SERVER['REMOTE_ADDR'];
}
if (isset($_POST['submit1'])) {

    $current_day = date('j');
    $query = "SELECT COUNT(*) as count FROM log WHERE student_number = '{$_POST["student_number"]}' AND ipadd = '{$ip_address}' AND t_out = '' AND event_id='{$_POST["event_id_number"]}'";
    $result = mysqli_query($con, $query);
    $count = mysqli_fetch_assoc($result)['count'];
    if ($count > 0) {
        $message = "You have already timed in for this event.";
    } else if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM log WHERE student_number = '{$_POST["student_number"]}' AND t_out IS NULL")) > 0) {
        $message = "You already have an active session on this device.";
    } else if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM log WHERE ipadd = '{$ip_address}' AND student_number <> '{$_POST["student_number"]}' AND t_out IS NULL")) > 0) {
        $message = "This device is being used by another student.";
    } else if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM log WHERE student_number = '{$_POST["student_number"]}' AND ipadd <> '{$ip_address}' AND t_out IS NULL")) > 0) {
        $message = "You already have an active session on a different device.";
    } else {
        $query = "INSERT INTO log (student_number, password, name, department, t_in, t_out, ipadd, event_id) 
                SELECT student_number, password, name, department, 
                NOW() as t_in, NULL as t_out,'{$ip_address}' as ipadd, '{$_POST['event_id_number']}' as event_id
                FROM users 
                WHERE student_number = '{$_POST["student_number"]}'";
        mysqli_query($con, $query);
        $message = 'Successfully timed in.';
    }
}
if (isset($_POST['submit2'])) {
    $current_day = date('j');
    $query = "UPDATE log SET t_out = NOW() WHERE ipadd = '{$ip_address}'";
    mysqli_query($con, $query);
    $message = 'Successfully timed out.';
}
?>

<!DOCTYPE html>
<html>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind CSS -->
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style2.css">
    <script src="https://kit.fontawesome.com/cc984e4696.js" crossorigin="anonymous"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LPU Laguna</title>

    <script>
    // Disable time in and time out buttons based on PHP code result
    <?php
        echo "var timeInDisabled = " . ($time_in_disabled ? 'true' : 'false') . ";";
        echo "var timeOutDisabled = " . ($time_out_disabled ? 'true' : 'false') . ";";
        ?>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('button[name="submit1"]').disabled = timeInDisabled;
        document.querySelector('button[name="submit2"]').disabled = timeOutDisabled;
    });
    </script>
</head>

<body onload="startTime()">
    <div class="wrapper bg-gray-400 antialiased text-gray-900">
        <div>
            <img src="lpulogo2.png" alt=" random imgee" class="w-full object-cover object-center rounded-lg shadow-md">
            <div class="relative px-4 -mt-16">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h5 class="text-center mt-1 text-xl font-semibold leading-tight">Attendance for Mr. and Ms. LPU 2023
                    </h5>
                    <div id="txt" class="<?php
                                            if ($message == "Successfully timed in." || $message == "Successfully timed out.") {
                                                echo "text-green-500";
                                            } else {
                                                echo "text-red-500";
                                            }
                                            ?> text-center"><?php echo $message ?>
                    </div>
                    <script>
                    function display_ct7() {
                        var x = new Date()
                        var ampm = x.getHours() >= 12 ? ' PM' : ' AM';
                        hours = x.getHours() % 12;
                        hours = hours ? hours : 12;
                        hours = hours.toString().length == 1 ? 0 + hours.toString() : hours;

                        var minutes = x.getMinutes().toString()
                        minutes = minutes.length == 1 ? 0 + minutes : minutes;

                        var seconds = x.getSeconds().toString()
                        seconds = seconds.length == 1 ? 0 + seconds : seconds;

                        var month = (x.getMonth() + 1).toString();
                        month = month.length == 1 ? 0 + month : month;

                        var dt = x.getDate().toString();
                        dt = dt.length == 1 ? 0 + dt : dt;

                        var x1 = month + "/" + dt + "/" + x.getFullYear();
                        x1 = x1 + " - " + hours + ":" + minutes + ":" + seconds + " " + ampm;
                        document.getElementById('ct7').innerHTML = x1;
                        display_c7();
                    }

                    function display_c7() {
                        var refresh = 1000;
                        mytime = setTimeout('display_ct7()', refresh)
                    }
                    display_c7()
                    </script>
                    <div id="ct7" class="mt-1 font-semibold uppercase text-center"></div>
                    <div class="mt-4">
                        <span id='ct7' style="font-family:'Bahnschrift';font-size:x-large"></span>
                        <form action="" method="POST">
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" <?php if($time_in_disabled){
                                        echo "disabled";
                                    }
                                    ?> id="username" name="student_number" type="text" placeholder="Student Number"
                                required>
                            <br>
                            <br>
                            <input name="event_id_number" type="hidden" value="<?php echo $event_id ?>">
                            <div class="rounded-md shadow-sm flex items-center justify-center" role="group">
                                <button type="submit" name="submit1" class="<?php
                                    if($time_in_disabled){
                                        echo "bg-gray-500 text-white font-bold py-2 px-4 border-b-4 border-gray-700 rounded";
                                    }else{
                                        echo "bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 border-b-4 border-red-700 hover:border-blue-500 rounded";
                                    }
                                    ?>">
                                    Time in
                                </button>
                                <button
                                    class="bg-white-500 hover:bg-white-400 text-white font-bold py-2 px-4 border-b-4 border-none hover:border-white-500 rounded">
                                </button>
                                <button type="submit" name="submit2" class="<?php
                                    if($time_in_disabled){
                                        echo "bg-gray-500 text-white font-bold py-2 px-4 border-b-4 border-gray-700 rounded";
                                    }else{
                                        echo "bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 border-b-4 border-red-700 hover:border-blue-500 rounded";
                                    }
                                    ?>"">
                                    Time out
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
            <span class=" text-sm text-gray-500 sm:text-center dark:text-gray-400">Please be reminded that
                                    physical attendancewill be verified by the school through class representatives and
                                    faculty in charge.</span>
                            </div>
</body>

</html>