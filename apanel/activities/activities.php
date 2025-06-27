<link href="<?php echo ASSETS_PATH; ?>uploadify/uploadify.css" rel="stylesheet" type="text/css"/>
<?php
$moduleTablename = "tbl_activities"; // Database table name
$moduleId = 20;                // module id >>>>> tbl_modules
$moduleFoldername = "activities";        // Image folder name

if (isset($_GET['page']) && $_GET['page'] == "activities" && isset($_GET['mode']) && $_GET['mode'] == "list"):
    clearImages($moduleTablename, $moduleFoldername);
    clearImages($moduleTablename, $moduleFoldername . "/thumbnails");
    ?>
    <h3>
        List Activities
        <a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="AddNewActivities();">
            <span class="glyph-icon icon-separator"><i class="glyph-icon icon-plus-square"></i></span>
            <span class="button-content"> Add New </span>
        </a>
    </h3>
    <div class="my-msg"></div>
    <div class="example-box">
        <div class="example-code">
            <table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
                <thead>
                <tr>
                    <th style="display:none;"></th>
                    <th class="text-center"><input class="check-all" type="checkbox"/></th>
                    <th>Title</th>
                    <th>Destination</th>
                    <th class="text-center">Region</th>
                    <th class="text-center"><?php echo $GLOBALS['basic']['action']; ?></th>
                </tr>
                </thead>

                <tbody>
                <?php $parentId = (isset($_REQUEST['id']) and !empty($_REQUEST['id'])) ? addslashes($_REQUEST['id']) : 0;
                $records = Activities::find_all_byparnt($parentId);
                foreach ($records as $key => $record): ?>
                    <tr id="<?php echo $record->id; ?>">
                        <td style="display:none;"><?php echo $key + 1; ?></td>
                        <td><input type="checkbox" class="bulkCheckbox" bulkId="<?php echo $record->id; ?>"/></td>
                        <td>
                            <div class="col-md-7">
                                <a href="javascript:void(0);" onClick="editRecord(<?php echo $record->id; ?>);" class="loadingbar-demo"
                                   title="<?php echo $record->title; ?>"><?php echo $record->title; ?></a>
                            </div>
                        </td>
                        <td><?php echo Destination::field_by_id($record->destinationId, 'title'); ?></td>
                        <td class="text-center">
                            <?php $countChild = Activities::getTotalChild($record->id);
                            $addfnc = ($countChild) ? 'onClick="viewsublist(' . $record->id . ');"' : ''; ?>
                            <a class="primary-bg medium btn loadingbar-demo" title="" <?php echo $addfnc; ?> href="javascript:void(0);">
                                <span class="button-content">
                                    <span class="badge bg-orange radius-all-4 mrg5R" title=""
                                          data-original-title="Badge with tooltip"><?php echo $countChild; ?></span>
                                    <span class="text-transform-upr font-bold font-size-11">View Lists</span>
                                </span>
                            </a>
                        </td>
                        <td class="text-center">
                            <?php
                            $statusImage = ($record->status == 1) ? "bg-green" : "bg-red";
                            $statusText = ($record->status == 1) ? $GLOBALS['basic']['clickUnpub'] : $GLOBALS['basic']['clickPub'];
                            ?>
                            <a href="javascript:void(0);" class="btn small <?php echo $statusImage; ?> tooltip-button statusToggler" data-placement="top"
                               title="<?php echo $statusText; ?>" status="<?php echo $record->status; ?>" id="imgHolder_<?php echo $record->id; ?>"
                               moduleId="<?php echo $record->id; ?>">
                                <i class="glyph-icon icon-flag"></i>
                            </a>
                            <a href="javascript:void(0);" class="loadingbar-demo btn small bg-blue-alt tooltip-button" data-placement="top" title="Edit"
                               onclick="editRecord(<?php echo $record->id; ?>);">
                                <i class="glyph-icon icon-edit"></i>
                            </a>
                            <a href="javascript:void(0);" class="btn small bg-red tooltip-button" data-placement="top" title="Remove"
                               onclick="recordDelete(<?php echo $record->id; ?>);">
                                <i class="glyph-icon icon-remove"></i>
                            </a>
                            <input name="sortId" type="hidden" value="<?php echo $record->id; ?>">
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="pad0L col-md-2">
            <select name="dropdown" id="groupTaskField" class="custom-select">
                <option value="0"><?php echo $GLOBALS['basic']['choseAction']; ?></option>
                <option value="delete"><?php echo $GLOBALS['basic']['delete']; ?></option>
                <option value="toggleStatus"><?php echo $GLOBALS['basic']['toggleStatus']; ?></option>
            </select>
        </div>
        <a class="btn medium primary-bg" href="javascript:void(0);" id="applySelected_btn">
        <span class="glyph-icon icon-separator float-right">
          <i class="glyph-icon icon-cog"></i>
        </span>
            <span class="button-content"> Click </span>
        </a>
    </div>

<?php elseif (isset($_GET['mode']) && $_GET['mode'] == "addEdit"):
    if (isset($_GET['id']) && !empty($_GET['id'])):
        $activitiesId = addslashes($_REQUEST['id']);
        $activitiesInfo = Activities::find_by_id($activitiesId);
        $status = ($activitiesInfo->status == 1) ? "checked" : " ";
        $unstatus = ($activitiesInfo->status == 0) ? "checked" : " ";
    endif;
    ?>
    <h3>
        <?php echo (isset($_GET['id'])) ? 'Edit Activities' : 'Add Activities'; ?>
        <a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="viewactivitieslist();">
            <span class="glyph-icon icon-separator"><i class="glyph-icon icon-arrow-circle-left"></i></span>
            <span class="button-content"> Back </span>
        </a>
    </h3>

    <div class="my-msg"></div>
    <div class="example-box">
        <div class="example-code">
            <form action="" class="col-md-12 center-margin" id="activities_frm">
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">Destination</label>
                    </div>
                    <div class="form-input col-md-20">
                        <select name="destinationId" class="col-md-4 validate[required] destinationId">
                            <option value=" ">Choose Destionation</option>
                            <?php $desId = !empty($activitiesInfo->destinationId) ? $activitiesInfo->destinationId : 0;
                            echo Destination::get_destination_option($desId); ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">Parent</label>
                    </div>
                    <div class="form-input col-md-20">
                        <?php $selid = !empty($activitiesInfo->parentOf) ? $activitiesInfo->parentOf : 0; ?>
                        <select name="parentOf" class="col-md-4 activityfilter" selId="<?php echo $selid; ?>">
                            <?php $destid = !empty($activitiesInfo->destinationId) ? $activitiesInfo->destinationId : 0;
                            echo Activities::get_all_filterdata($destid, $selid); ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Title :
                        </label>
                    </div>
                    <div class="form-input col-md-20">
                        <input placeholder="Activities Title" class="col-md-6 validate[required,length[0,100]]"
                               type="text" name="title" id="title"
                               value="<?php echo !empty($activitiesInfo->title) ? $activitiesInfo->title : ""; ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Title Brief :
                        </label>
                    </div>
                    <div class="form-input col-md-20">
                        <input placeholder="Title Brief" class="col-md-6 validate[required,length[0,200]]" type="text"
                               name="title_brief" id="title_brief"
                               value="<?php echo !empty($activitiesInfo->title_brief) ? $activitiesInfo->title_brief : ""; ?>">
                    </div>
                </div>

                <div class="form-row add-image">
                    <div class="form-label col-md-2">
                        <label for="">
                            Image :
                        </label>
                    </div>

                    <?php if (!empty($activitiesInfo->image)): ?>
                        <div class="col-md-3" id="removeSavedimg<?php echo $activitiesInfo->id; ?>">
                            <div class="infobox info-bg">
                                <div class="button-group" data-toggle="buttons">
                            <span class="float-left">
                                <?php
                                if (file_exists(SITE_ROOT . "images/activities/" . $activitiesInfo->image)):
                                    $filesize = filesize(SITE_ROOT . "images/activities/" . $activitiesInfo->image);
                                    echo 'Size : ' . getFileFormattedSize($filesize);
                                endif;
                                ?>
                            </span>
                                    <a class="btn small float-right" href="javascript:void(0);"
                                       onclick="deleteSavedActivitiesimage(<?php echo $activitiesInfo->id; ?>);">
                                        <i class="glyph-icon icon-trash-o"></i>
                                    </a>
                                </div>
                                <img src="<?php echo IMAGE_PATH . 'activities/thumbnails/' . $activitiesInfo->image; ?>"
                                     style="width:100%"/>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="form-input col-md-10 uploader">
                        <input type="file" name="gallery_upload" id="gallery_upload" class="transparent no-shadow">
                        <label>
                            <small>Image Dimensions (<?php echo Module::get_properties($moduleId, 'imgwidth'); ?> px
                                X <?php echo Module::get_properties($moduleId, 'imgheight'); ?> px)
                            </small>
                        </label>
                    </div>
                    <!-- Upload user image preview -->
                    <div id="preview_Image"><input type="hidden" name="imageArrayname"
                                                   value="<?php echo !empty($activitiesInfo->image) ? $activitiesInfo->image : ""; ?>"
                                                   class=""/></div>
                </div>

                <div class="form-row add-image">
                    <div class="form-label col-md-2">
                        <label for="">
                            Banner Image :
                        </label>
                    </div>

                    <?php if (!empty($activitiesInfo->banner_image)): ?>
                        <div class="col-md-3" id="removeSavedimgb<?php echo $activitiesInfo->id; ?>">
                            <div class="infobox info-bg">
                                <div class="button-group" data-toggle="buttons">
                            <span class="float-left">
                                <?php
                                if (file_exists(SITE_ROOT . "images/activities/banner/" . $activitiesInfo->banner_image)):
                                    $filesize = filesize(SITE_ROOT . "images/activities/banner/" . $activitiesInfo->banner_image);
                                    echo 'Size : ' . getFileFormattedSize($filesize);
                                endif;
                                ?>
                            </span>
                                    <a class="btn small float-right" href="javascript:void(0);"
                                       onclick="deleteSavedActivitiesimage('b<?php echo $activitiesInfo->id; ?>');">
                                        <i class="glyph-icon icon-trash-o"></i>
                                    </a>
                                </div>
                                <img src="<?php echo IMAGE_PATH . 'activities/banner/thumbnails/' . $activitiesInfo->banner_image; ?>"
                                     style="width:100%"/>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="form-input col-md-10 uploader">
                        <input type="file" name="banner_upload" id="banner_upload" class="transparent no-shadow">
                        <label>
                            <small>Image Dimensions (1353px X 253px)</small>
                        </label>
                    </div>
                    <!-- Upload user image preview -->
                    <div id="preview_Image2"><input type="hidden" name="imageArrayname2"
                                                    value="<?php echo !empty($activitiesInfo->banner_image) ? $activitiesInfo->banner_image : ""; ?>"
                                                    class=""/></div>
                </div>

                <div class="form-row">
                    <div class="form-label col-md-12">
                        <label for="">
                            Content :
                        </label>
                        <textarea name="content" id="content"
                                  class="large-textarea validate[required]"><?php echo !empty($activitiesInfo->content) ? $activitiesInfo->content : ""; ?></textarea>
                        <a class="btn medium bg-orange mrg5T" title="Read More" id="readMore"
                           href="javascript:void(0);">
                            <span class="button-content">Read More</span>
                        </a>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-checkbox-radio col-md-9">
                        <input type="radio" class="custom-radio" name="status" id="check1"
                               value="1" <?php echo !empty($status) ? $status : "checked"; ?>>
                        <label for="">Published</label>
                        <input type="radio" class="custom-radio" name="status" id="check0"
                               value="0" <?php echo !empty($unstatus) ? $unstatus : ""; ?>>
                        <label for="">Un-Published</label>
                    </div>
                </div>

                <!-- Meta Tags-->
                <div class="form-row">
                    <div class="form-checkbox-radio col-md-9">
                        <a class="btn medium bg-blue" href="javascript:void(0);" onClick="toggleMetadata();">
                        <span class="glyph-icon icon-separator float-right">
                        	<i class="glyph-icon icon-caret-down"></i>
                        </span>
                            <span class="button-content"> Metadata Info </span>
                        </a>
                    </div>
                </div>
                <div class="form-row <?php echo (!empty($activitiesInfo->meta_keywords) || !empty($activitiesInfo->meta_description)) ? '' : 'hide'; ?> metadata">
                    <div class="col-md-6">
                        <textarea placeholder="Meta Keyword" name="meta_keywords" id="meta_keywords"
                                  class="character-keyword validate[required]"><?php echo !empty($activitiesInfo->meta_keywords) ? $activitiesInfo->meta_keywords : ""; ?></textarea>
                        <div class="keyword-remaining clear input-description">250 characters left</div>
                    </div>
                    <div class="col-md-6">
                        <textarea placeholder="Meta Description" name="meta_description" id="meta_description"
                                  class="character-description validate[required]"><?php echo !empty($activitiesInfo->meta_description) ? $activitiesInfo->meta_description : ""; ?></textarea>
                        <div class="description-remaining clear input-description">160 characters left</div>
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
                       value="<?php echo !empty($activitiesInfo->id) ? $activitiesInfo->id : 0; ?>"/>
            </form>
        </div>
    </div>
    <script>
        var base_url = "<?php echo ASSETS_PATH; ?>";
        var editor_arr = ["content"];
        create_editor(base_url, editor_arr);
    </script>

    <script type="text/javascript" src="<?php echo ASSETS_PATH; ?>uploadify/jquery.uploadify.min.js"></script>
    <script type="text/javascript">
        // <![CDATA[
        $(document).ready(function () {
            $('#gallery_upload').uploadify({
                'swf': '<?php echo ASSETS_PATH;?>uploadify/uploadify.swf',
                'uploader': '<?php echo ASSETS_PATH;?>uploadify/uploadify.php',
                'formData': {
                    PROJECT: '<?php echo SITE_FOLDER;?>',
                    targetFolder: 'images/activities/',
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
                    $.post('<?php echo BASE_URL;?>apanel/activities/uploaded_image.php', {imagefile: filename}, function (msg) {
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

            $('#banner_upload').uploadify({
                'swf': '<?php echo ASSETS_PATH;?>uploadify/uploadify.swf',
                'uploader': '<?php echo ASSETS_PATH;?>uploadify/uploadify.php',
                'formData': {
                    PROJECT: '<?php echo SITE_FOLDER;?>',
                    targetFolder: 'images/activities/banner/',
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
                    $('#uploadedImageName2').val('1');
                    var filename = data;
                    $.post('<?php echo BASE_URL;?>apanel/activities/banner_image.php', {imagefile: filename}, function (msg) {
                        $('#preview_Image2').html(msg).show();
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
        // ]]>
    </script>
<?php endif; ?>