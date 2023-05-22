<?php
include 'common/useful_stuff.php';
if(!db_connect())
die();



if ($_uid == 0){
	header("location:login.php");
	die();
	}
	
	  

include 'common/header.php';

	
echo"<div class='span12'>
<div id='tabvanilla' class='widget' align='center'>

    <ul class='unstyled' >
    <li><a href='#qrtly' class='btn'>Quarterly Reports</a></li>
    <li ><a href='#status' class='btn'>Status Reports</a></li>
    <li><a href='#support' class='btn'>Support Topic Report</a> </li>
    <li><a href='#user' class='btn'>User Report</a></li>
    
    </ul>
    </div>
 	
 	<div id='qrtly' class='tabdiv'>
 	<a name='qrtly'></a>";
 	//qrtly report
 	include 'reports/qrtlyreports.php';
 	echo"
 	</div>
 	
 	

<div id='status' class='tabdiv'>
<a name='status'></a>";
	
	//status report	
	include 'reports/status_report.php';

	echo"
</div>

<div id='support' class='tabdiv'>
<a name='support'></a>";

	//support_topic_report
	include 'reports/support_topic_report.php';

	echo"
</div>

<div id='user' class='tabdiv'>
<a name='users'></a>";

	//user_reports
	include 'reports/user_reports.php';

											
echo"
</div>";
	
?>

	<script>
	// perform JavaScript after the document is scriptable. 
$(function() { 
    // setup ul.tabs to work as tabs for each div directly under div.panes 
    $("ul.tabs").tabs("div.panes > div"); 
});
	
// history configuration option
$(function() { 
    $("ul.tabs").tabs("div.panes > div", {history: true}); 
});

//Description for mouseover
$("#products").tabs("div.description", {event:'mouseover'});
	</script>
