<?php
 $sname = "dijkstra.ug.bcc.bilkent.edu.tr";
 $uname = "bilgehan.akcan";
 $pass = "QNlLsxxn";

 $db_name = "bilgehan_akcan";

 $conn = new mysqli($sname,$uname,$pass,$db_name);

 if (!$conn){
 	echo "Connection Failed";
 } 
 else {
 	echo "";
 }