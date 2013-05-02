<?php
session_start();
if(!isset($_SESSION['userid'])){
    header("refresh:2; url=index.php");
    exit("<center><h1>Please login</h1></center>"); 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <style>
            .b{
            font-family: monospace;
            font-size: 12px;
        }
        </style>
        <title>Questionnaire</title>
       
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <script>
            function goback(){
                window.history.back();
            }
        </script>
    </head>
    <body class='b'>
        <div>
        <table border="0" align='center' class='gradient'>
           
            <tr><td style="text-align: center"><img src="image\title.jpg"></td></tr>
        </table>
        
        <?php
        
        $moduleID = $_GET['moduleID'];
        include "conn.php";
        
        $sql = "select domain from domain where domainID in (select domainID from subdomain where subdomainID in (select subdomainID from module where moduleID ='$moduleID'))";
        $rst = sqlsrv_query($conn, $sql);
        $row = sqlsrv_fetch_array($rst);
        $domain=$row[0];
        
        $sql = "select subdomain from subdomain where subdomainID in (select subdomainID from module where moduleID ='$moduleID')";
        $rst = sqlsrv_query($conn, $sql);
        $row = sqlsrv_fetch_array($rst);
        $subdomain=$row[0];
      
        $sql = "select * from module where moduleID='$moduleID'";
        $rst = sqlsrv_query($conn, $sql);
        $row = sqlsrv_fetch_array($rst);
        $module=$row['module'];
        
        
        echo "<table width='972' border='0' align='center'>";
        echo "<tr><td width='100'>";
        echo "<a href='export.php?moduleID=$moduleID' class='button'>Export</a></td>";
        //echo "<td width='100'>";
       // echo "<a href='document/{$module}.docx' class='button'>Download</a></td>";
        echo "<td width='100'>";
      
        echo "<a href='javascript:void(0);' class='button' onclick='goback()'>Back</a></td>";
        echo "<td><a href='index.php?action=logout' class='button'>Logout</a></td></tr></table>";
        echo "<table align='center'><tr><td class='input'>";
       
        
        echo "<p>";
        echo "<b>Domain</b>: ".$domain."<br/>";
        echo "<b>Sub-Domain</b>: ".$subdomain."<br/>";
        echo "<b>Module</b>: ".$module."<br/>";
        
        if($row['multisource']==0){
           $nomultiflag=1;
        echo "<b>Source</b>: ".$row['source']."<br/>";
        echo "<b>Proprietary</b>: ".$row['proprietary']."<br/>";
        echo "<b>Scale</b>: ".$row['scale']."<br/>"; 
        echo "<b>Core</b>: ".$row['core']."<br/>";
        echo "<b>Vanguard</b>: ".$row['vanguard']."<br/>";
        }
        
        
        echo "<table align='center'><tr><td class='input'>";
       
        echo "<center><font size='+2'><b>$module</b></font></center>";
        $sql = "select * from question where moduleID='$moduleID' order by orderID";
        $questionrst = sqlsrv_query($conn, $sql);
    
        $hflag=FALSE;
        while($questionrow = sqlsrv_fetch_array($questionrst)){
            //echo "<tr>";
            
             $qid=$questionrow['questionID'];
             $ressql = "select * from response where questionID='$qid' ";
             $resrst = sqlsrv_query($conn, $ressql);
             $resrstd =sqlsrv_query($conn, $ressql);
             
            if($questionrow['qtype']=='m' || $questionrow['qtype']=='ms' || $questionrow['qtype']=='me' || $questionrow['qtype']=='mh'){
                
                if($questionrow['qtype']=='mh'){
                    $hflag=TRUE;
                    echo "</p>";
                    echo "<p>";
                   
                    echo "<table border='1' ><tr><th colspan='2' rowspan='3'  ></th><th colspan='7' >Negative/Bad or Positive/Good Impact on your life?</th></tr>
                                            <tr><th colspan='3'>Negative/Bad</th> <th>No Impact</th> <th colspan='3'>Positive/Good</th></tr>
                                            <tr>
                                                <td >Extremely Negative</td>
                                                <td >Moderately Negative</td>
                                                <td >Somewhat Negative</td>
                                                <td >No Impact</td>
                                                <td >Somewhat Positive</td>
                                                <td >Moderately Positive</td>
                                                <td >Extremely Positive</td>
                                             </tr>";
                                                                     
                            
                }
                
                if($questionrow['qtype']=='ms'){
                    echo "</p>";
                    echo "<p>";
                   
                    echo "<table border='0'><tr><td width='450'></td>";
                    while($resrow = sqlsrv_fetch_array($resrst)){
                        $r=$resrow['response'];
                        echo "<td width='50'><font size='-1'>$r</font></td>";
                    }
                    echo "</tr>";
                }
                
                $questionline=$questionrow['question'];
                 $k =76-strlen($questionline)%76;
                 $i = 0;
                 if(!$hflag){
                 while($i<$k){
                        $questionline = $questionline.'.';
                        $i = $i+1;
                   }}
                    if(!$nomultiflag){
                                  $questionline = $questionline."<br/> Source: ".$questionrow['qsource']."<br/>";
                                  $questionline = $questionline. "Proprietary: ".$questionrow['proprietary']."<br/>";
                                  $questionline = $questionline."Scale: ".$questionrow['qscale']."<br/>"; 
                                  $questionline = $questionline."Core: ".$questionrow['core']."<br/>";
                                  $questionline = $questionline."Vanguard: ".$questionrow['vanguard']."<br/><br/>";      
                            }
                   
                    echo "<tr><td ><font size='-1'>$questionline</font></td>";
                    
                  if($hflag){
                       
                            echo "<td width='60'>__Yes-> <br/>__No</td>";
                            $i=0;
                                while($i<7){
                                    echo "<td><center>__</center></td>";
                                    $i++;
                                }
                                echo "</tr>";
                  }
                
                  else{
                      
                        while($resrow = sqlsrv_fetch_array($resrstd)){
                               //$questionline=$questionline.$resrow['rid']."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
                               echo "<td width='50'><font size='-1'>".$resrow['rid']."</font></td>";
                          }
                          echo "</tr>";
                  
                 }  
                 
                 
                 if($questionrow['qtype']=='me'){
                    echo "</table>";
                     $hflag=FALSE;
                   } 
                   
                   
      }
               
               
               
               
        else{
            
               $twdeduct=0;
               if($questionrow['qtype']=='ts'){
                    echo "<table border='1' style='border-collapse:collapse;' align='center'><tr><td valign='top'>";
                    $twdeduct=40;
                    $nomultiflag = true;
               }  
               
               if($questionrow['qtype']=='t'){
                   echo "</td><td valign='top'>";
                   $twdeduct=40;
               }
               
               if($questionrow['qtype']=='te'){
                   echo "</td><td valign='top'>";
                   $twdeduct=40;
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
                            if(!$nomultiflag){
                                  echo "Source: ".$questionrow['qsource']."<br/>";
                                  echo "Proprietary: ".$questionrow['proprietary']."<br/>";
                                  echo "Scale: ".$questionrow['qscale']."<br/>"; 
                                  echo "Core: ".$questionrow['core']."<br/>";
                                  echo "Vanguard: ".$questionrow['vanguard']."<br/><br/>";      
                            }
                      }
                       
                      while($resrow = sqlsrv_fetch_array($resrst)){
                         
                          $rid = $resrow['rid'];
                          $r = $resrow['response'];
                          $skip = $resrow['skippattern'];
                           if($rid != ''){
                                    
                                    $k = 75 - $twdeduct - strlen($rid) - strlen($r)%75;
                                    $i = 0;
                                    while($i<$k){
                                             $r = $r.'.';
                                             $i = $i+1;
                                    }
                                    $r = $r.$rid;
                           }
                           if($skip != ''){
                           $skip = str_replace("(",'',$skip);
                           $skip = str_replace(")",'',$skip);
                           $skip = '('.$skip.')';
                           }
                          
                           echo $r.$skip."<br>";
                      }
                
                if($questionrow['qtype']=='te'){
                   $nomultiflag = false;
                        echo "</td></tr></table>";
                    } 
                    
                    
                    
                    
        }         
                    
        }
        echo "</table>";
        sqlsrv_close($conn);
        echo "</table>";
        
        echo "<table width='972' border='0' align='center'>";
        echo "<tr><td width='100'>";
        echo "<a href='export.php?module=$module' class='button'>Export</a></td>";
        
        echo "<td>";
        //echo "<a href='search.php' class='button'>Back</a></td></tr></table>";
        echo "<a href='javascript:void(0);' class='button' onclick='goback()'>Back</a></td>";
        ?>
    </div>
    </body>
</html>