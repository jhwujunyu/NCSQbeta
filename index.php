<?php
session_start();
if($_GET['action']=='logout'){
    unset($_SESSION['userid']);
    unset($_SESSION['passwd']);
}
include("conn.php");
$login = 1;
if(isset($_POST['userid'])){
    $userid = $_POST['userid'];
    $passwd = $_POST['passwd'];
    $sql = "select * from account where username='$userid'";
    $rst = sqlsrv_query($conn, $sql);
    $row = sqlsrv_fetch_array($rst);
    if($userid==''){
        $login = 0;
    }
    else if($passwd == $row['password']){
        $_SESSION['userid'] = $userid;
        $_SESSION['passwd'] = $passwd;
        $_SESSION['type'] = $row['type'];
        $login = 1;
        echo  "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=domain.php'>";
    }
    else{
        $login = 0;
    }
}
sqlsrv_close($conn);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title>National Children's Study Questionaire</title>
        <style type="text/css">
        body {
        font-family:Arial,Helvetica,sans-serif;font-size:100%;
        }
        fieldset{
            width: 320px;
            height: 240px;
            margin: auto;
        }
        label{
            float: left;
            width: 90px;
            margin-left:10px;
        }
        .left{margin-left: 100px;}
        .input{width: 150px;}
        table{
            width: 972px;
            border: none;
            border-collapse:collapse;
        }
        th, td{
            text-align: left;
        }
        .h1{
            color: #CD6839;
        }
        .h2{
            font-size: 12px;
        }
        .login{
            text-align: center;
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
    </head>
    <body>
        <table align='center'  class='gradient'>
            <tr><td style='text-align: center'>
                <img src="image\title.jpg">
            </td></tr>
        </table>
        <table align='center'>
            <tr><td height='50'></td></tr>
            <tr><th class='h1'>
                What is the National Children's Study?
            </th></tr>
            <tr><td class='h2'>
                The National Children's Study will examine the effects of the environment, as broadly defined to include factors such as air, water, diet, sound, family dynamics, community and cultural influences, and  genetics on the growth, development, and health of children across the United States, following them from before birth until age 21 years. The goal of the Study is to improve the health and well-being of children and contribute to understanding the role various factors have on health and disease. Findings from the Study will be made available as the research progresses, making potential benefits known to the public as soon as possible.
            </td></tr>
            <tr><td height='50'></td></tr>
        </table>
        <div>
        <table align='center'><tr><td >
            <table><tr><td class='login'>
            <form name='f1' method='post' action='index.php'>
                <p>
                    Username:
                    <input id='userid' name='userid' type='text'/>
                </p>
                <p>
                    Password:
                    <input id='passwd' name='passwd' type='password'/>
                </p>
                <div style='padding:10px 150px 50px 0px;'>
                <p><input type='submit' name='submit' id='submit' value='Login' class='button'/></p>
                </div>
            </form>
            <p>
                <?php
                if($login == 0){
                    echo "<font color='red'>Your username or password is not correct, please try again</font>";
                }
                ?>
            </p>
            </td></tr>
            </table>
        </td></tr></table>
        </div>
    </body>
</html>