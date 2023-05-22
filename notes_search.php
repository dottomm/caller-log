<?php

$caller_fname=getvar("caller_fname");
$caller_lname=getvar("caller_lname");
$title=getvar("title");
$bgcolor=#fff;
$errmsg="";
$note_search = getvar("note_search");
$search = getvar("search");
$metode = getvar("metode");

?>

<?php	
	
	echo "<a name='notes'></a>
<h3>Search Desired Results <i>access</i>  Call Log by Notes &amp; Comments</h3>
<form method='post' action='{$_SERVER["PHP_SELF"]}#notes' name='notes'>

<table border='0' cellpadding='0' cellspacing='0'>
<tr >
<td >
<p>
	<input type='text' name='note_search' value='{$note_search}' size='25'> &nbsp;
		<input type='submit'   value ='Search by Notes & Comments' class='btn'>

</td>
</tr>
</table>
</form>
			<p class='text-info'>Please specify criteria before submitting a search</p>

<hr>";


if ($note_search !="" ) 
{// shoot off query


 		$res2 = mysql_query ("select *  from error_log e 
		inner join caller_log c on e.caller_id=c.caller_id
		inner join support_log s on e.support_id=s.support_id
		inner join comments o on e.error_id=o.error_id
 		where  notes like  '%{$note_search}%'   ||  comment like '%{$note_search}%' order by e.caller_id Asc");
 	$count=mysql_num_rows($res2);
 			 if(mysql_num_rows($res2)==0){
			echo"<p class=text-error'><b>Sorry!</b>. No comments or notes contain that criteria.</p>";
			}else{
			echo"<p class='text-success'>We've found <span class='badge badge-info'>$count</span> matches to your notes search criteria";
 			 while ($row=mysql_fetch_assoc($res2)){
 		  
			echo"  

<pre>{$row['error_id']} <a href='error_profile.php?error_id={$row['error_id']}&caller_id={$row['caller_id']}'>{$row['support_type']}</a>  <a href='caller_profile.php?caller_id={$row['caller_id']}'>{$row['caller_fname']} {$row['caller_lname']}</a></pre>";

	
		}
	}
}








?>