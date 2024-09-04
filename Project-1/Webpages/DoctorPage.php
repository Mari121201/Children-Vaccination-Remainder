<?php
include '../Private/database.php';
session_start();
try{
    if(isset($_POST['submit'])){
        $dcontact=$_POST['dcontact'];
        $dpassword=$_POST['dpassword'];
        $query="select * from doctor_details where dcontact='$dcontact' and dpassword='$dpassword'";
        $result=mysqli_query($connection,$query);
        $resultCheck=mysqli_num_rows($result);
        if($resultCheck>0){
            $_SESSION['dcontact']=$dcontact;
            $_SESSION['dpassword']=$dpassword;
            echo"<script>alert('Login successfully');
            window.location.href='http://localhost/Project-1/Webpages/DoctorHome.php';</script>";
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
    <title>Doctor Login Page</title>
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

        /*------------------------doctor login---------------------------*/
        .body-4 {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 1000px;
        }

        .body-4 .background-blur-4 {
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

        .body-4 .background-blur-4 .container-4 {
            padding-left: 12%;
        }

        .body-4 .background-blur-4 .back-4 {
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

        .body-4 .background-blur-4 .back-4 button {
            outline: none;
            border: none;
            background: transparent;
            color: rgb(129, 124, 124);
            font-size: 200%;
            font-weight: bold;
            cursor: pointer;
        }

        .body-4 .background-blur-4 .back-4:hover {

            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        }

        .body-4 .background-blur-4 .title-4 {
            text-align: center;
            padding: 0;
            padding-bottom: 0;
            font-size: 2em;
            font-weight: bold;
            cursor: default;
        }

        .body-4 .background-blur-4 .container-4 .input-details-4 {
            padding: 10px;
            text-align: left;
            font-size: 20px;
            font-weight: bold;
            line-height: 25px;
            margin-bottom: 30px;
            margin-top: 30px;

        }

        .body-4 .background-blur-4 .container-4 .input-details-4.left-side {
            text-align: right;
            padding-right: 20%;
        }

        .body-4 .background-blur-4 .container-4 .input-details-4 label {
            text-align: left;
        }

        .body-4 .background-blur-4 .container-4 .input-details-4 input {
            width: 80%;
            height: 30px;
            border-radius: 5px;
            outline: none;
            border: none;
            border: 1px solid black;
        }

        .body-4 .background-blur-4 .container-4 .buttons-4 {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .body-4 .background-blur-4 .container-4 .login-button-4 {
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

        .body-4 .background-blur-4 .container-4 .buttons-4 #regbutton-4 {
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

    <div class="body-4">
        <form class="background-blur-4" method="post" action="">
            <div class="back-4" title="Back to Home Page"><button onclick="backpage()" id="backtohome-1">
                    < </button>
            </div>
            <div class="title-4">Log in</div>
            <div class="container-4">
                <div class="input-details-4">
                    <label for="dcontact">Phone no </label>
                    <br>
                    <input name="dcontact" id="dcontact" type="tel" required>
                </div>
                <div class="input-details-4">
                    <label for="dpassword">Password </label>
                    <br>
                    <input name="dpassword" id="dpassword" type="password" required>
                </div>
                <div class="input-details-4 left-side">
                    <a href="#">Forgot Password?</a>
                </div>
                <br>
                <div class="buttons-4">
                    <button type="submit" name="submit" class="login-button-4">
                        Login</button>
                    <button onclick="regpage()" id="regbutton-4">Register</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        function backpage(){
            window.location.href="http://localhost/Project-1/Home.html";
        }function regpage(){
            window.location.href="http://localhost/Project-1/Webpages/DoctorRegPage.php";
        }
    </script>
</body>

</html>