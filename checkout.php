<?php
session_start();
if(!isset($_SESSION['userid'])){
    header("refresh:2; url=index.php");
    exit("<center><h1>Please login</h1></center>"); 
}
$userid = $_SESSION['userid'];

header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=combined modules.doc");

echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
?>
<head>
    <style>
        body{
            font-family: monospace;
            font-size: 12px;
        }
        table{
            width: 650px;
        }
    </style>
</head>
<?php
echo "<body>";


    
    include "conn.php";
        
    $basketquery= "select * from basket where username='$userid' order by num";
    $basketresult = sqlsrv_query ($conn,$basketquery);
    while($basketrow = sqlsrv_fetch_array($basketresult)){
                 
        $module=$basketrow['itemid'];
        echo "<table align='center' width='100%'><tr><td class='input'>";
        
        $sql = "select domain from domain where domainID in (select domainID from subdomain where subdomainID in (select subdomainID from module where module ='$module'))";
        $rst = sqlsrv_query($conn, $sql);
        $row = sqlsrv_fetch_array($rst);
        $domain=$row[0];
        
        $sql = "select subdomain from subdomain where subdomainID in (select subdomainID from module where module ='$module')";
        $rst = sqlsrv_query($conn, $sql);
        $row = sqlsrv_fetch_array($rst);
        $subdomain=$row[0];
      
        $sql = "select * from module where module='$module'";
        $rst = sqlsrv_query($conn, $sql);
        $row = sqlsrv_fetch_array($rst);
        
        echo "<p>";
       
        
        echo "<table align='center' ><tr><td class='input'>";
     
        echo "<center><font size='+2'><b>$module</b></font></center>";
        $sql = "select * from question where moduleID in (select moduleID from module where module ='$module') order by orderID";
        $questionrst = sqlsrv_query($conn, $sql);
        $hflag=FALSE;
        while($questionrow = sqlsrv_fetch_array($questionrst)){
            //echo "<tr>";
            
             $qid=$questionrow['questionID'];
             $ressql = "select * from response where questionID='$qid' ";
             $resrst = sqlsrv_query($conn, $ressql);
             $resrstd =sqlsrv_query($conn, $ressql);
            if($questionrow['qtype']=='m' || $questionrow['qtype']=='ms' || $questionrow['qtype']=='me'|| $questionrow['qtype']=='mh'){
                
                 if($questionrow['qtype']=='mh'){
                    $hflag=TRUE;
                    echo "</p>";
                    echo "<p>";
                   
                    echo "<table  border='1' ><font size='-3'><tr><th colspan='2' rowspan='3'  ></th><th colspan='7' >Negative/Bad or Positive/Good Impact on your life?</th></tr>
                                            <tr><th colspan='3'>Negative/Bad</th> <th>No Impact</th> <th colspan='3'>Positive/Good</th></tr>
                                            <tr>
                                                <td >Extremely Negative</td>
                                                <td >Moderately Negative</td>
                                                <td >Somewhat Negative</td>
                                                <td >No Impact</td>
                                                <td >Somewhat Positive</td>
                                                <td >Moderately Positive</td>
                                                <td >Extremely Positive</td>
                                             </tr></font>";
                                                                     
                            
                }
                
                
                
                
                if($questionrow['qtype']=='ms'){
                    echo "</p>";
                    echo "<p>";
                   
                    echo "<table border='0'><tr><td width='60%'></td>";
                    while($resrow = sqlsrv_fetch_array($resrst)){
                        $r=$resrow['response'];
                        echo "<td width='5%'><font size='-3'>$r</font></td>";
                    }
                    echo "</tr>";
                }
                $questionline=$questionrow['question'];
                 $k =60  - strlen($questionline)%60;
                 
                 $i = 0;
                 if(!$hflag){
                 while($i<$k){
                        $questionline = $questionline.'.';
                        $i = $i+1;
                   }}
                    echo "<tr><td width='60%'><font size='-3'>$questionline</font></td>";
                    
                     if($hflag){
                       
                            echo "<td >__Yes> <br/>__No</td>";
                            $i=0;
                                while($i<7){
                                    echo "<td><center>__</center></td>";
                                    $i++;
                                }
                                echo "</tr>";
                  }
                    
                  else{
                       while($resrow = sqlsrv_fetch_array($resrstd)){
                       
                        echo "<td width='5%'><font size='-3'>".$resrow['rid']."</font></td>";
                   }
                   echo "</tr>";
                  }  
                    
                
                   if($questionrow['qtype']=='me'){
                    echo "</table>";
                    $hflag=FALSE;
                   }
                 //echo "<font size='-1'>$questionline</font><br/>";     
               }
            else{
            
               $twdeduct=0;
               if($questionrow['qtype']=='ts'){
                    echo "<table border='1' style='border-collapse:collapse;' align='center'><tr><td valign='top'>";
                    $twdeduct=50;
               }  
               
               if($questionrow['qtype']=='t'){
                   echo "</td><td valign='top'>";
                   $twdeduct=50;
               }
               
               if($questionrow['qtype']=='te'){
                   echo "</td><td valign='top'>";
                   $twdeduct=50;
               }
               
               
               
                      echo "</p>";
                      echo "<p>";
                      if($questionrow['qtype']=='ml'){
                           echo $questionrow['question']."<br/>";
                      }
                      else {
                            echo "<b>".$questionrow['surveyID'].". ".$questionrow['question']."</b><br/>";
                            if(isset($questionrow['instruction'])){
                                echo $questionrow['instruction']."<br/>";
                            }
                        
                      }
                       
                      while($resrow = sqlsrv_fetch_array($resrst)){
                         
                          $rid = $resrow['rid'];
                          $r = $resrow['response'];
                           if($rid != ''){
                                    
                                    $k = 70 - $twdeduct - strlen($rid) - strlen($r);
                                    $i = 0;
                                    while($i<$k){
                                             $r = $r.'.';
                                             $i = $i+1;
                                    }
                                    $r = $r.$rid;
                           }
                          
                           echo $r."<br>";
                      }
                
                if($questionrow['qtype']=='te'){
                   
                        echo "</td></tr></table>";
                    } 
                    
                    
                    
                    
        }                    
        }
        echo "</td></tr></table>";
    }
     sqlsrv_close($conn);
        
echo "</html>";
?>
