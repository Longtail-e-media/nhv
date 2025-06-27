<?php
$Tablename = "tbl_review"; // Database table name
if (isset($_GET['page']) && $_GET['page'] == "package" && isset($_GET['mode']) && $_GET['mode'] == "reviewlist"):
    $id = intval(addslashes($_GET['id']));
    clearImages($Tablename, "package/review");
    clearImages($Tablename, "package/review/thumbnails");
    ?>
    <h3>
        List Review ["<?php echo Package::field_by_id($id, 'title'); ?>"]
        <a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);"
           onClick="AddNewReview(<?php echo $id; ?>);">
    <span class="glyph-icon icon-separator">
        <i class="glyph-icon icon-plus-square"></i>
    </span>
            <span class="button-content"> Add New </span>
        </a>
        <a class="loadingbar-demo btn medium bg-blue-alt float-right mrg5R" href="javascript:void(0);"
           onClick="viewPackagelist();">
    <span class="glyph-icon icon-separator">
        <i class="glyph-icon icon-arrow-circle-left"></i>
    </span>
            <span class="button-content"> Back </span>
        </a>
    </h3>
    <div class="my-msg"></div>
    <div class="example-box">
        <div class="example-code">
            <table cellpadding="0" cellspacing="0" border="0" class="table" id="subexample2">
                <thead>
                <tr>
                    <th style="display:none;"></th>
                    <th class="text-center"><input class="check-all" type="checkbox"/></th>
                    <th>Name</th>
                    <th class="text-center">Homepage</th>
                    <th class="text-center"><?php echo $GLOBALS['basic']['action']; ?></th>
                </tr>
                </thead>

                <tbody>
                <?php $records = Review::find_by_sql("SELECT * FROM " . $Tablename . " WHERE package_id=" . $id . " ORDER BY sortorder DESC ");
                foreach ($records as $key => $record): ?>
                    <tr id="<?php echo $record->id; ?>">
                        <td style="display:none;"><?php echo $key + 1; ?></td>
                        <td><input type="checkbox" class="bulkCheckbox" bulkId="<?php echo $record->id; ?>"/></td>
                        <td>
                            <div class="col-md-7">
                                <a href="javascript:void(0);"
                                   onClick="editReview(<?php echo $record->package_id; ?>,<?php echo $record->id; ?>);"
                                   class="loadingbar-demo"
                                   title="<?php echo $record->name; ?>"><?php echo $record->name; ?></a>
                            </div>
                        </td>
                        <td class="text-center">
                            <?php $homeImage = ($record->homepage == 1) ? "bg-green" : "bg-red";
                            $homeText = ($record->homepage == 1) ? $GLOBALS['basic']['clickUnpub'] : $GLOBALS['basic']['clickPub']; ?>
                            <a href="javascript:void(0);"
                               class="btn small <?php echo $homeImage; ?> tooltip-button reviewhomeToggler"
                               data-placement="top" title="<?php echo $homeText; ?>"
                               status="<?php echo $record->homepage; ?>" id="hmimgHolder_<?php echo $record->id; ?>"
                               moduleId="<?php echo $record->id; ?>">
                                <i class="glyph-icon icon-flag"></i>
                            </a>
                        </td>
                        <td class="text-center">
                            <?php
                            $statusImage = ($record->status == 1) ? "bg-green" : "bg-red";
                            $statusText = ($record->status == 1) ? $GLOBALS['basic']['clickUnpub'] : $GLOBALS['basic']['clickPub'];
                            ?>
                            <a href="javascript:void(0);"
                               class="btn small <?php echo $statusImage; ?> tooltip-button statusReview"
                               data-placement="top" title="<?php echo $statusText; ?>"
                               status="<?php echo $record->status; ?>" id="imgHolder_<?php echo $record->id; ?>"
                               moduleId="<?php echo $record->id; ?>">
                                <i class="glyph-icon icon-flag"></i>
                            </a>
                            <a href="javascript:void(0);" class="loadingbar-demo btn small bg-blue-alt tooltip-button"
                               data-placement="top" title="Edit"
                               onclick="editReview(<?php echo $record->package_id; ?>,<?php echo $record->id; ?>);">
                                <i class="glyph-icon icon-edit"></i>
                            </a>
                            <a href="javascript:void(0);" class="btn small bg-red tooltip-button" data-placement="top"
                               title="Remove" onclick="subreviewDelete(<?php echo $record->id; ?>);">
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
            <select name="dropdown" id="groupTaskField2" class="custom-select">
                <option value="0"><?php echo $GLOBALS['basic']['choseAction']; ?></option>
                <option value="subreviewdelete"><?php echo $GLOBALS['basic']['delete']; ?></option>
                <option value="subreviewtoggleStatus"><?php echo $GLOBALS['basic']['toggleStatus']; ?></option>
            </select>
        </div>
        <a class="btn medium primary-bg" href="javascript:void(0);" id="applySelected_btn2">
    <span class="glyph-icon icon-separator float-right">
      <i class="glyph-icon icon-cog"></i>
    </span>
            <span class="button-content"> Submit </span>
        </a>
    </div>

<?php elseif (isset($_GET['mode']) && $_GET['mode'] == "addEditreview"):
    $pid = addslashes($_REQUEST['id']);
    if (isset($_GET['subid']) and !empty($_GET['subid'])):
        $subpackageId = addslashes($_REQUEST['subid']);
        $reviewinfo = Review::find_by_id($subpackageId);
        $status = ($reviewinfo->status == 1) ? "checked" : " ";
        $unstatus = ($reviewinfo->status == 0) ? "checked" : " ";
        $homepage = ($reviewinfo->homepage == 1) ? "checked" : " ";
        $nothomepage = ($reviewinfo->homepage == 0) ? "checked" : " ";
        //echo "<pre>";print_r($reviewinfo);die();
    endif;
    ?>
    <h3>
        <?php echo (isset($_GET['subid'])) ? 'Edit Review' : 'Add Review'; ?>
        <a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);"
           onClick="viewreviewlist(<?php echo $pid; ?>);">
    <span class="glyph-icon icon-separator">
        <i class="glyph-icon icon-arrow-circle-left"></i>
    </span>
            <span class="button-content"> Back </span>
        </a>
    </h3>

    <div class="my-msg"></div>
    <div class="example-box">
        <div class="example-code">
            <form action="" class="col-md-12 center-margin" id="review_frm">
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Title:
                        </label>
                    </div>
                    <div class="form-input col-md-20">
                        <input placeholder="Title" class="col-md-4 validate[required]" type="text" name="title"
                               id="title" value="<?php echo !empty($reviewinfo->title) ? $reviewinfo->title : ""; ?>">
                    </div>
                </div>

                <!--<div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Link:
                        </label>
                    </div>
                    <div class="form-input col-md-20">
                        <input placeholder="Link" class="col-md-4" type="text" name="linksrc" id="linksrc"
                               value="<?php echo !empty($reviewinfo->linksrc) ? $reviewinfo->linksrc : ""; ?>">
                    </div>
                </div>-->

                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Image :
                        </label>
                    </div>
                    <div class="form-input col-md-10 uploader1 <?php echo !empty($reviewinfo->image) ? "hide" : ""; ?>">
                        <input type="file" name="background_upload" id="background_upload"
                               class="transparent no-shadow">
                        <label>
                            <small>Image Dimensions (100 px X 100 px)</small>
                        </label>
                    </div>
                    <!-- Upload user image preview -->
                    <div id="preview_Image"><input type="hidden" name="imageArrayname" class=""/></div>

                    <?php if (!empty($reviewinfo->image)): ?>
                        <div class="col-md-3" id="removeSavedimg1">
                            <div class="infobox info-bg">
                                <div class="button-group" data-toggle="buttons">
                            <span class="float-left">
                                <?php
                                if (file_exists(SITE_ROOT . "images/package/review/" . $reviewinfo->image)):
                                    $filesize = filesize(SITE_ROOT . "images/package/review/" . $reviewinfo->image);
                                    echo 'Size : ' . getFileFormattedSize($filesize);
                                endif;
                                ?>
                            </span>
                                    <a class="btn small float-right" href="javascript:void(0);"
                                       onclick="deleteSavedReviewimage(1);">
                                        <i class="glyph-icon icon-trash-o"></i>
                                    </a>
                                </div>
                                <img src="<?php echo IMAGE_PATH . 'package/review/thumbnails/' . $reviewinfo->image; ?>"
                                     style="width:100%"/> <input type="hidden" name="imageArrayname"
                                                                 value="<?php echo $reviewinfo->image; ?>" class=""/>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Message :
                        </label>
                    </div>
                    <div class="form-input col-md-8">
                        <textarea name="content" id="content"
                                  class="large-textarea"><?php echo !empty($reviewinfo->comments) ? $reviewinfo->comments : ""; ?></textarea>
                    </div>
                </div>
                <h3>Personal Information</h3>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Full Name:
                        </label>
                    </div>
                    <div class="form-input col-md-20">
                        <input placeholder=" Full Name" class="col-md-6 validate[required]" type="text" name="name"
                               id="name" value="<?php echo !empty($reviewinfo->name) ? $reviewinfo->name : ""; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Email:
                        </label>
                    </div>
                    <div class="form-input col-md-20">
                        <input placeholder="email" class="col-md-6 validate[]" type="text" name="email"
                               id="email" value="<?php echo !empty($reviewinfo->email) ? $reviewinfo->email : ""; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">Gender</label>
                    </div>
                    <div class="form-input col-md-20">
                        <select name="gender" class="col-md-4">
                            <option value="0">Others</option>
                            <?php $Arr = array(1 => 'Male', 2 => 'Female');
                            foreach ($Arr as $a => $b) {
                                $sel = (!empty($reviewinfo->gender) and ($reviewinfo->gender == $a)) ? "selected" : "";
                                echo '<option value="' . $a . '" ' . $sel . '>' . $b . '</option>';
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Phone:
                        </label>
                    </div>
                    <div class="form-input col-md-20">
                        <input placeholder="phone" class="col-md-6 validate[]" type="text" name="address"
                               id="address"
                               value="<?php echo !empty($reviewinfo->address) ? $reviewinfo->address : ""; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Country:
                        </label>
                    </div>
                    <div class="form-input col-md-20">
                        <input placeholder="country" class="col-md-6 validate[required]" type="text" name="country"
                               id="country"
                               value="<?php echo !empty($reviewinfo->country) ? $reviewinfo->country : ""; ?>">
                    </div>
                </div>

                <h3>Average Rating</h3>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">Pre-trip Info :</label>
                    </div>
                    <div class="form-input col-md-20">
                        <select name="pretrip" class="col-md-4">
                            <option value="0">None</option>
                            <?php $Arr2 = array('5' => 'Five', '4' => 'Four', '3' => 'Three', '2' => 'Two', '1' => 'One');
                            foreach ($Arr2 as $c => $d) {
                                $sel2 = (!empty($reviewinfo->pretrip) and ($reviewinfo->pretrip == $c)) ? "selected" : "";

                                echo '<option value="' . $c . '" ' . $sel2 . '>' . $d . '</option>';
                            } ?>
                        </select>

                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">Meals :</label>
                    </div>
                    <div class="form-input col-md-20">
                        <select name="meals" class="col-md-4">
                            <option value="0">None</option>
                            <?php $Arr3 = array('5' => 'Five', '4' => 'Four', '3' => 'Three', '2' => 'Two', '1' => 'One');
                            foreach ($Arr3 as $e => $f) {
                                $sel3 = (!empty($reviewinfo->meals) and ($reviewinfo->meals == $e)) ? "selected" : "";
                                echo '<option value="' . $e . '" ' . $sel3 . '>' . $f . '</option>';
                            } ?>

                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">Staffs :</label>
                    </div>
                    <div class="form-input col-md-20">
                        <select name="staffs" class="col-md-4">
                            <option value="0">None</option>
                            <?php $Arr4 = array('5' => 'Five', '4' => 'Four', '3' => 'Three', '2' => 'Two', '1' => 'One');
                            foreach ($Arr4 as $g => $h) {
                                $sel4 = (!empty($reviewinfo->staffs) and ($reviewinfo->staffs == $g)) ? "selected" : "";
                                echo '<option value="' . $g . '" ' . $sel4 . '>' . $h . '</option>';
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">Transportation :</label>
                    </div>
                    <div class="form-input col-md-20">
                        <select name="transportation" class="col-md-4">
                            <option value="0">None</option>
                            <?php $Arr5 = array('5' => 'Five', '4' => 'Four', '3' => 'Three', '2' => 'Two', '1' => 'One');
                            foreach ($Arr5 as $i => $j) {
                                $sel5 = (!empty($reviewinfo->transportation) and ($reviewinfo->transportation == $i)) ? "selected" : "";
                                echo '<option value="' . $i . '" ' . $sel5 . '>' . $j . '</option>';
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">Accomodation</label>
                    </div>
                    <div class="form-input col-md-20">
                        <select name="accomodation" class="col-md-4">
                            <option value="0">None</option>
                            <?php $Arr6 = array('5' => 'Five', '4' => 'Four', '3' => 'Three', '2' => 'Two', '1' => 'One');
                            foreach ($Arr6 as $k => $l) {
                                $sel6 = (!empty($reviewinfo->accomodation) and ($reviewinfo->accomodation == $k)) ? "selected" : "";
                                echo '<option value="' . $k . '" ' . $sel6 . '>' . $l . '</option>';
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">Value for Money :</label>
                    </div>
                    <div class="form-input col-md-20">
                        <select name="money" class="col-md-4">
                            <option value="0">None</option>
                            <?php $Arr7 = array('5' => 'Five', '4' => 'Four', '3' => 'Three', '2' => 'Two', '1' => 'One');
                            foreach ($Arr7 as $m => $n) {
                                $sel7 = (!empty($reviewinfo->money) and ($reviewinfo->money == $m)) ? "selected" : "";
                                echo '<option value="' . $m . '" ' . $sel7 . '>' . $n . '</option>';
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">Overall Rating:</label>
                    </div>
                    <div class="form-input col-md-20">
                        <select name="rating" class="col-md-4">
                            <option value="0">None</option>
                            <?php $Arr8 = array('5' => 'Five', '4' => 'Four', '3' => 'Three', '2' => 'Two', '1' => 'One');
                            foreach ($Arr8 as $o => $p) {
                                $sel8 = (!empty($reviewinfo->rating) and ($reviewinfo->rating == $o)) ? "selected" : "";
                                echo '<option value="' . $o . '" ' . $sel8 . '>' . $p . '</option>';
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Homepage :
                        </label>
                    </div>
                    <div class="form-checkbox-radio col-md-9">
                        <input type="radio" class="custom-radio" name="homepage" id="checkh"
                               value="1" <?php echo !empty($homepage) ? $homepage : ""; ?>>
                        <label for="">Homepage</label>
                        <input type="radio" class="custom-radio" name="homepage" id="checknh"
                               value="0" <?php echo !empty($nothomepage) ? $nothomepage : "checked"; ?>>
                        <label for="">Not Homepage</label>
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
                <button btn-action='1' type="submit" name="submit"
                        class="btn-submit btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4"
                        id="btn-submit" title="Save">
                <span class="button-content">
                    Save & More
                </span>
                </button>
                <button btn-action='2' type="submit" name="submit"
                        class="btn-submit btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4"
                        id="btn-submit" title="Save">
                <span class="button-content">
                    Save & quit
                </span>
                </button>
                <input myaction='0' type="hidden" name="idValue" id="idValue"
                       value="<?php echo !empty($reviewinfo->id) ? $reviewinfo->id : 0; ?>"/>
                <!-- <input type="hidden" name="package_currency" id="package_currency" value="USD" /> -->
                <input type="hidden" name="package_id" id="package_id"
                       value="<?php echo !empty($reviewinfo->package_id) ? $reviewinfo->package_id : $pid; ?>"/>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo ASSETS_PATH; ?>uploadify/jquery.uploadify.min.js"></script>
    <script>
        var base_url = "<?php echo ASSETS_PATH; ?>";
        var editor_arr = ["content"];
        create_editor(base_url, editor_arr);
    </script>
    <script type="text/javascript">
        // <![CDATA[
        $(document).ready(function () {
            $('#background_upload').uploadify({
                'swf': '<?php echo ASSETS_PATH;?>uploadify/uploadify.swf',
                'uploader': '<?php echo ASSETS_PATH;?>uploadify/uploadify.php',
                'formData': {
                    PROJECT: '<?php echo SITE_FOLDER;?>',
                    targetFolder: 'images/package/review/',
                    thumb_width: 200,
                    thumb_height: 200
                },
                'method': 'post',
                'cancelImg': '<?php echo BASE_URL;?>uploadify/cancel.png',
                'auto': true,
                'multi': false,
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
                    $.post('<?php echo BASE_URL;?>apanel/package/uploaded_image2.php', {imagefile: filename}, function (msg) {
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
        // ]]>
    </script>
<?php endif; ?>