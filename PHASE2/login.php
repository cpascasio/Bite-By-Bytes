<html>
<head><title> Administrator Login </title></head>
<link rel="icon" href="img/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="style1.css">

<body>
  <header> 
    <img class="logo" src="logo.svg" alt="logo" height="80">
    <h1 style="color: white; text-align: center;"> &nbsp; Bite-By-Bytes </h1>
  </header>

<div class="login-card">
  <h1 style="color: #F16D20"> Administrator Login </h1>
  <form method="post" action="check.php">

  <hr>
  <br>

  <div class="form-group">
    <input type="text" placeholder="Username" name="username" size="25" required>
  </div>

  <div class="form-group">
    <input type="password" placeholder="Password" name="password" size="25" required>
  </div>
  
  <input type="submit" value="Login" name="loginBtn"/>

</form>
</div>  

<?php
      if(isset($_GET["error"])) {
          $error=$_GET["error"];
  
        // this line will be called by the check.php if the login credentials are incorrect 
         if ($error==1) {
            echo "<p align=center style='color: red;'> Username and/or password is invalid! Please try again. <br/></p>"; 
		   }
      }
 
   ?>

</body>
</html>