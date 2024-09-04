<?php
include '../Private/database.php';

try{
    if(isset($_POST['submit'])){
        $pname=$_POST['pname'];
        $pfname=$_POST['pfname'];
        $pmname=$_POST['pmname'];
        $pgender=$_POST['pgender'];
        $pdob=$_POST['pdob'];
        $paddress=$_POST['paddress'];
        $pcity=$_POST['pcity'];
        $pstate=$_POST['pstate'];
        $pcontact=$_POST['pcontact'];
        $pemail=$_POST['pemail'];
        $ppassword=$_POST['ppassword'];
        $pbloodgroup=$_POST['pbloodgroup'];
        $checkquery="select * from patient_details where pcontact='$pcontact' or pemail='$pemail'";
        $checkresult=mysqli_query($connection,$checkquery);
        $checkqueryresult=mysqli_num_rows($checkresult);
        if($checkqueryresult>0){
            echo"
            <script>
            alert('You are already registered');
            </script>";
        }
        else{
            $query="insert into patient_details values('','$pname','$pfname','$pmname','$pgender','$pdob','$paddress','$pcity','$pstate','$pcontact','$pemail','$ppassword','$pbloodgroup')";
            mysqli_query($connection,$query);
            echo"
            <script>
            alert('Registered successfully');
            window.location.href = 'http://localhost/Project-1/Webpages/PatientPage.php';
            </script>";

        }
    }

}catch(Exception){
    echo"
    <script>
    alert('Registered unsuccessfully please retry');
    </script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>``````
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration Page</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            width: 100%;
            height: 1300px;
            background: linear-gradient(to right bottom, skyblue, white, rgb(252, 252, 189), whitesmoke);
            background-repeat: no-repeat;
        }

        /*---------------------------Parent Registration------------------------------------------------*/

        .body-2 {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .body-2 .background-blur-2 {
            display: block;
            width: 600px;
            height: 80%;
            background-color: rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(50px);
            border-radius: 15px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
            padding: 50px;
            margin: 50px;
        }

        .body-2 .background-blur-2 .title-2 {
            text-align: center;
            padding: 0;
            padding-bottom: 30px;
            font-size: 2em;
            font-weight: bold;
            cursor: default;
        }

        .body-2 .background-blur-2 .input-details-2 {
            padding: 10px;
            text-align: left;
            font-size: 20px;
            font-weight: bold;
            line-height: 25px;

        }

        .body-2 .background-blur-2 .input-details-2 input,
        .body-2 .background-blur-2 .input-details-2 select {
            width: 90%;
            height: 25px;
            border-radius: 5px;
            outline: none;
            border: none;
            border: 1px solid black;
        }

        .body-2 .background-blur-2 .gender-2,
        .body-2 .background-blur-2 .vaccine-provide-2 {
            padding: 10px;
            text-align: left;
            font-size: 20px;
            font-weight: bold;
            line-height: 35px;

        }

        .body-2 .background-blur-2 .gender-2 label,
        .body-2 .background-blur-2 .vaccine-provide-2 label {
            padding-right: 15px;
        }

        .body-2 .background-blur-2 .input-details-2 select {
            width: 50%;
            font-size: 16px;
        }

        .body-2 .background-blur-2 .vaccine-provide-2 .vaccine-title {
            padding-bottom: 30px;
            font-size: 25px;
            font-weight: bold;
            cursor: default;
        }

        .body-2 .background-blur-2 .buttons-2 {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .body-2 .background-blur-2 #back-button-2 {
            margin-left: 20px;
            width: 100px;
            height: 40px;
            display: flex;
            font-size: 20px;
            font-weight: bold;
            justify-content: center;
            align-items: center;
            background: white;
            color: black;
            border: none;
            outline: none;
            border-radius: 10px;
            border: 2px solid black;
            box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }

        .body-2 .background-blur-2 .buttons-2 #regbutton-2 {
            margin-right: 100px;
            width: 120px;
            height: 40px;
            display: flex;
            font-size: 20px;
            font-weight: bold;
            justify-content: center;
            align-items: center;
            background: rgb(156, 229, 11);
            color: white;
            border: none;
            outline: none;
            border-radius: 10px;
            border: 2px solid black;
            box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="body-2">
        <form class="background-blur-2" method="post">
            <div class="title-2">Patient Registration Form</div>
            <div class="input-details-2">
                <label for="pname">Name </label>
                <br>
                <input name="pname" id="pname" type="text" required>
            </div>
            <div class="input-details-2">
                <label for="pfname">Father Name </label>
                <br>
                <input name="pfname" id="pfname" type="text" required>
            </div>
            <div class="input-details-2">
                <label for="pmname">Mother Name </label>
                <br>
                <input name="pmname" id="pmname" type="text" required>
            </div>
            <div class="gender-2">
                <label for="pgender">Gender </label>
                <br>
                <input name="pgender" id="pmale" type="radio" value="Male" required>
                <label for="pmale">Male</label>

                <input name="pgender" id="pfemale" type="radio" value="Female" required>
                <label for="pfemale">Female</label>
            </div>
            <div class="input-details-2">
                <label for="pdob">Date of Birth </label>
                <br>
                <input name="pdob" id="pdob" type="date" required>
            </div>
            <div class="input-details-2">
                <label for="paddress">Address </label>
                <br>
                <input name="paddress" id="paddress" type="text" required>
            </div>
            <div class="input-details-2">
                <label for="pcity">City </label>
                <br>
                <input name="pcity" id="pcity" type="text" required>
            </div>
            <div class="input-details-2">
                <label for="pstate">State </label>
                <br>
                <input name="pstate" id="pstate" type="text" required>
            </div>
            <div class="input-details-2">
                <label for="pcontact">Contact </label>
                <br>
                <input name="pcontact" id="pcontact" type="tel" required>
            </div>

            <div class="input-details-2">
                <label for="pemail">E-mail ID </label>
                <br>
                <input name="pemail" id="pemail" type="email" required>
            </div>
            <div class="input-details-2">
                <label for="ppassword">Password </label>
                <br>
                <input name="ppassword" id="ppassword" type="password" required>
            </div>
            <div class="input-details-2">
                <label for="pbloodgroup">Blood Group </label>
                <br>
                <select name="pbloodgroup" id="pbloodgroup" required>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>
            </div>
            <br>
            <div class="buttons-2">
                <button onclick="back()" id="back-button-2">
                    < Back</button>
                        <button id="regbutton-2" name="submit" type="submit" >Register</button>
            </div>
        </form>
    </div>
    <script>
        function back() {
            window.location.href = "http://localhost/Project-1/Webpages/PatientPage.php";
        }
    </script>
</body>

</html>