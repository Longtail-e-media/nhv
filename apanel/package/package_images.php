<?php

if (isset($_GET['page']) && $_GET['page'] == "package" && isset($_GET['mode']) && $_GET['mode'] == "packageImageList"):
    $id = intval(addslashes($_GET['id']));
    $glRec = Package::find_by_id($id);
    //$pkgId = $glRec->type;

    ?>
    <h3>
        List Package Galleries Images ["<?php echo $glRec->title; ?>"]
        <a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);"
           onClick="viewPackagelist();">
    <span class="glyph-icon icon-separator">
        <i class="glyph-icon icon-arrow-circle-left"></i>
    </span>
            <span class="button-content"> Back </span>
        </a>
    </h3>
    <div class="divider"></div>
    <div class="my-msg"></div>

    <link href="<?php echo ASSETS_PATH; ?>uploadify/uploadify.css" rel="stylesheet" type="text/css"/>
    <form action="" class="col-md-12 center-margin" method="post" id="gallery_frm">
        <div class="row">
            <div class="form-row col-md-12">
                <div class="form-input col-md-10">
                    <input type="file" name="users_upload" id="users_upload" class="transparent no-shadow">
                    <label>
                        <small>Image Dimensions (735 px X 400 px)</small>
                    </label>
                </div>
                <div class="form-input float-right">
                    <button type="submit" name="submit"
                            class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit"
                            id="btn-submit" title="Save">
                    <span class="button-content">
                        Save
                    </span>
                    </button>
                </div>
            </div>
            <input type="hidden" name="packageid" value="<?php echo $glRec->id; ?>" class="validate[required]">

            <!-- Upload user image preview -->
            <div id="previewUser_Image"></div>
        </div>
    </form>

    <script type="text/javascript" src="<?php echo ASSETS_PATH; ?>uploadify/jquery.uploadify.min.js"></script>
    <script type="text/javascript">
        // <![CDATA[
        $(document).ready(function () {
            $('#users_upload').uploadify({
                'swf': '<?php echo ASSETS_PATH;?>uploadify/uploadify.swf',
                'uploader': '<?php echo ASSETS_PATH;?>uploadify/uploadify.php',
                'formData': {
                    PROJECT: '<?php echo SITE_FOLDER;?>',
                    targetFolder: 'images/package/galleryimages/',
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
                    $.post('<?php echo BASE_URL;?>apanel/package/uploaded_gallery_image1.php', {imagefile: filename}, function (msg) {
                        $('#previewUser_Image').append(msg).show();
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

    <?php
    clearImages("tbl_package_images", "package/galleryimages");
    clearImages("tbl_package_images", "package/galleryimages/thumbnails");
    $saveGallery = PackageImage::find_by_sql("SELECT * FROM tbl_package_images WHERE packageid='{$id}' ORDER BY sortorder ASC");
if ($saveGallery):
    ?>
    <div class="row">
        <div class="col-md-12 Imagegallery-sort">
            <?php
            $ic = 1;
            foreach ($saveGallery as $galleryRow):
//$newrecRow = ($ic++%4==0)?'</div><div class="row">':'';
                ?>
                <div class="col-md-3 removeSavedimg<?php echo $galleryRow->id; ?> oldsort"
                     id="<?php echo $galleryRow->id; ?>" csort="<?php echo $galleryRow->id; ?>">
                    <div class="infobox info-bg">
                        <div class="button-group" data-toggle="buttons">
                <span class="float-left"><?php
                    $filesize = filesize(SITE_ROOT . "images/package/galleryimages/" . $galleryRow->image);
                    echo 'Size : ' . getFileFormattedSize($filesize);
                    ?>
                </span>
                            <a class="btn small float-right" href="javascript:void(0);"
                               onclick="deleteSavedimage(<?php echo $galleryRow->id; ?>);">
                                <i class="glyph-icon icon-trash-o"></i>
                            </a>
                            <?php
                            $imageStatus = ($galleryRow->status == 1) ? 'icon-check-circle-o' : 'icon-clock-os-circle-o';
                            ?>
                            <a class="btn small float-right imageStatusToggle" href="javascript:void(0);"
                               rowId="<?php echo $galleryRow->id; ?>" status="<?php echo $galleryRow->status; ?>">
                                <i class="glyph-icon <?php echo $imageStatus; ?>"
                                   id="toggleImg<?php echo $galleryRow->id; ?>"></i>
                            </a>
                            <a class="btn small float-right" href="javascript:void(0);"
                               onclick="editImageTitle(<?php echo $galleryRow->id; ?>);" title="Edit Title">
                                <i class="glyph-icon icon-edit"></i>
                            </a>
                        </div>
                        <img src="<?php echo IMAGE_PATH . 'package/galleryimages/thumbnails/' . $galleryRow->image; ?>"
                             style="width:100%"/>
                        <div class="button-group" data-toggle="buttons">
                            <span class="up-title clicked<?php echo $galleryRow->id; ?>"
                              img-id="<?php echo $galleryRow->id; ?>"><?php echo $galleryRow->title; ?></span>
                        </div>

                    </div>
                </div>

            <?php endforeach;
            endif;
            ?>
        </div>
    </div>
<?php
endif; ?>
