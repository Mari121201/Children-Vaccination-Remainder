<?php
$host="localhost";
$user="root";
$password="";
$database="cvrdb";

try{
    $connection=mysqli_connect($host,$user,$password,$database);
}catch(mysqli_sql_exception){
    header("Location:http://localhost/Project-1/notFound.html");
    exit();
}
?>