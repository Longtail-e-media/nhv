<?php
// Load the header files first
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("cache-control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");

// Load necessary files then...
require_once("includes/initialize.php");

$action = $_REQUEST['action'];

switch ($action) {
    case "filteractivity":
        $desId = addslashes($_REQUEST['destid']);
        $rec = Activities::get_all_filterdatafront($desId);
        echo json_encode(array("action" => "success", "result" => $rec));
        break;

    case "filterRegion":
        $actId = addslashes($_REQUEST['actid']);
        $rec = Activities::get_all_regionfront($actId);
        echo json_encode(array("action" => "success", "result" => $rec));
        break;
}
?>