<?php
include '../Private/database.php';
try{
    if (isset($_POST['submit'])) {
        $dname = $_POST['dname'];
        $dgender = $_POST['dgender'];
        $specialist = $_POST['specialist'];
        $dcontact = $_POST['dcontact'];
        $demail = $_POST['demail'];
        $dpassword = $_POST['dpassword'];
        $hname = $_POST['hname'];
        $haddress = $_POST['haddress'];
        $hcity = $_POST['hcity'];
        $hstate = $_POST['hstate'];
        $checkquery = "select * from doctor_details where dcontact='$dcontact' or demail='$demail'";
        $checkresult = mysqli_query($connection, $checkquery);
        $checkqueryresult = mysqli_num_rows($checkresult);
        if ($checkqueryresult > 0) {
            echo "
            <script>
            alert('You are already registered');
            </script>";
        } else {
            $query = "insert into doctor_details values('','$dname','$dgender','$specialist','$dcontact','$demail','$dpassword','$hname','$haddress','$hcity','$hstate')";
            mysqli_query($connection, $query);
            echo "
        <script>
        alert('Registered successfully');
        window.location.href = 'http://localhost/Project-1/Webpages/DoctorPage.php';
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

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Registration Page</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            width: 100%;
            height: 1100px;
            background: linear-gradient(to right bottom, skyblue, white, rgb(252, 252, 189), whitesmoke);
            background-repeat: no-repeat;
        }

        /*---------------------------doctor Registration------------------------------------------------*/
        .body {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .body .background-blur {
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

        .body .background-blur .title {
            text-align: center;
            padding: 0;
            padding-bottom: 30px;
            font-size: 2em;
            font-weight: bold;
            cursor: default;
        }

        .body .background-blur .input-details {
            padding: 10px;
            text-align: left;
            font-size: 20px;
            font-weight: bold;
            line-height: 25px;

        }

        .body .background-blur .input-details input,
        .background-blur .input-details select {
            width: 90%;
            height: 25px;
            border-radius: 5px;
            outline: none;
            border: none;
            border: 1px solid black;
        }

        .body .background-blur .gender {
            padding: 10px;
            text-align: left;
            font-size: 20px;
            font-weight: bold;
            line-height: 35px;

        }

        .body .background-blur .gender label {
            padding-right: 15px;
        }

        .body .background-blur .input-details select {
            width: 50%;
            font-size: 16px;
        }

        .body .background-blur .buttons {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .body .background-blur #back-button {
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

        .body .background-blur .buttons #regbutton {
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

    <div class="body">
        <form class="background-blur" method="post" action="">
            <div class="title">Doctor Registration Form</div>
            <div class="input-details">
                <label for="dname">Name </label>
                <br>
                <input name="dname" id="dname" type="text" required>
            </div>
            <div class="gender">
                <label for="dgender">Gender </label>
                <br>
                <input name="dgender" id="dmale" type="radio" value="Male" required>
                <label for="dmale">Male</label>

                <input name="dgender" id="dfemale" type="radio" value="Female" required>
                <label for="dfemale">Female</label>
            </div>
            <div class="input-details">
                <label for="specialist">Specialist </label>
                <br>
                <select name="specialist" id="specialist" required>
                    <option value="Pediatrics">Pediatrics</option>
                    <option value="Obstetrics and Gynecology (OB/GYN)">OB / GYN</option>
                    <option value="Orthopedics">Orthopedics</option>
                    <option value="Dermatology">Dermatology</option>
                    <option value="Cardiology">Cardiology</option>
                    <option value="Neurology">Neurology</option>
                    <option value="Psychiatry">Psychiatry</option>
                    <option value="Ophthalmology">Ophthalmology</option>
                    <option value="Otolarynology or ENT">Otolarynology or ENT</option>
                    <option value="Anesthesiology">Anesthesiology</option>
                    <option value="Radiology">Radiology</option>
                    <option value="Urology">Urology</option>
                </select>
            </div>

            <div class="input-details">
                <label for="dcontact">Contact </label>
                <br>
                <input name="dcontact" id="dcontact" type="tel" required>
            </div>

            <div class="input-details">
                <label for="demail">E-mail ID </label>
                <br>
                <input name="demail" id="demail" type="email" required>
            </div>
            <div class="input-details">
                <label for="dpassword">Password </label>
                <br>
                <input name="dpassword" id="dpassword" type="password" required>
            </div>
            <div class="input-details">
                <label for="hname">Hospital Name </label>
                <br>
                <input name="hname" id="hname" type="text" required>
            </div>
            <div class="input-details">
                <label for="haddress">Address </label>
                <br>
                <input name="haddress" id="haddress" type="text" required>
            </div>
            <div class="input-details">
                <label for="hcity">City </label>
                <br>
                <input name="hcity" id="hcity" type="text" required>
            </div>
            <div class="input-details">
                <label for="hstate">State </label>
                <br>
                <input name="hstate" id="hstate" type="text" required>
            </div>
            <br>
            <div class="buttons">
                <button onclick="back()" id="back-button">
                    < Back</button>
                        <button type="submit" name="submit" id="regbutton">Register</button>
            </div>
        </form>
        <div id="result"></div>
    </div>
    <script>
        function back() {
            window.location.href = "http://localhost/Project-1/Webpages/DoctorPage.php";
        }
    </script>
</body>

</html>