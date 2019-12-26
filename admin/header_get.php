<html>
<?php
require '../functions.php';
require 'checking.php';

// grab the connecting ip address. //



// determine if connecting ip address is allowed to connect to PHP Timeclock //

if ($restrict_ips == "yes") {
  for ($x=0; $x<count($allowed_networks); $x++) {
    $is_allowed = ip_range($allowed_networks[$x], $connecting_ip);
    if (!empty($is_allowed)) {
      $allowed = TRUE;
    }
  }
  if (!isset($allowed)) {
    echo "You are not authorized to view this page."; exit;
  }
}

// check for correct db version //
$table = "dbversion";
$result = DBcon::execute("SHOW TABLES LIKE '".$db_prefix.$table."'");
@$rows = $result->num_rows;
if ($rows == "1") {
$dbexists = "1";
} else {
$dbexists = "0";
}

$db_version_result = DBcon::execute("select * from ".$db_prefix."dbversion");
while (@$row = DBcon::fetch_all_array($db_version_result)) {
    @$my_dbversion = "".$row["dbversion"]."";
}

// include css and timezone offset//

if (($use_client_tz == "yes") && ($use_server_tz == "yes")) {

$use_client_tz = '$use_client_tz';
$use_server_tz = '$use_server_tz';
echo "Please reconfigure your config.inc.php file, you cannot have both $use_client_tz AND $use_server_tz set to 'yes'"; exit;}

echo "<head>\n";
if ($use_client_tz == "yes") {
if (!isset($_COOKIE['tzoffset'])) {
include '../tzoffset.php';
echo "<meta http-equiv='refresh' content='0;URL=index.php'>\n";}}
echo "<link rel='stylesheet' type='text/css' media='screen' href='../css/default.css' />\n";
echo "<link rel='stylesheet' type='text/css' media='print' href='../css/print.css' />\n";
echo "<script type=\"text/javascript\" src=\"../scripts/CalendarPopup.js\"></script>\n";
echo "<script language=\"javascript\">document.write(getCalendarStyles());</script>\n";
echo "<script language=\"javascript\" src=\"../scripts/pnguin.js\"></script>\n";
include '../scripts/dropdown_get.php';
echo "</head>\n";

if ($use_client_tz == "yes") {
if (isset($_COOKIE['tzoffset'])) {
$tzo = $_COOKIE['tzoffset'];
settype($tzo, "integer");
$tzo = $tzo * 60;}
} elseif ($use_server_tz == "yes") {
  $tzo = date('Z');
} else {
  $tzo = "1";}
echo "<body onload='office_names();'>\n";
?>
