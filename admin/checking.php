<?php


// grab the connecting ip address for the audit log. if more than 1 ip address is returned, accept the first ip and discard the rest. //

$connecting_ip = get_ipaddress();
if (empty($connecting_ip)) {
    return FALSE;
}

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
$rows = DBcon::fetch_all_assoc($db_version_result);
foreach($rows as $row ){
    $my_dbversion = "".$row["dbversion"]."";
}
