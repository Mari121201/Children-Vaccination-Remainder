<?php
include '../Private/database.php';
session_start();
try{
    if (isset($_POST['submit'])) {
        $pcontact = $_POST['pcontact'];
        $ppassword = $_POST['ppassword'];
        $query="select * from patient_details where pcontact='$pcontact' and ppassword='$ppassword'";
        $result=mysqli_query($connection,$query);
        $resultCheck=mysqli_num_rows($result);
        if($resultCheck>0){
            
            $_SESSION['pcontact']=$pcontact;
            $_SESSION['ppassword']=$ppassword;
            echo"<script>alert('Login successfully');
            window.location.href='http://localhost/Project-1/Webpages/PatientHome.php';
            </script>";
        }
        else{
            echo"<script>alert('Phone number and password is incorrect');</script>";
        }
    }
}catch(Exception){
    echo"<script>window.location.href='http://localhost/Project-1/notFound.html';";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Login Page</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            width: 100%;
            height: 1000px;
            background: linear-gradient(to right bottom, skyblue, white, rgb(252, 252, 189), whitesmoke);
            background-repeat: no-repeat;
        }


        /*------------------------patient login---------------------------*/
        .body-3 {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 1000px;
        }

        .body-3 .background-blur-3 {
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

        .body-3 .background-blur-3 .container-3 {
            padding-left: 12%;
        }

        .body-3 .background-blur-3 .back-3 {
            height: 50px;
            width: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: whitesmoke;
            backdrop-filter: blur(500px);
            border-radius: 50%;
            cursor: pointer;
        }

        .body-3 .background-blur-3 .back-3 button {
            outline: none;
            border: none;
            background: transparent;
            color: rgb(129, 124, 124);
            font-size: 200%;
            font-weight: bold;
            cursor: pointer;
        }

        .body-3 .background-blur-3 .back-3:hover {

            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        }

        .body-3 .background-blur-3 .title-3 {
            text-align: center;
            padding: 0;
            padding-bottom: 0;
            font-size: 2em;
            font-weight: bold;
            cursor: default;
        }

        .body-3 .background-blur-3 .container-3 .input-details-3 {
            padding: 10px;
            text-align: left;
            font-size: 20px;
            font-weight: bold;
            line-height: 25px;
            margin-bottom: 30px;
            margin-top: 30px;

        }

        .body-3 .background-blur-3 .container-3 .input-details-3.left-side {
            text-align: right;
            padding-right: 20%;
        }

        .body-3 .background-blur-3 .container-3 .input-details-3 label {
            text-align: left;
        }

        .body-3 .background-blur-3 .container-3 .input-details-3 input {
            width: 80%;
            height: 30px;
            border-radius: 5px;
            outline: none;
            border: none;
            border: 1px solid black;
        }

        .body-3 .background-blur-3 .container-3 .buttons-3 {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .body-3 .background-blur-3 .container-3 #login-button-3 {
            margin-left: 20px;
            width: 100px;
            height: 40px;
            display: flex;
            font-size: 20px;
            font-weight: bold;
            justify-content: center;
            align-items: center;
            background: rgb(18, 129, 255);
            color: white;
            border: none;
            outline: none;
            border-radius: 10px;
            border: 2px solid black;
            box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }

        .body-3 .background-blur-3 .container-3 .buttons-3 #regbutton-3 {
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

    <div class="body-3">
        <form class="background-blur-3" id="myForm" method="post" action="">
            <div class="back-3" title="Back to Home Page">
                <button onclick="backpage()" id="backtohome-2">
                    < </button>
            </div>
            <div class="title-3">Log in</div>
            <div class="container-3">
                <div class="input-details-3">
                    <label for="pcontact">Phone no </label>
                    <br>
                    <input name="pcontact" id="pcontact" type="tel" required>
                </div>
                <div class="input-details-3">
                    <label for="ppassword">Password </label>
                    <br>
                    <input name="ppassword" id="ppassword" type="password" required>
                </div>
                <div class="input-details-3 left-side">
                    <a href="#">Forgot Password?</a>
                </div>
                <br>
                <div class="buttons-3">
                    <button type="submit" name="submit" id="login-button-3">
                        Login</button>
                    <button onclick="regpage()" id="regbutton-3">Register</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        function backpage() {
            window.location.href = "http://localhost/Project-1/Home.html";
        }

        function regpage() {
            window.location.href = "http://localhost/Project-1/Webpages/PatientRegPage.php";
        }
    </script>
</body>

</html>