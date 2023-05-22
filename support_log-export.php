<?php
include 'common/useful_stuff.php';
if(!db_connect())
die();
if ($_uid == 0){
	header("location:login.php");
	die();
	}
$support_id = getvar("support_id");
$support_type = getvar("support_type");
	$question = getvar("question");
	$email = getvar("email");
	$output="";
	$result="";
  
  //
  // execute sql query
  //
  $query = sprintf("Select * from support_log order by support_id" );
  $result = mysql_query( $query);
  //
  // send response headers to the browser
  // following headers instruct the browser to treat the data as a csv file called export.csv
  //
  header( 'Content-Type: text/csv' );
  header( 'Content-Disposition: attachment;filename=support-type-export.csv' );
  //
  // output header row (if atleast one row exists)
  //
  $row = mysql_fetch_assoc( $result );
  if ( $row )
  {
    echocsv( array_keys( $row ) );
  }
  //
  // output data rows (if atleast one row exists)
  //
  while ( $row )
  {
    echocsv( $row );
    $row = mysql_fetch_assoc( $result );
  }
  //
  // echocsv function
  //
  // echo the input array as csv data maintaining consistency with most CSV implementations
  // * uses double-quotes as enclosure when necessary
  // * uses double double-quotes to escape double-quotes 
  // * uses CRLF as a line separator
  //
  function echocsv( $fields )
  {
    $separator = '';
    foreach ( $fields as $field )
    {
      if ( preg_match( '/\\r|\\n|,|"/', $field ) )
      {
        $field = '"' . str_replace( '"', '""', $field ) . '"';

      }

      echo $separator . $field;
      $separator = ',';
    }
    echo "\r\n";
  }

?>