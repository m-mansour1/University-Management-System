<HTML><HEAD><TITLE>AUCE</TITLE>

 
<BODY aLink=#FFFFFF bgColor=#9dbbf8 leftMargin=0 link=#000066  
text=#000000 topMargin=0 vLink=#000066 marginheight="0" marginwidth="0" onLoad="MM_preloadImages('images/link1b.gif','images/link3b.gif','images/link4b.gif','images/link5b.gif','images/link6b.gif')">
<table >
  <tr> 
    <td> 
      <table width="1430" border="0" cellspacing="0" cellpadding="0" height=110  background="Images/logomain.png"></td></tr>
        <tr>
         <td width="100">&nbsp;&nbsp;</td>
             <td width="100">&nbsp;&nbsp;</td>
             <td width="100">&nbsp;&nbsp;</td>
             <td width="100">&nbsp;&nbsp;</td>
               <td width="100">&nbsp;&nbsp;</td>
             <td width="100">&nbsp;&nbsp;</td>
		<td width="100">&nbsp;&nbsp;</td>
             <td width="100">&nbsp;&nbsp;</td>
             <td width="100">&nbsp;&nbsp;</td>
               <td width="100">&nbsp;&nbsp;</td>
             
     
        <td><a href="https://www.facebook.com/AUCEhadath/"> <IMG  src="images/facebook.png"></a> </td>     
        <td><a href="https://twitter.com/aucehadath"> <IMG  src="images/twitter.png"></a> </td>  
	<td><a href="https://www.youtube.com/channel/UCya7wJDI1_rgV6bB3DQFlPw"><IMG  src="images/youtube.png"></a> </td>
	<td><a href="https://www.instagram.com/auce_university/"><IMG  src="images/instagram.png"></a> </td>
      
        </tr>
      </table>
</table>

<style type="text/css">
<style
.imagebox{width:100%;
height:100%;
background-image:url("images\log.jpg");
background-repeat:no-repeat;
background-position: 50% 50% ;
}

INPUT {
background-color: white;
color: black;
font-family: cooper black;
font-size: 20 pt
}
</style>

                                                             
   </td> 
  </tr></table>
  <br>

<TABLE align="center" border=0 cellPadding=0 cellSpacing=0 width=50%>
  

       <tr>
      <td><a href="events.php"><IMG border=0 height=30 src="images/events.png" width=140></a></td>
      <td><a href="aboutus.php"><IMG border=0 height=30 src="images/about us.png" width=140></a></td>
      <td><a href="contactus.php"><IMG border=0 height=30 src="images/contact us.png" width=140></a></td>
    
	<td><a href="http://localhost/AUCE/uis.php"><IMG border=0 height=30 src="images/logout.png" width=140></a></td></tr>
	</TD>
  </TR>
</table>
             


    <div class="imagebox">
<br><br><br><br>
  
<form  action="http://localhost/AUCE/www.WhatIBroke.com_/index1.php"  method="post" >
 
<TABLE   border="0" align="center" >

<tr>
                <td  ><b>Select Branch:</b> </td>
                <td  >
				<select name="branch" ">
        <option >Please select branch .....</option>'
                 <?php 
				 include"bdd.php";
                    $query = mysql_query("select branchname from branch ") 
                           or die(mysql_error());  
                    while ($result = mysql_fetch_assoc($query)) {   
                           $stateChoice = $result['branchname'];                                      
                             echo '<option value="';
                             echo "$stateChoice"; 
                             echo '">';
                             echo "$stateChoice";  
                             echo '</option>';
                             echo '<br />';                  
                     }
                  ?>
    </select> 
				<tr>
             <td align="center" colspan="7">
<input type=submit size=30 name="btsearch" value="F I N D"></td>
</tr>
				

</table>


</form>
</BODY>
