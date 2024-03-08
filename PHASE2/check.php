<?php 
require("connect.php"); //optional
if (isset($_POST["loginBtn"]))
 {
    $user=$_POST["username"];
    $pass=$_POST["password"];

    $studQuery = mysqli_query($conn, "SELECT u.userID AS id, u.name AS name, u.user AS username, u.pass AS password FROM users u WHERE u.user='$user'
    AND u.pass='$pass'");

    $fetch = mysqli_fetch_array($studQuery);

    if($user==$fetch["username"] && $pass==$fetch["password"]) 
    {
      session_start();  //to start the session
      $_SESSION['getLogin'] = $fetch["id"];  //this will hold the session variable to identify the user of the system
      $_SESSION['getName'] = $fetch["name"];  //this will hold the session variable to identify the name of the user
      header("location:main.php");  //this sets the headers for the HTTP response given by the server 
    }
   else
    {
      header("location:login.php?error=1");
    }
}
?>