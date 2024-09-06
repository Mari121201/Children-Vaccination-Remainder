<?php
include '../Private/database.php';
session_start();
try {
    if (isset($_SESSION['pcontact']) && isset($_SESSION['ppassword'])) {
        $pcontact = $_SESSION['pcontact'];
        $ppassword = $_SESSION['ppassword'];
        $query = "select * from patient_details where pcontact='$pcontact' and ppassword='$ppassword'";
        $result = mysqli_query($connection, $query);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) {
            $row = mysqli_fetch_assoc($result);
            $pname = $row['pname'];
            $pfname = $row['pfname'];
            $pmname = $row['pmname'];
            $pgender = $row['pgender'];
            $pdob = $row['pdob'];
            $paddress = $row['paddress'];
            $pcity = $row['pcity'];
            $pstate = $row['pstate'];
            $pcontact = $row['pcontact'];
            $pemail = $row['pemail'];
            $pbloodgroup = $row['pbloodgroup'];
            $_SESSION['patient_id'] = $row['patient_id'];
            $_SESSION['dob'] = $pdob;
            $_SESSION['gender'] = $pgender;
        }
    }

    //Date increase function and date calculating function

    function nextDate($appointmentDate, $addDay)
    {
        $nextday = new DateTime($appointmentDate);
        $nextday->modify("+$addDay days");
        return $nextday->format('Y-m-d');
    }
    function calculateDays($current, $shiftDate)
    {
        $today = new DateTime($current);
        $shiftdate = new DateTime($shiftDate);
        $interval = $today->diff($shiftdate);
        return $interval->days;
    }

    //Appointment function

    $currentDate = date("Y-m-d");

    $_SESSION['showappointment'] = "none";
    $_SESSION['showappointment_date'] = "none";
    $_SESSION['showappointment_wait'] = "none";
    $patientID = $_SESSION['patient_id'];
    $checkmsg = "select * from message_details where patient_id='$patientID'";
    $checkResult = mysqli_query($connection, $checkmsg);
    $checking = mysqli_num_rows($checkResult);
    if ($checking > 0) {
        $date = '0000-00-00';
        $time='00:00:00';
        $row = mysqli_fetch_assoc($checkResult);
        $msg = $row['message'];
        $pid = $row['patient_id'];
        $did = $row['doctor_id'];
        $appointdate = $row['appointment'];
        $appointtime = $row['appointment_time'];
        $_SESSION['appointmentDate'] = $appointdate;
        $_SESSION['appointmentTime'] = $appointtime;
        $msgid = $row['message_id'];

        $dayadd = 1;
        $theNextDate = nextDate($appointdate, $dayadd);
        if ($currentDate === $theNextDate) {
            $deleteQuery = "delete from message_details where message_id='$msgid'";
            mysqli_query($connection, $deleteQuery);
        }

        if ($appointdate === $date && $appointtime===$time) {
            $_SESSION['showappointment'] = "none";
            $_SESSION['showappointment_date'] = "none";
            $_SESSION['showappointment_wait'] = "block";
        } else {
            $_SESSION['showappointment'] = "none";
            $_SESSION['showappointment_date'] = "block";
            $_SESSION['showappointment_wait'] = "none";
        }
    } else {
        $_SESSION['showappointment'] = "block";
        $_SESSION['showappointment_date'] = "none";
        $_SESSION['showappointment_wait'] = "none";

        if (isset($_POST['submit'])) {
            if (isset($_POST['choose'])) {
                $message = $_POST['message'];
                $patient_id = $_SESSION['patient_id'];
                $doctor_id = $_POST['choose'];
                $query = "insert into message_details values('','$message','','','$doctor_id','$patient_id')";
                mysqli_query($connection, $query);
                echo "<script>alert('Message send successfully');
                window.location.href='http://localhost/Project-1/Webpages/PatientHome.php';</script>";
            } else {
                echo "<script>alert('please choose doctor');</script>";
            }
        }
    }

    // vaccine date 

    $dob = $_SESSION['dob'];
    $shift1 = nextDate($dob, 42);
    $shift2 = nextDate($dob, 84);
    $shift3 = nextDate($dob, 126);
    $shift4 = nextDate($dob, 180);
    $shift5 = nextDate($dob, 270);
    $shift6 = nextDate($dob, 450);
    $shift7 = nextDate($dob, 1826);
    $shift8 = nextDate($dob, 3650);
    $lastVaccineDate = nextDate($dob, 3650);
    if ($currentDate >= $dob && $currentDate <= $lastVaccineDate) {
        $_SESSION['showContainer'] = "block";
        $_SESSION['showNoVaccine'] = "none";
        $_SESSION['showNotBorn'] = "none";
        if ($dob === $currentDate) {
            $_SESSION['count'] = 0;
            $_SESSION['showDate'] = $dob;
            $_SESSION['dose'] = "<tr><td>BCG</td><td>1st Dose</td></tr>
            <tr><td>OPV</td><td>1st Dose</td></tr>
            <tr><td>Hepatitis B</td><td>1st Dose</td></tr>";
        } else if ($shift1 >= $currentDate) {
            $_SESSION['showDate'] = $shift1;
            $_SESSION['dose'] = "<tr><td>DTP</td><td>1st Dose</td></tr>
            <tr><td>OPV</td><td>2nd Dose</td></tr>
            <tr><td>Hib</td><td>1st Dose</td></tr>
            <tr><td>IPV</td><td>1st Dose</td></tr>
            <tr><td>Hepatitis B</td><td>2nd Dose</td></tr>
            <tr><td>RV</td><td>1st Dose</td></tr>";
            if ($shift1 === $currentDate) {
                $_SESSION['count'] = 0;
            } else {
                $_SESSION['count'] = 1;
                $_SESSION['daysLeft'] = calculateDays($currentDate, $shift1);
            }
        } else if ($shift2 >= $currentDate && $shift1 < $currentDate) {
            $_SESSION['showDate'] = $shift2;
            $_SESSION['dose'] = "<tr><td>DTP</td><td>2nd Dose</td></tr>
            <tr><td>OPV</td><td>3rd Dose</td></tr>
            <tr><td>Hib</td><td>2nd Dose</td></tr>
            <tr><td>IPV</td><td>2nd Dose</td></tr>
            <tr><td>RV</td><td>2nd Dose</td></tr>";
            if ($shift2 === $currentDate) {
                $_SESSION['count'] = 0;
            } else {
                $_SESSION['count'] = 1;
                $_SESSION['daysLeft'] = calculateDays($currentDate, $shift2);
            }
        } else if ($shift3 >= $currentDate && $shift2 < $currentDate) {
            $_SESSION['showDate'] = $shift3;
            $_SESSION['dose'] = "<tr><td>DTP</td><td>3rd Dose</td></tr>
            <tr><td>Hib</td><td>3rd Dose</td></tr>
            <tr><td>IPV</td><td>3rd Dose</td></tr>
            <tr><td>RV</td><td>3rd Dose</td></tr>";
            if ($shift3 === $currentDate) {
                $_SESSION['count'] = 0;
            } else {
                $_SESSION['count'] = 1;
                $_SESSION['daysLeft'] = calculateDays($currentDate, $shift3);
            }
        } else if ($shift4 >= $currentDate && $shift3 < $currentDate) {
            $_SESSION['showDate'] = $shift4;
            $_SESSION['dose'] = "<tr><td>Hepatitis B</td><td>3rd Dose</td></tr>";
            if ($shift4 === $currentDate) {
                $_SESSION['count'] = 0;
            } else {
                $_SESSION['count'] = 1;
                $_SESSION['daysLeft'] = calculateDays($currentDate, $shift4);
            }
        } else if ($shift5 >= $currentDate && $shift4 < $currentDate) {
            $_SESSION['showDate'] = $shift5;
            $_SESSION['dose'] = "<tr><td>MMR</td><td>1st Dose</td></tr>
            <tr><td>Hepatitis A</td><td>1st Dose</td></tr>
            <tr><td>VCA</td><td>1st Dose</td></tr>";
            if ($shift5 === $currentDate) {
                $_SESSION['count'] = 0;
            } else {
                $_SESSION['count'] = 1;
                $_SESSION['daysLeft'] = calculateDays($currentDate, $shift5);
            }
        } else if ($shift6 >= $currentDate && $shift5 < $currentDate) {
            $_SESSION['showDate'] = $shift6;
            $_SESSION['dose'] = "<tr><td>DTP</td><td>Booster dose</td></tr>
            <tr><td>Hib</td><td>Booster Dose</td></tr>
            <tr><td>OPV</td><td>Booster Dose</td></tr>
            <tr><td>MMR</td><td>2nd Dose</td></tr>
            <tr><td>Hepatitis A</td><td>2nd Dose</td></tr>
            <tr><td>VCA</td><td>2nd Dose</td></tr>";
            if ($shift6 === $currentDate) {
                $_SESSION['count'] = 0;
            } else {
                $_SESSION['count'] = 1;
                $_SESSION['daysLeft'] = calculateDays($currentDate, $shift6);
            }
        } else if ($shift7 >= $currentDate && $shift6 < $currentDate) {
            $_SESSION['showDate'] = $shift7;
            $_SESSION['dose'] = "<tr><td>DTP</td><td>Booster Dose</td></tr>
            <tr><td>OPV</td><td>Booster Dose</td></tr>";
            if ($shift7 === $currentDate) {
                $_SESSION['count'] = 0;
            } else {
                $_SESSION['count'] = 1;
                $_SESSION['daysLeft'] = calculateDays($currentDate, $shift7);
            }
        } else if ($shift8 >= $currentDate && $shift7 < $currentDate) {
            $_SESSION['showDate'] = $shift8;
            $gender = $_SESSION['gender'];
            if ($gender === "Male") {
                $_SESSION['dose'] = "<tr><td>Tdap</td><td>Booster dose</td></tr>";
            } else {
                $_SESSION['dose'] = "<tr><td>Tdap</td><td>Booster dose</td></tr>
                <tr><td>HPV (For girls)</td><td>1st dose</td></tr>";
            }
            if ($shift8 === $currentDate) {
                $_SESSION['count'] = 0;
            } else {
                $_SESSION['count'] = 1;
                $_SESSION['daysLeft'] = calculateDays($currentDate, $shift8);
            }
        } else {
            $_SESSION['count'] = 0;
        }
    } else if ($currentDate < $dob) {
        $_SESSION['showNotBorn'] = "block";
        $_SESSION['showNoVaccine'] = "none";
        $_SESSION['showContainer'] = "none";
    } else {
        $_SESSION['showContainer'] = "none";
        $_SESSION['showNoVaccine'] = "block";
        $_SESSION['showNotBorn'] = "none";
    }
} catch (Exception) {
    echo "<script>window.location.href='http://localhost/Project-1/notFound.html';";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Home Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            scroll-behavior: smooth;
            box-sizing: border-box;
        }

        body {
            width: 100vw;
            height: 100vh;
            display: inline;
        }

        .headerpart-2 {
            display: none;
        }

        /*-------------navbarmain----------------*/
        .navbar {
            background: linear-gradient(to right, wheat, whitesmoke);
            cursor: default;
            padding: 10px;
            padding-left: 30px;
            color: black;
            display: flex;
            justify-content: space-between;
            align-items: center;
            display: show;
        }

        .logo {
            padding: 10px 20px;
            display: flex;
            justify-content: center;

        }

        /*------------navigation bar--------------*/
        .bar {
            padding: 10px 20px;
            display: flex;
            justify-content: center;
        }

        .bar ul {
            display: inline-block;
            transform: skew(-25deg);
        }

        .bar ul li {
            list-style: none;
            background: linear-gradient(to right, lightgreen, orange);
            float: left;
            padding: 10px 20px;
            border-right: 1px solid rgb(49, 48, 48);
            box-shadow: 1px 1.5px 5px rgb(50, 50, 50);
            font-weight: bold;
            font-size: 1em;
        }

        .bar ul li:first-child {
            border-radius: 5px 0 0 10px;
        }

        .bar ul li:last-child {
            border-radius: 0 10px 5px 0;
        }

        .bar ul li:nth-child(3) {
            background: linear-gradient(to right, rgb(92, 92, 250), skyblue);
        }

        .bar ul li a {
            color: inherit;
            text-decoration: none;
            color: white;
            display: flex;
            flex-direction: row-reverse;
            transform: skew(25deg);
        }

        .bar ul li:hover {
            background: linear-gradient(to right, rgb(92, 92, 250), skyblue);
        }

        /*--------------------------------*/
        #homepage1 {
            column-count: 2;
            column-gap: 75px;
        }

        /*------------title--------------*/
        .part1 {
            display: inline-block;
        }

        .title {
            padding: 25px;
            padding-left: 50px;
            font-size: 35px;
            font-weight: bold;
            margin-bottom: 0;
            background: linear-gradient(to right, skyblue, pink, wheat, lightgreen);
            background-size: 5000px 500px;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: default;
            animation: animate-1 20s linear infinite;

        }

        @keyframes animate-1 {
            0% {
                background-position: 0%;
            }

            50% {
                background-position: 100%;
            }

            100% {
                background-position: 0%;
            }
        }

        #container {
            height: 600px;
            width: 100%;
            column-count: 2;
            padding-top: 100px;

        }

        #left-side {
            padding: 50px 0 0 50px;
            margin-left: 50px;
        }

        #right-side {
            width: 80%;
            padding: 50px 0 50px 50px;
            display: flex;
            justify-content: right;
            margin-left: 0;
        }

        #right-side #links {
            line-height: 100px;
        }

        #right-side #links a {
            text-decoration: none;
            font-size: 30px;
            display: flex;
            flex-direction: column;
        }

        /*--------------------------------------------------Home page---------------------------------------------*/

        #Welcome-page {
            display: none;
        }

        #wel {
            font-weight: bold;
            font-size: 50px;
            padding-bottom: 30%;
            padding-top: 20%;
        }

        #Welcome-page #right-side #Home {
            text-decoration: underline;

        }

        /*----------------------------------------------vaccine table------------------------------*/

        #vaccine_table {
            margin: 50px;
            font-size: 25px;

        }

        #vaccine_table h1 {
            text-align: center;
        }

        #vaccine_table table {
            margin-top: 30px;
            width: 100%;
            border-collapse: collapse;
            font-size: 25px;
        }

        #vaccine_table table th {
            width: 100px;
            border: 5px solid black;
            background-color: rgb(179, 173, 173);
        }

        #vaccine_table table td,
        #vaccine_table table tr {
            width: 100px;
            height: 100px;
            border: 5px solid black;
            padding-left: 15px;
            padding-right: 15px;
        }

        #vaccine_table table tbody tr td:nth-child(1) {
            font-weight: bold;
        }

        /*----------------------------------------------Advantages--------------------------------------------*/

        #prosandcons {
            background: linear-gradient(to right, skyblue, white, rgb(252, 252, 189), whitesmoke);
            cursor: default;
            padding: 50px;
            font-size: 30px;
        }

        #prosandcons h2 {
            padding-bottom: 50px;
            font-size: 40px;
        }

        #prosandcons p {
            padding-left: 35px;
            line-height: 50px;
            font-size: 28px;
        }

        #advantages p b {
            font-size: 32px;
        }

        /*--------------------------------------------------Personal details---------------------------------------------*/
        #personalDetails {
            display: block;
        }

        #pdetails {
            font-weight: bold;
            font-size: 50px;
            padding-bottom: 30%;
            padding-top: 20%;
        }

        #personalDetails #right-side #Details {
            text-decoration: underline;

        }

        #personalDetails #pshowdetails {
            padding: 50px;
            height: 900px;
            width: 100%;
            background: linear-gradient(to right, skyblue, white, rgb(252, 252, 189), whitesmoke);
            cursor: default;
            display: flex;
            justify-content: center;
        }

        #personalDetails #pshowdetails table {
            font-size: 30px;
        }

        #personalDetails #pshowdetails table tr td:nth-child(1) {
            height: 25px;
            font-weight: bold;
            padding: 10px;
            text-align: right;
        }

        #personalDetails #pshowdetails table tr td:nth-child(2) {
            height: 25px;
            color: blue;
            padding: 10px;
            text-align: left;
        }

        /*--------------------------------------------------Doctor appointment---------------------------------------------*/
        #pdoctorappointment {
            display: none;
        }

        #pdappointment {
            font-weight: bold;
            font-size: 50px;
            padding-bottom: 30%;
            padding-top: 20%;
        }

        #pdoctorappointment #right-side #Appointment {
            text-decoration: underline;

        }

        #pdoctorappointment #showappointment #sendappointment {
            display: flex;
            justify-content: center;
        }

        #pdoctorappointment #showappointment #sendappointment input[type="text"] {
            height: 200px;
            width: 500px;
            box-sizing: border-box;
            font-size: 20px;
            border-radius: 20px 20px;
        }

        #pdoctorappointment #showappointment #sendappointment input[type="text"]:placeholder-shown {
            padding-left: 20px;
        }

        #pdoctorappointment #showappointment #buttons {
            display: flex;
            justify-content: center;
        }

        #pdoctorappointment #showappointment #buttons #cancel {
            height: 50px;
            width: 100px;
            border-radius: 50px 50px;
            background-color: red;
            font-size: 16px;
            font-weight: bold;
            color: white;
            margin-right: 25px;
            cursor: pointer;

        }

        #pdoctorappointment #showappointment #buttons #submit {
            height: 50px;
            width: 100px;
            border-radius: 50px 50px;
            background-color: green;
            font-size: 16px;
            font-weight: bold;
            color: white;
            margin-left: 25px;
            cursor: pointer;

        }

        #showappointment {
            display: <?php
                        $showappointment = $_SESSION['showappointment'];
                        echo "$showappointment"; ?>;
        }

        #showappointment-date {
            display: <?php
                        $showappointment_date = $_SESSION['showappointment_date'];
                        echo "$showappointment_date"; ?>;
        }

        #showappointment-wait {
            display: <?php
                        $showappointment_wait = $_SESSION['showappointment_wait'];
                        echo "$showappointment_wait"; ?>;
        }

        #pdoctorappointment #showappointment-date #showappointment-contents {
            display: flex;
            justify-content: center;
        }

        #pdoctorappointment #showappointment-date #showappointment-contents #appointment-container {
            display: flex;
            flex-direction: column;
        }

        #pdoctorappointment #showappointment-date #showappointment-contents #appointment-input-values input {
            width: 200px;
            height: 50px;
            font-size: 20px;
            margin: 20px;
            text-align:center;
        }
        #appointment-input-values{
            display:flex;
            flex-direction:row;
        }

        #pdoctorappointment #showappointment-wait {
            padding: 20px;
        }

        #pdoctorappointment #showappointment-wait h1 {
            display: flex;
            justify-content: center;
        }


        /*--------------------------------------------------Vaccine date---------------------------------------------*/
        #pvaccinedate {
            display: none;
        }

        #pvaccine {
            font-weight: bold;
            font-size: 50px;
            padding-bottom: 30%;
            padding-top: 20%;
        }

        #pvaccinedate #right-side #Date {
            text-decoration: underline;

        }

        #vaccinedate {
            display: flex;
            justify-content: center;
        }

        #vaccinedateHeader,
        #vaccinedateInput,
        #vaccinedateShow,
        #showdate,
        #showcontent,
        #vaccineList,
        #showvaccines {
            display: flex;
            justify-content: center;
            padding: 10px;
            word-spacing: 5px;
        }

        #vaccinedateInput input {
            font-size: 20px;
            font-weight: bold;
            height: 50px;
            width: 150px;
            text-align: center;
            color: red;
        }

        #vaccinedateShow {
            display: flex;
            flex-direction: column;
        }

        #vaccinedateShow h1,
        #vaccinedateHeader h1 {
            font-size: 30px;
        }

        #showdate b {
            color: blue;
        }

        #vaccineList b {
            font-size: 40px;
            font-weight: bold;
        }

        #showvaccines td {
            font-size: 20px;
            outline: 3px black solid;
            padding: 20px;
            text-align: center;
        }

        #showvaccines td:nth-child(2) {
            color: blue;
        }

        #vaccinedateNoVaccine h1,
        #vaccinedateNotBorn h1 {
            display: flex;
            justify-content: center;
            color: grey;
            cursor: not-allowed;
        }

        #vaccinedateContainer {
            display: <?php $showContainer = $_SESSION['showContainer'];
                        echo "$showContainer"; ?>;
        }

        #vaccinedateNoVaccine {
            display: <?php $showNoVaccine = $_SESSION['showNoVaccine'];
                        echo "$showNoVaccine"; ?>;
        }

        #vaccinedateNotBorn {
            display: <?php $showNotBorn = $_SESSION['showNotBorn'];
                        echo "$showNotBorn"; ?>;
        }
    </style>
</head>

<body>
    <!----------------part-1 Title------------------->
    <header class="navbar">
        <h1 class="logo">Children Vaccination Remainder</h1>
        <nav class="bar">
            <ul>
                <li><a href="http://localhost/Project-1/Home.html">HOME</a></li>
                <li><a href="http://localhost/Project-1/Webpages/DoctorPage.php">DOCTOR</a></li>
                <li><a href="http://localhost/Project-1/Webpages/PatientHome.php">PARENT</a></li>
                <li><a href="http://localhost/Project-1/Webpages/Help.html">HELP</a></li>
            </ul>
        </nav>
    </header>
    <!------------------------------------------Patient Home Page---------------------------------------------------------->
    <div id="Welcome-page">
        <div id="container">
            <div id="left-side">
                <h1 id="wel">Welcome</h1>

            </div>

            <!------------------------------------------side contents---------------------------------------------------------->
            <div id="right-side">
                <div id="links">
                    <a href="#" onclick="homepage()" id="Home">Home</a>
                    <a href="#" onclick="personaldetails()" id="Details">Personal details</a>
                    <a href="#" onclick="appointment()" id="Appointment">Appointment</a>
                    <a href="#" onclick="pvaccineDate()" id="Date">Vaccine date</a>
                </div>
            </div>
        </div>

        <!---------------------------------Vaccine table------------------------------------------------->
        <div id="vaccine_table">
            <h1>Baby's vaccination schedule</h1>
            <table>
                <thead>
                    <tr>
                        <th>Vaccine Name</th>
                        <th>At Birth</th>
                        <th>6 Weeks</th>
                        <th>10 Weeks</th>
                        <th>14 Weeks</th>
                        <th>6 Months</th>
                        <th>9-12 Months</th>
                        <th>15-18 Months</th>
                        <th>5-6 Years</th>
                        <th>10-12 Years</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>BCG</td>
                        <td>Tuberculosis</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>OPV</td>
                        <td>1st Dose</td>
                        <td>2nd Dose</td>
                        <td>3rd Dose</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Booster Dose</td>
                        <td>Booster Dose</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Hepatitis-B</td>
                        <td>1st Dose</td>
                        <td>2nd Dose</td>
                        <td></td>
                        <td></td>
                        <td>3rd Dose</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>DTP</td>
                        <td></td>
                        <td>1st Dose</td>
                        <td>2nd Dose</td>
                        <td>3rd Dose</td>
                        <td></td>
                        <td></td>
                        <td>Booster Dose</td>
                        <td>Booster Dose</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Hib</td>
                        <td></td>
                        <td>1st Dose</td>
                        <td>2nd Dose</td>
                        <td>3rd Dose</td>
                        <td></td>
                        <td></td>
                        <td>Booster Dose</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>IPV</td>
                        <td></td>
                        <td>1st Dose</td>
                        <td>2nd Dose</td>
                        <td>3rd Dose</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>RV</td>
                        <td></td>
                        <td>1st Dose</td>
                        <td>2nd Dose</td>
                        <td>3rd Dose</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>MMR</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>1st Dose</td>
                        <td>2nd Dose</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>VCA</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>1st Dose</td>
                        <td>2nd Dose</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Hepatitis-A</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>1st Dose</td>
                        <td>2nd Dose</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Tdap</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Booster Dose</td>
                    </tr>
                    <tr>
                        <td>HPV</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Booster Dose</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!--------------------------------------------------pros and cons--------------------------------------------------->
        <div id="prosandcons">
            <h2>Advantages of this vaccination remainder</h2>
            <p><b>1. Disease Prevention : </b>Vaccines protect children from serious and potentially life-threatening diseases such as measles, mumps, rubella and whooping cough.</p>
            <p><b>2. Herd Immunity : </b>High vaccination rates help protect those who cannot be vaccinated (e.g., due to medical conditions) by reducing the spread of disease in the community.</p>
            <p><b>3. Reduced Health Care Costs : </b>Preventing disease through vaccination can lower healthcare costs associated with treating illnesses and managing complications.</p>
            <p><b>4. Promotes Community Health : </b>Vaccinations contribute to overall public health by reducing the incidence of contagious diseases.</p>
        </div>

        <br><br><br>


        <div id="prosandcons">
            <h2>Disadvantages of this vaccination remainder</h2>
            <p><b>1. Side Effects : </b>While rare, vaccines can have side effects, such as mild fever or soreness at the injection site. Severe reactions are extremely uncommon.</p>
            <p><b>2. Access and Disparities : </b>Some families may face barriers to accessing vaccines due to cost, lack of availability, or misinformation.</p>
            <p><b>3. Vaccine Hesitancy : </b>Misinformation and concerns about vaccine safety can lead to hesitation or refusal to vaccinate, potentially affecting public health.</p>
            <p><b>4. Multiple Doses : </b>Some vaccines require multiple doses and booster shots, which can be a challenge for scheduling and compliance.</p>
        </div>
    </div>
    <!------------------------------------------------------Personal details------------------------------------------------->
    <div id="personalDetails">
        <div id="container">
            <div id="left-side">
                <h1 id="pdetails">Personal details</h1>

            </div>

            <!------------------------------------------side contents---------------------------------------------------------->
            <div id="right-side">
                <div id="links">
                    <a href="#" onclick="homepage()" id="Home">Home</a>
                    <a href="#" onclick="personaldetails()" id="Details">Personal details</a>
                    <a href="#" onclick="appointment()" id="Appointment">Appointment</a>
                    <a href="#" onclick="pvaccineDate()" id="Date">Vaccine date</a>
                </div>
            </div>
        </div>
        <div id="pshowdetails">
            <table>
                <tr>
                    <td>Name :</td>
                    <td><?php echo "$pname" ?></td>
                </tr>
                <tr>
                    <td>Father name :</td>
                    <td><?php echo "$pfname" ?></td>
                </tr>
                <tr>
                    <td>Mother name :</td>
                    <td><?php echo "$pmname" ?></td>
                </tr>
                <tr>
                    <td>Gender :</td>
                    <td><?php echo "$pgender" ?></td>
                </tr>
                <tr>
                    <td>Date of birth :</td>
                    <td><?php echo "$pdob" ?></td>
                </tr>
                <tr>
                    <td>Address :</td>
                    <td><?php echo "$paddress" ?></td>
                </tr>
                <tr>
                    <td>City :</td>
                    <td><?php echo "$pcity" ?></td>
                </tr>
                <tr>
                    <td>State :</td>
                    <td><?php echo "$pstate" ?></td>
                </tr>
                <tr>
                    <td>Contact :</td>
                    <td><?php echo "$pcontact" ?></td>
                </tr>
                <tr>
                    <td>Email :</td>
                    <td><?php echo "$pemail" ?></td>
                </tr>
                <tr>
                    <td>Bloodgroup :</td>
                    <td><?php echo "$pbloodgroup" ?></td>
                </tr>
            </table>
        </div>
    </div>
    <!------------------------------------------------------Doctor appointment------------------------------------------------->
    <div id="pdoctorappointment">
        <div id="container">
            <div id="left-side">
                <h1 id="pdappointment">Doctor appointment</h1>

            </div>

            <!------------------------------------------side contents---------------------------------------------------------->
            <div id="right-side">
                <div id="links">
                    <a href="#" onclick="homepage()" id="Home">Home</a>
                    <a href="#" onclick="personaldetails()" id="Details">Personal details</a>
                    <a href="#" onclick="appointment()" id="Appointment">Appointment</a>
                    <a href="#" onclick="pvaccineDate()" id="Date">Vaccine date</a>
                </div>
            </div>
        </div>
        <form id="showappointment" method="post" action="">
            <?php
            $chooseQuery = "select * from doctor_details";
            $chooseResult = mysqli_query($connection, $chooseQuery);
            $chooseCheck = mysqli_num_rows($chooseResult);
            if ($chooseCheck > 0) {
                echo "<div id='chooseDoctor' style='display:flex; justify-content:center; margin:40px; '>
                    <select id='choose' name='choose' style='font-size:20px; border-radius:10px 10px;
                    outline:3px black solid; width:20%; height:50px;' required>";
                echo "<option disabled selected>Choose doctor</option>";
                while ($chooseRow = mysqli_fetch_assoc($chooseResult)) {
                    $doc_id = $chooseRow['doctor_id'];
                    $dname = $chooseRow['dname'];
                    $hname = $chooseRow['hname'];
                    $hcity = $chooseRow['hcity'];
                    $hstate = $chooseRow['hstate'];
                    echo "<option value='$doc_id'>$dname,$hname,$hcity,$hstate</option>";
                }
                echo "</select></div>";
                echo "<div id='sendappointment'><input type='text' name='message' id='message' placeholder='what reason to appointment doctor ?' required></div>
                    <br>
                    <div id='buttons'>
                    <button id='cancel' onclick='cancel()'>Cancel</button>
                    <button id='submit' name='submit'>Submit</button>
                    </div>";
            } else {
                echo "<h1 style='display:flex; justify-content:center; font-size:35px; color:grey; cursor:not-allowed;'>No doctors found</h1>";
            }
            ?>
        </form>
        <br>
        <div id="showappointment-date">
            <div id="showappointment-contents">
                <div id="appointment-container">
                    <center><h1>Appointment date</h1></center>
                    <?php
                    $appointmentDate = $_SESSION['appointmentDate'];
                    $appointmentTime = $_SESSION['appointmentTime'];
                    echo "<div id='appointment-input-values'>";
                    echo "<input type='date' value='$appointmentDate' disabled>";
                    echo "<input type='time' style='width:150px;' value='$appointmentTime' disabled>";
                    echo "</div>";

                    ?>
                </div>

            </div>
        </div>
        <div id="showappointment-wait">
            <h1>Waiting for doctor confirmation</h1>
            <h1 id="status"></h1>
        </div>
        <br>
    </div>
    <!------------------------------------------------------Vaccine date------------------------------------------------->
    <div id="pvaccinedate">
        <div id="container">
            <div id="left-side">
                <h1 id="pvaccine">Vaccine date</h1>

            </div>

            <!------------------------------------------side contents---------------------------------------------------------->
            <div id="right-side">
                <div id="links">
                    <a href="#" onclick="homepage()" id="Home">Home</a>
                    <a href="#" onclick="personaldetails()" id="Details">Personal details</a>
                    <a href="#" onclick="appointment()" id="Appointment">Appointment</a>
                    <a href="#" onclick="pvaccineDate()" id="Date">Vaccine date</a>
                </div>
            </div>
        </div>
        <form name="vaccinedate" method="post" action="">
            <div id="vaccinedateContainer">
                <div id="vaccinedateHeader">
                    <h1>Next vaccine date</h1>
                    <br>
                </div>
                <div id="vaccinedateInput">
                    <input type="date" value=<?php $showDate = $_SESSION['showDate'];
                                                echo "$showDate"; ?> disabled>
                </div>
                <div id="vaccinedateShow"><?php $daysLeft = $_SESSION['daysLeft'];
                                            $count = $_SESSION['count'];
                                            if ($count === 1) {
                                                $dose = $_SESSION['dose'];
                                                echo "<div id='showdate'><h1><b>$daysLeft</b> days left</h1></div>";
                                                echo "<div id='showcontent'><h1>For next vaccine date</h1></div>";
                                                echo "<br><div id='vaccineList'><h1><b>Next vaccine list<b></h1></div>";
                                                echo "<table id='showvaccines'>$dose</table>";
                                            } else {
                                                $dose = $_SESSION['dose'];
                                                echo "<script>const title=document.getElementById('vaccinedateHeader');
                                            title.style.display='none';
                                            const input=document.getElementById('vaccinedateInput');
                                            input.style.display='none';</script>";
                                                echo "<div id='showdate'><h1><b>Today<b></h1></div>";
                                                echo "<div id='showcontent'><h1>is your vaccine day</h1></div>";
                                                echo "<br><div id='vaccineList'><h1><b>Today vaccine list<b></h1></div>";
                                                echo "<table id='showvaccines'>$dose</table>";
                                            }
                                            ?></div>
            </div>
            <div id="vaccinedateNoVaccine">
                <h1>You're already finished all vaccine</h1>
            </div>
            <div id="vaccinedateNotBorn">
                <h1>Please check your child born date</h1>
            </div>
        </form>
    </div>

    <script>
        const home = document.getElementById("Welcome-page");
        const personalDetails = document.getElementById("personalDetails");
        const pdoctorappointment = document.getElementById("pdoctorappointment");
        const pvaccinedate = document.getElementById("pvaccinedate");
        home.style.display = "block";
        personalDetails.style.display = "none";
        pdoctorappoinment.style.display = "none";
        pvaccinedate.style.display = "none";

        function personaldetails() {
            home.style.display = "none";
            pdoctorappointment.style.display = "none";
            pvaccinedate.style.display = "none";
            personalDetails.style.display = "block";
        }

        function appointment() {
            home.style.display = "none";
            pvaccinedate.style.display = "none";
            personalDetails.style.display = "none";
            pdoctorappointment.style.display = "block";
        }

        function pvaccineDate() {
            home.style.display = "none";
            pdoctorappointment.style.display = "none";
            personalDetails.style.display = "none";
            pvaccinedate.style.display = "block";
        }

        function homepage() {
            pdoctorappointment.style.display = "none";
            pvaccinedate.style.display = "none";
            personalDetails.style.display = "none";
            home.style.display = "block";
        }

        function cancel() {
            const valuenull = document.getElementById('message');
            valuenull.value = "";
        }
    </script>
</body>

</html>