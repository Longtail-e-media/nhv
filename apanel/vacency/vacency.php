<?php
$moduleTablename = "tbl_vacency"; // Database table name
$moduleId = 35;                // module id >>>>> tbl_modules
$moduleFoldername = "";        // Image folder name



if (isset($_GET['page']) && $_GET['page'] == "vacency" && isset($_GET['mode']) && $_GET['mode'] == "list"):
    ?>
    <h3>
        List Vacency
        <a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);"
           onClick="AddNewVacencys();">
    <span class="glyph-icon icon-separator">
    	<i class="glyph-icon icon-plus-square"></i>
    </span>
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
                    <th class="text-center">Applicants</th>

                    <th class="text-center"><?php echo $GLOBALS['basic']['action']; ?></th>
                </tr>
                </thead>

                <tbody>
                <?php $records = Vacency::find_by_sql("SELECT * FROM " . $moduleTablename . " ORDER BY sortorder DESC ");
                foreach ($records as $record): ?>
                    <tr id="<?php echo $record->id; ?>">
                        <td style="display:none;"><?php echo $record->sortorder; ?></td>
                        <td><input type="checkbox" class="bulkCheckbox" bulkId="<?php echo $record->id; ?>"/></td>
                        <td>
                            <div class="col-md-7">
                                <a href="javascript:void(0);" onClick="editRecord(<?php echo $record->id; ?>);"
                                   class="loadingbar-demo"
                                   title="<?php echo $record->title; ?>"><?php echo $record->title; ?></a>
                            </div>
                        </td>
                        <td>
                            <a class="primary-bg medium btn loadingbar-demo" title=""
                               onClick="viewApplicantlist(<?php echo $record->id; ?>);" href="javascript:void(0);">
                        <span class="button-content">
                            <span class="badge bg-orange radius-all-4 mrg5R" title=""
                                  data-original-title="Badge with tooltip"><?php echo $countImages = Applicant::getTotalSub($record->id); ?></span>
                            <span class="text-transform-upr font-bold font-size-11">View Lists</span>
                        </span>
                            </a>
                            <?php $makasroom = ($record->type == 1) ? "icon-circle" : "icon-circle-o"; ?>
                            <a href="javascript:void(0);" class="btn small tooltip-button" data-placement="top"
                               title="">
                                <i class="glyph-icon <?php echo $makasroom; ?>"></i>
                            </a>
                        </td>
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
                               title="Remove" onclick="recordDelete(<?php echo $record->id; ?>);">
                                <i class="glyph-icon icon-remove"></i>
                            </a>
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
            <span class="button-content"> Submit </span>
        </a>
    </div>

<?php elseif (isset($_GET['mode']) && $_GET['mode'] == "addEdit"):
    if (isset($_GET['id']) && !empty($_GET['id'])):
        $vacencyId = addslashes($_REQUEST['id']);
        $vacencyInfo = Vacency::find_by_id($vacencyId);
        $status = ($vacencyInfo->status == 1) ? "checked" : "";
        $unstatus = ($vacencyInfo->status == 0) ? "checked" : "";
    endif;
    ?>
    <h3>
        <?php echo (isset($_GET['id'])) ? 'Edit Vacency' : 'Add Vacency'; ?>
        <a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);"
           onClick="viewvacencylist();">
    <span class="glyph-icon icon-separator">
    	<i class="glyph-icon icon-arrow-circle-left"></i>
    </span>
            <span class="button-content"> Back </span>
        </a>
    </h3>

    <div class="my-msg"></div>
    <div class="example-box">
        <div class="example-code">
            <form action="" class="col-md-12 center-margin" id="vacency_frm">
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Title :
                        </label>
                    </div>
                    <div class="form-input col-md-6">
                        <input placeholder="Vacency Title" class="col-md-6 validate[required,length[0,200]]" type="text"
                               name="title" id="title"
                               value="<?php echo !empty($vacencyInfo->title) ? $vacencyInfo->title : ""; ?>">
                    </div>
                </div>
                <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Start Date :
                    </label>
                </div>                
                <div class="form-input col-md-4">
                    <input placeholder="Start Date" class="col-md-6 validate[required] datepicker" type="text" name="date1" id="date1" value="<?php echo !empty($vacencyInfo->date1)?$vacencyInfo->date1:"";?>">
                </div>                
            </div> 

                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                           Deadline :
                        </label>
                    </div>
                    <div class="form-input col-md-4">
                        <input placeholder="Deadline " class="col-md-6 validate[required] datepicker" type="text"
                               name="vacency_date" id="vacency_date"
                               value="<?php echo !empty($vacencyInfo->date2) ? $vacencyInfo->date2 : ""; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            No.of Pax :
                        </label>
                    </div>
                    <div class="form-input col-md-6">
                        <input placeholder="Pax" class="col-md-4 validate[required,length[0,200]]" type="text"
                               name="pax" id="pax"
                               value="<?php echo !empty($vacencyInfo->pax) ? $vacencyInfo->pax : ""; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-12">
                        <label for="">
                            Content :
                        </label>
                        <textarea name="content" id="content"
                                  class="large-textarea validate[required]"><?php echo !empty($vacencyInfo->content) ? $vacencyInfo->content : ""; ?></textarea>
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
                <div class="form-row <?php echo (!empty($vacencyInfo->meta_keywords) || !empty($vacencyInfo->meta_description)) ? '' : 'hide'; ?> metadata">
                    <div class="col-md-6">
                        <textarea placeholder="Meta Keyword" name="meta_keywords" id="meta_keywords"
                                  class="character-keyword validate[required]"><?php echo !empty($vacencyInfo->meta_keywords) ? $vacencyInfo->meta_keywords : ""; ?></textarea>
                        <div class="keyword-remaining clear input-description">250 characters left</div>
                    </div>
                    <div class="col-md-6">
                        <textarea placeholder="Meta Description" name="meta_description" id="meta_description"
                                  class="character-description validate[required]"><?php echo !empty($vacencyInfo->meta_description) ? $vacencyInfo->meta_description : ""; ?></textarea>
                        <div class="description-remaining clear input-description">160 characters left</div>
                    </div>
                </div>

                <button type="submit" name="submit"
                        class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4"
                        id="btn-submit" title="Save">
                <span class="button-content">
                    Save
                </span>
                </button>
                <input type="hidden" name="idValue" id="idValue"
                       value="<?php echo !empty($vacencyInfo->id) ? $vacencyInfo->id : 0; ?>"/>
            </form>
        </div>
    </div>
    <script>
        var base_url = "<?php echo ASSETS_PATH; ?>";
        var editor_arr = ["content"];
        create_editor(base_url, editor_arr);
    </script>
<?php endif;
include("applicant.php"); ?>