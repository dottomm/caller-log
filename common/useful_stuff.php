<?php

$_uid = chk_user();


//---------------------------------
// the db connect function
//---------------------------------
function db_connect()
{
	if (stristr($_SERVER['SERVER_NAME'],"dottomm.com")){
		if (@mysql_connect("localhost","dottommc_access","drAccess@2014")){
			if (@mysql_select_db("dottommc_callerLog")){
				return true;
			}
		}
	}

	else {
		if (@mysql_connect("localhost","root","root")){
			if (@mysql_select_db("DR_Caller_Log")){
				return true;
			}
		}
	}

	echo "Our database is offline for maintainance. Please try again shortly.
	<hr>Status 500";
}

//-------------------------------------
// this gets a form / page variable
//-------------------------------------
function getvar($varname)
{
	if (isset($_REQUEST[$varname])){
		if (get_magic_quotes_gpc()){
			return trim($_REQUEST[$varname]);
		}
		else {
			return trim(addslashes($_REQUEST[$varname]));
		}
	}

	// variable didnt exist
	return "";
}

//-------------------------------------
// checks if a user is logged in
//-------------------------------------
function chk_user()
{
	if (isset($_COOKIE['_1001']))
		return $_COOKIE['_1001'];

	return 0;
}

?>
