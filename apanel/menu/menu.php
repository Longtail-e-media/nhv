<link href="<?php echo ASSETS_PATH; ?>uploadify/uploadify.css" rel="stylesheet" type="text/css"/>
<?php
$moduleTablename = "tbl_menu"; // Database table name
$moduleId = 2;                // module id >>>>> tbl_modules
$moduleFoldername = "menu";        // Image folder name
$menuLevel = Module::get_properties($moduleId, 'level');
$position = array(1 => 'Main Menu', 2 => 'Footer Menu 1', 3 => 'Footer Menu 2', 4 => 'Footer Menu 3');
$style = array(0 => 'one-column', 1 => 'four-column', 2 => 'four-column with Image');

if (isset($_GET['page']) && $_GET['page'] == "menu" && isset($_GET['mode']) && $_GET['mode'] == "list"):
clearImages($moduleTablename, $moduleFoldername);
    clearImages($moduleTablename, $moduleFoldername . "/thumbnails");
    
?>
    <h3>
        List Menu
        <a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);"
           onClick="AddNewMenu();">
    <span class="glyph-icon icon-separator">
    	<i class="glyph-icon icon-plus-square"></i>
    </span>
            <span class="button-content"> Add Menu </span>
        </a>
    </h3>
    <div class="my-msg"></div>
    <div class="example-box">
        <div class="example-code">
            <table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
                <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Name</th>
                    <th class="text-center">Link</th>
                    <th class="text-center">Position</th>
                    <th class="text-center"><?php echo $GLOBALS['basic']['action']; ?></th>
                </tr>
                </thead>

                <tbody>
                <?php $records = Menu::find_by_sql("SELECT * FROM " . $moduleTablename . " WHERE parentOf='0' ORDER BY sortorder ASC ");
                foreach ($records as $record): ?>
                    <tr id="<?php echo $record->id; ?>">
                        <td class="text-center"><?php echo $record->sortorder; ?></td>
                        <td>
                            <?php
                            $submenu = Menu::countSubMenu($record->id);
                            if ($submenu):
                                ?>
                                <a href="javascript:void(0);" title="title"
                                   onClick="displaySubMenu(<?php echo $record->id; ?>,'<?php echo $record->name; ?>')"
                                   id="" name="<?php echo $record->name; ?>">
                                    <?php echo $record->name; ?> <i>[<?php echo $submenu; ?>]</i>
                                </a>
                            <?php else:
                                echo $record->name;
                            endif; ?>
                        </td>
                        <td><?php echo $record->linksrc; ?></td>
                        <td class="text-center"><?php echo ($record->type) ? $position[$record->type] : 'N/A'; ?></td>
                        <td class="text-center">
                            <?php
                            $statusImage = ($record->status == 1) ? "bg-green" : "bg-red";
                            $statusText = ($record->status == 1) ? $GLOBALS['basic']['clickUnpub'] : $GLOBALS['basic']['clickPub'];
                            ?>
                            <a href="javascript:void(0);"
                               class="btn small <?php echo $statusImage; ?> tooltip-button statusToggler"
                               data-placement="top" title="<?php echo $statusText; ?>"
                               status="<?php echo $record->status; ?>" id="imgHolder_<?php echo $record->id; ?>"
                               moduleId="<?php echo $record->id; ?>">
                                <i class="glyph-icon icon-flag"></i>
                            </a>
                            <a href="javascript:void(0);" class="loadingbar-demo btn small bg-blue-alt tooltip-button"
                               data-placement="top" title="Edit" onclick="editRecord(<?php echo $record->id; ?>);">
                                <i class="glyph-icon icon-edit"></i>
                            </a>
                            <a href="javascript:void(0);" class="btn small bg-red tooltip-button" data-placement="top"
                               title="Remove"
                               onclick="recordDelete(<?php echo $record->id; ?>,<?php echo ($submenu) ? '1' : 0; ?>);">
                                <i class="glyph-icon icon-remove"></i>
                            </a>
                            <input name="sortId" type="hidden" value="<?php echo $record->id; ?>">
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- First Submenu -->
    <div class="submenu1"></div>
    <!-- Second Submenu -->
    <div class="submenu2"></div>
    <!-- Third Submenu -->
    <div class="submenu3"></div>
    <!-- Fourth Submenu -->
    <div class="submenu4"></div>

<?php elseif (isset($_GET['mode']) && $_GET['mode'] == "addEdit"):
    if (isset($_GET['id']) && !empty($_GET['id'])):
        $menuId = addslashes($_REQUEST['id']);
        $menu = Menu::find_by_id($menuId);
        $status = ($menu->status == 1) ? "checked" : "";
        $unstatus = ($menu->status == 0) ? "checked" : "";

        $external = ($menu->linktype == 1) ? "checked" : "";
        $internal = ($menu->linktype == 0) ? "checked" : "";
    endif;
    ?>
    <h3>
        <?php echo (isset($_GET['id'])) ? 'Edit Menu' : 'Add Menu'; ?>
        <a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);"
           onClick="viewMenulist();">
    <span class="glyph-icon icon-separator">
    	<i class="glyph-icon icon-arrow-circle-left"></i>
    </span>
            <span class="button-content"> Back </span>
        </a>
    </h3>

    <div class="my-msg"></div>
    <div class="example-box">
        <div class="example-code">
            <form action="" class="col-md-10 center-margin" id="menu_frm">
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Menu Name :
                        </label>
                    </div>
                    <div class="form-input col-md-10">
                        <input placeholder="Menu Name" class="col-md-4 validate[required,length[0,50]]" type="text"
                               name="name" id="name" value="<?php echo !empty($menu->name) ? $menu->name : ""; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Parent :
                        </label>
                    </div>
                    <div class="form-input col-md-4">
                        <?php
                        $Parentview = !empty($menu->parentOf) ? $menu->parentOf : 0;
                        echo Menu::get_parentList_bylevel($menuLevel, $Parentview);
                        ?>
                    </div>
                </div>
                <div class="form-row menu-position">
                    <div class="form-label col-md-2">
                        <label for="">
                            Menu Position :
                        </label>
                    </div>
                    <div class="form-input col-md-4">
                        <select data-placeholder="None" class="chosen-select validate[required]" id="type" name="type">
                            <option value="">Choose Position</option>
                            <?php foreach ($position as $key => $val) {
                                $sel = (!empty($menu->type) and $menu->type == $key) ? 'selected' : '';
                                echo '<option value="' . $key . '" ' . $sel . '>' . $val . '</option>';
                            } ?>
                        </select>
                    </div>
                </div>
                <!-- <div class="form-row menu-position">
                <div class="form-label col-md-2">
                    <label for="">
                        Menu Style :
                    </label>
                </div>                
                <div class="form-input col-md-4">
                    <select data-placeholder="None" class="chosen-select validate[required]" id="style" name="style">                        
                        <?php /* foreach ($style as $k => $v) {
                           $sel = (!empty($menu->style) and $menu->style==$k)?'selected':'';
                           echo '<option value="'.$k.'" '.$sel.'>'.$v.'</option>' ;
                        } */ ?>
                    </select>    
                </div>                
            </div> -->
             <div class="form-row add-image">
                    <div class="form-label col-md-2">
                        <label for="">
                            Image :
                        </label>
                    </div>

                    <?php if (!empty($menu->image)): ?>
                        <div class="col-md-3" id="removeSavedimg<?php echo $menu->id; ?>">
                            <div class="infobox info-bg">
                                <div class="button-group" data-toggle="buttons">
                            <span class="float-left">
                                <?php
                                if (file_exists(SITE_ROOT . "images/menu/" . $menu->image)):
                                    $filesize = filesize(SITE_ROOT . "images/menu/" . $menu->image);
                                    echo 'Size : ' . getFileFormattedSize($filesize);
                                endif;
                                ?>
                            </span>
                                    <a class="btn small float-right" href="javascript:void(0);"
                                       onclick="deleteSavedDestinationimage(<?php echo $menu->id; ?>);">
                                        <i class="glyph-icon icon-trash-o"></i>
                                    </a>
                                </div>
                                <img src="<?php echo IMAGE_PATH . 'menu/thumbnails/' . $menu->image; ?>"
                                     style="width:100%"/>
                            </div>
                            <input type="hidden" name="imageArrayname"
                                                   value="<?php echo !empty($menu->image) ? $menu->image : ""; ?>"
                                                   class=""/>
                        </div>
                    <?php endif; ?>
                    <div class="form-input col-md-10 uploader <?php echo !empty($menu->image) ? "hide" : ""; ?>">
                        <input type="file" name="gallery_upload" id="gallery_upload" class="transparent no-shadow">
                        <label>
                            <small>Image Dimensions (385px X 500px)</small>
                        </label>
                    </div>
                    <!-- Upload user image preview -->
                    <div id="preview_Image"></div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Link Type :
                        </label>
                    </div>
                    <div class="form-checkbox-radio col-md-9">
                        <input id="" class="custom-radio" type="radio" name="linktype" value="0"
                               onClick="linkTypeSelect(0);" <?php echo !empty($internal) ? $internal : "checked"; ?>>
                        <label for="">Internal Link</label>
                        <input id="" class="custom-radio" type="radio" name="linktype" value="1"
                               onClick="linkTypeSelect(1);" <?php echo !empty($external) ? $external : ""; ?>>
                        <label for="">External Link</label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Link :
                        </label>
                    </div>
                    <div class="form-input col-md-8">
                        <div class="col-md-4" style="padding-left:0px !important;">
                            <input placeholder="Menu Link" class="validate[required,length[0,50]]" type="text"
                                   name="linksrc" id="linksrc"
                                   value="<?php echo !empty($menu->linksrc) ? $menu->linksrc : ""; ?>">
                        </div>
                        <div class="col-md-6" style="padding-left:0px !important;">
                            <select data-placeholder="Select Link Page" class="col-md-4 chosen-select" id="linkPage">
                                <option value=""></option>
                                <?php
                                $Lpageview = !empty($menu->linksrc) ? $menu->linksrc : "";
                                $LinkTypeview = !empty($menu->linktype) ? $menu->linktype : "";
                                // Article Page Link
                                echo Articles::get_internal_link($Lpageview, $LinkTypeview);
                                // menu Page Link
                                echo Destination::get_internal_link($Lpageview, $LinkTypeview);
                                // Activities Page Link
                                echo Activities::get_internal_link($Lpageview, $LinkTypeview);
                                // Package Page Link
                                echo Package::get_internal_link($Lpageview, $LinkTypeview);
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Published :
                        </label>
                    </div>
                    <div class="form-checkbox-radio col-md-9">
                        <input type="radio" class="custom-radio" name="status" id="check1"
                               value="1" <?php echo !empty($status) ? $status : "checked"; ?>>
                        <label for="">Published</label>
                        <input type="radio" class="custom-radio" name="status" id="check0"
                               value="0" <?php echo !empty($unstatus) ? $unstatus : ""; ?>>
                        <label for="">Un-Published</label>
                    </div>
                </div>

                <button btn-action='0' type="submit" name="submit"
                        class="btn-submit btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4"
                        id="btn-submit" title="Save">
                <span class="button-content">
                    Save
                </span>
                </button>
                <?php if (!isset($_GET['id'])) { ?>
                    <button btn-action='1' type="submit" name="submit"
                            class="btn-submit btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4"
                            id="btn-submit" title="Save">
                <span class="button-content">
                    Save & More
                </span>
                    </button>
                <?php } ?>
                <button btn-action='2' type="submit" name="submit"
                        class="btn-submit btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4"
                        id="btn-submit" title="Save">
                <span class="button-content">
                    Save & quit
                </span>
                </button>
                <input myaction='0' type="hidden" name="idValue" id="idValue"
                       value="<?php echo !empty($menu->id) ? $menu->id : 0; ?>"/>
        </form>
        </div>
    </div>

      <script type="text/javascript" src="<?php echo ASSETS_PATH; ?>uploadify/jquery.uploadify.min.js"></script>
   <script type="text/javascript">
        // <![CDATA[
        $(document).ready(function () {
            $('#gallery_upload').uploadify({
                'swf': '<?php echo ASSETS_PATH;?>uploadify/uploadify.swf',
                'uploader': '<?php echo ASSETS_PATH;?>uploadify/uploadify.php',
                'formData': {
                    PROJECT: '<?php echo SITE_FOLDER;?>',
                    targetFolder: 'images/menu/',
                    thumb_width: 200,
                    thumb_height: 200
                },
                'method': 'post',
                'cancelImg': '<?php echo BASE_URL;?>uploadify/cancel.png',
                'auto': true,
                'multi': true,
                'hideButton': false,
                'buttonText': 'Upload Image',
                'width': 125,
                'height': 21,
                'removeCompleted': true,
                'progressData': 'speed',
                'uploadLimit': 100,
                'fileTypeExts': '*.gif; *.jpg; *.jpeg;  *.png; *.GIF; *.JPG; *.JPEG; *.PNG;',
                'buttonClass': 'button formButtons',
                /* 'checkExisting' : '/uploadify/check-exists.php',*/
                'onUploadSuccess': function (file, data, response) {
                    $('#uploadedImageName').val('1');
                    var filename = data;
                    $.post('<?php echo BASE_URL;?>apanel/menu/uploaded_image.php', {imagefile: filename}, function (msg) {
                        $('#preview_Image').html(msg).show();
                    });

                },
                'onDialogOpen': function (event, ID, fileObj) {
                },
                'onUploadError': function (file, errorCode, errorMsg, errorString) {
                    alert(errorMsg);
                },
                'onUploadComplete': function (file) {
                    //alert('The file ' + file.name + ' was successfully uploaded');
                }
            });
            });
            </script>
<?php endif; ?>