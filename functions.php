<?php 

require("conn.php"); 

session_start();
if(!isset($_SESSION['userid'])){
    header("refresh:2; url=index.php");
    exit("<center><h1>Please login</h1></center>"); 
}
$userid = $_SESSION['userid'];

if($_POST['action'] != '' || $_GET['action'] != '') {
	if($_POST['action'] == '')
	{
		$action 	= $_GET['action'];
		$productID	= $_GET['productID'];
                $linum          = $_GET['num'];
		$noJavaScript = 1;
	} else {
		$action 	= $_POST['action'];
		$productID	= $_POST['productID']; 
                $linum          = $_POST['num'];
		$noJavaScript = 0;
	}
}

if ($action =="updatelinum"){
    $query  = "UPDATE basket SET num=$linum WHERE username = '$userid' AND id = '$productID'";
    sqlsrv_query($conn, $query);
}
	
if ($action == "addToBasket"){
    
        $query  = "SELECT * FROM basket WHERE username = '$userid'";
        $result = sqlsrv_query($conn, $query);
        $maxnum=0;
        while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
            if($row[num]>$maxnum)$maxnum=$row[num];
        }

	$query  = "SELECT * FROM basket WHERE username = '$userid' AND itemid = '$productID'";
        $result = sqlsrv_query($conn, $query);
        if(!sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) 
        {
        $maxnum++;
        $x=hash(md4,  microtime());
	$query = "INSERT INTO basket (num,id,username,itemid) VALUES ($maxnum,'$x','$userid','$productID')";
	sqlsrv_query($conn, $query) or die('Error, insert query failed');	
	
	
	
	
	if ($noJavaScript == 1) {
		header("Location:javascript:history.back(-1)");
	} else {
              
             
		echo "<li id='productID_$x'>
		<a  id='$productID' href='functions.php?action=deleteFromBasket&productID=$x' onClick='return false;'>
			<img src='image/delete.png' id='$productID"."_$x'>
		</a>
		<a href='module.php?module=$productID'>".$productID."</a>
                  <img src='image/updown.png' width=20px style='position: absolute;right:50px;'>  
                <a href='document/$productID.docx'><img src='image/download.png' width=25px style='position: absolute;right:20px;'></a>
                        
		</li>";
            }
        }
}


if ($action == "deleteFromBasket"){
	
	$query = "DELETE FROM basket WHERE id ='$productID' AND username = '$userid'";
	sqlsrv_query($conn, $query) or die('Error, delete query failed');
		
	if ($noJavaScript == 1) {
		header("Location:javascript:history.back(-1)");
	}	
}


function getBasket(){
	require("conn.php"); 
	session_start();
	if(!isset($_SESSION['userid'])){
	    header("refresh:2; url=index.php");
	    exit("<center><h1>Please login</h1></center>"); 
	}
	$userid = $_SESSION['userid'];
	
	
	$query  = "SELECT * FROM basket WHERE username = '$userid' order by num ";
	$result = sqlsrv_query($conn,$query) or die(sqlsrv_errors());
	
	while($row =sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
	{
              
		$productID=$row['itemid'];
                 $x=$row['id'];
                
		echo "<li id='productID_$x'>
		<a id='$productID' href='functions.php?action=deleteFromBasket&productID=$x' onClick='return false;'>
			<img src='image/delete.png' id='$productID"."_$x'>
		</a>
		<a href='module.php?module=$productID'>".$productID."</a>
                    <img src='image/updown.png' width=20px style='position: absolute;right:50px;'>  
                <a href='document/$productID.docx'><img src='image/download.png' width=25px style='position: absolute;right:20px;'></a>
		</li>";
		
	}
     
	
}


	

?>