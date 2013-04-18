<?php
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=document_name.doc");

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
$module = $_GET['module'];

        echo "<table align='center' width='600'><tr><td class='input'>";
        include "conn.php";
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
        echo "<b>Domain</b>: ".$domain."<br/>";
        echo "<b>Sub-Domain</b>: ".$subdomain."<br/>";
        echo "<b>Module</b>: ".$module."<br/>";
        
        echo "<table align='center'><tr><td class='input'>";
     
        echo "<center><font size='+2'><b>$module</b></font></center>";
        $sql = "select * from question where moduleID in (select moduleID from module where module ='$module') order by orderID";
        $questionrst = sqlsrv_query($conn, $sql);
        //$question = "";
        while($questionrow = sqlsrv_fetch_array($questionrst)){
            //echo "<tr>";
            
             $qid=$questionrow['questionID'];
             $ressql = "select * from response where questionID='$qid' ";
             $resrst = sqlsrv_query($conn, $ressql);
             $resrstd =sqlsrv_query($conn, $ressql);
            if($questionrow['qtype']=='m' || $questionrow['qtype']=='ms' || $questionrow['qtype']=='me'){
                
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
                 $k =58  - strlen($questionline);
                 if($k < 0){
                    $k += 55;
                 }
                 $i = 0;
                 while($i<$k){
                        $questionline = $questionline.'.';
                        $i = $i+1;
                   }
                    echo "<tr><td width='60%'><font size='-3'>$questionline</font></td>";
                 while($resrow = sqlsrv_fetch_array($resrstd)){
                       
                        echo "<td width='5%'><font size='-3'>".$resrow['rid']."</font></td>";
                   }
                   echo "</tr>";
                   if($questionrow['qtype']=='me'){
                    echo "</table>";
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
        sqlsrv_close($conn);
echo "</html>";
?>
