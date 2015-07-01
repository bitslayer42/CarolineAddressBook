<!DOCTYPE html>
<HTML>
<HEAD>
<TITLE>Caroline's Contacts Database</TITLE>

<script type='text/javascript'>
function deleteform(ID){
	var answer = confirm('Delete current record?');
	if (answer){
		document.location = 'index.php?delID=' + ID;
	}
}

function validate() {
	//validation code here
}
</script>
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
	
if (isset($_GET['delID'])){
	$sql = "DELETE FROM person WHERE ID=" . $_GET["delID"] . ";";	
	if(mysql_query($sql,$con)){
		echo '<script>alert("Record Deleted");</script>';	
	}else{
		echo '<script>alert("Record Not Deleted:' . mysql_errno($con) . mysql_error($con). '");</script>';		
	}
}
else if (isset($_GET['editmode'])){
	$sql = "UPDATE person
		SET LastName='" . $_GET['LastName'] . "', FirstName='" . $_GET['FirstName'] .
		"' WHERE ID=" . $_GET['ID'] . ";" ;
	if(mysql_query($sql,$con)){
		echo "<script>alert('Record modified');</script>";	
	}else{
		echo "<script>alert('Record not modified:" . mysql_errno($con) . mysql_error($con) . "');</script>";		
	}	
}
else if(isset($_GET['addmode'])){
	$sql = "INSERT INTO person(LastName,FirstName)
		VALUES('" . $_GET['LastName'] . "','" . $_GET['FirstName'] . "');";
	if(mysql_query($sql,$con)){
		echo "<script>alert('Record added');</script>";	
	}else{
		echo "<script>alert('Record not added:" . mysql_errno($con) . mysql_error($con) . "');</script>";		
	}
}

//list box 
$listboxresult = mysql_query("SELECT * FROM person");

//fill values for fields if one has been selected
if(isset($_GET['selID'])){  //&& $_GET['selID'] NEQ '@'){
	$selectedresult = mysql_query("SELECT * FROM person WHERE ID = '" . $_GET['selID'] . "'") ;
	$selectedrow = mysql_fetch_assoc($selectedresult);
	if($selectedrow==false){
		$MyID = "";
		$MyLastName = "Not found.";
		$MyFirstName = "";
		$addmode = true;
	}else{	
		$MyLastName = $selectedrow['LastName'];
		$MyID = $_GET['selID'];
		$MyFirstName = $selectedrow['FirstName'];
		$addmode = false;
	}
}
else{
	$MyID = "";
	$MyLastName = "";
	$MyFirstName = "";
	$addmode = true;
}
?>


<center>
		
<h2>Contacts Database</h2>

<table border="0" cellpadding="6" cellspacing="0" width="550">
<tr><td colspan="2" style="background-color:#0066CC;" align="center">
<font style="font-size:16px;color:#FFFFFF;">
Find an existing entry:
</font>
</td></tr>

<tr>
<td colspan="2" style="border:1px solid black;" align="center">
<form name="listform" method="GET" action="index.php">	
	Name: &nbsp;
	<select name="selID" onChange="document.listform.submit();">
		<option value="@">Choose One</option>
			<?php
			while($listboxrow = mysql_fetch_array($listboxresult))
			  {
			  echo "<option value='" . $listboxrow['ID'] . "'>" . 
			  $listboxrow['FirstName'] . " " . $listboxrow['LastName'] . "</option>";
			  }
			?>
	</select>
</form>

</td></tr>

<tr><td colspan="2"></td></tr>

<tr><td colspan="2" style="background-color:#0066CC;" align="center">
<font style="font-size:16px;color:#FFFFFF;">
Search:
</font>
</td></tr>

<tr>
<td colspan="2" style="border:1px solid black;" align="center">
	<form method="GET" action="searchfinish.php" name="myForm2"> 

	<b>Search for:</b>
	<input type="Text" name="searchstr" size="50" REQUIRED="Yes" MAXLENGTH="30" MESSAGE="Please enter text in the search field.">
	<br><br><br>
	<INPUT type="submit" value="Search">
	</form>
</td></tr>

<tr><td colspan="2"></td></tr>


<?php
if($addmode){
	echo "<tr><td colspan='2' style='background-color:#0066CC;' align='center'>
	<font style='font-size:16px;color:#FFFFFF;'>
	Add a new entry
	</font>
	</td></tr>";
}else{
	echo "<tr><td colspan='2' style='background-color:#00CC99;' align='center'>
	<font style='font-size:20px;color:#FFFFFF;'>
	Edit
	</font>
	</td></tr>";
}

?>

<tr><td colspan="2" style="border:1px solid black;" align="center">
<form name="SigForm" method="GET" action="index.php" onSubmit="validate();">
	<input type="hidden" name="ID" value="<?php echo $MyID; ?>">
		<table border="0" cellspacing="10" cellpadding="0" width="100%">
		<tr>
		<td colspan="2">
		<hr size="1" color="gray">
		</td>
		</tr>
		
		<tr>
		<td width="160" align="right">
		<b>First Name:</b>
		</td>
		<td>
		<input type="Text" name="FirstName" value="<?php echo $MyFirstName; ?>" size="50" REQUIRED="Yes" MAXLENGTH="50" 
        MESSAGE="Please enter a first name.">
		</td>
		</tr>
		<tr>
		<td width="160" align="right">
		<b>Last Name:</b>
		</td>
		<td>
		<input type="Text" name="LastName" value="<?php echo $MyLastName; ?>" size="50" Required="yes" MAXLENGTH="50" 
        Message="Please enter a last name">
		<br>
		</td>
		</tr>
		</table>
<?php
	if($addmode){
		echo "<br>
		<input type='hidden' name='addmode' value='addthis'>
		<input type='submit' name='subm' value='Add'>";
	}else{
		echo "<br>
		<input type='hidden' name='editmode' value='editthis'>		
		<input type='submit' name='subm' value='Save Changes'>
		<input type='button' name='del' value='Delete' onClick='deleteform(" . $MyID . ");'>";
	}
?>

</form>
</td></tr>
</table>
</center>
</BODY>
</HTML>







