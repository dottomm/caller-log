<?php

$caller_fname=getvar("caller_fname");
$caller_lname=getvar("caller_lname");
$title=getvar("title");
$bgcolor=#fff;
$errmsg="";
$comment_search =getvar("comment_search");
$caller_search =getvar("caller_search");
$search = getvar("search");
$metode = getvar("metode");

?>

<?php	
	
	echo "<a name='search'></a>
<h3>Search Desired Results <i>access</i>  Call Log by Caller</h3>
<form method='post' action='{$_SERVER["PHP_SELF"]}' name='search'>

<table border='0' cellpadding='0' cellspacing='0'>
<tr >
<td >
<p>
<!--select tag -->
	<select name='metode' size='1' >
		<option value='caller_fname'>Caller First Name</option>
		<option value='caller_lname'>Caller Last Name</option>
	</select> 
	
	<input type='text' name='caller_search' value='{$search}' size='25' > &nbsp;
	
	<input type='submit'   value ='Search by Caller Name' class='btn'>

</td>
</tr>
</table>
</form>
			<p class='text-info'>Please specify criteria before submitting a search</p>

<hr>			<p>&nbsp;</p>  
";


if ($caller_search !="" || $metode !="") 
					{// shoot off query


 		$res = mysql_query ("SELECT * from caller_log where  $metode like '%{$caller_search}%'    order by caller_id Asc");
 		$count=mysql_num_rows($res);
 			 if(mysql_num_rows($res)==0){
			echo"<p style='color:red;'><b>Sorry!</b>. No callers available with that criteria.You may <a href='submitt_caller.php'>Add A New Caller</a></p>";
			}else{
			echo"<p class='text-success'>We've found <span class='badge badge-info'>$count</span> matches to your search criteria";
 			 while ($row=mysql_fetch_assoc($res)){
 		  
			echo"
<pre><a href='caller_profile.php?caller_id={$row['caller_id']}'>{$row['caller_fname']} {$row['caller_lname']}</a></pre>
";
	
		}
	}
}








?>