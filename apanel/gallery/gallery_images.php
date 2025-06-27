<?php
if (isset($_GET['page']) && $_GET['page'] == "gallery" && isset($_GET['mode']) && $_GET['mode'] == "galleryImageList"):
    $id = intval(addslashes($_GET['id']));
    ?>
    <h3>
        List Galleries Images ["<?php echo Gallery::getGalleryName($id); ?>"]
        <a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);"
           onClick="viewGallerylist();">
    <span class="glyph-icon icon-separator">
    	<i class="glyph-icon icon-arrow-circle-left"></i>
    </span>
            <span class="button-content"> Back </span>
        </a>
    </h3>
    <div class="divider"></div>
    <div class="my-msg"></div>

    <link href="<?php echo ASSETS_PATH; ?>uploadify/uploadify.css" rel="stylesheet" type="text/css"/>
    <form action="" class="col-md-12 center-margin" method="post" id="subgallery_frm">
        <div class="row">
            <div class="form-row col-md-12">
                <div class="form-input col-md-10">
                    <input type="file" name="users_upload" id="users_upload" class="transparent no-shadow">
                    <label>
                        <small>Image Dimensions (<?php echo Module::get_properties($moduleId, 'simgwidth'); ?> px
                            X <?php echo Module::get_properties($moduleId, 'simgheight'); ?> px)
                        </small>
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
            <input type="hidden" name="galleryid" value="<?php echo $id; ?>" class="validate[required]">
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
                    targetFolder: 'images/gallery/galleryimages/',
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
                    $.post('<?php echo BASE_URL;?>apanel/gallery/uploaded_gallery_image.php', {imagefile: filename}, function (msg) {
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
    clearImages("tbl_gallery_images", "gallery/galleryimages");
    clearImages("tbl_gallery_images", "gallery/galleryimages/thumbnails");
    $saveGallery = GalleryImage::find_by_sql("SELECT * FROM tbl_gallery_images WHERE galleryid='{$id}' ORDER BY sortorder ASC");
    if ($saveGallery):
        ?>
        <div class="row">
            <div class="col-md-12 subImagegallery-sort">
                <?php
                $ic = 1;
                foreach ($saveGallery as $galleryRow):
//$newrecRow = ($ic++%4==0)?'</div><div class="row">':'';
                    ?>
                    <div class="col-md-3 removeSavedimg<?php echo $galleryRow->id; ?>"
                         id="<?php echo $galleryRow->id; ?>">
                        <div class="infobox info-bg">
                            <div class="button-group" data-toggle="buttons">
                <span class="float-left"><?php
                    $filesize = filesize(SITE_ROOT . "images/gallery/galleryimages/" . $galleryRow->image);
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
                            </div>
                            <img src="<?php echo IMAGE_PATH . 'gallery/galleryimages/thumbnails/' . $galleryRow->image; ?>"
                                 style="width:100%"/>
                            <span><?php echo $galleryRow->title; ?></span>
                        </div>
                    </div>
                    <?php //echo $newrecRow;
                    ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; endif; ?>