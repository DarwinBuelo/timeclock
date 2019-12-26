<html>
<?php

require '../functions.php';
require 'checking.php';
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
echo "<script language=\"javascript\" src=\"../scripts/pnguin.js\"></script>\n";
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
echo "<body>\n";
?>
