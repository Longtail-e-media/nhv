<?php
// Load the header files first
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("cache-control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");

// Load necessary files then...
require_once('../initialize.php');

$action = $_REQUEST['action'];

switch ($action) {
    case "add":
        $record = new Vacency();
        $record->title = $_REQUEST['title'];
        $record->slug       = create_slug($_REQUEST['title']);
	       $record->pax 	= $_REQUEST['pax'];			
        $record->content = $_REQUEST['content'];
       $record->date1   = $_REQUEST['date1'];
        $record->date2  = $_REQUEST['vacency_date'];
        $record->status = $_REQUEST['status'];
        $record->meta_keywords = $_REQUEST['meta_keywords'];
        $record->meta_description = $_REQUEST['meta_description'];

        $record->sortorder = Vacency::find_maximum();
        $record->added_date = registered();
        $db->begin();
        if ($record->save()): $db->commit();
            $message = sprintf($GLOBALS['basic']['addedSuccess_'], "Vacency '" . $record->title . "'");
            echo json_encode(array("action" => "success", "message" => $message));
            log_action("Vacency [" . $record->title . "]" . $GLOBALS['basic']['addedSuccess'], 1, 3);
        else: $db->rollback();
            echo json_encode(array("action" => "error", "message" => $GLOBALS['basic']['unableToSave']));
        endif;
        break;

    case "edit":
        $record = Vacency::find_by_id($_REQUEST['idValue']);

        $record->title = $_REQUEST['title'];
        $record->slug       = create_slug($_REQUEST['title']);
        $record->date1   = $_REQUEST['date1'];
	$record->pax 	= $_REQUEST['pax'];			
        $record->content = $_REQUEST['content'];
        $record->date2 = $_REQUEST['vacency_date'];
        $record->status = $_REQUEST['status'];
        $record->meta_keywords = $_REQUEST['meta_keywords'];
        $record->meta_description = $_REQUEST['meta_description'];
        $db->begin();
        if ($record->save()): $db->commit();
            $message = sprintf($GLOBALS['basic']['changesSaved_'], "Vacency '" . $record->title . "'");
            echo json_encode(array("action" => "success", "message" => $message));
            log_action("Vacency [" . $record->title . "] Edit Successfully", 1, 4);
        else: $db->rollback();
            echo json_encode(array("action" => "notice", "message" => $GLOBALS['basic']['noChanges']));
        endif;
        break;

    case "delete":
        $id = $_REQUEST['id'];
        $record = Vacency::find_by_id($id);
        $db->begin();
        $res = $db->query("DELETE FROM tbl_vacency WHERE id='{$id}'");
        if ($res) $db->commit(); else $db->rollback();
        reOrder("tbl_vacency", "sortorder");

        $message = sprintf($GLOBALS['basic']['deletedSuccess_'], "Vacency '" . $record->title . "'");
        echo json_encode(array("action" => "success", "message" => $message));
        log_action("Vacency  [" . $record->title . "]" . $GLOBALS['basic']['deletedSuccess'], 1, 6);
        break;

    // Module Setting Sections  >> <<
    case "toggleStatus":
        $id = $_REQUEST['id'];
        $record = Vacency::find_by_id($id);
        $record->status = ($record->status == 1) ? 0 : 1;
        $record->save();
        echo "";
        break;

    case "bulkToggleStatus":
        $id = $_REQUEST['idArray'];
        $allid = explode("|", $id);
        $return = "0";
        for ($i = 1; $i < count($allid); $i++) {
            $record = Vacency::find_by_id($allid[$i]);
            $record->status = ($record->status == 1) ? 0 : 1;
            $record->save();
        }
        echo "";
        break;

    case "bulkDelete":
        $id = $_REQUEST['idArray'];
        $allid = explode("|", $id);
        $return = "0";
        $db->begin();
        for ($i = 1; $i < count($allid); $i++) {
            $record = Vacency::find_by_id($allid[$i]);
            log_action("Vacency  [" . $record->title . "]" . $GLOBALS['basic']['deletedSuccess'], 1, 6);
            $res = $db->query("DELETE FROM tbl_vacency WHERE id='" . $allid[$i] . "'");
            $return = 1;
        }
        if ($res) $db->commit(); else $db->rollback();
        reOrder("tbl_vacency", "sortorder");

        if ($return == 1):
            $message = sprintf($GLOBALS['basic']['deletedSuccess_bulk'], "Vacency");
            echo json_encode(array("action" => "success", "message" => $message));
        else:
            echo json_encode(array("action" => "error", "message" => $GLOBALS['basic']['noRecords']));
        endif;
        break;

    case "sort":
        $id = $_REQUEST['id'];    // IS a line containing ids starting with : sortIds
        $order = ($_REQUEST['toPosition'] == 1) ? 0 : $_REQUEST['toPosition'];// IS a line containing sortorder

        $db->query("UPDATE tbl_vacency SET sortorder=" . $order . " WHERE id=" . $id . " ");

        reOrder("tbl_vacency", "sortorder");
        $message = sprintf($GLOBALS['basic']['sorted_'], "Vacency");
        echo json_encode(array("action" => "success", "message" => $message));
        break;
}
?>