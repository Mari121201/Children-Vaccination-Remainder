<?php
include '../Private/database.php';
session_start();
try {
    if (isset($_SESSION['dcontact']) && isset($_SESSION['dpassword'])) {
        $dcontact = $_SESSION['dcontact'];
        $dpassword = $_SESSION['dpassword'];
        $query = "select * from doctor_details where dcontact='$dcontact' and dpassword='$dpassword'";
        $result = mysqli_query($connection, $query);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) {
            $row = mysqli_fetch_assoc($result);
            $dname = $row['dname'];
            $dgender = $row['dgender'];
            $specialist = $row['specialist'];
            $dcontact = $row['dcontact'];
            $demail = $row['demail'];
            $hname = $row['hname'];
            $haddress = $row['haddress'];
            $hcity = $row['hcity'];
            $hstate = $row['hstate'];
            $_SESSION['doctor_id'] = $row['doctor_id'];
        }
    }
    $_SESSION['showmessage'] = "none";
    $_SESSION['showSetDate'] = "none";
    if (isset($_POST['check'])) {
        $message_id = $_POST['choosePatient'];
        $_SESSION['messageID'] = $message_id;
        $msgQuery = "select * from message_details where message_id='$message_id'";
        $msgResult = mysqli_query($connection, $msgQuery);
        if (mysqli_num_rows($msgResult) > 0) {
            $msgDetails = mysqli_fetch_assoc($msgResult);
            $_SESSION['message'] = $msgDetails['message'];
            $patient_id = $msgDetails['patient_id'];
            echo "<script>window.onload=function(){appointment();}</script>";
            $_SESSION['showmessage'] = "block";
            $_SESSION['showSetDate'] = "block";

            $patientQuery = "select * from patient_details where patient_id='$patient_id'";
            $patientResult = mysqli_query($connection, $patientQuery);
            if (mysqli_num_rows($patientResult) > 0) {
                $prow = mysqli_fetch_assoc($patientResult);
                $_SESSION['patient_name'] = $prow['pname'];
            }
        } else {
            $_SESSION['showmessage'] = "none";
            $_SESSION['showSetDate'] = "none";
        }
    }
    if (isset($_POST['accept'])) {
        echo "<script>window.onload=function(){appointment();}</script>";
        $_SESSION['showmessage'] = "none";
        $_SESSION['showSetDate'] = "block";
    }
    if (isset($_POST['set'])) {
        $setDate = $_POST['setdate'];
        $msgID = $_SESSION['messageID'];
        $setQuery = "update message_details set appointment='$setDate' where message_id='$msgID'";
        mysqli_query($connection, $setQuery);
        echo "<script>alert('Appointment date set successfully');
        window.onload=function(){appointment();}</script>";
    }
    if (isset($_POST['setcancel'])) {
        $msgID = $_SESSION['messageID'];
        $setQuery = "delete from message_details where message_id='$msgID'";
        mysqli_query($connection, $setQuery);
        echo "<script>window.onload=function(){appointment();}</script>";
    }
} catch (Exception) {
    echo "<script>window.location.href='http://localhost/Project-1/notFound.html';</script>";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Home Page</title>
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

        .bar ul li:nth-child(2) {
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
            display: none;
        }

        #ddetails {
            font-weight: bold;
            font-size: 50px;
            padding-bottom: 30%;
            padding-top: 20%;
        }

        #personalDetails #right-side #Details {
            text-decoration: underline;

        }

        #personalDetails #dshowdetails {
            padding: 50px;
            height: 800px;
            width: 100%;
            background: linear-gradient(to right, skyblue, white, rgb(252, 252, 189), whitesmoke);
            cursor: default;
            display: flex;
            justify-content: center;
        }

        #personalDetails #dshowdetails table {
            font-size: 30px;
        }

        #personalDetails #dshowdetails table tr td:nth-child(1) {
            height: 25px;
            font-weight: bold;
            padding: 10px;
            text-align: right;
        }

        #personalDetails #dshowdetails table tr td:nth-child(2) {
            height: 25px;
            color: blue;
            padding: 10px;
            text-align: left;
        }

        /*--------------------------------------------------Patient appointment---------------------------------------------*/
        #doctorappointment {
            display: none;
        }

        #dappointment {
            font-weight: bold;
            font-size: 50px;
            padding-bottom: 30%;
            padding-top: 20%;
        }

        #doctorappointment #right-side #Appointment {
            text-decoration: underline;

        }

        #doctorappointment #showappointment h1 {
            text-align: center;
            margin-bottom: 35px;
            margin-top: 35px;
        }

        #alignments {
            display: flex;
            flex-direction: column;

        }

        #recieveappointment {
            text-align: center;
        }

        #recieveappointment input[type="text"] {
            height: 200px;
            width: 500px;
            box-sizing: border-box;
            font-size: 20px;
            border-radius: 20px 20px;
            padding-left: 20px;
        }


        #buttons {
            display: flex;
            justify-content: center;
        }

        #showappointment #check {
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

        #buttons #reject {
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

        #buttons #accept {
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

        #setButton {
            display: flex;
            justify-content: center;
        }

        #setButton #setcancel {
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

        #setButton #set {
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

        #setappointmentdate {
            display: flex;
            justify-content: center;
        }

        #setappointmentdate #setappointment-align {
            display: flex;
            flex-direction: column;
            line-height: 75px;
            margin-top: 30px;
            margin-bottom: 30px;
        }

        #setappointmentdate #setappointment-align input[type="date"] {
            height: 40px;
            width: 200px;
            margin-left: 40px;
            font-size: 20px;
        }


        #showmessage {
            display: <?php $showmessage = $_SESSION['showmessage'];
                        echo "$showmessage"; ?>;
        }

        #showSetDate {
            display: <?php $showSetDate = $_SESSION['showSetDate'];
                        echo "$showSetDate"; ?>
        }

        /*---------------------------------------------------Patient information---------------------------------------------------*/
        #patientinfo {
            display: none;
        }

        #patientinformation {
            font-weight: bold;
            font-size: 50px;
            padding-bottom: 30%;
            padding-top: 20%;
        }

        #patientinfo #right-side #info {
            text-decoration: underline;

        }

        #patientinfo #noshowpatients {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
            color: gray;
            cursor: not-allowed;
        }

        #patientinfo #showpatients {
            text-align: center;
        }

        #patientinfo #showpatients #leftside-contents h1 {
            line-height: 50px;
            text-align: right;
        }

        #patientinfo #showpatients #rightside-contents {
            text-align: justify;
            width: 500px;
        }

        #patientinfo #showpatients #rightside-details h1 {
            line-height: 50px;
            text-align: left;
            color: blue;
        }

        #showpatients {
            width: 100%;
        }

        #showChoose {
            display: flex;
            justify-content: center;
        }

        #showChoose table {
            font-size: 20px;
            padding: 25px;
        }

        #showChoose table th {
            font-weight: bold;
            outline: 3px black solid;
            padding: 25px 15px;
            text-align: center;
            font-size: 30px;
        }

        #showChoose table td {
            font-weight: bold;
            outline: 3px black solid;
            padding: 20px 15px;
            text-align: center;
        }

        #showChoose table td:nth-child(3),
        #showChoose table td:nth-child(4) {
            color: blue;
        }

        #showP {
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
    </style>
</head>

<body>
    <!----------------part-1 Title------------------->
    <header class="navbar">
        <h1 class="logo">Children Vaccination Remainder</h1>
        <nav class="bar">
            <ul>
                <li><a href="http://localhost/Project-1/Home.html">HOME</a></li>
                <li><a href="http://localhost/Project-1/Webpages/DoctorHome.php">DOCTOR</a></li>
                <li><a href="http://localhost/Project-1/Webpages/PatientPage.php">PARENT</a></li>
                <li><a href="http://localhost/Project-1/Webpages/Help.html">HELP</a></li>
            </ul>
        </nav>
    </header>
    <!------------------------------------------Doctor Home Page---------------------------------------------------------->
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
                    <a href="#" onclick="patientInfo()" id="info">Appointment details</a>
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
            <p><b>1. Disease Prevention : </b>Vaccines protect children from serious and potentially life-threatening
                diseases such as measles, mumps, rubella and whooping cough.</p>
            <p><b>2. Herd Immunity : </b>High vaccination rates help protect those who cannot be vaccinated (e.g., due
                to medical conditions) by reducing the spread of disease in the community.</p>
            <p><b>3. Reduced Health Care Costs : </b>Preventing disease through vaccination can lower healthcare costs
                associated with treating illnesses and managing complications.</p>
            <p><b>4. Promotes Community Health : </b>Vaccinations contribute to overall public health by reducing the
                incidence of contagious diseases.</p>
        </div>

        <br><br><br>


        <div id="prosandcons">
            <h2>Disadvantages of this vaccination remainder</h2>
            <p><b>1. Side Effects : </b>While rare, vaccines can have side effects, such as mild fever or soreness at
                the injection site. Severe reactions are extremely uncommon.</p>
            <p><b>2. Access and Disparities : </b>Some families may face barriers to accessing vaccines due to cost,
                lack of availability, or misinformation.</p>
            <p><b>3. Vaccine Hesitancy : </b>Misinformation and concerns about vaccine safety can lead to hesitation or
                refusal to vaccinate, potentially affecting public health.</p>
            <p><b>4. Multiple Doses : </b>Some vaccines require multiple doses and booster shots, which can be a
                challenge for scheduling and compliance.</p>
        </div>
    </div>
    <!------------------------------------------------------Personal details------------------------------------------------->
    <div id="personalDetails">
        <div id="container">
            <div id="left-side">
                <h1 id="ddetails">Personal details</h1>

            </div>

            <!------------------------------------------side contents---------------------------------------------------------->
            <div id="right-side">
                <div id="links">
                    <a href="#" onclick="homepage()" id="Home">Home</a>
                    <a href="#" onclick="personaldetails()" id="Details">Personal details</a>
                    <a href="#" onclick="appointment()" id="Appointment">Appointment</a>
                    <a href="#" onclick="patientInfo()" id="info">Appointment details</a>
                </div>
            </div>
        </div>
        <div id="dshowdetails">
            <table>
                <tr>
                    <td>Name :</td>
                    <td><?php echo "$dname" ?></td>
                </tr>
                <tr>
                    <td>Gender :</td>
                    <td><?php echo "$dgender" ?></td>
                </tr>
                <tr>
                    <td>Specialist :</td>
                    <td><?php echo "$specialist" ?></td>
                </tr>
                <tr>
                    <td>Contact :</td>
                    <td><?php echo "$dcontact" ?></td>
                </tr>
                <tr>
                    <td>Email :</td>
                    <td><?php echo "$demail" ?></td>
                </tr>
                <tr>
                    <td>Hospital name :</td>
                    <td><?php echo "$hname" ?></td>
                </tr>
                <tr>
                    <td>Hospital address :</td>
                    <td><?php echo "$haddress" ?></td>
                </tr>
                <tr>
                    <td>Hospital city :</td>
                    <td><?php echo "$hcity" ?></td>
                </tr>
                <tr>
                    <td>Hospital state :</td>
                    <td><?php echo "$hstate" ?></td>
                </tr>
            </table>
        </div>
    </div>

    <!------------------------------------------------------Patient appointment------------------------------------------------->
    <div id="doctorappointment">
        <div id="container">
            <div id="left-side">
                <h1 id="dappointment">Appointments</h1>

            </div>

            <!------------------------------------------side contents---------------------------------------------------------->
            <div id="right-side">
                <div id="links">
                    <a href="#" onclick="homepage()" id="Home">Home</a>
                    <a href="#" onclick="personaldetails()" id="Details">Personal details</a>
                    <a href="#" onclick="appointment()" id="Appointment">Appointment</a>
                    <a href="#" onclick="patientInfo()" id="info">Appointment details</a>
                </div>
            </div>
        </div>
        </form>
        <div id="shownoappointment" style='display: flex; justify-content: center; text-align:center; color: gray;cursor: not-allowed;'>
            <h1>No appointments</h1>
        </div>
        <form id="showcheck" method="post" action="">
            <div id="showappointment" style="display:flex;  justify-content:center;
             margin:40px; ">
                <?php
                $doctor_id = $_SESSION['doctor_id'];
                $chooseQuery = "select * from message_details where doctor_id='$doctor_id'";
                $chooseResult = mysqli_query($connection, $chooseQuery);
                $chooseCheck = mysqli_num_rows($chooseResult);
                $tempcount = 0;
                $count = 0;
                if ($chooseCheck > 0) {
                    echo "
                    <select id='choosePatient' name='choosePatient' style='font-size:20px; border-radius:10px 10px;
                    outline:3px black solid; width:20%; height:50px;' required>";
                    $selected = $_SESSION['selected'];
                    while ($chooseRow = mysqli_fetch_assoc($chooseResult)) {
                        $msg_id = $chooseRow['message_id'];
                        $appointment = $chooseRow['appointment'];
                        $date = '0000-00-00';
                        $patientID = $chooseRow['patient_id'];
                        $queryCheck = "select * from patient_details where patient_id='$patientID'";
                        $queryCheckResult = mysqli_query($connection, $queryCheck);
                        if (mysqli_num_rows($queryCheckResult) > 0) {
                            $rowResult = mysqli_fetch_assoc($queryCheckResult);
                            $pname = $rowResult['pname'];
                            $pgender = $rowResult['pgender'];
                            $pcity = $rowResult['pcity'];
                            $pstate = $rowResult['pstate'];
                            if ($appointment === $date) {
                                $count = 1;
                                $_SESSION['count'] = $count;
                                echo "<option value='$msg_id'>$pname,$pgender,$pcity,$pstate</option>";
                            } else {
                                $count = 0;
                                $_SESSION['count'] = $count;
                            }
                        }
                    }
                    echo "</select>";
                    echo "<button id='check' name='check'>Check</button>";
                    $count = $_SESSION['count'];
                    if ($count === $tempcount) {
                        $_SESSION['showcheck'] = "none";
                        echo "<script>
                        window.onload=function hide(){
                const showcheck=document.getElementById('showcheck');
                const shownoappointment=document.getElementById('shownoappointment');
                showcheck.style.display='none';
                shownoappointment.style.display='block';
                appointment();
                }</script>";
                    } else {
                        echo "<script>
                        window.onload=function show() {
                    const showcheck = document.getElementById('showcheck');
                const shownoappointment=document.getElementById('shownoappointment');
                    showcheck.style.display = 'block';
                shownoappointment.style.display='none';
                    appointment();
                }
                        </script>";
                    }
                } else {
                    echo "<script>
                window.onload=function hide(){
        const showcheck=document.getElementById('showcheck');
        const shownoappointment=document.getElementById('shownoappointment');
        showcheck.style.display='none';
        shownoappointment.style.display='block';
        appointment();
        }</script>";
                }
                ?>

            </div>
            <br>
        </form>

        <form id="showmessage" name="showmessage" action="">
            <div id="recieveappointment">
                <h1><?php $patient_name = $_SESSION['patient_name'];
                    echo "$patient_name"; ?> is what reason to see you</h1>
                <br><input type='text' name='messageText'
                    <?php $message = $_SESSION['message'];
                    echo "value='$message'";
                    ?>>
            </div>
            <br>
        </form>
        <form id="showSetDate" name="setDate" method="post" action="">
            <div id="setappointmentdate">
                <div id="setappointment-align">
                    <h1>Set appointment date</h1>
                    <input type="date" name="setdate">
                </div>
            </div>
            <div id="setButton">
                <button id="setcancel" name="setcancel">Cancel</button>
                <button id="set" name="set">Set Date</button>
            </div>
            <br>
        </form>

    </div>
    </div>
    <br>
    </div>

    <!------------------------------------------------------Appointment details------------------------------------------------->
    <div id="patientinfo">
        <div id="container">
            <div id="left-side">
                <h1 id="patientinformation">Appointment details</h1>

            </div>

            <!------------------------------------------side contents---------------------------------------------------------->
            <div id="right-side">
                <div id="links">
                    <a href="#" onclick="homepage()" id="Home">Home</a>
                    <a href="#" onclick="personaldetails()" id="Details">Personal details</a>
                    <a href="#" onclick="appointment()" id="Appointment">Appointment</a>
                    <a href="#" onclick="patientInfo()" id="info">Appointment details</a>
                </div>
            </div>
        </div>
        <form id="showpatients" name="showpatients" method="post" action="">
            <h1 style="font-size:45px; padding:20px;">Today appointments</h1>
            <div id='noshowpatients'>
                <h1>No Appointments</h1>
            </div>
            <div id="showChoose">
                <?php
                $_SESSION['shownopatients'] = "block";
                $_SESSION['showchoosepatients'] = "none";
                $doctorid = $_SESSION['doctor_id'];
                $tempDate = "0000-00-00";
                $currentDate = date("Y-m-d");
                $mQuery = "select * from message_details where doctor_id='$doctorid'";
                $mResult = mysqli_query($connection, $mQuery);
                if (mysqli_num_rows($mResult)) {
                    echo "<table id='showTable'>";
                    echo "<tr><th>Patient Name</th><th>Phone number</th><th>Appointment date</th>";
                    while ($mRow = mysqli_fetch_assoc($mResult)) {
                        $mMsgId = $mRow['message_id'];
                        $mMsg = $mRow['message'];
                        $mDoc = $mRow['doctor_id'];
                        $mPat = $mRow['patient_id'];
                        $mApp = $mRow['appointment'];
                        if ($mApp === $currentDate) {
                            $pQuery = "select * from patient_details where patient_id='$mPat'";
                            $pResult = mysqli_query($connection, $pQuery);
                            if (mysqli_num_rows($pResult) > 0) {
                                $pRow = mysqli_fetch_assoc($pResult);
                                $pName = $pRow['pname'];
                                $pContact = $pRow['pcontact'];
                                $_SESSION['shownopatients'] = "none";
                                $_SESSION['showchoosepatients'] = "block";
                                echo "<tr style='height: 25px;font-weight: bold;padding: 10px;text-align: right;'><td>$pName</td><td>$pContact</td><td>$mApp</td></tr>";
                            }
                        }
                    }
                    echo "</table>";
                } else {
                    $_SESSION['shownopatients'] = "block";
                    $_SESSION['showchoosepatients'] = "none";
                }

                $shownopatients = $_SESSION['shownopatients'];
                $showchoosepatients = $_SESSION['showchoosepatients'];
                echo "<script>
                const noshowpatients=document.getElementById('noshowpatients');
                const showTable=document.getElementById('showTable');
                showTable.style.display='$showchoosepatients';
                noshowpatients.style.display='$shownopatients'; </script>";
                ?>
                <br>
            </div>
        </form>
        <br>
        <br>
    </div>
    <script>
        const home = document.getElementById("Welcome-page");
        const personalDetails = document.getElementById("personalDetails");
        const doctorappointment = document.getElementById("doctorappointment");
        const patientinfo = document.getElementById("patientinfo");
        home.style.display = "block";

        function personaldetails() {
            home.style.display = "none";
            doctorappointment.style.display = "none";
            patientinfo.style.display = "none";
            personalDetails.style.display = "block";
        }

        function appointment() {
            home.style.display = "none";
            patientinfo.style.display = "none";
            personalDetails.style.display = "none";
            doctorappointment.style.display = "block";
        }

        function patientInfo() {
            home.style.display = "none";
            doctorappointment.style.display = "none";
            personalDetails.style.display = "none";
            patientinfo.style.display = "block";
        }

        function homepage() {
            doctorappointment.style.display = "none";
            patientinfo.style.display = "none";
            personalDetails.style.display = "none";
            home.style.display = "block";
        }
    </script>

</body>

</html>