<?php
require("functions.php"); 
session_start();
if(!isset($_SESSION['userid'])){
    header("refresh:2; url=index.php");
    exit("<center><h1>Please login</h1></center>"); 
}
$userid = $_SESSION['userid'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Questionnaire</title>
        <style type="text/css" media="all">
        body {
        font-family:Arial,Helvetica,sans-serif;font-size:100%;
        } 
        table{
            width: 972px;
            border: none;
            border-collapse:collapse;
        }
        td{
            vertical-align: top;
        }
        .t1{
            border-bottom: #ff0000 1px solid;
        }
        .gradient{
            width: 100%;
            /*height: 700px;*/
            text-align: center;
            background: -moz-linear-gradient(top, #FFB90F, white);
            background:-webkit-gradient(linear,0 0, 0 bottom, from(#FFB90F), to(white)) no-repeat;
            filter:progid:DXImageTransform.Microsoft.gradient(startcolorstr=#FFB90F,endcolorstr=white,gradientType=0);
            -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startcolorstr=#FFB90F,endcolorstr=white,gradientType=0)";
        }
        .button {
            -moz-box-shadow:inset 0px 1px 0px 0px #fceaca;
            -webkit-box-shadow:inset 0px 1px 0px 0px #fceaca;
            box-shadow:inset 0px 1px 0px 0px #fceaca;
            background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #ffce79), color-stop(1, #eeaf41) );
            background:-moz-linear-gradient( center top, #ffce79 5%, #eeaf41 100% );
            filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffce79', endColorstr='#eeaf41');
            background-color:#ffce79;
            -moz-border-radius:6px;
            -webkit-border-radius:6px;
            border-radius:6px;
            border:1px solid #eeb44f;
            display:inline-block;
            color:#ffffff;
            font-family:arial;
            font-size:15px;
            font-weight:bold;
            padding:6px 24px;
            text-decoration:none;
            text-shadow:1px 1px 0px #ce8e28;
        }.button:hover {
            background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #eeaf41), color-stop(1, #ffce79) );
            background:-moz-linear-gradient( center top, #eeaf41 5%, #ffce79 100% );
            filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#eeaf41', endColorstr='#ffce79');
            background-color:#eeaf41;
        }.button:active {
            position:relative;
            top:1px;
        }
        </style>
        <link rel="stylesheet" type="text/css" href="css/SimpleTree.css"/>
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
        <script type="text/javascript" src="js/custom.js"></script>
        <script type="text/javascript" src="js/jquery-1.6.min.js"></script>
        <script type="text/javascript" src="js/SimpleTree.js"></script>
        
        <script src="js/jquery-ui-1.10.2.custom.min.js"></script>
       
        <script type="text/javascript">
        $(document).ready(function(){
            $(".st_tree").SimpleTree({
                click:function(a){
                    /*if(!$(a).attr("hasChild") && $(a).attr('ref')=='x' )
                        window.location.href="module.php?module="+$(a).attr('id');*/
            }
        });
        });                              
        </script>
    </head>
    <body >
        <table align='center' class='gradient'>
            
            <tr><td>
                <img src="image\title.jpg">
            </td></tr>
        </table>
        
        <div id="contentWrapLeft">
        <form id="f1" name='f1' method='post' action='search.php'>
        <table border="0"  align='center'>
            <tr>
                <td>
                    <font color="orange">Module</font>
                    <input type="text" name="module" id="module" value="<?php echo $_POST['module']?>"/>
                    <input type="submit" name="search" value="search" class='button'/>
                    <a href='domain.php' class='button'>Back</a>
                    <a href='index.php?action=logout' class='button'>Logout</a>
                </td>
            </tr> 
        </table>
        </form>
        <div class="st_tree">
        <table align='center'>
        <?php
        include('conn.php');
        $domainID = $_GET['domainID'];
       
        if(!isset($_POST['module'])){
            $sql = "select domain from domain where domainID='$domainID' ";
            $query = sqlsrv_query($conn, $sql);
            $result = sqlsrv_fetch_array($query);
           
            $subdomainquery = "select * from subdomain where domainID='$domainID' ";
            $subdomainrst = sqlsrv_query($conn, $subdomainquery);
            //echo "<ul show='true'>";
            //echo "<li>$domain</li>";
            echo "<table class='t1' align='center'><tr><td width='300px' style='text-align: center'>";
            ?>
            <div class='productImageWrap' id='productImageWrap'>
            
                <p><img src='image/folder.png' alt="Product" class='img1'/><br/><div style='padding: 0px 0px 0px 20px'><font size='+2'><?php echo $result[0]; ?></font></div><br/></p></td>
                <td>
                <ul show='true'>
            </div>
            <?php
            while($subdomainrow=sqlsrv_fetch_array($subdomainrst)){
                $subdomainID = $subdomainrow['subdomainID'];
                $subdomain = $subdomainrow['subdomain'];
               
                $modulequery = "select * from module where subdomainID = '$subdomainID' ";
                $modulerst = sqlsrv_query($conn, $modulequery);
                echo "<li>$subdomain</li>";
                echo "<ul show='true'>";
                while($modulerow=sqlsrv_fetch_array($modulerst)){
                    $module = $modulerow['module'];
                    echo "<div class='productPriceWrapRight'>";
                    echo "<li><a id='$module' href='module.php?module=$module' ref='x'>$module</a>
                        <a href='document/$module.docx'><img src='image/download.png' width=25px ></a>";
               
                    
                    echo "<a href='functions.php?action=addToBasket&productID=".$module."' onClick='return false;'>";
                         
                        $basketquery="SELECT * FROM basket WHERE username = '$userid' and itemid='$module'";
                        $result = sqlsrv_query($conn,$basketquery) or die(sqlsrv_errors());
                        if(sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
                            {   echo" <img src='image/plus.png' alt='Add To Basket' width='25' id='featuredProduct_".$module."' style='display:none' >";}
                        else 
                            {
                               echo" <img src='image/plus.png' alt='Add To Basket' width='25' id='featuredProduct_".$module."' >";
                            }
                   
                    echo "</a>
                           </li>";
                    echo "</div>";
                    
                }
                echo "</ul>";
            }
            echo "</ul>";
            echo "</ul>";
            echo "</td></tr></table>";
        }
       
        else{
            $modulekey= $_POST['module'];
            $sql="select * from module where module like '%$modulekey%'";
            $request = sqlsrv_query($conn, $sql);
            $result = sqlsrv_fetch_array($request);
            if(!$result[0] || $modulekey==''){
         
         
                echo "<table align='center'><tr><td>";
                echo "<img src='image\alert.png'><br/>";
                echo "No record could be found by keyword \"<font color='red'>$modulekey</font>\"";
                echo "</td></tr></table>";
            }
            //echo "<ul show='true'>";
            else{
            $domainquery = "select domain from domain where domainID in (select domainID from subdomain where subdomainID in(select subdomainID from module where module like '%$modulekey%'))";
            $domainrst = sqlsrv_query($conn, $domainquery);
            while($domainrow = sqlsrv_fetch_array($domainrst)){
                $domain = $domainrow['domain'];
                
                $subdomainquery = "select * from subdomain where subdomainID in(select subdomainID from module where module like '%$modulekey%')";
                $subdomainrst = sqlsrv_query($conn, $subdomainquery);
                echo "<table class='t1' align='center'><tr><td width='300px' style='text-align: center'>";
                echo "<div class='productImageWrap' id='productImageWrap'>";
                echo "<p><img src='image/folder.png' class='img1'/><br/><div style='padding: 0px 0px 0px 20px'><font size='+2'>$domain</font></div><br/></p>";
                echo "</div>";
                echo "</td>";
                //echo "<li>$domain</li>";
                echo "<td>";
                echo "<ul show='true'>";
                while($subdomainrow=sqlsrv_fetch_array($subdomainrst)){
                    $subdomainID = $subdomainrow['subdomainID'] ;
                    $subdomain=$subdomainrow['subdomain'];
                    $modulequery = "select module from module where subdomainID = '$subdomainID' and module like '%$modulekey%' ";
                    $modulerst = sqlsrv_query($conn, $modulequery);
                    echo "<li>$subdomain</li>";
                    echo "<ul show='true'>";
                    while($modulerow=sqlsrv_fetch_array($modulerst)){
                        $module = $modulerow['module'];
                        echo "<div class='productPriceWrapRight'>";
                        echo "<li><a id='$module' href='module.php?module=$module' ref='x'>$module</a>
                            <a href='document/$module.docx'><img src='image/download.png' width=25px ></a>";
                        echo "<a href='functions.php?action=addToBasket&productID=".$module."' onClick='return false;'>";
                        
                        $basketquery="SELECT * FROM basket WHERE username = '$userid' and itemid='$module'";
                        $result = sqlsrv_query($conn,$basketquery) or die(sqlsrv_errors());
                        if(sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
                            {   echo" <img src='image/plus.png' alt='Add To Basket' width='25' id='featuredProduct_".$module."' style='display:none' >";}
                        else 
                            {
                               echo" <img src='image/plus.png' alt='Add To Basket' width='25' id='featuredProduct_".$module."' >";
                            }
                       
                        echo "</a>
                            </li>";
                    echo "</div>";
                    }
                    echo "</ul>";
                }
                echo "</ul>";
                echo "</td></tr></table>";
            }
            }
        }
        echo "</ul>";
        sqlsrv_close($conn);
        ?>
        </table>
        </div>
        </div>
        <div id="contentWrapRight">
			<div id="basketWrap">
				<div id="basketTitleWrap">
					Module Selected <span id="notificationsLoader"></span> 
                                        
				</div>
				<div id="basketItemsWrap">
					<ul id="sortable">
					<li></li>
					<?php getBasket(); ?>
                                        <li>
                                        </li>
					</ul>
                                        <div id="basketTitleWrap">
                                            Total Items: <span id="totalitems"></span> <a href='checkout.php' class='button2'>Download All</a>
                                        </div>
				</div>
			</div>
			
	</div>
       
        
    </body>
</html>