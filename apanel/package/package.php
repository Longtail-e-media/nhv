<link href="<?php echo ASSETS_PATH; ?>uploadify/uploadify.css" rel="stylesheet" type="text/css"/>
<?php
$moduleTablename = "tbl_package"; // Database table name
$moduleId = 21;                // module id >>>>> tbl_modules
$moduleFoldername = "package";        // Image folder name

if (isset($_GET['page']) && $_GET['page'] == "package" && isset($_GET['mode']) && $_GET['mode'] == "list"):
    clearImages($moduleTablename, $moduleFoldername);
    clearImages($moduleTablename, $moduleFoldername . "/thumbnails");

    clearImages($moduleTablename, $moduleFoldername . "/map", "mapimage");
    clearImages($moduleTablename, $moduleFoldername . "/map/thumbnails", "mapimage");
    
    clearImages($moduleTablename, $moduleFoldername . "/docs", "itenaryfile");
    clearImages($moduleTablename, $moduleFoldername . "/docs/thumbnails", "itenaryfile");

    serclearImages($moduleTablename, $moduleFoldername . "/banner", "banner_image");
    serclearImages($moduleTablename, $moduleFoldername . "/banner/thumbnails", "banner_image");

    serclearImages($moduleTablename, $moduleFoldername . "/gallery", "gallery");
    serclearImages($moduleTablename, $moduleFoldername . "/gallery/thumbnails", "gallery");
    ?>
    <h3>
        List Package
        <a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);"
           onClick="AddNewPackage();">
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
                    <th class="text-center">Destination</th>
                    <th class="text-center">Itinerary</th>
                    <th class="text-center">Fixed Date</th>
                    <th class="text-center">Review</th>
                    <th class="text-center">Images</th>
                    <th class="text-center">Popular</th>
                    <th class="text-center">Featured</th>
                    <th class="text-center"><?php echo $GLOBALS['basic']['action']; ?></th>
                </tr>
                </thead>

                <tbody>
                <?php $records = Package::find_by_sql("SELECT * FROM " . $moduleTablename . " ORDER BY sortorder ASC ");
                foreach ($records as $key => $record): ?>
                    <tr id="<?php echo $record->id; ?>">
                        <td class="text-center" style="display:none;"><?php echo $key + 1; ?></td>
                        <td><input type="checkbox" class="bulkCheckbox" bulkId="<?php echo $record->id; ?>"/></td>
                        <td><?php echo $record->title; ?></td>
                        <td class="text-center"><?php echo set_na(Destination::field_by_id($record->destinationId, 'title')); ?></td>
                        <!-- <td class="text-center"><?php echo set_na(Activities::field_by_id($record->activityId, 'title')); ?></td>
                <td class="text-center"><?php echo set_na(Activities::field_by_id($record->regionId, 'title')); ?></td> -->
                        <td class="text-center">
                            <a class="primary-bg medium btn loadingbar-demo" title=""
                               onClick="viewItinerarylist(<?php echo $record->id; ?>);" href="javascript:void(0);">
                        <span class="button-content">
                            <span class="badge bg-orange radius-all-4 mrg5R" title=""
                                  data-original-title="Badge with tooltip"><?php echo $countImages = Itinerary::getTotalSub($record->id); ?></span>
                            <span class="text-transform-upr font-bold font-size-11">View</span>
                        </span>
                            </a>
                        </td>
                        <td class="text-center">
                            <a class="primary-bg medium btn loadingbar-demo" title=""
                               onClick="viewpackagedatelist(<?php echo $record->id; ?>);" href="javascript:void(0);">
                        <span class="button-content">
                            <span class="badge bg-orange radius-all-4 mrg5R" title=""
                                  data-original-title="Badge with tooltip"><?php echo $countImages = PackageDate::getTotalSub($record->id); ?></span>
                            <span class="text-transform-upr font-bold font-size-11">View</span>
                        </span>
                            </a>
                        </td>
                        <td class="text-center">
                            <a class="primary-bg medium btn loadingbar-demo" title=""
                               onClick="viewreviewlist(<?php echo $record->id; ?>);" href="javascript:void(0);">
                        <span class="button-content">
                            <span class="badge bg-orange radius-all-4 mrg5R" title=""
                                  data-original-title="Badge with tooltip"><?php echo $countImages = Review::getTotalSub($record->id); ?></span>
                            <span class="text-transform-upr font-bold font-size-11">View</span>
                        </span>
                            </a>
                        </td>
                        <td>
                            <a class="primary-bg medium btn loadingbar-demo" title=""
                               onClick="viewsubimagelist(<?php echo $record->id; ?>);" href="javascript:void(0);">
                        <span class="button-content">
                            <span class="badge bg-orange radius-all-4 mrg5R" title=""
                                  data-original-title="Badge with tooltip"><?php echo $countImages = PackageImage::getTotalImages($record->id);
                                //var_dump($countImages);die();?></span>

                            <span class="text-transform-upr font-bold font-size-11">View Lists</span>
                        </span>
                            </a>
                        </td>
                        <td class="text-center">
                            <?php $featureImage = ($record->featured == 1) ? "bg-green" : "bg-red";
                            $featlureText = ($record->featured == 1) ? $GLOBALS['basic']['clickUnpub'] : $GLOBALS['basic']['clickPub']; ?>
                            <a href="javascript:void(0);"
                               class="btn small <?php echo $featureImage; ?> tooltip-button featureToggler"
                               data-placement="top" title="<?php echo $featlureText; ?>"
                               status="<?php echo $record->featured; ?>" id="futimgHolder_<?php echo $record->id; ?>"
                               moduleId="<?php echo $record->id; ?>">
                                <i class="glyph-icon icon-flag"></i>
                            </a>
                        </td>
                        <!-- <td class="text-center">
                    <?php /*$lstminImage = ($record->lastminutes == 1) ? "bg-green" : "bg-red" ; 
                    $lstminText = ($record->lastminutes == 1) ? $GLOBALS['basic']['clickUnpub'] : $GLOBALS['basic']['clickPub'] ;*/ ?>                                             
                    <a href="javascript:void(0);" class="btn small <?php //echo $lstminImage;?> tooltip-button lstminToggler" data-placement="top" title="<?php //echo $lstminText;?>" status="<?php //echo $record->lastminutes;?>" id="lstimgHolder_<?php //echo $record->id;?>" moduleId="<?php //echo $record->id;?>">
                        <i class="glyph-icon icon-flag"></i>
                    </a>
                </td> -->
                        <td class="text-center">
                            <?php $homeImage = ($record->homepage == 1) ? "bg-green" : "bg-red";
                            $homeText = ($record->homepage == 1) ? $GLOBALS['basic']['clickUnpub'] : $GLOBALS['basic']['clickPub']; ?>
                            <a href="javascript:void(0);"
                               class="btn small <?php echo $homeImage; ?> tooltip-button homeToggler"
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
        $packageId = addslashes($_REQUEST['id']);
        $packageInfo = Package::find_by_id($packageId);
        $status = ($packageInfo->status == 1) ? "checked" : " ";
        $unstatus = ($packageInfo->status == 0) ? "checked" : " ";
        $feature = ($packageInfo->featured == 1) ? "checked" : " ";
        $unfeature = ($packageInfo->featured == 0) ? "checked" : " ";
        /*$lstmin      = ($packageInfo->lastminutes==1)?"checked":" ";
        $unlstmin    = ($packageInfo->lastminutes==0)?"checked":" ";*/
        $homepg = ($packageInfo->homepage == 1) ? "checked" : " ";
        $unhomepg = ($packageInfo->homepage == 0) ? "checked" : " ";
        $imgmptype = ($packageInfo->maptype == 1) ? "checked" : " ";
        $gogmptype = ($packageInfo->maptype == 2) ? "checked" : " ";
        $gogmphide = ($packageInfo->maptype == 1) ? 'hide' : '';
        $imgmphide = ($packageInfo->maptype == 2) ? 'hide' : '';
        //$vdogmptype = ($packageInfo->maptype == 2) ? "checked" : " ";
        /*$lstmin      = ($packageInfo->lastminutes==1)?"checked":" ";
        $unlstmin    = ($packageInfo->lastminutes==0)?"checked":" ";*/
    endif;
    ?>

    <h3>
        <?php echo (isset($_GET['id'])) ? 'Edit Package' : 'Add Package'; ?>
        <a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);"
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
            <form action="" class="col-md-12 center-margin" id="package_frm">

                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Title :
                        </label>
                    </div>
                    <div class="form-input col-md-20">
                        <input placeholder="Title" class="col-md-4 validate[required,length[0,200]]" type="text"
                               name="title" id="title"
                               value="<?php echo !empty($packageInfo->title) ? $packageInfo->title : ""; ?>">
                    </div>
                </div>

                <div class="form-row add-image">
                    <div class="form-label col-md-2">
                        <label for="">
                            Image :
                        </label>
                    </div>
                    <div class="form-input col-md-10 uploader <?php echo !empty($packageInfo->image) ? "hide" : ""; ?>">
                        <input type="file" name="package_icon" id="package_icon" class="transparent no-shadow">
                        <label>
                            <small>Image Dimensions (<?php echo Module::get_properties($moduleId, 'imgwidth'); ?> px
                                X <?php echo Module::get_properties($moduleId, 'imgheight'); ?> px)
                            </small>
                        </label>
                    </div>
                    <!-- Upload user image preview -->
                    <div id="preview_Image"><input type="hidden" name="imageArrayname" class=""/></div>
                    <div class="form-row">
                        <?php if (!empty($packageInfo->image)): ?>
                            <div class="col-md-3" id="removeSavedimg<?php echo $packageInfo->id; ?>">
                                <div class="infobox info-bg">
                                    <div class="button-group" data-toggle="buttons">
                            <span class="float-left">
                                <?php
                                if (file_exists(SITE_ROOT . "images/package/" . $packageInfo->image)):
                                    $filesize = filesize(SITE_ROOT . "images/package/" . $packageInfo->image);
                                    echo 'Size : ' . getFileFormattedSize($filesize);
                                endif;
                                ?>
                            </span>
                                        <a class="btn small float-right" href="javascript:void(0);"
                                           onclick="deleteSavedPackageimage(<?php echo $packageInfo->id; ?>);">
                                            <i class="glyph-icon icon-trash-o"></i>
                                        </a>
                                    </div>
                                    <img src="<?php echo IMAGE_PATH . 'package/thumbnails/' . $packageInfo->image; ?>"
                                         style="width:100%"/> <input type="hidden" name="imageArrayname"
                                                                     value="<?php echo $packageInfo->image; ?>"/>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>

                    <?php
                    if (!empty($packageInfo->banner_image)):
                        $imageRec = unserialize($packageInfo->banner_image);
                        if ($imageRec):
                            foreach ($imageRec as $k => $imageRow): ?>
                                <div class="col-md-3" id="removeSavedimg22">
                                    <div class="infobox info-bg">
                                        <div class="button-group" data-toggle="buttons">
                                    <span class="float-left">
                                        <?php
                                        if (file_exists(SITE_ROOT . "images/package/banner/" . $imageRow)):
                                            $filesize = filesize(SITE_ROOT . "images/package/banner/" . $imageRow);
                                            echo 'Size : ' . getFileFormattedSize($filesize);
                                        endif;
                                        ?>
                                    </span>
                                            <a class="btn small float-right" href="javascript:void(0);"
                                               onclick="deleteSavedPackageimage('22');">
                                                <i class="glyph-icon icon-trash-o"></i>
                                            </a>
                                        </div>
                                        <img src="<?php echo IMAGE_PATH . 'package/banner/thumbnails/' . $imageRow; ?>"
                                             style="width:100%"/>
                                        <input type="hidden" name="imageArrayname2[]" value="<?php echo $imageRow; ?>"/>

                                    </div>
                                </div>
                            <?php endforeach;
                        endif;
                    endif; ?>
                </div>
                <div class="form-row add-image">
                    <div class="form-label col-md-2">
                        <label for="">
                            Itinerary Upload :
                        </label>
                    </div>
                    <div class="form-input col-md-10 uploader">
                        <input type="file" name="download_icon" id="download_icon" class="transparent no-shadow">
                        <label>
                            <small>Upload files. (*.pdf, *.docx and image files)</small>
                        </label>
                    </div>
                    <!-- Upload user image preview -->
                    <div id="preview_Imagef"><input type="hidden" name="imageArrayname3" class=""/></div>
                </div>
                <div class="form-row">
                    <?php if (!empty($packageInfo->itenaryfile)): ?>
                        <div class="col-md-6" id="removeSavedimg23">
                            <div class="infobox info-bg">
                                <div class="button-group" data-toggle="buttons">
                            <span class="float-left">
                                <?php
                                if (file_exists(SITE_ROOT . "images/package/docs/" . $packageInfo->itenaryfile)):
                                    $filesize = filesize(SITE_ROOT . "images/package/docs/" . $packageInfo->itenaryfile);
                                    echo 'Size : ' . getFileFormattedSize($filesize);
                                endif;
                                ?>
                            </span>
                                    <a class="btn small float-right" href="javascript:void(0);"
                                       onclick="deleteSavedPackageimage('23');">
                                        <i class="glyph-icon icon-trash-o"></i>
                                    </a>
                                </div>
                                <?php echo $packageInfo->itenaryfile; ?>
                                <input type="hidden" name="imageArrayname3"
                                       value="<?php echo $packageInfo->itenaryfile;; ?>"/>

                            </div>
                        </div>
                    <?php endif; ?>

                </div>

                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">Destination</label>
                    </div>
                    <div class="form-input col-md-20">
                        <select name="destinationId" class="col-md-4 validate[required] destinationId">
                            <option value=" ">Choose</option>
                            <?php $desId = !empty($packageInfo->destinationId) ? $packageInfo->destinationId : 0;
                            echo Destination::get_destination_option($desId); ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">Activities</label>
                    </div>
                    <div class="form-input col-md-20">
                        <?php $selid = !empty($packageInfo->activityId) ? $packageInfo->activityId : 0; ?>
                        <select name="activityId" class="col-md-4 validate[required] actaction"
                                selId="<?php echo $selid; ?>">
                            <?php $actid = !empty($packageInfo->destinationId) ? $packageInfo->destinationId : 0;
                            echo Activities::get_all_filterdata($actid, $selid); ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">Region</label>
                    </div>
                    <div class="form-input col-md-20">
                        <?php $selid2 = !empty($packageInfo->regionId) ? $packageInfo->regionId : 0; ?>
                        <select name="regionId" class="col-md-4 actregion" selId="<?php echo $selid2; ?>">
                            <?php $regid = !empty($packageInfo->activityId) ? $packageInfo->activityId : 0;
                            echo Activities::get_all_regiondata($regid, $selid2); ?>
                        </select>
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Experts :
                        </label>
                    </div>
                    <?php $svfr = !empty($packageInfo->expert_id) ? $packageInfo->expert_id : '';
                    $saveRec = unserialize($svfr);
                    //$RecFearures = Expert::get_allexpert();
                    ?>
                    <?php //if($RecFearures){
                    //foreach($RecFearures as $recRow){
                    ?>
                    <div class="form-checkbox-radio col-md-10 form-input">

                        <?php $childRec = Expert::get_allexpert();
                        if ($childRec) {
                            $i = 1;
                            foreach ($childRec as $childRow) {
                                $check = '';
                                if (!empty($saveRec) and !empty($saveRec[$childRow->id][1])) {
                                    $check = (in_array($childRow->id, $saveRec[$childRow->id][1])) ? 'checked="checked"' : '';
                                } ?>
                                <input type="checkbox" class="custom-radio"
                                       name="feature[<?php echo $childRow->id; ?>][]"
                                       value="<?php echo $childRow->id; ?>" <?php echo $check; ?>>
                                <label for=""><?php echo $childRow->name; ?></label>
                                <?php
                                echo ($i % 4 == 0) ? '<div class="clear"></div>' : '';
                                $i++;
                            }
                        } ?>
                    </div>
                </div>


                <!--  <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="offers">Offers:</label> 
                </div>
                <div class="form-input col-md-20">
                    <select name="offers" id="offers" class="col-md-4">
                        <option value="none">None</option>
                    <?php $Arrdiff = array('1' => 'Hot Deals', '2' => 'Early Bird', '3' => 'Special Offers');
                foreach ($Arrdiff as $k => $v) {
                    $sel1 = (!empty($packageInfo->offers) and ($packageInfo->offers == $v)) ? "selected" : "";
                    echo '<option value="' . $k . '" ' . $sel1 . '>' . $v . '</option>';
                } ?>
                    </select>
                </div>    
            </div> -->
                <!--  <div class="form-row offerprice">
                <div class="form-label col-md-2">
                    <label for="">
                        Offer Price:
                    </label>
                </div>                
                <div class="form-input col-md-20">
                    <input placeholder="Offer Price" class="col-md-4 validate[custom[number],length[0,5]]" type="text" name="offer_price" id="offer_price" value="<?php echo !empty($packageInfo->offer_price) ? $packageInfo->offer_price : ""; ?>">
                </div>                
            </div> -->

                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Length (Days) :
                        </label>
                    </div>
                    <div class="form-input col-md-20">
                        <input placeholder="Length (Days)" class="col-md-4 validate[length[0,200]]" type="text"
                               name="days" id="days"
                               value="<?php echo !empty($packageInfo->days) ? $packageInfo->days : ""; ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Group size :
                        </label>
                    </div>
                    <div class="form-input col-md-20">
                        <input placeholder="Group Size" class="col-md-4 validate[length[0,200]]" type="text"
                               name="group_size" id="group_size"
                               value="<?php echo !empty($packageInfo->group_size) ? $packageInfo->group_size : ""; ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Route :
                        </label>
                    </div>
                    <div class="form-input col-md-20">
                        <input placeholder="Route (Separate with commas)" class="col-md-4 validate[length[0,200]]" type="text"
                               name="accomodation" id="accomodation"
                               value="<?php echo !empty($packageInfo->accomodation) ? $packageInfo->accomodation : ""; ?>">
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Map Type :
                        </label>
                    </div>
                    <div class="form-checkbox-radio col-md-9">
                        <input type="radio" class="custom-radio" name="maptype" id="check1"
                               value="1" <?php echo !empty($imgmptype) ? $imgmptype : "checked"; ?>>
                        <label for="">Image</label>
                        <input type="radio" class="custom-radio" name="maptype" id="check0"
                               value="2" <?php echo !empty($gogmptype) ? $gogmptype : ""; ?>>
                        <label for="">Google Link</label>
                    </div>
                </div>
                <div class="form-row imagemap <?php echo !empty($imgmphide) ? $imgmphide : ''; ?>">
                    <div class="form-input col-md-12">
                        <?php if (!empty($packageInfo->mapimage)): ?>
                            <div class="col-md-3" id="removeSavedimg<?php echo 'C00' . $packageInfo->id; ?>">
                                <div class="infobox info-bg">
                                    <div class="button-group" data-toggle="buttons">
                                <span class="float-left">
                                    <?php
                                    if (file_exists(SITE_ROOT . "images/package/map/" . $packageInfo->mapimage)):
                                        $filesize = filesize(SITE_ROOT . "images/package/map/" . $packageInfo->mapimage);
                                        echo 'Size : ' . getFileFormattedSize($filesize);
                                    endif;
                                    ?>
                                </span>
                                        <a class="btn small float-right" href="javascript:void(0);"
                                           onclick="deleteSavedPackageimage('<?php echo 'C00' . $packageInfo->id; ?>');">
                                            <i class="glyph-icon icon-trash-o"></i>
                                        </a>
                                    </div>
                                    <img src="<?php echo IMAGE_PATH . 'package/map/thumbnails/' . $packageInfo->mapimage; ?>"
                                         style="width:100%"/>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="form-input col-md-10 uploader <?php echo !empty($packageInfo->mapimage) ? "hide" : ""; ?>">
                            <input type="file" name="mapimage" id="mapimage" class="transparent no-shadow">
                            <label>
                                <small>Image Dimensions (<?php echo Module::get_properties($moduleId, 'mapimgwidth'); ?>
                                    px X <?php echo Module::get_properties($moduleId, 'mapimgheight'); ?> px)
                                </small>
                            </label>
                        </div>
                        <!-- Upload user image preview -->
                        <div id="preview_map"><input type="hidden" name="mapArrayname"
                                                     value="<?php echo !empty($packageInfo->mapimage) ? $packageInfo->mapimage : ""; ?>"
                                                     class=""/></div>
                    </div>
                </div>
                <div class="form-row googlemap <?php echo !empty($gogmphide) ? $gogmphide : '';
                echo isset($_GET['id']) ? '' : 'hide'; ?>">
                    <div class="form-input col-md-12">
                        <textarea class="large-textarea" placeholder="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14128.014830613765!2d85.3089123!3d27.7171718!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xe33609df94b2f600!2sABC%20and%20EBC%20Nepal%20Trekking%20Adventure%20Pvt.%20Ltd.!5e0!3m2!1sen!2snp!4v1608430313997!5m2!1sen!2snp"
                                  name="mapgoogle"><?php echo !empty($packageInfo->mapgoogle) ? $packageInfo->mapgoogle : ""; ?></textarea>
                    </div>
                </div>

                <!--<div class="form-row">
                    <div class="form-label col-md-12">
                        <label for="">
                            Brief :
                        </label>
                        <textarea name="breif" id="breif"
                                  class="large-textarea validate[required]"><?php echo !empty($packageInfo->breif) ? $packageInfo->breif : ""; ?></textarea>
                    </div>
                </div>-->
                <div class="form-row">
                    <div class="form-label col-md-12">
                        <label for="">
                            Overview :
                        </label>
                        <textarea name="overview" id="overview"
                                  class="large-textarea validate[required]"><?php echo !empty($packageInfo->overview) ? $packageInfo->overview : ""; ?></textarea>
                        <a class="btn medium bg-orange mrg5T hide" title="Read More" id="readMore"
                           href="javascript:void(0);">
                            <span class="button-content">Read More</span>
                        </a>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label col-md-12">
                        <label for="">
                            Do's and Don'ts :
                        </label>
                        <textarea name="availability" id="availability"
                                  class="large-textarea validate[required]"><?php echo !empty($packageInfo->availability) ? $packageInfo->availability : ""; ?></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-12">
                        <label for="">
                            Includes :
                        </label>
                        <textarea name="incexc" id="incexc"
                                  class="large-textarea validate[required]"><?php echo !empty($packageInfo->incexc) ? $packageInfo->incexc : ""; ?></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-12">
                        <label for="">
                            Excludes :
                        </label>
                        <textarea name="booking_info" id="booking_info"
                                  class="large-textarea validate[required]"><?php echo !empty($packageInfo->booking_info) ? $packageInfo->booking_info : ""; ?></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-12">
                        <label for="">
                            Others Information :
                        </label>
                        <textarea name="other_info" id="other_info"
                                  class="large-textarea validate[required]"><?php echo !empty($packageInfo->other_info) ? $packageInfo->other_info : ""; ?></textarea>
                    </div>
                </div>
                <!-- <div class="form-row">
                <div class="form-label col-md-12">
                    <label for="">
                        Others Activity :
                    </label>
                    <textarea name="others" id="others" class="large-textarea validate[required]"><?php // echo !empty($packageInfo->others)?$packageInfo->others:"";
                ?></textarea>
                </div>            
            </div> -->
                <!-- <div class="form-row">
                <div class="form-label col-md-12">
                    <label for="">
                        Travel Guide :
                    </label>
                    <textarea name="guide" id="guide" class="large-textarea validate[required]"><?php // echo !empty($packageInfo->guide)?$packageInfo->guide:"";
                ?></textarea>
                </div>            
            </div> -->

                <h3>Facts</h3>
                <!--
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Higest Altitude (m) :
                        </label>
                    </div>
                    <div class="form-input col-md-20">
                        <input placeholder="Higest Altitude (m)" class="col-md-4" type="text" name="altitude"
                               id="altitude"
                               value="<?php echo !empty($packageInfo->altitude) ? $packageInfo->altitude : ""; ?>">
                    </div>
                </div>
                -->
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">Difficulty</label>
                    </div>
                    <div class="form-input col-md-20">
                        <select name="difficulty" class="col-md-4">
                            <option value="0">None</option>
                            <?php $Arrdiff = array('1' => 'Easy', '2' => 'Moderate', '3' => 'Moderate To Strenous', '4' => 'Strenous', '5' => 'Very Strenous');
                            foreach ($Arrdiff as $k => $v) {
                                $sel1 = (!empty($packageInfo->difficulty) and ($packageInfo->difficulty == $v)) ? "selected" : "";
                                echo '<option value="' . $k . '" ' . $sel1 . '>' . $v . '</option>';
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">Grade</label>
                    </div>
                    <div class="form-input col-md-20">
                        <select name="gread" class="col-md-4">
                            <option value="0">None</option>
                            <?php $Arrdiff2 = array('5' => 'Five', '4' => 'Four', '3' => 'Three', '2' => 'Two', '1' => 'One');
                            foreach ($Arrdiff2 as $k2 => $v2) {
                                $sel2 = (!empty($packageInfo->gread) and ($packageInfo->gread == $k2)) ? "selected" : "";
                                echo '<option value="' . $k2 . '" ' . $sel2 . '>' . $v2 . '</option>';
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">Season</label>
                    </div>
                    <div class="form-input col-md-20">
                        <input placeholder="Season" class="col-md-4" type="text" name="season" id="season"
                               value="<?php echo !empty($packageInfo->season) ? $packageInfo->season : ""; ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Starting Point :
                        </label>
                    </div>
                    <div class="form-input col-md-20">
                        <input placeholder="Starting Point" class="col-md-4" type="text" name="startpoint"
                               id="startpoint"
                               value="<?php echo !empty($packageInfo->startpoint) ? $packageInfo->startpoint : ""; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Ending Point :
                        </label>
                    </div>
                    <div class="form-input col-md-20">
                        <input placeholder="Ending Point" class="col-md-4" type="text" name="endpoint" id="endpoint"
                               value="<?php echo !empty($packageInfo->endpoint) ? $packageInfo->endpoint : ""; ?>">
                    </div>
                </div>

                <!--   <h3>Gallery</h3>
            <div class="form-row add-image">                                
                <?php if (!empty($packageInfo->gallery)):
                        $imgall = unserialize($packageInfo->gallery);
                    if (is_array($imgall)) {
                        foreach ($imgall as $imgk => $imgv) { ?>
                    <div class="col-md-3" id="removeSavedimg<?php echo 'G00' . $imgk; ?>">
                        <div class="infobox info-bg">                                                               
                            <div class="button-group" data-toggle="buttons">
                                <span class="float-left">
                                    <?php
                            if (file_exists(SITE_ROOT . "images/package/gallery/" . $imgv)):
                                $filesize = filesize(SITE_ROOT . "images/package/gallery/" . $imgv);
                                echo 'Size : ' . getFileFormattedSize($filesize);
                            endif;
                            ?>
                                </span> 
                                <a class="btn small float-right" href="javascript:void(0);" onclick="deleteSavedPackageimage('<?php echo 'G00' . $imgk; ?>');">
                                    <i class="glyph-icon icon-trash-o"></i>
                                </a>                                                       
                            </div>
                            <img src="<?php echo IMAGE_PATH . 'package/gallery/thumbnails/' . $imgv; ?>"  style="width:100%"/>
                            <input type="hidden" name="galleryArrayname[]" value="<?php echo $imgv; ?>" class="" />
                        </div> 
                    </div>
                    <?php }
                    }
                endif; ?>
                <div class="form-input col-md-10 uploader">          
                   <input type="file" name="gallery" id="gallery" class="transparent no-shadow">
                   <label><small>Image Dimensions (<?php echo Module::get_properties($moduleId, 'galleryimgwidth'); ?> px X <?php echo Module::get_properties($moduleId, 'galleryimgheight'); ?> px)</small></label>
                </div>                
                <!-- Upload user Gallery image preview -->
                <!-- <div id="preview_gallery"></div>
            </div> -->

                <!--<h3>Price</h3>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Global Price :
                        </label>
                    </div>
                    <div class="form-input col-md-20">
                        <div class="col-md-4" style="padding-left:0px !important;"> US ($)
                            <input placeholder="Price" class="col-md-4 validate[custom[number]]" type="text"
                                   name="price" id="price"
                                   value="<?php echo !empty($packageInfo->price) ? $packageInfo->price : ""; ?>"> /
                            person
                        </div>
                    </div>
                </div>


                <div class="form-row col-md-12">

                    <div class="form-input col-md-6">
                        <h5><b>From Group Size :</b></h5>  <br>
                        <input placeholder="group_size_price" class="col-md-6 validate[length[0,50]]" type="text"
                               name="group_size_price1" id="group_size_price1"
                               value="<?php echo !empty($packageInfo->group_size_price1) ? $packageInfo->group_size_price1 : ""; ?>">

                        <br> <br>
                        <input placeholder="group_size_price" class="col-md-6 validate[length[0,50]]" type="text"
                               name="group_size_price2" id="group_size_price_2"
                               value="<?php echo !empty($packageInfo->group_size_price2) ? $packageInfo->group_size_price2 : ""; ?>">
                        <br> <br>
                        <input placeholder="group_size_price" class="col-md-6 validate[length[0,50]]" type="text"
                               name="group_size_price3" id="group_size_price3"
                               value="<?php echo !empty($packageInfo->group_size_price3) ? $packageInfo->group_size_price3 : ""; ?>">
                        <br> <br>
                        <input placeholder="group_size_price" class="col-md-6 validate[length[0,50]]" type="text"
                               name="group_size_price4" id="group_size_price4"
                               value="<?php echo !empty($packageInfo->group_size_price4) ? $packageInfo->group_size_price4 : ""; ?>">
                        <br><br>
                        <input placeholder="group_size_price" class="col-md-6 validate[length[0,50]]" type="text"
                               name="group_size_price5" id="group_size_price5"
                               value="<?php echo !empty($packageInfo->group_size_price5) ? $packageInfo->group_size_price5 : ""; ?>">
                    </div>

                    <div class="form-input col-md-6">
                        <h5><b>Discount :</b></h5> <br>
                        <input placeholder="Discount (%)" class="col-md-6 validate[length[0,50]]" type="number"
                               name="discount1" id="discount1"
                               value="<?php echo !empty($packageInfo->discount1) ? $packageInfo->discount1 : ""; ?>">

                        <br> <br>
                        <input placeholder="Discount (%)" class="col-md-6 validate[length[0,50]]" type="number"
                               name="discount2" id="discount2"
                               value="<?php echo !empty($packageInfo->discount2) ? $packageInfo->discount2 : ""; ?>">
                         <br> <br>
                        <input placeholder="Discount (%)" class="col-md-6 validate[length[0,50]]" type="number"
                               name="discount3" id="discount3"
                               value="<?php echo !empty($packageInfo->discount3) ? $packageInfo->discount3 : ""; ?>">
                        <br> <br>
                        <input placeholder="Discount (%)" class="col-md-6 validate[length[0,50]]" type="number"
                               name="discount4" id="discount4"
                               value="<?php echo !empty($packageInfo->discount4) ? $packageInfo->discount4 : ""; ?>"><br>
                        <br>

                        <input placeholder="Discount (%)" class="col-md-6 validate[length[0,50]]" type="number"
                               name="discount5" id="discount5"
                               value="<?php echo !empty($packageInfo->discount5) ? $packageInfo->discount5 : ""; ?>">


                    </div>
                </div>-->


                <h3>Action</h3>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label>Tag For</label>
                    </div>
                    <div class="form-input col-md-12">
                        <input placeholder="Tag For" class="col-md-4 validate[length[0,20]]" type="text" name="tags"
                               id="tags" value="<?php echo !empty($packageInfo->tags) ? $packageInfo->tags : ""; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">Color :</label>
                    </div>
                    <div class="form-input col-md-20">
                        <select name="color" class="col-md-4">
                            <option value="0">None</option>
                            <?php $Arr2 = array('ribbon_3' => 'Green', 'ribbon_4' => 'Gray', 'ribbon_5' => 'Red');
                            foreach ($Arr2 as $c => $d) {
                                $sel2 = (!empty($packageInfo->color) and ($packageInfo->color == $c)) ? "selected" : "";
                                echo '<option value="' . $c . '" ' . $sel2 . '>' . $d . '</option>';
                            } ?>
                        </select>

                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Featured :
                        </label>
                    </div>
                    <div class="form-checkbox-radio col-md-9">
                        <input type="radio" class="custom-radio" name="featured" id="check1"
                               value="1" <?php echo !empty($feature) ? $feature : ""; ?>>
                        <label for="">Yes</label>
                        <input type="radio" class="custom-radio" name="featured" id="check0"
                               value="0" <?php echo !empty($unfeature) ? $unfeature : "checked"; ?>>
                        <label for="">No</label>
                    </div>
                </div>
                <!--  <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Last Minute :
                    </label>
                </div>             
                <div class="form-checkbox-radio col-md-9">
                    <input type="radio" class="custom-radio" name="lastminutes" id="check1" value="1" <?php echo !empty($lstmin) ? $lstmin : ""; ?>>
                    <label for="">Yes</label>
                    <input type="radio" class="custom-radio" name="lastminutes" id="check0" value="0" <?php echo !empty($unlstmin) ? $unlstmin : "checked"; ?>>
                    <label for="">No</label>
                </div>                
            </div> -->
                <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Show Homepage :
                        </label>
                    </div>
                    <div class="form-checkbox-radio col-md-9">
                        <input type="radio" class="custom-radio" name="homepage" id="check1"
                               value="1" <?php echo !empty($homepg) ? $homepg : ""; ?>>
                        <label for="">Yes</label>
                        <input type="radio" class="custom-radio" name="homepage" id="check0"
                               value="0" <?php echo !empty($unhomepg) ? $unhomepg : "checked"; ?>>
                        <label for="">No</label>
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
                <div class="form-row <?php echo (!empty($packageInfo->meta_keywords) || !empty($packageInfo->meta_description)) ? '' : 'hide'; ?> metadata">
                    <div class="col-md-6">
                        <textarea placeholder="Meta Keyword" name="meta_keywords" id="meta_keywords"
                                  class="character-keyword validate[required]"><?php echo !empty($packageInfo->meta_keywords) ? $packageInfo->meta_keywords : ""; ?></textarea>
                        <div class="keyword-remaining clear input-description">250 characters left</div>
                    </div>
                    <div class="col-md-6">
                        <textarea placeholder="Meta Description" name="meta_description" id="meta_description"
                                  class="character-description validate[required]"><?php echo !empty($packageInfo->meta_description) ? $packageInfo->meta_description : ""; ?></textarea>
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
                       value="<?php echo !empty($packageInfo) ? $packageInfo->id : 0; ?>"/>
            </form>
        </div>
    </div>
    <script>
        var base_url = "<?php echo ASSETS_PATH; ?>";
        var editor_arr = ["overview", "incexc", "booking_info", "availability", "other_info"];
        create_editor(base_url, editor_arr);
    </script>
    <script>
        /*$(document).ready(function () {
            var base_url = "<?php echo ASSETS_PATH; ?>";
            CKEDITOR.replace('breif', {
                toolbar:
                    [
                        {
                            name: 'document',
                            items: ['Source', '-', 'Save', 'NewPage', 'DocProps', 'Preview', 'Print', '-', 'Templates']
                        },
                        {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']}, '/',
                        {name: 'colors', items: ['TextColor', 'BGColor']},
                        {name: 'tools', items: ['Maximize', 'ShowBlocks', '-', 'About']}
                    ]
            });
        });*/
    </script>
    <script type="text/javascript" src="<?php echo ASSETS_PATH; ?>uploadify/jquery.uploadify.min.js"></script>
    <script type="text/javascript">
        // <![CDATA[
        $(document).ready(function () {
            $('#package_icon').uploadify({
                'swf': '<?php echo ASSETS_PATH;?>uploadify/uploadify.swf',
                'uploader': '<?php echo ASSETS_PATH;?>uploadify/uploadify.php',
                'formData': {
                    PROJECT: '<?php echo SITE_FOLDER;?>',
                    targetFolder: 'images/package/',
                    thumb_width: 200,
                    thumb_height: 200
                },
                'method': 'post',
                'cancelImg': '<?php echo BASE_URL;?>uploadify/cancel.png',
                'auto': true,
                'multi': false,
                'hideButton': false,
                'buttonText': 'Upload Image',
                'width': 100,
                'height': 25,
                'removeCompleted': true,
                'progressData': 'speed',
                'uploadLimit': 100,
                'fileTypeExts': '*.gif; *.jpg; *.jpeg;  *.png; *.GIF; *.JPG; *.JPEG; *.PNG;',
                'buttonClass': 'button formButtons',
                /* 'checkExisting' : '/uploadify/check-exists.php',*/
                'onUploadSuccess': function (file, data, response) {
                    $('#uploadedImageName').val('1');
                    var filename = data;
                    $.post('<?php echo BASE_URL;?>apanel/package/uploaded_image.php', {imagefile: filename}, function (msg) {
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
    <!-- Map Image section -->
    <script type="text/javascript">
        // <![CDATA[
        $(document).ready(function () {
            $('#mapimage').uploadify({
                'swf': '<?php echo ASSETS_PATH;?>uploadify/uploadify.swf',
                'uploader': '<?php echo ASSETS_PATH;?>uploadify/uploadify.php',
                'formData': {
                    PROJECT: '<?php echo SITE_FOLDER;?>',
                    targetFolder: 'images/package/map/',
                    thumb_width: 200,
                    thumb_height: 200
                },
                'method': 'post',
                'cancelImg': '<?php echo BASE_URL;?>uploadify/cancel.png',
                'auto': true,
                'multi': false,
                'hideButton': false,
                'buttonText': 'Upload Image',
                'width': 100,
                'height': 25,
                'removeCompleted': true,
                'progressData': 'speed',
                'uploadLimit': 100,
                'fileTypeExts': '*.gif; *.jpg; *.jpeg;  *.png; *.GIF; *.JPG; *.JPEG; *.PNG;',
                'buttonClass': 'button formButtons',
                /* 'checkExisting' : '/uploadify/check-exists.php',*/
                'onUploadSuccess': function (file, data, response) {
                    $('#uploadedImageName').val('1');
                    var filename = data;
                    $.post('<?php echo BASE_URL;?>apanel/package/uploaded_map.php', {imagefile: filename}, function (msg) {
                        $('#preview_map').html(msg).show();
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

    <!-- Gallery Image section -->
    <script type="text/javascript">
        // <![CDATA[
        $(document).ready(function () {
            $('#gallery').uploadify({
                'swf': '<?php echo ASSETS_PATH;?>uploadify/uploadify.swf',
                'uploader': '<?php echo ASSETS_PATH;?>uploadify/uploadify.php',
                'formData': {
                    PROJECT: '<?php echo SITE_FOLDER;?>',
                    targetFolder: 'images/package/gallery/',
                    thumb_width: 200,
                    thumb_height: 200
                },
                'method': 'post',
                'cancelImg': '<?php echo BASE_URL;?>uploadify/cancel.png',
                'auto': true,
                'multi': true,
                'hideButton': false,
                'buttonText': 'Upload Image',
                'width': 100,
                'height': 25,
                'removeCompleted': true,
                'progressData': 'speed',
                'uploadLimit': 100,
                'fileTypeExts': '*.gif; *.jpg; *.jpeg;  *.png; *.GIF; *.JPG; *.JPEG; *.PNG;',
                'buttonClass': 'button formButtons',
                /* 'checkExisting' : '/uploadify/check-exists.php',*/
                'onUploadSuccess': function (file, data, response) {
                    $('#uploadedImageName').val('1');
                    var filename = data;
                    $.post('<?php echo BASE_URL;?>apanel/package/uploaded_gallery.php', {imagefile: filename}, function (msg) {
                        $('#preview_gallery').append(msg).show();
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
                    targetFolder: 'images/package/banner/',
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
                    $.post('<?php echo BASE_URL;?>apanel/package/banner_image.php', {imagefile: filename}, function (msg) {
                        $('#preview_banner').append(msg).show();
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
    <script type="text/javascript">
        $(document).ready(function () {
            $('#download_icon').uploadify({
                'swf': '<?php echo ASSETS_PATH;?>uploadify/uploadify.swf',
                'uploader': '<?php echo ASSETS_PATH;?>uploadify/uploadifyfile.php',
                'formData': {
                    PROJECT: '<?php echo SITE_FOLDER;?>',
                    targetFolder: 'images/package/docs/',
                    thumb_width: 200,
                    thumb_height: 200
                },
                'method': 'post',
                'cancelImg': '<?php echo BASE_URL;?>uploadify/cancel.png',
                'auto': true,
                'multi': false,
                'hideButton': false,
                'buttonText': 'Upload',
                'width': 100,
                'height': 25,
                'removeCompleted': true,
                'progressData': 'speed',
                'uploadLimit': 100,
                'fileTypeExts': '*.gif; *.jpg; *.jpeg;  *.png; *.GIF; *.JPG; *.JPEG; *.PNG; *.pdf; *.docx',
                'buttonClass': 'button formButtons',
                /* 'checkExisting' : '/uploadify/check-exists.php',*/
                'onUploadSuccess': function (file, data, response) {
                    $('#uploadedImageName').val('1');
                    var filename = data;
                    $.post('<?php echo BASE_URL;?>apanel/package/uploaded_file.php', {imagefile: filename}, function (msg) {
                        $('#preview_Imagef').html(msg).show();
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
<?php endif;
include_once('packagedate.php');
include_once('itinerary.php');
include_once('review.php');
include("package_images.php"); ?>