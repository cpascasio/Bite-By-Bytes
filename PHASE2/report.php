<?php
session_start();
require("connect.php"); //optional
if(!isset($_SESSION["getLogin"])){
    header("location:login.php");
} else {
   
?>

<html>
    <head><title>Generate Summary Report</title></head>
    <link rel="stylesheet" href="style8.css">

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
            <div class="generate-fromdate">
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
                    <h1 style="color: #F16D20"> Generate Report </h1>
                    <br>
                    <h2>Select Start Date:</h2>
                    <input type="date" name="startDate" required>
                    <br><br>
                    <h2>Select End Date:</h2>
                    <input type="date" name="endDate" required>
                    <br><br>
                    <h3>Input File Name:</h3>
                    <input type="text" name="fileName" required>.xml
                    <br><br>
                    <input type="submit" class="buttonChoice" name="generate" value="Generate">

                </form>
            </div>
        </div>

        <?php
        $fileName = $_POST['fileName'].'.xml'; 
        $xmlFilePath = "./reports/".$fileName;
        // echo "FILE NAME: ".$fileName;
        // echo "<br>FILE PATH: ".$xmlFilePath;
         // Load the existing XML file if it exists, or create a new one if it doesn't
         if (file_exists($xmlFilePath)) {
            // echo "FILE EXISTS!";
            $summary = simplexml_load_file($xmlFilePath);
            $fileExists = true;
        } else {
            $summary = new SimpleXMLElement('<summary></summary>'); // Create a new XML document
        }

            if(isset($_POST['generate'])) {  ?>

                <div class="table-content">

                <?php 
                $startDate = $_POST['startDate']; 
                $endDate = $_POST['endDate']; 
                

                // date_default_timezone_set('Asia/Manila'); // Set timezone to MNL
                // $script_tz = date_default_timezone_get();

                // if (strcmp($script_tz, ini_get('date.timezone'))){
                //     echo 'Script timezone differs from ini-set timezone.';
                //     echo "Default Timezone:".$script_tz;
                //     echo "<br>".ini_get('date.timezone');
                // } else {
                //     echo 'Script timezone and ini-set timezone match.';
                // }
            

                //echo "Generate: ".$_POST['generate'];
                //echo "<br>Start Date: ".$startDate;
                //echo "<br>End Date: ".$endDate;

                // Add 1 day to the end date
                $endDateAdjusted = date('Y-m-d', strtotime($endDate . ' + 1 day'));

                $sql = "SELECT  date, 
                                m1, s1, d1,
                                totalPrice, 
                                discountPrice 
                        FROM    receipts 
                        WHERE   date BETWEEN '$startDate' AND '$endDateAdjusted' 
                        GROUP BY date;";
                $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                //echo "<br>Date found!.";
                // Process the data
                $totalDishesSold = 0;
                $totalAmount = 0;
                $totalDiscount = 0;

        ?>
            <h3 class="main-title">Generated Report (<?php echo $startDate;?> to <?php echo $endDate;?>)</h3>
            <div class="table-container">
            <table>
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Main Quantity</th>
                    <th>Side Quantity</th>
                    <th>Drinks Quantity</th>
                    <th>Total Price</th>
                    <th>Discount Price</th>
                </tr>
                </thead>

                <?php
                while ($row = $result->fetch_assoc()) {
                    // var_dump($row);
                    // echo "ROW".$row;
                    $counter++;
                        $totalM1 += $row['m1'];
                        $totalS1 += $row['s1'];
                        $totalD1 += $row['d1'];
                        $totalDishesSold = ($totalM1 + $totalS1 +$totalD1);
                        // echo "COUNTER:".$counter."<br>TOTAL DISHES SOLD:".$totalDishesSold."=".$totalM1."(m1)+".$totalS1 ."(m2)+".$totalD1."(m3)";
                        // $totalDishesSold += ($row['m1'] + $row['s1'] + $row['d1']);
                        // echo "<br>TOTAL DISHES SOLD:".$totalDishesSold."=".$row['m1']."(m1)+".$row['s1'] ."(m2)+". $row['d1']."(m3)";
                        $totalAmount += $row['totalPrice'];
                        // echo "<br>Total Price:".$totalAmount;
                        $totalDiscount += $row['discountPrice'];
                        // echo "<br>Total Price:".$totalDiscount;
                ?>

                <tr>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['m1']; ?></td>
                    <td><?php echo $row['s1']; ?></td>
                    <td><?php echo $row['d1']; ?></td>
                    <td><?php echo $row['totalPrice']; ?></td>
                    <td><?php echo $row['discountPrice']; ?></td>
                </tr>
                    

                <?php
                    }
                    // echo "TOTAL DISHEs SOLD:".$totalDishesSold."=".$row['m1']."(m1)+".$row['s1'] ."(m2)+". $row['d1']."(m3)";
                    $totalDishesSold = ($totalM1 + $totalS1 +$totalD1);
                    // echo "<br>TOTAL DISHES SOLD:".$totalDishesSold."=".$totalM1."(m1)+".$totalS1 ."(m2)+".$totalD1."(m3)";
                ?>
                    <tfoot style="color: #DA7E0D">
                    <h3>Total Dishes Sold: <?php echo $totalDishesSold; ?> </h3>
                    <h3>Total Amount: Php <?php echo number_format($totalAmount, 2); ?></h3>
                    <h3>Total Discount: Php <?php echo number_format($totalDiscount, 2); ?><br><br></h3>
                  
                    </tfoot>

            </table>
            </div>


       <?php
       
         // Create an XML structure for the summary data
         $report = $summary->addChild('report');
         $report->addChild('startDate', $startDate);
         $report->addChild('endDate', $endDate);
         $report->addChild('totalDishesSold', $totalDishesSold);
         $report->addChild('totalAmount', $totalAmount);
         $report->addChild('totalDiscount', $totalDiscount);
        
        // $summary->formatOutput = true;
        $xmlFilePath = "./reports/".$fileName;
    
         // Save the XML to a file
         file_put_contents($xmlFilePath, $summary->asXML());
        //  var_dump(file_exists($xmlFilePath));
         if(file_exists($xmlFilePath))
         {
            echo "<h4><center>".$fileName." report has been generated.</center></h4>";
         }else{
            echo "<h3><center>Failed to generate report.</center></h3>";
         }

    } else {
        echo "<br><h3><center>No orders found for the specified date range.</center></h3>";
    } ?>
    </div>
    <?php
}
?>

<div class="table-content">
<h3 class="main-title">Generated XML File</h3>
<?php echo "<h4> File Name: ".$fileName."</h4>";?>
<div class="table-container">
    <table>
		<thead>
			<tr>
				<th>Start Date</th>
				<th>End Date</th>
				<th>Total Dishes Sold</th>
				<th>Total Amount</th>
                <th>Total Discount</th>
			</tr>
		</thead>

		<tbody>
 		<?php
			$xml = simplexml_load_file($xmlFilePath);
				foreach($xml->report as $report){
                    echo '	
                        <tr>
                            <td>'.$report->startDate.'</td>
                            <td>'.$report->endDate.'</td>
                            <td>'.$report->totalDishesSold.'</td>
                            <td>'.$report->totalAmount.'</td>
                            <td>'.$report->totalDiscount.'</td>
                        </tr>
                    ';
				}
                
		?>
		</tbody>
    </table>
    </div>


</div>
</body>
</html>
<?php } ?>

