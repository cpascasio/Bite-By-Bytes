<?php
  session_start();
  require("connect.php"); //optional
  if(!isset($_SESSION["getLogin"])){
     header("location:login.php");
  } else {
?>

<html>
<head><title> Upload XML and Insert Data </title></head>
<link rel="icon" href="img/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="style5.css">

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
                <div class="side-div">
                <form action='main.php' method='post'>
                <img  src="back.svg" alt="logo" height="3.5%"/>
                    <input type="submit" class="button-menu" name="backBtn" value="Back to Main Page" style="font-size: 14.4px"/>
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

    <div class="table-cards">

    <div class="add-food">
        <br>
        <h2 style="color: #F16D20"> Add Food via XML file : </h2>
        <br>
        <hr>
        <br>
        <form method="post" action='<?php echo $_SERVER["PHP_SELF"];?>' enctype="multipart/form-data">
        
        <?php
            $count = 0;
            
            if(isset($_POST["uploadFood"])){
                if(isset($_FILES["xmlFilefood"])) {
                $xmlFile = $_FILES["xmlFilefood"]["tmp_name"];
                $foodexists = false;
                $imageIDexists = false;
                // Load the XML and XSD files
                $xmlFilePath = $xmlFile;
                $xsdFilePath = "foodChecker.xsd";

                $xml = new DOMDocument();
                $xml->load($xmlFilePath);

                $xsd = new DOMDocument();
                $xsd->load($xsdFilePath);

                // Validate the XML against the XSD
                if ($xml->schemaValidate($xsdFilePath)) {
                    echo "XML is valid according to the XSD.";
                    // Process the XML data


                    if(file_exists($xmlFile)){
                        $xml = simplexml_load_file($xmlFile);
                        foreach($xml->food as $food){
                            $studQuery = mysqli_query($conn, "SELECT f.foodCode AS foodCode, f.name AS name, f.category AS category, f.price AS price, f.imageID as imageID FROM food f");
                            $studQuery2 = mysqli_query($conn, "SELECT i.imageID AS imageID, i.originalName AS originalName, i.mime_type AS mime_type, i.image_data AS image_data FROM images i");   
                            $foodexists = false;
                            $imageIDexists = false;           
                            while($studResult = mysqli_fetch_assoc($studQuery)){
                                if($food->name == $studResult['name']){
                                // echo $food->name." STUDRESULT ".$studResult['name']."<br>";
                                echo $studResult['name']." already exists in food record.<br>";
                                $foodexists = true;
                                break;
                                }else{
                                // echo "Food does not exist! </br>";
                                $foodexists = false;
                                }
    
                            }
                            while($studResult2 = mysqli_fetch_assoc($studQuery2)){
                                if($food->imageID == $studResult2['imageID']){
                                    // echo $food->imageID." STUDRESULT ".$studResult2['imageID']."<br>";
                                    // echo "Image exists <br>";
                                    $imageIDexists = true;
                                    break;
                                    }else{
                                    // echo "Image does not exist! </br>";
                                    $imageIDexists = false;
                                    }
                            }
    
                                                    
                            // Load the XML and XSD files
                            if($foodexists == false && $imageIDexists == true){
                                    $foodCode = $food->foodCode;
                                    $name = $food->name;
                                    $category = $food->category;
                                    $price = $food->price;
                                    $imageID = $food->imageID;
                                    $insert = "INSERT INTO food VALUES ($foodCode, '$name', '$category', $price, $imageID)";
                                    if(mysqli_query($conn, $insert)){
                                        echo $name." has been successfully added! </br>";
                                    }else{
                                        echo "Failed to add new food.";
                                    }
                                    
                            }
                        }
                        // echo "XML file has been successfully uploaded and inserted! </br>";
                        }else{
                            echo "File does not exist! </br>";
                        }

                    
                } else {
                    echo "XML is not valid according to the XSD.";
                    $errors = libxml_get_errors();
                    foreach ($errors as $error) {
                        echo $error->message . "<br>";
                    }
                    libxml_clear_errors();
                }

                    
                }
            }
        ?>

        <input type="file" name="xmlFilefood" required>
        <input type="submit" class="buttonChoice" name="uploadFood" value="Upload Food Data">
        </form>
    </div>

    <div class="add-combos">
        <br>
        <h2 style="color: #F16D20"> Add Combo via XML file: </h2>
        <br>
        <hr>
        <br>
        <form method="post" action='<?php echo $_SERVER["PHP_SELF"];?>' enctype="multipart/form-data">

        <?php
            if(isset($_POST["uploadCombo"])){
                if(isset($_FILES["xmlFilecombo"])) {
                $xmlFile = $_FILES["xmlFilecombo"]["tmp_name"];
                $comboexists = false;

                // Load the XML and XSD files
                $xmlFilePath = $xmlFile;
                $xsdFilePath = "comboChecker.xsd"; // Adjust the path accordingly

                $xml = new DOMDocument();
                $xml->load($xmlFilePath);

                $xsd = new DOMDocument();
                $xsd->load($xsdFilePath);

                // Validate the XML against the XSD
                if ($xml->schemaValidate($xsdFilePath)) {
                    echo "XML is valid according to the XSD.";
                    // Process the XML data
                    
                    if(file_exists($xmlFile)){
                        $xml = simplexml_load_file($xmlFile);
                        foreach($xml->combos as $combos){
                            $comboexists = false;
                            $comboQuery = mysqli_query($conn, "SELECT c.comboID AS comboID, c.name AS name, c.mainCode AS mainCode, c.sideCode AS sideCode, c.drinkCode AS drinkCode, c.comboPrice as comboPrice FROM combos c");
                            while($comboResult = mysqli_fetch_assoc($comboQuery)){
                                if($combos->name == $comboResult['name']){
                                    // echo $combos->name." STUDRESULT ".$comboResult['name']."<br>";
                                    echo $comboResult['name']." combo already exists <br>";
                                    $comboexists = true;
                                    break;
                                }else{
                                    // echo $combos->name." STUDRESULT ".$comboResult['name']."<br>";
                                    // echo "Combo does not exist <br>";
                                    $comboexists = false;
                                }
                            }
    
                            // Load the XML and XSD files
                            
    
                            
    
    
                            if($comboexists == false){
                                $studQuery = mysqli_query($conn, "SELECT f.foodCode AS foodCode, f.name AS name, f.category AS category, f.price AS price FROM food f");
                                $mainexists = false;
                                $sideexists = false;
                                $drinkexists = false;
    
                                $comboID = $combos->comboID;
                                $name = $combos->name;
                                $mainCode = $combos->mainCode;
                                $sideCode = $combos->sideCode;
                                $drinkCode = $combos->drinkCode;
                                while($studResult = mysqli_fetch_assoc($studQuery)){
                                    if($mainCode == $studResult['foodCode'] && $mainexists == false){
                                        $mainexists = true;  
                                        // echo $mainCode."==".$studResult['foodCode']."<br>";
                                        // echo "mainCode exists<br>".$mainexists;      
                                    }else{
                                        $mainexists = false;
                                        // echo $mainCode."==".$studResult['foodCode']."<br>";
                                        // echo "mainCode not exists<br>".$mainexists;
                                    }
    
                                    if($sideCode == $studResult['foodCode'] && $sideexists == false){
                                        $sideexists = true;
                                        // echo $sideCode."==".$studResult['foodCode']."<br>";
                                        // echo "sideCode exists<br>".$sideexists;   
                                    }else{
                                        $sideexists = false;
                                        // echo $sideCode."==".$studResult['foodCode']."<br>";
                                        // echo "sideCode not exists<br>".$sideexists;
                                    }
    
                                    if($drinkCode == $studResult['foodCode'] && $drinkexists == false){
                                        $drinkexists = true;
                                        // echo $drinkCode."==".$studResult['foodCode']."<br>";
                                        // echo "drinkCode exists<br>".$drinkexists;   
                                    }else{
                                        $drinkexists = false;
                                        // echo $drinkCode."==".$studResult['foodCode']."<br>";
                                        // echo "drinkCode not exists<br>".$drinkexists;  
                                    }
                                }
                                $comboPrice = $combos->comboPrice;
                                // echo "Main Exists: " . ($mainexists ? 'true' : 'false') . " Side Exists: " . ($sideexists ? 'true' : 'false') . " Drink Exists: " . ($drinkexists ? 'true' : 'false');
    
                                if ($mainexists == false && $sideexists == false && $drinkexists == false){
                                    // echo "ANDITO KA BAAA?? </br>";
                                    // echo "comboID: ".$comboID."</br>";
                                    // echo "name: ".$name."</br>";
                                    // echo "mainCode: ".$mainCode."</br>";
                                    // echo "sideCode: ".$sideCode."</br>";
                                    // echo "drinkCode: ".$drinkCode."</br>";
                                    // echo "comboPrice: ".$comboPrice."</br>";
                                    $insert = "INSERT INTO combos VALUES ($comboID, '$name', $mainCode, $sideCode, $drinkCode, $comboPrice)";
                                    // $insert = "INSERT INTO combos VALUES (4, 'MIN8888', 3, 7, 9, 101)";
                                    // echo "AFTER INSERT </br>";
                                    // $added = mysqli_query($conn, $insert);
                                    // echo "AFTER ADDED </br>";
                                    if(mysqli_query($conn, $insert)){
                                        echo $name." has been successfully added!  <br>";
                                        // echo "Record has been successfully inserted! </br>";
                                    }else{
                                        echo "Failed to insert record!Error: " . mysqli_error($conn) . "</br>";
                                    }
                                }else{
                                    echo "Combo already exists. </br>";
                                } 
                           }
    
    
                            
    
                        }
                        }else{
                            echo "File does not exist</br>";
                        }


                    // Process the XML data and perform insertion here
                } else {
                    echo "XML is not valid according to the XSD.";
                    $errors = libxml_get_errors();
                    foreach ($errors as $error) {
                        echo $error->message . "<br>";
                    }
                    libxml_clear_errors();
                }

                    
                }
            }
        ?>

            <input type="file" name="xmlFilecombo" required>
            <input type="submit" class="buttonChoice" name="uploadCombo" value="Upload Combo Data">
        </form>
    </div>
    </div>

    <div class="table-content">
            <?php
                $studQuery = mysqli_query($conn, "SELECT f.foodCode AS foodCode, f.name AS name, f.category AS category, f.price AS price FROM food f");
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
        }
    ?>

</body>
</html>