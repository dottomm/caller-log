<?php
//connect database
include 'common/useful_stuff.php';
if (!db_connect())
	die();
//include banner	-->
	include 'common/header.php';

?>
    <div class='row-fluid'>
        <!--dashboard-->
        
        <div class='span12'>
<div id='tabvanilla' class='widget' align='center'>
    <p>&nbsp;</p>
<ul >
    
    <li><a class='btn' href='#caller' data-toggle='tab'><i class='icon-search'></i> Search by Caller Name</a></li>
    <li><a class='btn' href='#support' data-toggle='tab'><i class='icon-search'></i> Search by Support Topic</a></li>
    <li><a class='btn' href='#notes' data-toggle='tab'><i class='icon-search'></i> Search Notes</a></li>
    
    </ul>

    </div>
    <p>&nbsp; </p>
<!--//search by caller name -->
<a name='caller'></a>
<div id='caller' class='tabdiv'>
<?php include 'search.php';?>

</div>
<!--search by support topic -->
<a name='support'></a>
<div id='support' class='tabdiv'>
<?php include 'support_search.php'; ?>

</div>

<!--search comments -->
<a name ='notes'></a>
<div id='notes' class='tabdiv'>
<?php include 'notes_search.php';?>
	
	</div>


