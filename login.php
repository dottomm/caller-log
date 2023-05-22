<?php
include 'common/useful_stuff.php';
if (!db_connect())
	die();

$errmsg = "";
$rem =getvar("rem");
$username = getvar("username");
$user_email = getvar("email");
$pw = getvar("pw");
$doit = getvar("doit");
if ($doit == "yes"){

	if ($pw == "" || $username == ""){
		$errmsg = "You must fill in both fields!";
	}
	else {
		// go see if they are in the db
		$un = mysql_real_escape_string($username);
		$em = mysql_real_escape_string($user_email);
		$p = mysql_real_escape_string($pw);
		$res = mysql_query("select user_id from users where username='{$un}' and password='{$p}'");
		$row = mysql_fetch_assoc($res);
		if (!$row){
			$errmsg = "Unknown username and password combination!";
		}
		else {
			$ttl = 0;
			if ($rem !="")
			$ttl = time() + 7*24*60*60;
			setcookie("_1001",$row['user_id'],$ttl,"/");
			header("location:index.php");
			die();
		}
	}
}
?>

<?php
include 'common/header.php';

echo "
<div class='container'>
 
<p>&nbsp;</p>
      	<font color='red'><b>{$errmsg}&nbsp;</b></font>
<form action='{$_SERVER['PHP_SELF']}' method='post'>
<legend>Log-In</legend>
<input type='hidden' name='doit' value='yes'>

<label>Username</label>
<input type='text' name='username' value='{$username}'>

<label>Password<br><input type='password' name='pw' value=''></p>

<label class='checkbox'>

<input type='checkbox' name='rem'>Remember Me on this computer</label>
<button type='submit' class='btn'>Log-In</button>
</form>
    		</div>

";

?>

</body>
</html>
