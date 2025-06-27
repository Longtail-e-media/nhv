<link href="<?php echo ASSETS_PATH; ?>uploadify/uploadify.css" rel="stylesheet" type="text/css"/>

<?php

$moduleTablename = "tbl_applicants"; // Database table name

$moduleId = 32;              // module id >>>>> tbl_modules

$moduleFoldername = "";     // Image folder name



if (isset($_GET['page']) && $_GET['page'] == "vacency" && isset($_GET['mode']) && $_GET['mode'] == "vacencylist"):
    $id = intval(addslashes($_GET['id']));
    ?>

    <h3>

        List of Applicants

    </h3>

    <div class="my-msg"></div>

    <div class="example-box">

        <div class="example-code">

            <table cellpadding="0" cellspacing="0" border="0" class="table" id="example">

                <thead>

                <tr>

                    <th style="display:none;"></th>

                    <th class="text-center"><input class="check-all" type="checkbox"/></th>

                    <th>Name</th>
                    <th class="text-center">Address</th>
                    <th class="text-center">Phone</th>
                    <th class="text-center">Email</th>
                    <th class="text-center"><?php echo $GLOBALS['basic']['action']; ?></th>


                </tr>

                </thead>


                <tbody>

                <?php $records = Applicant::find_by_position($id);


                foreach ($records

                as $record):

                ?>

                <tr id="<?php echo $record->id; ?>">

                    <td style="display:none;"><?php echo $record->sortorder; ?></td>

                    <td><input type="checkbox" class="bulkCheckbox" bulkId="<?php echo $record->id; ?>"/></td>

                    <td><?php echo $record->fullname; ?></td>
                    <td><?php echo $record->current_address; ?></td>
                    <td><?php echo $record->mobile; ?></td>

                    <td><?php echo $record->email; ?></td>


                    <td class="text-center">


                        <a href="javascript:void(0);" class="loadingbar-demo btn small bg-blue-alt tooltip-button"
                           data-placement="top" title="View detail" onclick="editApplicant(<?php echo $record->id; ?>);">

                            <span class="button-content"> View Detail </span>


                        </a>

                        <a href="javascript:void(0);" class="btn small bg-red tooltip-button" data-placement="top"
                           title="Remove" onclick="recordApplicationDelete(<?php echo $record->id; ?>);">

                            <i class="glyph-icon icon-remove"></i>

                        </a>

                    </td>


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

            <span class="button-content"> Submit </span>

        </a>

    </div>


<?php elseif (isset($_GET['mode']) && $_GET['mode'] == "addEditApplicant"):

    if (isset($_GET['id']) && !empty($_GET['id'])):

        $appId = addslashes($_REQUEST['id']);

        $appInfo = Applicant::find_by_id($appId);

    endif;

    ?>

    <h3>

        <?php echo (isset($_GET['id'])) ? 'View Applicant' : 'View Applicant'; ?>

        <a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);"
           onClick="viewvacencylist();">

    <span class="glyph-icon icon-separator">

        <i class="glyph-icon icon-arrow-circle-left"></i>

    </span>

            <span class="button-content"> Back </span>

        </a>

    </h3>


    <div class="my-msg"></div>

    <table cellpadding="0" cellspacing="0" border="0" class="table">

        <thead>

        <tr>

            <th style="display:none;"></th>


        </tr>

        </thead>


        <tbody>

        <?php $record = Applicant::find_by_sql("SELECT * FROM " . $moduleTablename . " ORDER BY sortorder DESC ");

        ?>

        <tr id="<?php echo $record->id; ?>"></tr>

        <td style="display:none;"><?php echo $appInfo->sortorder; ?></td>

        <tr>
            <th>Name</th>
            <td><?php echo $appInfo->fullname; ?></td>
        </tr>
        <tr>
            <th class="text-center">Address</th>
            <td><?php echo $appInfo->current_address; ?></td>
        </tr>
        <tr>
            <th class="text-center">Mobile</th>
            <td><?php echo $appInfo->mobile; ?></td>
        </tr>


        <tr>
            <th class="text-center">Email</th>
            <td><?php echo $appInfo->email; ?></td>
        </tr>


        <tr>
            <th class="text-center">Special Qualification</th>
            <td><?php echo $appInfo->qualification; ?></td>
        </tr>

        <tr>
            <th class="text-center">Resume</th>
            <td><a href='../../../images/career/<?php echo $appInfo->myfile; ?>'
                   target="_blank"><?php echo $appInfo->myfile; ?></a></td>
        </tr>


        <tr>
            <td>
            </td>
        </tr>


        </tbody>

    </table>

    <script>

        var base_url = "<?php echo ASSETS_PATH; ?>";

        var editor_arr = ["content"];

        create_editor(base_url, editor_arr);

    </script>


    <script type="text/javascript" src="../assets/uploadify/jquery.uploadify.min.js"></script>

    <script type="text/javascript">

        // <![CDATA[

        $(document).ready(function () {

            $('#gallery_upload').uploadify({

                'swf': '<?php echo ASSETS_PATH;?>uploadify/uploadify.swf',

                'uploader': '<?php echo ASSETS_PATH;?>uploadify/uploadify.php',

                'formData': {
                    PROJECT: '<?php echo SITE_FOLDER;?>/',
                    targetFolder: 'images/news/',
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

                    $.post('<?php echo BASE_URL;?>apanel/news/uploaded_image.php', {imagefile: filename}, function (msg) {

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