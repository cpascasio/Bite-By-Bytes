
<?php
  session_start();
  require("connect.php"); //optional
  if(!isset($_SESSION["getLogin"])){
     header("location:login.php");
  } else {
?>

<html>
<head><title> Admin Page </title></head>
<link rel="icon" href="img/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="style2.css">

<body>

    <?php
        error_reporting(E_ERROR | E_PARSE);
        $user_id = $_SESSION['getLogin'];
        $user_name = $_SESSION['getName'];
    ?>

    <div class="sidebar">
        <div class="logo">
            <img class="logo" src="logo.svg" alt="logo" height="50"/>
            <h1> Bite-By-Bytes </h1>
        </div>

        <br>

        <ul class="side-menu">
            <li>
                <div class="side-div">
                <form action='addIMG.php' method='post'>
                    <img  src="addimg.svg" alt="logo" height="3.5%"/>
                    <input type="submit" class="button-menu" name="addIMG" value="Add an image" style="font-size: 16px"/>
                </form>
                </div>
            </li>
            <li>
                <div class="side-div">
                <form action='addInput.php'method='post'>
                <img  src="addinput.svg" alt="logo" height="3.5%"/>
                    <input type="submit" class="button-menu" name="addInput" value="Add via Input" style="font-size: 16px"/>
                </form>
                </div>
            </li>
            <li>
                <div class="side-div">
                <form action='addXML.php' method='post'>
                <img  src="addxml.svg" alt="logo" height="3.5%" />
                    <input type="submit" class="button-menu" name="addXML" value="Add via XML file" style="font-size: 16px" />
                </form>
                </div>
            </li>
            <li>
                <div class="side-div">
                <form action='update.php' method='post'>
                <img  src="update.svg" alt="logo" height="3.5%"/>
                    <input type="submit" class="button-menu" name="update" value="Update Record" style="font-size: 16px"/>
                </form>
                </div>
            </li>
            <li>
                <div class="side-div">
                <form action='delete.php' method='post'>
                <img  src="delete.svg" alt="logo" height="3.5%"/>
                    <input type="submit" class="button-menu" name="delete" value="Delete Record" style="font-size: 16px"/>
                </form>
                </div>
             </li>
             <li>
                <div class="side-div">
                <form action='report.php' method='post'>
                <img  src="report.svg" alt="logo" height="3.5%"/>
                    <input type="submit" class="button-menu" name="report" value="Generate Report" style="font-size: 16px"/>
                </form>
                </div>
            </li>
            <li>    
                <div class="logout">
                <form action="login.php" method="get">
                    <input type="submit" class="logout" value="Logout" name="LogoutBtn" style="font-size: 16px; margin-top: 10px">
                </form>
                </div>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header-wrapper">
            <div class="header-title">
                <span><b>Admin</b></span>
                <h1>Dashboard</h1>
            </div>
            <div class="user-info">
                <img src="user-icon.svg" alt="user-icon" />
                <span><b><?php echo "Welcome,<br> ".$user_name; ?></b></span>
            </div>
        </div>


        <div class="table-content">
        <?php
            $studQuery = mysqli_query($conn, "SELECT f.foodCode AS foodCode, f.name AS name, f.category AS category, f.price AS price FROM food f");
            if($user_id != null){
        ?>

            <h3 class="main-title">Food Record</h3>
            <h4> Category Legend: </h4>
            <p> M - Main Dish | S - Side Dish | D - Drink </p>
            <br>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Food Code</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                
                    <?php
                        while($studResult = mysqli_fetch_assoc($studQuery)){
                            echo "<tr>";
                            echo "<td>".$studResult['foodCode']."</td>";
                            echo "<td>".$studResult['name']."</td>";
                            echo "<td>".$studResult['category']."</td>";
                            echo "<td>".$studResult['price']."</td>";
                            echo "</tr>";        
                        }
                    ?>
                </table>
            </div>
        </div>

        <div class="table-content">
            <h3 class="main-title">Combo Record</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Combo ID</th>
                            <th>Name</th>
                            <th>Main Code</th>
                            <th>Side Code</th>
                            <th>Drink Code</th>
                            <th>Combo Price</th>
                        </tr>
                    </thead>
                
                    <?php
                        $studQuery = mysqli_query($conn, "SELECT c.comboID AS comboID, c.name AS name, c.mainCode AS mainCode, c.sideCode AS sideCode, c.drinkCode AS drinkCode, c.comboPrice as comboPrice FROM combos c");
                        while($studResult = mysqli_fetch_assoc($studQuery)){
                            echo "<tr>";
                            echo "<td>".$studResult['comboID']."</td>";
                            echo "<td>".$studResult['name']."</td>";
                            echo "<td>".$studResult['mainCode']."</td>";
                            echo "<td>".$studResult['sideCode']."</td>";
                            echo "<td>".$studResult['drinkCode']."</td>";
                            echo "<td>".$studResult['comboPrice']."</td>";
                        }
                    ?>
                </table>
            </div>
        </div>
        <div class="table-content">
                <h3 class="main-title">Image Record</h3>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Image ID</th>
                                <th>Original Name</th>
                                <th>mime_type</th>
                                <th>image_data</th>
                                <th>Image Display</th>
                            </tr>
                        </thead>
            <?php
                $studQuery = mysqli_query($conn, "SELECT i.imageID AS imageID, i.originalName AS originalName, i.mime_type AS mime_type, i.image_data AS image_data FROM images i");
                while($studResult = mysqli_fetch_assoc($studQuery)){
                    echo "<tr>";
                    echo "<td>".$studResult['imageID']."</td>";
                    echo "<td>".$studResult['originalName']."</td>";
                    echo "<td>".$studResult['mime_type']."</td>";
                    echo "<td>".$studResult['image_data']."</td>";
                    echo "<td><img src='../public/".$studResult['image_data']."' alt='Image' width='75'></td>";
                }
            ?>
                    </table>
                </div>
            </div>

    </div>

            <?php
                } else{
                    echo "<h2> User ID Not found! </h2> </br>";
                }
  }
         ?>


</body>
</html>