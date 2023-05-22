<!DOCTYPE HTML>
<html lang='en'>
<head>

<meta http-equiv="content-type"
        content="text/html;charset=utf-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <!--//bootstrap files -->
	<link href="css/bootstrap.css" rel="stylesheet">
	<script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<!--my style ammendments -->
	<link href="css/append.css" rel="stylesheet" type="text/css">
<!--JQuery Files-->
<!--<script src="http://cdn.jquerytools.org/1.0.2/jquery.tools.min.js"></script> -->
<!--<link href="css/jQuery_tabs.css" type="text/css" rel="stylesheet"> -->
<!--//Begin sliding divs-->
<script type='text/javascript' src='jscripts/jquery-1.2.6.min.js'></script>
<script type='text/javascript' src='jscripts/jquery-ui-personalized-1.5.2.packed.js'></script>
<script type='text/javascript' src='jscripts/sprinkle.js'></script>
<link rel="stylesheet" href="css/style2.css" />
<!--End sliding divs// -->

<!--Begin tinyMCE -->
<script type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
    mode : "textareas",
theme_advanced_toolbar_location : "top"

});
</script>
<!--End tinyMCE-->
<!--Begin Calendar Files-->
<script language="javascript" src="calendar/calendar.js"></script>

<!--End Calendar Files-->

<!--Charting File -->
<script type='text/javascript' src='js/jscharts.js'></script>

</head>
<body>
<?php
// set defaul timezone
date_default_timezone_set("America/New_York");

echo "
<div class='container-fluid'>
<div class='container'>
    <h2><img src='images/maintitleguy.jpg' align='left'> DR<i>access</i> Caller Log</h2>

<div class='navbar'>
		<ul class='nav nav-pills' >";
		//if user is admin
 if($_uid ==1){
	echo"	<li ><a href='#' class='brand'>ADMIN</a></li> ";
 }
// if user is logged in)
if ($_uid > 0){

 	echo "

		
		<li><a href='index.php' class='btn'>Home</a></li>
		<li><a href='submitt_caller.php' class='btn'>Submit New Caller</a>
		<li><a href='caller_log.php' class='btn'>All Callers</a></li>
		<li><a href='search_tool.php' class='btn'>Search</a></li>
		<li><a href='reports.php' class='btn'  >Reports</a></li>
		<li><a href='DRa_Support_Calls_Worksheet_040814_v2.doc' class='btn'>Call Tracker Worksheet</a></li>
 		<li ><a href='logout.php' class='btn'>LOG OUT</a></li>";
}


// not logged in 
else {
	echo "
		
	
	<li ><a href='login.php' class='btn'>LOG IN</a></li>
	
		";
}
?>







