<link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH;?>colorpicker/spectrum.css">
<script type="text/javascript" src="<?php echo ASSETS_PATH;?>colorpicker/spectrum.js"></script>
<h3>Themes Management</h3>
<div class="my-msg"></div>
<div class="example-box">
    <div class="example-code">
        <div class="example-code">
            <div class="accordion">  
                <h3>
                    <i class="glyph-icon icon-list float-left"></i>
                    Header Mgmt
                </h3>
                <div>
                    <!-- Header Nav -->
                    <?php $rowId = 1;
                    $rec = Themes::find_by_id($rowId); ?>           
                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                <?php echo $rec->title;?> :
                            </label>
                        </div>                
                        <div class="form-input col-md-10">
                            <input class="col-md-4 clorval" type="text" value="<?php echo !empty($rec->valnew)?$rec->valnew:$rec->valdefault;?>" idVal="<?php echo !empty($rec->id)?$rec->id:0;?>">                                               
                        </div>                
                    </div>
                    <!-- Header Nav Display-->
                    <?php $rowId = 2;
                    $rec = Themes::find_by_id($rowId); ?>           
                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                <?php echo $rec->title;?> :
                            </label>
                        </div>                
                        <div class="form-input col-md-10">                            
                            <input class="custom col-md-1" type="checkbox" name="valnew<?php echo $rowId;?>" value="<?php echo !empty($rec->valnew=='block')?'none':'block';?>" onclick="changeresult(<?php echo $rowId;?>);" <?php echo !empty($rec->valnew=='block')?'checked':'';?>>
                        </div>                
                    </div>

                    <!-- Main Header -->
                    <?php $rowId = 3;
                    $rec = Themes::find_by_id($rowId); ?>           
                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                <?php echo $rec->title;?> :
                            </label>
                        </div>                
                        <div class="form-input col-md-10">
                            <input class="col-md-4 clorval" type="text" value="<?php echo !empty($rec->valnew)?$rec->valnew:$rec->valdefault;?>" idVal="<?php echo !empty($rec->id)?$rec->id:0;?>">                                                
                        </div>                
                    </div>
                </div>  
                
                <h3>
                    <i class="glyph-icon icon-list float-left"></i>
                    Slider Mgmt
                </h3>  
                <div>
                    <!-- Slider nav Type -->
                    <?php $rowId = 4;
                    $rec = Themes::find_by_id($rowId); ?>           
                    <div class="form-row">
                        <div class="form-label col-md-3">
                            <label for="">
                                <?php echo $rec->title;?> :
                            </label>
                        </div>                
                        <div class="form-checkbox-radio col-md-9">
                            <input class="custom " type="radio" name="valnew<?php echo $rowId;?>" value="none" onclick="changeresult(<?php echo $rowId;?>);" <?php echo !empty($rec->valnew=='none')?'checked':'';?>>
                            <label for="">None</label>
                            <input class="custom " type="radio" name="valnew<?php echo $rowId;?>" value="both" onclick="changeresult(<?php echo $rowId;?>);" <?php echo !empty($rec->valnew=='both')?'checked':'';?>> 
                            <label for="">Both</label>
                        </div>                
                    </div>

                    <!-- Slider nav Arrow -->
                    <?php $rowId = 5;
                    $rec = Themes::find_by_id($rowId); ?>           
                    <div class="form-row">
                        <div class="form-label col-md-3">
                            <label for="">
                                <?php echo $rec->title;?> :
                            </label>
                        </div>                
                        <div class="form-checkbox-radio col-md-9">
                            <input class="custom " type="radio" name="valnew<?php echo $rowId;?>" value=" " onclick="changeresult(<?php echo $rowId;?>);" <?php echo !empty($rec->valnew==' ')?'checked':'';?>> 
                            <label for="">Blank</label>
                            <input class="custom " type="radio" name="valnew<?php echo $rowId;?>" value="none" onclick="changeresult(<?php echo $rowId;?>);" <?php echo !empty($rec->valnew=='none')?'checked':'';?>> 
                            <label for="">None</label>
                            <input class="custom " type="radio" name="valnew<?php echo $rowId;?>" value="nextto" onclick="changeresult(<?php echo $rowId;?>);" <?php echo !empty($rec->valnew=='nextto')?'checked':'';?>>
                            <label for="">Next to</label>
                            <input class="custom " type="radio" name="valnew<?php echo $rowId;?>" value="nexttobullets" onclick="changeresult(<?php echo $rowId;?>);" <?php echo !empty($rec->valnew=='nexttobullets')?'checked':'';?>>
                            <label for="">Next to bullets</label>               
                        </div>                
                    </div>

                    <!-- Slider nav Style -->
                    <?php $rowId = 6;
                    $rec = Themes::find_by_id($rowId); ?>           
                    <div class="form-row">
                        <div class="form-label col-md-3">
                            <label for="">
                                <?php echo $rec->title;?> :
                            </label>
                        </div>                
                        <div class="form-checkbox-radio col-md-9">
                            <input class="custom " type="radio" name="valnew<?php echo $rowId;?>" value=" " onclick="changeresult(<?php echo $rowId;?>);" <?php echo !empty($rec->valnew==' ')?'checked':'';?>> 
                            <label for="">Blank</label>
                            <input class="custom " type="radio" name="valnew<?php echo $rowId;?>" value="none" onclick="changeresult(<?php echo $rowId;?>);" <?php echo !empty($rec->valnew=='none')?'checked':'';?>> 
                            <label for="">None</label>
                            <input class="custom " type="radio" name="valnew<?php echo $rowId;?>" value="round" onclick="changeresult(<?php echo $rowId;?>);" <?php echo !empty($rec->valnew=='round')?'checked':'';?>>
                            <label for="">Round</label>
                            <input class="custom " type="radio" name="valnew<?php echo $rowId;?>" value="square" onclick="changeresult(<?php echo $rowId;?>);" <?php echo !empty($rec->valnew=='square')?'checked':'';?>> 
                            <label for="">Square</label>                                       
                        </div>                
                    </div>
                </div>
            </div>    
        </div>        
    </div>
</div>  