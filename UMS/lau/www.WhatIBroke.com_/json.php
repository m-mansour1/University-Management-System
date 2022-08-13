
	
	
<?php
 

	/* connect to the db */

	 $link  = mysqli_connect('localhost', 'root', '', 'university_db');

 


 $a='Tyre Campus';
  //fetch table rows from mysql db
    $sql = "select id ,title,start,end,instructor from json where status='ACTIVE'";
    $res = mysqli_query($link, $sql) or die("Error in Selecting " . mysqli_error( $link));
    //create an arAray
   $result = array();
 
while($row = mysqli_fetch_array($res)){
array_push($result,
array(
'allDay'=>'',
'id'=>$row[0],
'title'=>$row[1],
'start'=>$row[2],
'end'=>$row[3],
'instructor'=>$row[4],


));
}
 

echo json_encode($result);

	
 
 ?>

