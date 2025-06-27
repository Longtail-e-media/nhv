<link href="<?php echo ASSETS_PATH; ?>uploadify/uploadify.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH;?>colorpicker/spectrum.css">
<script type="text/javascript" src="<?php echo ASSETS_PATH;?>colorpicker/spectrum.js"></script>
<h3>Themes Management</h3>
<div class="my-msg"></div>
<div class="example-box">
    <div class="example-code">
        <div class="accordion">  
            <?php $rowId = 1;
            $recs = Themes::find_by_id($rowId);
            if($recs){ ?> 
            <h3><?php echo $recs->title;?></h3>
            <div class="col-md-12">
                <div class="col-md-4">
                    <?php $record = Themes::field_by_id('cssproperties',$rowId);
                    $rslt = unserialize($record); ?>
                    <form action="" id="cssproperties_frm<?php echo $rowId;?>" class="cssproperties_frm" method="post" frm-for="topnav">
                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Bg Type :
                                </label>
                            </div>          
                            <div class="form-input col-md-6">
                                <select name="bgtype" class="form-control">
                                    <option value="">None</option>
                                    <option value="bgnone" <?php echo ('bgnone'==$rslt['bodybgtype'])?'selected':'';?> >bgstrip</option>
                                    <?php for($i=1; $i<26; $i++){ 
                                        $sel = ('bg'.$i==$rslt['bodybgtype'])?'selected':'';
                                        echo '<option value="bg'.$i.'" '.$sel.'>bg'.$i.'</option>';
                                    } ?>
                                </select>
                            </div>       
                        </div>
                        <input type="hidden" name="myVal" value="<?php echo $rowId;?>" />
                        <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                            <span class="button-content">
                                Save
                            </span>
                        </button>  
                    </form>
                </div>                               
                <div class="clear"></div>
            </div>
            <?php } ?>
            <!-- End Top Header -->

            <?php $rowId = 2;
            $recs = Themes::find_by_id($rowId);
            if($recs){ ?> 
            <h3><?php echo $recs->title;?></h3>
            <div class="col-md-12 hide">
                <div class="col-md-4">
                    <?php $record = Themes::field_by_id('properties',$rowId);
                    $rslt = unserialize($record); ?>
                    <form action="" id="properties_frm" class="properties_frm" method="post" frm-for="mainmenu">
                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Menu Level :
                                </label>
                            </div>                
                            <div class="form-input col-md-6">
                                <select class="form-control" name="level">
                                <?php for($i=1; $i<=5; $i++){ 
                                    $sel = ($rslt['level']==$i)?'selected':'';  
                                    echo '<option value="'.$i.'" '.$sel.'>'.$i.'</option>';
                                } ?>
                                </select>
                            </div>                
                        </div>
                        <input type="hidden" name="myVal" value="<?php echo $rowId;?>" />
                        <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                            <span class="button-content">
                                Save
                            </span>
                        </button>  
                    </form>
                </div>
                <div class="col-md-4">
                    <?php $record = Themes::field_by_id('cssproperties',$rowId);
                    $rslt = unserialize($record); ?>
                    <form action="" id="cssproperties_frm<?php echo $rowId;?>" class="cssproperties_frm" method="post" frm-for="mainmenu">
                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Bg Color :
                                </label>
                            </div>                
                            <div class="form-input col-md-6">
                                <input class="col-md-4 clorval" type="text" value="<?php echo !empty($rslt['main-menu-bgcolor'])?$rslt['main-menu-bgcolor']:'#fff';?>" name="bgcolor">                                              
                            </div>                
                        </div>
                        <input type="hidden" name="myVal" value="<?php echo $rowId;?>" />
                        <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                            <span class="button-content">
                                Save
                            </span>
                        </button>  
                    </form>
                </div>                
                <div class="clear"></div>
            </div>
            <?php } ?>
            <!-- End Main Header -->

            <?php $rowId = 3;
            $recs = Themes::find_by_id($rowId);
            if($recs){ ?> 
            <h3><?php echo $recs->title;?></h3>
            <div class="col-md-12 hide">
                <div class="col-md-4">
                    <?php $record = Themes::field_by_id('properties',$rowId);
                    $rslt = unserialize($record); ?>
                    <form action="" id="properties_frm" class="properties_frm" method="post" frm-for="mainslider">
                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Image Width :
                                </label>
                            </div>                
                            <div class="form-input col-md-6">
                                <input class="" type="text" name="imgwidth" value="<?php echo !empty($rslt['imgwidth'])?$rslt['imgwidth']:'0';?>">                                                
                            </div>                
                        </div>
                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Image Height :
                                </label>
                            </div>                
                            <div class="form-input col-md-6">
                                <input class="" type="text" name="imgheight" value="<?php echo !empty($rslt['imgheight'])?$rslt['imgheight']:'0';?>">
                            </div>                
                        </div>
                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Transaction :
                                </label>
                            </div>                
                            <div class="form-input col-md-6">
                                <select name="imagetransaction">
                                    <optgroup label="Flat Fade Transitions">                                        
                                        <option value="fade" <?php echo !empty($rslt['imagetransaction']=="fade")?'selected':'';?>>Fade</option>
                                        <option value="boxfade" <?php echo !empty($rslt['imagetransaction']=="boxfade")?'selected':'';?>>Fade Boxes</option>
                                        <option value="slotfade-horizontal" <?php echo !empty($rslt['imagetransaction']=="slotfade-horizontal")?'selected':'';?>>Fade Slots Horizontal</option>
                                        <option value="slotfade-vertical" <?php echo !empty($rslt['imagetransaction']=="slotfade-vertical")?'selected':'';?>>Fade Slots Vertical</option>
                                        <option value="fadefromright" <?php echo !empty($rslt['imagetransaction']=="fadefromright")?'selected':'';?>>Fade and Slide from Right</option>
                                        <option value="fadefromleft" <?php echo !empty($rslt['imagetransaction']=="fadefromleft")?'selected':'';?>>Fade and Slide from Left</option>
                                        <option value="fadefromtop" <?php echo !empty($rslt['imagetransaction']=="fadefromtop")?'selected':'';?>>Fade and Slide from Top</option>
                                        <option value="fadefrombottom" <?php echo !empty($rslt['imagetransaction']=="fadefrombottom")?'selected':'';?>>Fade and Slide from Bottom</option>
                                        <option value="fadetoleftfadefromright" <?php echo !empty($rslt['imagetransaction']=="fadetoleftfadefromright")?'selected':'';?>>Fade To Left and Fade From Right</option>
                                        <option value="fadetorightfadetoleft" <?php echo !empty($rslt['imagetransaction']=="fadetorightfadetoleft")?'selected':'';?>>Fade To Right and Fade From Left</option>
                                        <option value="fadetobottomfadefromtop" <?php echo !empty($rslt['imagetransaction']=="fadetobottomfadefromtop")?'selected':'';?>>Fade To Top and Fade From Bottom</option>
                                        <option value="fadetotopfadefrombottom" <?php echo !empty($rslt['imagetransaction']=="fadetotopfadefrombottom")?'selected':'';?>>Fade To Bottom and Fade From Top</option>
                                    </optgroup>

                                    <optgroup label="Flat Zoom Transitions">   
                                        <option value="scaledownfromright" <?php echo !empty($rslt['imagetransaction']=="scaledownfromright")?'selected':'';?>>Zoom Out and Fade From Right</option>
                                        <option value="scaledownfromleft" <?php echo !empty($rslt['imagetransaction']=="scaledownfromleft")?'selected':'';?>>Zoom Out and Fade From Left</option>
                                        <option value="scaledownfromtop" <?php echo !empty($rslt['imagetransaction']=="scaledownfromtop")?'selected':'';?>>Zoom Out and Fade From Top</option>
                                        <option value="scaledownfrombottom" <?php echo !empty($rslt['imagetransaction']=="scaledownfrombottom")?'selected':'';?>>Zoom Out and Fade From Bottom</option>
                                        <option value="zoomout" <?php echo !empty($rslt['imagetransaction']=="zoomout")?'selected':'';?>>ZoomOut</option>
                                        <option value="zoomin" <?php echo !empty($rslt['imagetransaction']=="zoomin")?'selected':'';?>>ZoomIn</option>
                                        <option value="slotzoom-horizontal" <?php echo !empty($rslt['imagetransaction']=="slotzoom-horizontal")?'selected':'';?>>Zoom Slots Horizontal</option>
                                        <option value="slotzoom-vertical" <?php echo !empty($rslt['imagetransaction']=="slotzoom-vertical")?'selected':'';?>>Zoom Slots Vertical</option>  
                                    </optgroup>

                                    <optgroup label="Flat Parallax Transitions">  
                                        <option value="parallaxtoright" <?php echo !empty($rslt['imagetransaction']=="parallaxtoright")?'selected':'';?>>Parallax to Right</option>
                                        <option value="parallaxtoleft" <?php echo !empty($rslt['imagetransaction']=="parallaxtoleft")?'selected':'';?>>Parallax to Left</option>
                                        <option value="parallaxtotop" <?php echo !empty($rslt['imagetransaction']=="parallaxtotop")?'selected':'';?>>Parallax to Top</option>
                                        <option value="parallaxtobottom" <?php echo !empty($rslt['imagetransaction']=="parallaxtobottom")?'selected':'';?>>Parallax to Bottom</option>   
                                    </optgroup>

                                    <optgroup label="Flat Slide Transitions">     
                                        <option value="slideup" <?php echo !empty($rslt['imagetransaction']=="slideup")?'selected':'';?>>Slide To Top</option>
                                        <option value="slidedown" <?php echo !empty($rslt['imagetransaction']=="slidedown")?'selected':'';?>>Slide To Bottom</option>
                                        <option value="slideright" <?php echo !empty($rslt['imagetransaction']=="slideright")?'selected':'';?>>Slide To Right</option>
                                        <option value="slideleft" <?php echo !empty($rslt['imagetransaction']=="slideleft")?'selected':'';?>>Slide To Left</option>
                                        <option value="slidehorizontal" <?php echo !empty($rslt['imagetransaction']=="slidehorizontal")?'selected':'';?>>Slide Horizontal (depending on Next/Previous)</option>
                                        <option value="slidevertical" <?php echo !empty($rslt['imagetransaction']=="slidevertical")?'selected':'';?>>Slide Vertical (depending on Next/Previous)</option>
                                        <option value="boxslide" <?php echo !empty($rslt['imagetransaction']=="boxslide")?'selected':'';?>>Slide Boxes</option>
                                        <option value="slotslide-horizontal" <?php echo !empty($rslt['imagetransaction']=="slotslide-horizontal")?'selected':'';?>>Slide Slots Horizontal</option>
                                        <option value="slotslide-vertical" <?php echo !empty($rslt['imagetransaction']=="slotslide-vertical")?'selected':'';?>>Slide Slots Vertical</option>
                                        <option value="curtain-1" <?php echo !empty($rslt['imagetransaction']=="curtain-1")?'selected':'';?>>Curtain from Left</option>
                                        <option value="curtain-2" <?php echo !empty($rslt['imagetransaction']=="curtain-2")?'selected':'';?>>Curtain from Right</option>
                                        <option value="curtain-3" <?php echo !empty($rslt['imagetransaction']=="curtain-3")?'selected':'';?>>Curtain from Middle</option>
                                    </optgroup>

                                    <optgroup label="Premium Transitions">   
                                        <option value="3dcurtain-horizontal" <?php echo !empty($rslt['imagetransaction']=="3dcurtain-horizontal")?'selected':'';?>>3D Curtain Horizontal</option>
                                        <option value="3dcurtain-vertical" <?php echo !empty($rslt['imagetransaction']=="3dcurtain-vertical")?'selected':'';?>>3D Curtain Vertical</option>
                                        <option value="cubic" <?php echo !empty($rslt['imagetransaction']=="cubic")?'selected':'';?>>Cube Vertical</option>
                                        <option value="cubic-horizontal" <?php echo !empty($rslt['imagetransaction']=="cubic-horizontal")?'selected':'';?>>Cube Horizontal</option>
                                        <option value="incube" <?php echo !empty($rslt['imagetransaction']=="fade")?'incube':'';?>>In Cube Vertical</option>
                                        <option value="incube-horizontal" <?php echo !empty($rslt['imagetransaction']=="incube-horizontal")?'selected':'';?>>In Cube Horizontal</option>
                                        <option value="turnoff" <?php echo !empty($rslt['imagetransaction']=="turnoff")?'selected':'';?>>TurnOff Horizontal</option>
                                        <option value="turnoff-vertical" <?php echo !empty($rslt['imagetransaction']=="turnoff-vertical")?'selected':'';?>>TurnOff Vertical</option>
                                        <option value="papercut" <?php echo !empty($rslt['imagetransaction']=="papercut")?'selected':'';?>>Paper Cut</option>
                                        <option value="flyin" <?php echo !empty($rslt['imagetransaction']=="flyin")?'selected':'';?>>Fly In</option>
                                        <option value="random-static" <?php echo !empty($rslt['imagetransaction']=="random-static")?'selected':'';?>>Random Premium</option>
                                        <option value="random" <?php echo !empty($rslt['imagetransaction']=="random")?'selected':'';?>>Random Flat and Premium</option>  
                                    </optgroup>
                                </select>
                            </div>                
                        </div>
                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Speed :
                                </label>
                            </div>                
                            <div class="form-input col-md-6">
                                <input placeholder="1000=1sec" class="" type="text" name="imageslidespeed" value="<?php echo !empty($rslt['imageslidespeed'])?$rslt['imageslidespeed']:'0';?>">
                            </div>                
                        </div>
                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    slots :
                                </label>
                            </div>                
                            <div class="form-input col-md-6">
                                <select name="imageslots">
                                <?php for($i=1; $i<=20; $i++){ 
                                    $sel = ($rslt['imageslots']==$i)?'selected':'';  
                                    echo '<option value="'.$i.'" '.$sel.'>'.$i.'</option>';
                                } ?>
                                </select>
                            </div>                
                        </div>
                        <input type="hidden" name="myVal" value="<?php echo $rowId;?>" />
                        <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                            <span class="button-content">
                                Save
                            </span>
                        </button>  
                    </form>
                </div>
                <div class="col-md-4">
                    <?php $record = Themes::field_by_id('jsproperties',$rowId);
                    $rslt = unserialize($record); ?>
                    <form action="" id="jsproperties_frm" class="jsproperties_frm" method="post" frm-for="mainslider">                        
                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Navigation Type :
                                </label>
                            </div>                
                            <div class="form-input col-md-6">
                                <select name="slidenavtype">
                                    <option value="none" <?php echo !empty($rslt['slidenavtype']=="none")?'selected':'';?>>None</option>
                                    <option value="both" <?php echo !empty($rslt['slidenavtype']=="both")?'selected':'';?>>Both</option>
                                </select>
                            </div>                
                        </div>
                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Navigation Arrows :
                                </label>
                            </div>                
                            <div class="form-input col-md-6">
                                <select name="slidenavarrow">
                                   <option value=" " <?php echo !empty($rslt['slidenavarrow']==" ")?'selected':'';?>>Blank</option> 
                                   <option value="none" <?php echo !empty($rslt['slidenavarrow']=="none")?'selected':'';?>>None</option>
                                   <option value="solo" <?php echo !empty($rslt['slidenavarrow']=="solo")?'selected':'';?>>Solo</option>
                                   <option value="nextto" <?php echo !empty($rslt['slidenavarrow']=="nextto")?'selected':'';?>>Next to</option>
                                   <option value="nexttobullets" <?php echo !empty($rslt['slidenavarrow']=="nexttobullets")?'selected':'';?>>Next to Bullets</option>
                                </select>             
                            </div>                
                        </div>
                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Navigation Style :
                                </label>
                            </div>                
                            <div class="form-input col-md-6">
                                <select name="slidenavstyle">
                                   <option value=" " <?php echo !empty($rslt['slidenavstyle']==" ")?'selected':'';?>>Blank</option> 
                                   <option value="none" <?php echo !empty($rslt['slidenavstyle']=="none")?'selected':'';?>>None</option>
                                   <option value="round" <?php echo !empty($rslt['slidenavstyle']=="round")?'selected':'';?>>Round</option>
                                   <option value="square" <?php echo !empty($rslt['slidenavstyle']=="square")?'selected':'';?>>Square</option>
                                   <option value="preview1" <?php echo !empty($rslt['slidenavstyle']=="preview1")?'selected':'';?>>Preview</option>                                   
                                </select>                                     
                            </div>                
                        </div>
                        <input type="hidden" name="myVal" value="<?php echo $rowId;?>" />
                        <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                            <span class="button-content">
                                Save
                            </span>
                        </button>  
                    </form>
                </div>                
                <div class="clear"></div>
            </div>
            <?php } ?>
            <!-- End Main Header -->

            <?php $rowId = 4;
            $recs = Themes::find_by_id($rowId);
            if($recs){ ?> 
            <h3><?php echo $recs->title;?></h3>
            <div class="col-md-12 hide">
                <div class="col-md-8">
                    <?php $record = Themes::field_by_id('properties',$rowId);
                    $rslt = unserialize($record); ?>
                    <form action="" id="properties_frm" class="properties_frm" method="post" frm-for="interdiction">
                        <div class="form-row">
                            <div class="form-label col-md-2">
                                <label for="">
                                    Title :
                                </label>
                            </div>                
                            <div class="form-input col-md-10">
                                <input type="text" class="" name="intdutitle" value="<?php echo !empty($rslt['intdutitle'])?$rslt['intdutitle']:'';?>" />                                
                            </div>                
                        </div>
                        <div class="form-row">
                            <div class="form-label col-md-2">
                                <label for="">
                                    Brief :
                                </label>
                            </div>                
                            <div class="form-input col-md-10">
                                <textarea name="intdubrief" class=""><?php echo !empty($rslt['intdubrief'])?$rslt['intdubrief']:'';?></textarea>                                               
                            </div>                
                        </div> 

                        <div class="form-row">
                            <div class="form-label col-md-2">
                                <label for="">
                                    Ads 1 :
                                </label>
                            </div>                
                            <div class="form-input col-md-10">
                                <div class="col-md-4">
                                    <input type="text" placeholder="Ads icon" class="" name="ads1icon" value="<?php echo !empty($rslt['ads1icon'])?$rslt['ads1icon']:'';?>" />                                
                                </div>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Ads title" class="" name="ads1title" value="<?php echo !empty($rslt['ads1title'])?$rslt['ads1title']:'';?>" />                                
                                </div>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Ads link" class="" name="ads1link" value="<?php echo !empty($rslt['ads1link'])?$rslt['ads1link']:'';?>" />                                
                                </div>
                            </div>                
                        </div>

                        <div class="form-row">
                            <div class="form-label col-md-2">
                                <label for="">
                                    Ads 2 :
                                </label>
                            </div>                
                            <div class="form-input col-md-10">
                                <div class="col-md-4">
                                    <input type="text" placeholder="Ads icon" class="" name="ads2icon" value="<?php echo !empty($rslt['ads2icon'])?$rslt['ads2icon']:'';?>" />                                
                                </div>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Ads title" class="" name="ads2title" value="<?php echo !empty($rslt['ads2title'])?$rslt['ads2title']:'';?>" />                                
                                </div>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Ads link" class="" name="ads2link" value="<?php echo !empty($rslt['ads2link'])?$rslt['ads2link']:'';?>" />                                
                                </div>
                            </div>                
                        </div>

                        <div class="form-row">
                            <div class="form-label col-md-2">
                                <label for="">
                                    Ads 3 :
                                </label>
                            </div>                
                            <div class="form-input col-md-10">
                                <div class="col-md-4">
                                    <input type="text" placeholder="Ads icon" class="" name="ads3icon" value="<?php echo !empty($rslt['ads3icon'])?$rslt['ads3icon']:'';?>" />                                
                                </div>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Ads title" class="" name="ads3title" value="<?php echo !empty($rslt['ads3title'])?$rslt['ads3title']:'';?>" />                                
                                </div>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Ads link" class="" name="ads3link" value="<?php echo !empty($rslt['ads3link'])?$rslt['ads3link']:'';?>" />                                
                                </div>
                            </div>                
                        </div>

                        <div class="form-row">
                            <div class="form-label col-md-2">
                                <label for="">
                                    Ads 4 :
                                </label>
                            </div>                
                            <div class="form-input col-md-10">
                                <div class="col-md-4">
                                    <input type="text" placeholder="Ads icon" class="" name="ads4icon" value="<?php echo !empty($rslt['ads4icon'])?$rslt['ads4icon']:'';?>" />                                
                                </div>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Ads title" class="" name="ads4title" value="<?php echo !empty($rslt['ads4title'])?$rslt['ads4title']:'';?>" />                                
                                </div>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Ads link" class="" name="ads4link" value="<?php echo !empty($rslt['ads4link'])?$rslt['ads4link']:'';?>" />                                
                                </div>
                            </div>                
                        </div>

                        <div class="form-row">
                            <div class="form-label col-md-2">
                                <label for="">
                                    Ads 5 :
                                </label>
                            </div>                
                            <div class="form-input col-md-10">
                                <div class="col-md-4">
                                    <input type="text" placeholder="Ads icon" class="" name="ads5icon" value="<?php echo !empty($rslt['ads5icon'])?$rslt['ads5icon']:'';?>" />                                
                                </div>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Ads title" class="" name="ads5title" value="<?php echo !empty($rslt['ads5title'])?$rslt['ads5title']:'';?>" />                                
                                </div>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Ads link" class="" name="ads5link" value="<?php echo !empty($rslt['ads5link'])?$rslt['ads5link']:'';?>" />                                
                                </div>
                            </div>                
                        </div>

                        <div class="form-row">
                            <div class="form-label col-md-2">
                                <label for="">
                                    Ads 6 :
                                </label>
                            </div>                
                            <div class="form-input col-md-10">
                                <div class="col-md-4">
                                    <input type="text" placeholder="Ads icon" class="" name="ads6icon" value="<?php echo !empty($rslt['ads6icon'])?$rslt['ads6icon']:'';?>" />                                
                                </div>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Ads title" class="" name="ads6title" value="<?php echo !empty($rslt['ads6title'])?$rslt['ads6title']:'';?>" />                                
                                </div>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Ads link" class="" name="ads6link" value="<?php echo !empty($rslt['ads6link'])?$rslt['ads6link']:'';?>" />                                
                                </div>
                            </div>                
                        </div>

                        <div class="form-row">
                            <div class="form-label col-md-2">
                                <label for="">
                                    Ads 7 :
                                </label>
                            </div>                
                            <div class="form-input col-md-10">
                                <div class="col-md-4">
                                    <input type="text" placeholder="Ads icon" class="" name="ads7icon" value="<?php echo !empty($rslt['ads7icon'])?$rslt['ads7icon']:'';?>" />                                
                                </div>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Ads title" class="" name="ads7title" value="<?php echo !empty($rslt['ads7title'])?$rslt['ads7title']:'';?>" />                                
                                </div>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Ads link" class="" name="ads7link" value="<?php echo !empty($rslt['ads7link'])?$rslt['ads7link']:'';?>" />                                
                                </div>
                            </div>                
                        </div>

                        <div class="form-row">
                            <div class="form-label col-md-2">
                                <label for="">
                                    Ads 8 :
                                </label>
                            </div>                
                            <div class="form-input col-md-10">
                                <div class="col-md-4">
                                    <input type="text" placeholder="Ads icon" class="" name="ads8icon" value="<?php echo !empty($rslt['ads8icon'])?$rslt['ads8icon']:'';?>" />                                
                                </div>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Ads title" class="" name="ads8title" value="<?php echo !empty($rslt['ads8title'])?$rslt['ads8title']:'';?>" />                                
                                </div>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Ads link" class="" name="ads8link" value="<?php echo !empty($rslt['ads8link'])?$rslt['ads8link']:'';?>" />                                
                                </div>
                            </div>                
                        </div>

                        <input type="hidden" name="myVal" value="<?php echo $rowId;?>" />
                        <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                            <span class="button-content">
                                Save
                            </span>
                        </button>  
                    </form>
                </div>    
                <div class="col-md-4">
                    <?php $record = Themes::field_by_id('cssproperties',$rowId);
                    $rslt = unserialize($record); ?>
                    <form action="" id="cssproperties_frm<?php echo $rowId;?>" class="cssproperties_frm" method="post" frm-for="interdiction">
                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Display :
                                </label>
                            </div>                
                            <div class="form-input col-md-6">                            
                                <input class="custom col-md-1" type="checkbox" name="interdictiondisplay" value="<?php echo !empty($rslt['interdictiondisplay'])?$rslt['interdictiondisplay']:'block';?>" <?php echo !empty($rslt['interdictiondisplay']=='block')?'checked':'';?>>
                            </div>                
                        </div>
                        <input type="hidden" name="myVal" value="<?php echo $rowId;?>" />
                        <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                            <span class="button-content">
                                Save
                            </span>
                        </button>  
                    </form>
                </div>                
                <div class="clear"></div>
            </div>
            <?php } ?>
            <!-- End Interduction Block -->

            <?php $rowId = 5;
            $recs = Themes::find_by_id($rowId);
            if($recs){ ?> 
            <h3><?php echo $recs->title;?></h3>
            <div class="col-md-12 hide">
                <div class="col-md-8">
                    <?php $record = Themes::field_by_id('properties',$rowId);
                    $rslt = unserialize($record); ?>
                    <form action="" id="properties_frm" class="properties_frm" method="post" frm-for="mainpackage">
                        <div class="form-row">
                            <div class="form-label col-md-2">
                                <label for="">
                                    Title :
                                </label>
                            </div>                
                            <div class="form-input col-md-10">
                                <textarea name="mpkgtitle" class=""><?php echo !empty($rslt['mpkgtitle'])?$rslt['mpkgtitle']:'';?></textarea>                                              
                            </div>                
                        </div>                        
                        <input type="hidden" name="myVal" value="<?php echo $rowId;?>" />
                        <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                            <span class="button-content">
                                Save
                            </span>
                        </button>  
                    </form>
                </div>                
                <div class="col-md-4">
                    <?php $record = Themes::field_by_id('cssproperties',$rowId);
                    $rslt = unserialize($record); ?>
                    <form action="" id="cssproperties_frm" class="cssproperties_frm" method="post" frm-for="mainpackage">
                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Bg Type :
                                </label>
                            </div>          
                            <div class="form-checkbox-radio col-md-6">
                                <input class="custom " type="radio" name="mpkgbgtype" value="0" <?php echo !empty(@$rslt['mpkgbgtype']=='0')?'checked':'';?>>
                                <label for="">Color</label>
                                <input class="custom " type="radio" name="mpkgbgtype" value="1" <?php echo !empty(@$rslt['mpkgbgtype']=='1')?'checked':'';?>> 
                                <label for="">Image</label>
                            </div>       
                        </div>
                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Bg Color :
                                </label>
                            </div>                
                            <div class="form-input col-md-6">
                                <input class="col-md-4 clorval" type="text" value="<?php echo !empty($rslt['mpkgbgcolor'])?$rslt['mpkgbgcolor']:'#fff';?>" name="mpkgbgcolor">                                               
                            </div>                
                        </div>

                        <div class="form-row add-image">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Image :
                                </label>
                            </div> 
                            
                            <?php if(!empty($rslt['mpkagbgimage'])):?>
                            <div class="col-md-6" id="removeSavedimg<?php echo $rowId;?>">
                                <div class="infobox info-bg">                                                               
                                    <div class="button-group" data-toggle="buttons">                                        
                                        <a class="btn small float-right" href="javascript:void(0);" onclick="deletesvimage(<?php echo $rowId;?>);">
                                            <i class="glyph-icon icon-trash-o"></i>
                                        </a>                                                       
                                    </div>
                                    <img src="<?php echo $rslt['mpkagbgimage'];?>"  style="width:100%"/>                                                                                   
                                </div> 
                            </div>
                            <?php endif;?>
                            <div class="form-input col-md-6 uploader <?php echo !empty($rslt['mpkagbgimage'])?"hide":"";?>">          
                               <input type="file" id="bgimage<?php echo $rowId;?>" class="transparent no-shadow bgimage">                               
                            </div>                
                            <!-- Upload user image preview -->
                            <div id="preview_Image<?php echo $rowId;?>"><input type="hidden" name="bgimage" value="<?php echo @$rslt['mpkagbgimage'];?>" class="" /></div>
                        </div>

                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Font Color :
                                </label>
                            </div>                
                            <div class="form-input col-md-6">                                
                                <input class="col-md-4 clorval" type="text" name="mpkgfontcolor" value="<?php echo !empty($rslt['mpkgfontcolor'])?$rslt['mpkgfontcolor']:'';?>">                                
                            </div>                
                        </div>

                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Display :
                                </label>
                            </div>                
                            <div class="form-input col-md-6">                            
                                <input class="custom col-md-1" type="checkbox" name="mpkgdisplay" value="<?php echo !empty($rslt['mpkgdisplay'])?$rslt['mpkgdisplay']:'block';?>" <?php echo !empty($rslt['mpkgdisplay']=='block')?'checked':'';?>>
                            </div>                
                        </div>

                        <input type="hidden" name="myVal" value="<?php echo $rowId;?>" />
                        <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                            <span class="button-content">
                                Save
                            </span>
                        </button>  
                    </form>
                </div>
                <div class="clear"></div>
            </div>
            <?php } ?>
            <!-- End Main Package -->

            <?php $rowId = 6;
            $recs = Themes::find_by_id($rowId);
            if($recs){ ?> 
            <h3><?php echo $recs->title;?></h3>
            <div class="col-md-12">
                <div class="col-md-4">
                    <?php $record = Themes::field_by_id('cssproperties',$rowId);
                    $rslt = unserialize($record); ?>
                    <form action="" id="cssproperties_frm<?php echo $rowId;?>" class="cssproperties_frm" method="post" frm-for="infoblock">
                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Bg Color :
                                </label>
                            </div>                
                            <div class="form-input col-md-6">
                                <input class="col-md-4 clorval" type="text" value="<?php echo !empty($rslt['infoblockbgcolor'])?$rslt['infoblockbgcolor']:'#fff';?>" name="infoblockbgcolor">                                               
                            </div>                
                        </div>

                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Display :
                                </label>
                            </div>                
                            <div class="form-input col-md-6">                            
                                <input class="custom col-md-1" type="checkbox" name="infoblockdisplay" value="<?php echo !empty($rslt['infoblockdisplay'])?$rslt['infoblockdisplay']:'block';?>" <?php echo !empty($rslt['infoblockdisplay']=='block')?'checked':'';?>>
                            </div>                
                        </div>
                        <input type="hidden" name="myVal" value="<?php echo $rowId;?>" />
                        <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                            <span class="button-content">
                                Save
                            </span>
                        </button>  
                    </form>
                </div>                               
                <div class="clear"></div>
            </div>
            <?php } ?>
            <!-- End Information Block -->

            <?php $rowId = 7;
            $recs = Themes::find_by_id($rowId);
            if($recs){ ?> 
            <h3><?php echo $recs->title;?></h3>
            <div class="col-md-12 hide">
                <div class="col-md-8">
                    <?php $record = Themes::field_by_id('properties',$rowId);
                    $rslt = unserialize($record); ?>
                    <form action="" id="properties_frm" class="properties_frm" method="post" frm-for="offers">
                        <div class="form-row">
                            <div class="form-label col-md-2">
                                <label for="">
                                    Title :
                                </label>
                            </div>                
                            <div class="form-input col-md-10">
                                <textarea name="offerstitle" class=""><?php echo !empty($rslt['offerstitle'])?$rslt['offerstitle']:'';?></textarea>                                               
                            </div>                
                        </div>                        
                        <input type="hidden" name="myVal" value="<?php echo $rowId;?>" />
                        <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                            <span class="button-content">
                                Save
                            </span>
                        </button>  
                    </form>
                </div>                
                <div class="col-md-4">
                    <?php $record = Themes::field_by_id('cssproperties',$rowId);
                    $rslt = unserialize($record); ?>
                    <form action="" id="cssproperties_frm" class="cssproperties_frm" method="post" frm-for="offers">
                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Bg Type :
                                </label>
                            </div>          
                            <div class="form-checkbox-radio col-md-6">
                                <input class="custom " type="radio" name="offersbgtype" value="0" <?php echo !empty(@$rslt['offersbgtype']=='0')?'checked':'';?>>
                                <label for="">Color</label>
                                <input class="custom " type="radio" name="offersbgtype" value="1" <?php echo !empty(@$rslt['offersbgtype']=='1')?'checked':'';?>> 
                                <label for="">Image</label>
                            </div>
                        </div>    
                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Bg Color :
                                </label>
                            </div>                
                            <div class="form-input col-md-6">
                                <input class="col-md-4 clorval" type="text" value="<?php echo !empty($rslt['offersbgcolor'])?$rslt['offersbgcolor']:'#fff';?>" name="offersbgcolor">                                               
                            </div>                
                        </div>
                        <div class="form-row add-image">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Image :
                                </label>
                            </div> 
                            
                            <?php if(!empty($rslt['offersbgimage'])):?>
                            <div class="col-md-6" id="removeSavedimg<?php echo $rowId;?>">
                                <div class="infobox info-bg">                                                               
                                    <div class="button-group" data-toggle="buttons">                                        
                                        <a class="btn small float-right" href="javascript:void(0);" onclick="deletesvimage(<?php echo $rowId;?>);">
                                            <i class="glyph-icon icon-trash-o"></i>
                                        </a>                                                       
                                    </div>
                                    <img src="<?php echo $rslt['offersbgimage'];?>"  style="width:100%"/>                                                                                   
                                </div> 
                            </div>
                            <?php endif;?>
                            <div class="form-input col-md-6 uploader <?php echo !empty($rslt['offersbgimage'])?"hide":"";?>">          
                               <input type="file" id="bgimage<?php echo $rowId;?>" class="transparent no-shadow bgimage">                               
                            </div>                
                            <!-- Upload user image preview -->
                            <div id="preview_Image<?php echo $rowId;?>"><input type="hidden" name="bgimage" value="<?php echo @$rslt['offersbgimage'];?>" class="" /></div>
                        </div>

                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Font Color :
                                </label>
                            </div>                
                            <div class="form-input col-md-6">                                
                                <input class="col-md-4 clorval" type="text" name="offersfontcolor" value="<?php echo !empty($rslt['offersfontcolor'])?$rslt['offersfontcolor']:'';?>">                                
                            </div>                
                        </div>

                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Display :
                                </label>
                            </div>                
                            <div class="form-input col-md-6">                            
                                <input class="custom col-md-1" type="checkbox" name="offersdisplay" value="<?php echo !empty($rslt['offersdisplay'])?$rslt['offersdisplay']:'block';?>" <?php echo !empty($rslt['offersdisplay']=='block')?'checked':'';?>>
                            </div>                
                        </div>
                        
                        <input type="hidden" name="myVal" value="<?php echo $rowId;?>" />
                        <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                            <span class="button-content">
                                Save
                            </span>
                        </button>  
                    </form>
                </div>
                <div class="clear"></div>
            </div>
            <?php } ?>
            <!-- End Offers Block -->

            <?php $rowId = 8;
            $recs = Themes::find_by_id($rowId);
            if($recs){ ?> 
            <h3><?php echo $recs->title;?></h3>
            <div class="col-md-12">
                <div class="col-md-8">
                    <?php $record = Themes::field_by_id('properties',$rowId);
                    $rslt = unserialize($record); ?>
                    <form action="" id="properties_frm" class="properties_frm" method="post" frm-for="testimonial">
                        <div class="form-row">
                            <div class="form-label col-md-2">
                                <label for="">
                                    Title :
                                </label>
                            </div>                
                            <div class="form-input col-md-10">
                                <input type="text" class="" name="testimonialtitle" value="<?php echo !empty($rslt['testimonialtitle'])?$rslt['testimonialtitle']:'';?>" />                                
                            </div>                
                        </div>
                        <div class="form-row">
                            <div class="form-label col-md-2">
                                <label for="">
                                    Brief :
                                </label>
                            </div>                
                            <div class="form-input col-md-10">
                                <textarea name="testimonialbrief" class=""><?php echo !empty($rslt['testimonialbrief'])?$rslt['testimonialbrief']:'';?></textarea>                                               
                            </div>                
                        </div>                        
                        <input type="hidden" name="myVal" value="<?php echo $rowId;?>" />
                        <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                            <span class="button-content">
                                Save
                            </span>
                        </button>  
                    </form>
                </div>                
                <div class="col-md-4">
                    <?php $record = Themes::field_by_id('cssproperties',$rowId);
                    $rslt = unserialize($record); ?>
                    <form action="" id="cssproperties_frm" class="cssproperties_frm" method="post" frm-for="testimonial">
                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Bg Type :
                                </label>
                            </div>          
                            <div class="form-checkbox-radio col-md-6">
                                <input class="custom " type="radio" name="testimonialbgtype" value="0" <?php echo !empty(@$rslt['testimonialbgtype']=='0')?'checked':'';?>>
                                <label for="">Color</label>
                                <input class="custom " type="radio" name="testimonialbgtype" value="1" <?php echo !empty(@$rslt['testimonialbgtype']=='1')?'checked':'';?>> 
                                <label for="">Image</label>
                            </div>
                        </div>    
                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Bg Color :
                                </label>
                            </div>                
                            <div class="form-input col-md-6">
                                <input class="col-md-4 clorval" type="text" value="<?php echo !empty($rslt['testimonialbgcolor'])?$rslt['testimonialbgcolor']:'#fff';?>" name="bgcolor">                                               
                            </div>                
                        </div>
                        <div class="form-row add-image">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Image :
                                </label>
                            </div> 
                            
                            <?php if(!empty($rslt['testimonialbgimage'])):?>
                            <div class="col-md-6" id="removeSavedimg<?php echo $rowId;?>">
                                <div class="infobox info-bg">                                                               
                                    <div class="button-group" data-toggle="buttons">                                        
                                        <a class="btn small float-right" href="javascript:void(0);" onclick="deletesvimage(<?php echo $rowId;?>);">
                                            <i class="glyph-icon icon-trash-o"></i>
                                        </a>                                                       
                                    </div>
                                    <img src="<?php echo $rslt['testimonialbgimage'];?>"  style="width:100%"/>                                                                                   
                                </div> 
                            </div>
                            <?php endif;?>
                            <div class="form-input col-md-6 uploader <?php echo !empty($rslt['testimonialbgimage'])?"hide":"";?>">          
                               <input type="file" id="bgimage<?php echo $rowId;?>" class="transparent no-shadow bgimage">                               
                            </div>                
                            <!-- Upload user image preview -->
                            <div id="preview_Image<?php echo $rowId;?>"><input type="hidden" name="bgimage" value="<?php echo @$rslt['testimonialbgimage'];?>" class="" /></div>
                        </div>
                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Display :
                                </label>
                            </div>                
                            <div class="form-input col-md-6">                            
                                <input class="custom col-md-1" type="checkbox" name="testimonialdisplay" value="<?php echo !empty($rslt['testimonialdisplay'])?$rslt['testimonialdisplay']:'block';?>" <?php echo !empty($rslt['testimonialdisplay']=='block')?'checked':'';?>>
                            </div>                
                        </div>
                        
                        <input type="hidden" name="myVal" value="<?php echo $rowId;?>" />
                        <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                            <span class="button-content">
                                Save
                            </span>
                        </button>  
                    </form>
                </div>
                <div class="clear"></div>
            </div>
            <?php } ?>
            <!-- End Testimonial Block -->

            <?php $rowId = 10;
            $recs = Themes::find_by_id($rowId);
            if($recs){ ?> 
            <h3><?php echo $recs->title;?></h3>
            <div class="col-md-12">
                <div class="col-md-8">
                    <?php $record = Themes::field_by_id('jsproperties',$rowId);
                    $rslt = unserialize($record); ?>
                    <form action="" id="properties_frm" class="properties_frm" method="post" frm-for="twitter">
                        <div class="form-row">
                            <div class="form-label col-md-4">
                                <label for="">
                                    Twitter Id :
                                </label>
                            </div>                
                            <div class="form-input col-md-8">
                                <input type="text" class="" name="twitterid" value="<?php echo !empty($rslt['twitterid'])?$rslt['twitterid']:'';?>" />                                
                            </div>                
                        </div>

                        <input type="hidden" name="myVal" value="<?php echo $rowId;?>" />
                        <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                            <span class="button-content">
                                Save
                            </span>
                        </button>  
                    </form>
                </div>    
                <div class="col-md-4">
                    <?php $record = Themes::field_by_id('cssproperties',$rowId);
                    $rslt = unserialize($record); ?>
                    <form action="" id="cssproperties_frm<?php echo $rowId;?>" class="cssproperties_frm" method="post" frm-for="twitter">
                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Bg Color :
                                </label>
                            </div>                
                            <div class="form-input col-md-6">
                                <input class="col-md-4 clorval" type="text" value="<?php echo !empty($rslt['twitterbgcolor'])?$rslt['twitterbgcolor']:'#fff';?>" name="twitterbgcolor">                                               
                            </div>                
                        </div>

                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Display :
                                </label>
                            </div>                
                            <div class="form-input col-md-6">                            
                                <input class="custom col-md-1" type="checkbox" name="twitterdisplay" value="<?php echo !empty($rslt['twitterdisplay'])?$rslt['twitterdisplay']:'block';?>" <?php echo !empty($rslt['twitterdisplay']=='block')?'checked':'';?>>
                            </div>                
                        </div>
                        <input type="hidden" name="myVal" value="<?php echo $rowId;?>" />
                        <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                            <span class="button-content">
                                Save
                            </span>
                        </button>  
                    </form>
                </div>                               
                <div class="clear"></div>
            </div>
            <?php } ?>
            <!-- End Twitter Block -->

            <?php $rowId = 9;
            $recs = Themes::find_by_id($rowId);
            if($recs){ ?> 
            <h3><?php echo $recs->title;?></h3>
            <div class="col-md-12">
                <div class="col-md-8">
                    <?php $record = Themes::field_by_id('properties',$rowId);
                    $rslt = unserialize($record); ?>
                    <form action="" id="properties_frm" class="properties_frm" method="post" frm-for="footer">
                        <div class="form-row">
                            <div class="form-label col-md-2">
                                <label for="">
                                    Brief :
                                </label>
                            </div>                
                            <div class="form-input col-md-10">
                                <textarea name="footerbrief" class=""><?php echo !empty($rslt['footerbrief'])?$rslt['footerbrief']:'';?></textarea>                                               
                            </div>                
                        </div>                        
                        <input type="hidden" name="myVal" value="<?php echo $rowId;?>" />
                        <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                            <span class="button-content">
                                Save
                            </span>
                        </button>  
                    </form>
                </div> 
                <div class="col-md-4">
                    <?php $record = Themes::field_by_id('cssproperties',$rowId);
                    $rslt = unserialize($record); ?>
                    <form action="" id="cssproperties_frm<?php echo $rowId;?>" class="cssproperties_frm" method="post" frm-for="footer">
                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Bg Color (top) :
                                </label>
                            </div>                
                            <div class="form-input col-md-6">
                                <input class="col-md-4 clorval" type="text" value="<?php echo !empty($rslt['topfooterbgcolor'])?$rslt['topfooterbgcolor']:'#fff';?>" name="topfooterbgcolor">                                               
                            </div>                
                        </div>

                        <div class="form-row">
                            <div class="form-label col-md-6">
                                <label for="">
                                    Bg Color (down) :
                                </label>
                            </div>                
                            <div class="form-input col-md-6">
                                <input class="col-md-4 clorval" type="text" value="<?php echo !empty($rslt['downfooterbgcolor'])?$rslt['downfooterbgcolor']:'#fff';?>" name="downfooterbgcolor">                                               
                            </div>                
                        </div>

                        <input type="hidden" name="myVal" value="<?php echo $rowId;?>" />
                        <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                            <span class="button-content">
                                Save
                            </span>
                        </button>  
                    </form>
                </div>                               
                <div class="clear"></div>
            </div>
            <?php } ?>
            <!-- End Top Footer -->
        </div>             
    </div>
</div>  
<script type="text/javascript" src="<?php echo ASSETS_PATH;?>uploadify/jquery.uploadify.min.js"></script>
<script type="text/javascript">
   // <![CDATA[
    $(document).ready(function() {
        <?php $imgArray = array('mainbody'=>1, 'mainpkg'=>5, 'offers'=>7, 'testimonial'=>8);
        foreach($imgArray as $key=>$val){ ?> 
        $('#bgimage<?php echo $val;?>').uploadify({
            'swf'  : '<?php echo ASSETS_PATH;?>uploadify/uploadify.swf',
            'uploader'   : '<?php echo ASSETS_PATH;?>uploadify/uploadify.php',
            'formData'   : {PROJECT : '<?php echo SITE_FOLDER;?>',targetFolder:'images/themes/',thumb_width:200,thumb_height:200},
            'method'     : 'post',
            'cancelImg'  : '<?php echo BASE_URL;?>uploadify/cancel.png',
            'auto'       : true,
            'multi'      : false,    
            'hideButton' : false,   
            'buttonText' : 'Bg Image',
            'width'      : 125,
            'height'     : 21,
            'removeCompleted' : true,
            'progressData' : 'speed',
            'uploadLimit' : 100,
            'fileTypeExts' : '*.gif; *.jpg; *.jpeg;  *.png; *.GIF; *.JPG; *.JPEG; *.PNG;',
             'buttonClass' : 'button formButtons',
           /* 'checkExisting' : '/uploadify/check-exists.php',*/
            'onUploadSuccess' : function(file, data, response) {            
                var filename =  data;
                $.post('<?php echo BASE_URL;?>apanel/themes/uploaded_image.php',{imagefile:filename},function(msg){           
                       $('#preview_Image<?php echo $val;?>').html(msg).show();
                    }); 
                    
            },
            'onDialogOpen'      : function(event,ID,fileObj) {      
            },
            'onUploadError' : function(file, errorCode, errorMsg, errorString) {
                   alert(errorMsg);
            },
            'onUploadComplete' : function(file) {
                  //alert('The file ' + file.name + ' was successfully uploaded');
            }   
        });
        <?php } ?>
    });
    // ]]>
</script>