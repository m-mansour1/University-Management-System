<?php
 /* connect to the db */

 $link = mysql_connect("localhost", "root", "");
  if ($link==NULL) echo "connection error to  MySql ";
  mysql_select_db("university_db");



	
 
 ?>
