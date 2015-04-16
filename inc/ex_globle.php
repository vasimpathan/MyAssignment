<?php
/*********************************************************************
Database Connection 
*********************************************************************/

define("HST", "localhost");
define("USR", "root");
define("PWD", "");		
define("DBN", "tekdi");
error_reporting(E_ALL & ~E_NOTICE); 

?>
<?php
Class Database 
{

	function connect_db() 
	{	
		$con=mysql_connect(HST, USR, PWD) OR die("Failed Connecting To Mysql");
		mysql_select_db(DBN) OR die("Failed Connecting To Database");
		return $con;
	}
}

function ex_redirect($pagename) 
{    
	 if (!headers_sent())
		 header("Location:$pagename");
	 else 
		echo "<script>window.location=\"$pagename\";</script>
		<noscript>Automatic  redirection didn't work.<br />
		<a href=\"$pagename\">Click here to go to $pagename</a></noscript>";
}


$dbObj = new Database();
$con=$dbObj->connect_db();




function no_record_message()
{
		echo "<div class='info'>Recored not found for selected combination</div>";

}

function s($message)
{
echo "<div class='alert success'>
<p style='color:green'>".$message.".</p>
</div>";
}


function e($message)
{
	echo "<div class='alert error'>
	<p>".$message.".</p>
	</div>";

}

function error_or_success_msg($value)
{
$type=substr($value,0,1);
switch ($value)
{
	case s1 : $type('The record has been added successfully.'); break;
	case s2 : $type('The record has been updated successfully.'); break;
	case s3 : $type('The record has been deleted successfully.'); break;
	case e1 : $type('Please provide all fields marked with ( * )'); break;
	default : e("Something Went Wrong.");
}
}


?>
