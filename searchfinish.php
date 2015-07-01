<!DOCTYPE html>
<HTML>
<HEAD>
<TITLE>Caroline's Contacts Database</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">

</HEAD>
<BODY>

<?php
$databasename = "";
$servername = '';
$usernm = '';
$password = '';

$con = mysql_connect($servername,$usernm,$password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db($databasename, $con);
	
	$sql = "SELECT * FROM person WHERE (LastName LIKE '%" . $_GET["searchstr"] . "%') 
	OR (FirstName LIKE '%" . $_GET["searchstr"] . "%')";	
	if($resultset = mysql_query($sql,$con)){
	}else{
		echo '<script>alert("Error:' . mysql_errno($con) . mysql_error($con). '");</script>';		
	}
?>
<center>
<h1>Contacts Database</h1>
<br>
<INPUT TYPE="button" VALUE="Back to Main Menu" onClick="parent.location='index.cfm'">
</center>

<table border="0" cellspacing="5" cellpadding="0" width="100%">
<tr> 
<td colspan="2">
<hr size="1" color="gray">
</td>
</tr>
<?php
while($resultrow = mysql_fetch_array($resultset)){
	
	echo '<form name="listform' . $resultrow['ID'] . '" method="GET" action="index.php">	
		<input type="hidden" name="selID" value="' . $resultrow['ID'] . '">
	</form>
	<tr>
	<td colspan="2">
	<INPUT TYPE="button" VALUE="Edit" onClick="document.listform' . $resultrow['ID'] . '.submit();">
	</td>
	</tr>
	
	<tr>
	<td width="13">
	&nbsp;
	</td>
	<td>
	<span style="color:gray">Name:</span>' . $resultrow['FirstName'] . ' ' . $resultrow['LastName'] . '<br>
	</td>
	</tr>

	<tr>
	<td colspan="2">
	<hr size="1" color="gray">
	</td>
	</tr>';
}
?>
</table>


</body>
</html>