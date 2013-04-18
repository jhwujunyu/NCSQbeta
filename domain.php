<?php
session_start();
if(!isset($_SESSION['userid'])){
    header("refresh:2; url=index.php");
    exit("<center><h1>Please login</h1></center>"); 
}
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
        table{
            width: 972px;
            border: none;
            border-collapse:collapse;
        }
        th, td{
            text-align: center;
        }
        .tleft{
            text-align: left;
        }
        img{
            border: none;
        }
        .img1:hover{
            max-height: 90%;
            max-width: 90%;
        }
        .img1{
            max-height: 80%;
            max-width: 80%;
        }
        </style>
    </head>
    <body>
        <table class='gradient' align='center'>
            <tr><td>
                <img src="image\title.jpg">
            </td></tr>
        </table>
        <form id="f1" name='f1' method='post' action='search.php'>
        <table border="0" width='973' align='center'>
            <tr>
                <td class='tleft'>
                    <font color="orange">Module</font>
                    <input type="text" name="module" id="module" value="<?php echo $_POST['module']?>"/>
                    <input type="submit" name="search" value="search" class='button'/>
                    <a href='index.php?action=logout' class='button'>Logout</a>
                </td>
            </tr> 
        </table>
        </form>
        <table align='center'>
            <tr><td height='50'></td></tr>
            <tr>
                <td>
                    <a href='search.php?domainID=PSY'><img src="image/folder.png" class='img1'/><br/></a>
                    <a href='search.php?domainID=PSY'>Psychosocial<br/></a>
                    <?php
                    include('conn.php');
                    
                    $sql = "select count(*)count from module where subdomainID in (select subdomainID from subdomain where domainID='PSY')";
                    $rst = sqlsrv_query($conn, $sql);
                    $row = sqlsrv_fetch_array($rst);
                    $count = $row['count'];
                   
                    $sql = "select count(*)count from subdomain where domainID='PSY' ";
                    $rst = sqlsrv_query($conn, $sql);
                    $row = sqlsrv_fetch_array($rst);
                    $subcount = $row['count'];
                    if($subcount <= 1){
                        $sub = 'subdomain';
                    }
                    else{
                        $sub = 'subdomains';
                    }
                    if($count=='0'){
                        echo "<a href='search.php?domainID=PSY'>0 module in $subcount $sub<br/></a>";
                    }
                    else if($count == '1'){
                        echo "<a href='search.php?domainID=PSY'>1 module in $subcount $sub<br/></a>";
                    }
                    else{
                        echo "<a href='search.php?domainID=PSY'>$count modules in $subcount $sub<br/></a>";
                    }
                    ?>
                </td>
                <td>
                    <a href='search.php?domainID=DEM'><img src="image/folder.png" class='img1'/><br/></a>
                    <a href='search.php?domainID=DEM'>Demographic</a><br/>
                    <?php
                    include('conn.php');
                    
                    $sql = "select count(*)count from module where subdomainID in (select subdomainID from subdomain where domainID='DEM')";
                    $rst = sqlsrv_query($conn, $sql);
                    $row = sqlsrv_fetch_array($rst);
                    $count = $row['count'];
                    
                    $sql = "select count(*)count from subdomain where domainID='DEM'";
                    $rst = sqlsrv_query($conn, $sql);
                    $row = sqlsrv_fetch_array($rst);
                    $subcount = $row['count'];
                    if($subcount <= 1){
                        $sub = 'subdomain';
                    }
                    else{
                        $sub = 'subdomains';
                    }
                    if($count=='0'){
                        echo "<a href='search.php?domainID=DEM'>0 module in $subcount $sub<br/></a>";
                    }
                    else if($count == '1'){
                        echo "<a href='search.php?domainID=DEM'>1 module in $subcount $sub<br/></a>";
                    }
                    else{
                        echo "<a href='search.php?domainID=DEM'>$count modules in $subcount $sub<br/></a>";
                    }
                    ?>
                </td>
                <td>
                    <a href='search.php?domainID=ENV'><img src="image/folder.png" class='img1'/><br/></a>
                    <a href='search.php?domainID=ENV'>Environmental</a><br/>
                    <?php
                    include('conn.php');
                    
                    $sql = "select count(*)count from module where subdomainID in (select subdomainID from subdomain where domainID='ENV')";
                    $rst = sqlsrv_query($conn, $sql);
                    $row = sqlsrv_fetch_array($rst);
                    $count = $row['count'];
                    
                    $sql = "select count(*)count from subdomain where domainID='ENV'";
                    $rst = sqlsrv_query($conn, $sql);
                    $row = sqlsrv_fetch_array($rst);
                    $subcount = $row['count'];
                    if($subcount <= 1){
                        $sub = 'subdomain';
                    }
                    else{
                        $sub = 'subdomains';
                    }
                    if($count=='0'){
                        echo "<a href='search.php?domainID=ENV'>0 module in $subcount $sub<br/></a>";
                    }
                    else if($count == '1'){
                        echo "<a href='search.php?domainID=ENV'>1 module in $subcount $sub<br/></a>";
                    }
                    else{
                        echo "<a href='search.php?domainID=ENV'>$count modules in $subcount $sub<br/></a>";
                    }
                    ?>
                </td>
            </tr>
            <tr><td height='50'></td></tr>
            <tr>
                <td>
                    <a href='search.php?domainID=MED'><img src="image/folder.png" class='img1'/><br/></a>
                    <a href='search.php?domainID=MED'>Medical</a><br/>
                    <?php
                    include('conn.php');
                    
                    $sql = "select count(*)count from module where subdomainID in (select subdomainID from subdomain where domainID='MED')";
                    $rst = sqlsrv_query($conn, $sql);
                    $row = sqlsrv_fetch_array($rst);
                    $count = $row['count'];
                    
                    $sql = "select count(*)count from subdomain where domainID='MED'";
                    $rst = sqlsrv_query($conn, $sql);
                    $row = sqlsrv_fetch_array($rst);
                    $subcount = $row['count'];
                    if($subcount <= 1){
                        $sub = 'subdomain';
                    }
                    else{
                        $sub = 'subdomains';
                    }
                    if($count=='0'){
                        echo "<a href='search.php?domainID=MED'>0 module in $subcount $sub<br/></a>";
                    }
                    else if($count == '1'){
                        echo "<a href='search.php?domainID=MED'>1 module in $subcount $sub<br/></a>";
                    }
                    else{
                        echo "<a href='search.php?domainID=MED'>$count modules in $subcount $sub<br/></a>";
                    }
                    ?>
                </td>
                <td>
                    <a href='search.php?domainID=CHE'><img src="image/folder.png" class='img1'/><br/></a>
                    <a href='search.php?domainID=CHE'>Chemical</a><br/>
                    <?php
                    include('conn.php');
                    
                    $sql = "select count(*)count from module where subdomainID in (select subdomainID from subdomain where domainID='CHE')";
                    $rst = sqlsrv_query($conn, $sql);
                    $row = sqlsrv_fetch_array($rst);
                    $count = $row['count'];
                    
                    $sql = "select count(*)count from subdomain where domainID='CHE'";
                    $rst = sqlsrv_query($conn, $sql);
                    $row = sqlsrv_fetch_array($rst);
                    $subcount = $row['count'];
                    if($subcount <= 1){
                        $sub = 'subdomain';
                    }
                    else{
                        $sub = 'subdomains';
                    }
                    if($count=='0'){
                        echo "<a href='search.php?domainID=CHE'>0 module in $subcount $sub<br/></a>";
                    }
                    else if($count == '1'){
                        echo "<a href='search.php?domainID=CHE'>1 module in $subcount $sub<br/></a>";
                    }
                    else{
                        echo "<a href='search.php?domainID=CHE'>$count modules in $subcount $sub<br/></a>";
                    }
                    sqlsrv_close($conn);
                    ?>
                </td>
                <td>
                    <a href='search.php?domainID=HEA'><img src="image/folder.png" class='img1'/><br/></a>
                    <a href='search.php?domainID=HEA'>Health/Lifestyle</a><br/>
                    <?php
                    include('conn.php');
                   
                    $sql = "select count(*)count from module where subdomainID in (select subdomainID from subdomain where domainID='HEA')";
                    $rst = sqlsrv_query($conn, $sql);
                    $row = sqlsrv_fetch_array($rst);
                    $count = $row['count'];
                    
                    $sql = "select count(*)count from subdomain where domainID='HEA'";
                    $rst = sqlsrv_query($conn, $sql);
                    $row = sqlsrv_fetch_array($rst);
                    $subcount = $row['count'];
                    if($subcount <= 1){
                        $sub = 'subdomain';
                    }
                    else{
                        $sub = 'subdomains';
                    }
                    if($count=='0'){
                        echo "<a href='search.php?domainID=HEA'>0 module in $subcount $sub<br/></a>";
                    }
                    else if($count == '1'){
                        echo "<a href='search.php?domainID=HEA'>1 module in $subcount $sub<br/></a>";
                    }
                    else{
                        echo "<a href='search.php?domainID=HEA'>$count modules in $subcount $sub<br/></a>";
                    }
                    sqlsrv_close($conn);
                    ?>
                </td>
            </tr>           
        </table>
    </body>
</html>