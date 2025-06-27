<h3>Properties Management</h3>
<?php $PrefeRow   = Config::find_by_id(1); ?>
<div class="my-msg"></div>
<div class="example-box">
    <div class="example-code">
        <div class="accordion">            
            <!-- Menu Section  -->
            <?php $moduleId = 2; 
            $rec = Module::field_by_id($moduleId,'status'); 
            if($rec==1){ ?>
            <h3>
                <i class="glyph-icon icon-list float-left"></i>
                Menu Mgmt
            </h3>
            <div>
            <?php
                $result = Module::field_by_id($moduleId,'properties');
                $rec = unserialize($result); ?>
                <form action="" id="menu-properties"  class="col-md-12 center-margin"> 
                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label>Level</label> 
                        </div>
                        <div class="form-input col-md-2">
                            <select class="form-control" name="level">
                            <?php for($i=1; $i<=5; $i++){ 
                                $sel = (Module::get_properties($moduleId,'level')==$i)?'selected':'';  
                                echo '<option value="'.$i.'" '.$sel.'>'.$i.'</option>';
                            } ?>
                            </select>
                        </div>                        
                    </div>
                    <input type="hidden" name="modelId" id="modelId" value="<?php echo $moduleId;?>" />
                    <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                        <span class="button-content">
                            Save
                        </span>
                    </button>                                        
                </form> 
            </div>

            <!-- Articles Section -->
            <?php  }
            $moduleId = 3; 
            $rec = Module::field_by_id($moduleId,'status'); 
            if($rec==1){ ?>
            <h3>
                <i class="glyph-icon icon-adn float-left"></i>
                Articles Mgmt
            </h3>

            <div class="hide">   
                <form action="" class="col-md-12 center-margin" id="articles-properties">
                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Width :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Width Px." class="col-md-4 validate[required,length[0,50]] noSpaces" type="text" name="imgwidth" id="imgwidth" value="<?php echo Module::get_properties($moduleId,'imgwidth');?>">
                        </div>                
                    </div>

                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Height :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Hight Px." class="col-md-4 validate[required,length[0,100]] noSpaces" type="text" name="imgheight" id="imgheight" value="<?php echo Module::get_properties($moduleId,'imgheight');?>">
                        </div>                
                    </div>

                    <input type="hidden" name="modelId" id="modelId" value="<?php echo $moduleId;?>" />         
                    <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                        <span class="button-content">
                            Save
                        </span>
                    </button>                                        
                </form> 
            </div>

            <!-- Slideshow Section -->
            <?php  }
            $moduleId = 4; 
            $rec = Module::field_by_id($moduleId,'status'); 
            if($rec==1){ ?>
            <h3>
                <i class="glyph-icon icon-film float-left"></i>
                Slideshow Mgmt
            </h3>

            <div class="hide">  
                <form action="" class="col-md-12 center-margin" id="slideshow-properties">
                    <h4>Main Slideshow</h4>
                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Width :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Width Px." class="col-md-4 validate[required,length[0,50]] noSpaces" type="text" name="imgwidth" id="imgwidth" value="<?php echo Module::get_properties($moduleId,'imgwidth');?>">
                        </div>                
                    </div>

                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Height :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Hight Px." class="col-md-4 validate[required,length[0,100]] noSpaces" type="text" name="imgheight" id="imgheight" value="<?php echo Module::get_properties($moduleId,'imgheight');?>">
                        </div>                
                    </div>  

                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Delay :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Delay Time (ex. : 1000 equal to 1 sec) " class="col-md-4 validate[required,length[0,100]] noSpaces" type="text" name="imgdelay" id="imgdelay" value="<?php echo Module::get_properties($moduleId,'imgdelay');?>">
                        </div>                
                    </div>  
                    <input type="hidden" name="modelId" id="modelId" value="<?php echo $moduleId;?>" />         
                    <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                        <span class="button-content">
                            Save
                        </span>
                    </button>                    
                 </form>       
            </div>

            <!-- Gallery Section -->
            <?php  }
            $moduleId = 5; 
            $rec = Module::field_by_id($moduleId,'status'); 
            if($rec==1){ ?>
            <h3>
                <i class="glyph-icon icon-picture-o float-left"></i>
                Gallery Mgmt
            </h3>

            <div class="hide">  
                <form action="" class="col-md-12 center-margin" id="gallery-properties">
                    <h4>Main Gallery</h4>
                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Width :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Width Px." class="col-md-4 validate[required,length[0,50]] noSpaces" type="text" name="imgwidth" id="imgwidth" value="<?php echo Module::get_properties($moduleId,'imgwidth');?>">
                        </div>                
                    </div>

                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Height :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Hight Px." class="col-md-4 validate[required,length[0,100]] noSpaces" type="text" name="imgheight" id="imgheight" value="<?php echo Module::get_properties($moduleId,'imgheight');?>">
                        </div>                
                    </div>

                    <h4>Sub Gallery</h4>
                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Width :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Width Px." class="col-md-4 validate[required,length[0,50]] noSpaces" type="text" name="simgwidth" id="simgwidth" value="<?php echo Module::get_properties($moduleId,'simgwidth');?>">
                        </div>                
                    </div>

                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Height :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Hight Px." class="col-md-4 validate[required,length[0,100]] noSpaces" type="text" name="simgheight" id="simgheight" value="<?php echo Module::get_properties($moduleId,'simgheight');?>">
                        </div>                
                    </div>  
                    <input type="hidden" name="modelId" id="modelId" value="<?php echo $moduleId;?>" />         
                    <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                        <span class="button-content">
                            Save
                        </span>
                    </button>                    
                 </form>       
            </div>

            <!-- News Section -->
            <?php  }
            $moduleId = 6; 
            $rec = Module::field_by_id($moduleId,'status'); 
            if($rec==1){ ?>
            <h3>
                <i class="glyph-icon icon-list-alt float-left"></i>
                News Mgmt
            </h3>

            <div class="hide">   
                <form action="" class="col-md-12 center-margin" id="news-properties">
                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Width :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Width Px." class="col-md-4 validate[required,length[0,50]] noSpaces" type="text" name="imgwidth" id="imgwidth" value="<?php echo Module::get_properties($moduleId,'imgwidth');?>">
                        </div>                
                    </div>

                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Height :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Hight Px." class="col-md-4 validate[required,length[0,100]] noSpaces" type="text" name="imgheight" id="imgheight" value="<?php echo Module::get_properties($moduleId,'imgheight');?>">
                        </div>                
                    </div>

                    <input type="hidden" name="modelId" id="modelId" value="<?php echo $moduleId;?>" />         
                    <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                        <span class="button-content">
                            Save
                        </span>
                    </button>                    
                 </form>       
            </div>
            
            <!-- Advertisment Section -->
            <?php  }
            $moduleId = 7; 
            $rec = Module::field_by_id($moduleId,'status'); 
            if($rec==1){ ?>
            <h3>
                <i class="glyph-icon icon-indent float-left"></i>
                Advertisment Mgmt
            </h3>

            <div class="hide">    
                <form action="" class="col-md-12 center-margin" id="advertisment-properties">
                    <h4>Display Left</h4>
                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Width :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Width Px." class="col-md-4 validate[required,length[0,50]] noSpaces" type="text" name="limgwidth" id="limgwidth" value="<?php echo Module::get_properties($moduleId,'limgwidth');?>">
                        </div>                
                    </div>

                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Height :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Hight Px." class="col-md-4 validate[required,length[0,100]] noSpaces" type="text" name="limgheight" id="limgheight" value="<?php echo Module::get_properties($moduleId,'limgheight');?>">
                        </div>                
                    </div>  

                    <h4>Display Top</h4>
                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Width :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Width Px." class="col-md-4 validate[required,length[0,50]] noSpaces" type="text" name="timgwidth" id="timgwidth" value="<?php echo Module::get_properties($moduleId,'timgwidth');?>">
                        </div>                
                    </div>

                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Height :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Hight Px." class="col-md-4 validate[required,length[0,100]] noSpaces" type="text" name="timgheight" id="timgheight" value="<?php echo Module::get_properties($moduleId,'timgheight');?>">
                        </div>                
                    </div> 

                    <h4>Display Right</h4>
                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Width :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Width Px." class="col-md-4 validate[required,length[0,50]] noSpaces" type="text" name="rimgwidth" id="rimgwidth" value="<?php echo Module::get_properties($moduleId,'rimgwidth');?>">
                        </div>                
                    </div>

                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Height :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Hight Px." class="col-md-4 validate[required,length[0,100]] noSpaces" type="text" name="rimgheight" id="rimgheight" value="<?php echo Module::get_properties($moduleId,'rimgheight');?>">
                        </div>                
                    </div> 

                    <h4>Display Bottom</h4>
                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Width :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Width Px." class="col-md-4 validate[required,length[0,50]] noSpaces" type="text" name="bimgwidth" id="bimgwidth" value="<?php echo Module::get_properties($moduleId,'bimgwidth');?>">
                        </div>                
                    </div>

                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Height :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Hight Px." class="col-md-4 validate[required,length[0,100]] noSpaces" type="text" name="bimgheight" id="bimgheight" value="<?php echo Module::get_properties($moduleId,'bimgheight');?>">
                        </div>                
                    </div> 

                    <input type="hidden" name="modelId" id="modelId" value="<?php echo $moduleId;?>" />         
                    <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                        <span class="button-content">
                            Save
                        </span>
                    </button>                    
                 </form>       
            </div>

            <!-- Social Section -->
            <?php  }
            $moduleId = 10; 
            $rec = Module::field_by_id($moduleId,'status'); 
            if($rec==1){ ?>
            <h3>
                <i class="glyph-icon icon-google-plus float-left"></i>
                Social Link Mgmt
            </h3>

            <div class="hide">   
                <form action="" class="col-md-12 center-margin" id="social-properties">
                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Width :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Width Px." class="col-md-4 validate[required,length[0,50]] noSpaces" type="text" name="imgwidth" id="imgwidth" value="<?php echo Module::get_properties($moduleId,'imgwidth');?>">
                        </div>                
                    </div>

                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Height :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Hight Px." class="col-md-4 validate[required,length[0,100]] noSpaces" type="text" name="imgheight" id="imgheight" value="<?php echo Module::get_properties($moduleId,'imgheight');?>">
                        </div>                
                    </div>

                    <input type="hidden" name="modelId" id="modelId" value="<?php echo $moduleId;?>" />         
                    <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                        <span class="button-content">
                            Save
                        </span>
                    </button>                    
                 </form>       
            </div>

            <!-- Destination Section -->
            <?php  }
            $moduleId = 18; 
            $rec = Module::field_by_id($moduleId,'status'); 
            if($rec==1){ ?>
            <h3>
                <i class="glyph-icon icon-plane float-left"></i>
                Destination Mgmt
            </h3>

            <div class="hide">   
                <form action="" class="col-md-12 center-margin" id="destination-properties">
                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Width :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Width Px." class="col-md-4 validate[required,length[0,50]] noSpaces" type="text" name="imgwidth" id="imgwidth" value="<?php echo Module::get_properties($moduleId,'imgwidth');?>">
                        </div>                
                    </div>

                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Height :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Hight Px." class="col-md-4 validate[required,length[0,100]] noSpaces" type="text" name="imgheight" id="imgheight" value="<?php echo Module::get_properties($moduleId,'imgheight');?>">
                        </div>                
                    </div>

                    <input type="hidden" name="modelId" id="modelId" value="<?php echo $moduleId;?>" />         
                    <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                        <span class="button-content">
                            Save
                        </span>
                    </button>                                        
                </form> 
            </div>

            <!-- Activities Section -->
            <?php  }
            $moduleId = 19; 
            $rec = Module::field_by_id($moduleId,'status'); 
            if($rec==1){ ?>
            <h3>
                <i class="glyph-icon icon-tags float-left"></i>
                Activities Mgmt
            </h3>

            <div class="hide">   
                <form action="" class="col-md-12 center-margin" id="activities-properties">
                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Width :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Width Px." class="col-md-4 validate[required,length[0,50]] noSpaces" type="text" name="imgwidth" id="imgwidth" value="<?php echo Module::get_properties($moduleId,'imgwidth');?>">
                        </div>                
                    </div>

                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Height :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Hight Px." class="col-md-4 validate[required,length[0,100]] noSpaces" type="text" name="imgheight" id="imgheight" value="<?php echo Module::get_properties($moduleId,'imgheight');?>">
                        </div>                
                    </div>

                    <input type="hidden" name="modelId" id="modelId" value="<?php echo $moduleId;?>" />         
                    <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                        <span class="button-content">
                            Save
                        </span>
                    </button>                                        
                </form> 
            </div>

            <!-- Package Section -->
            <?php  }
            $moduleId = 20; 
            $rec = Module::field_by_id($moduleId,'status'); 
            if($rec==1){ ?>
            <h3>
                <i class="glyph-icon icon-gift float-left"></i>
                Package Mgmt
            </h3>

            <div class="hide">   
                <form action="" class="col-md-12 center-margin" id="package-properties">
                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Width :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Width Px." class="col-md-4 validate[required,length[0,50]] noSpaces" type="text" name="imgwidth" id="imgwidth" value="<?php echo Module::get_properties($moduleId,'imgwidth');?>">
                        </div>                
                    </div>

                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Height :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Hight Px." class="col-md-4 validate[required,length[0,100]] noSpaces" type="text" name="imgheight" id="imgheight" value="<?php echo Module::get_properties($moduleId,'imgheight');?>">
                        </div>                
                    </div>

                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Map Image Width :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Map Image Width Px." class="col-md-4 validate[required,length[0,50]] noSpaces" type="text" name="mapimgwidth" id="mapimgwidth" value="<?php echo Module::get_properties($moduleId,'mapimgwidth');?>">
                        </div>                
                    </div>

                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Map Image Height :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Map Image Hight Px." class="col-md-4 validate[required,length[0,100]] noSpaces" type="text" name="mapimgheight" id="mapimgheight" value="<?php echo Module::get_properties($moduleId,'mapimgheight');?>">
                        </div>                
                    </div>

                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Gallery Image Width :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Gallery Image Width Px." class="col-md-4 validate[required,length[0,50]] noSpaces" type="text" name="galleryimgwidth" id="galleryimgwidth" value="<?php echo Module::get_properties($moduleId,'galleryimgwidth');?>">
                        </div>                
                    </div>

                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Gallery Image Height :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Gallery Image Hight Px." class="col-md-4 validate[required,length[0,100]] noSpaces" type="text" name="galleryimgheight" id="galleryimgheight" value="<?php echo Module::get_properties($moduleId,'galleryimgheight');?>">
                        </div>                
                    </div>

                    <input type="hidden" name="modelId" id="modelId" value="<?php echo $moduleId;?>" />         
                    <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                        <span class="button-content">
                            Save
                        </span>
                    </button>                                        
                </form> 
            </div>

            <!-- Preference Section -->
            <?php  }
            $moduleId = 12; 
            $rec = Module::field_by_id($moduleId,'status'); 
            if($rec==1){ ?>
            <h3>
                <i class="glyph-icon icon-cog float-left"></i>
                Preference Mgmt
            </h3>

            <div class="hide">         
                <form action="" class="col-md-12 center-margin" id="preference-properties">
                    <h4>Icon Image</h4>
                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Width :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Width Px." class="col-md-4 validate[required,length[0,50]] noSpaces" type="text" name="imgwidth" id="imgwidth" value="<?php echo Module::get_properties($moduleId,'imgwidth');?>">
                        </div>                
                    </div>

                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Height :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Hight Px." class="col-md-4 validate[required,length[0,100]] noSpaces" type="text" name="imgheight" id="imgheight" value="<?php echo Module::get_properties($moduleId,'imgheight');?>">
                        </div>                
                    </div>  

                    <h4>Logo Image</h4>
                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Width :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Width Px." class="col-md-4 validate[required,length[0,50]] noSpaces" type="text" name="simgwidth" id="simgwidth" value="<?php echo Module::get_properties($moduleId,'simgwidth');?>">
                        </div>                
                    </div>

                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Image Height :
                            </label>
                        </div>                
                        <div class="form-input col-md-20">
                            <input placeholder="Image Hight Px." class="col-md-4 validate[required,length[0,100]] noSpaces" type="text" name="simgheight" id="simgheight" value="<?php echo Module::get_properties($moduleId,'simgheight');?>">
                        </div>                
                    </div>  
                    <input type="hidden" name="modelId" id="modelId" value="<?php echo $moduleId;?>" />         
                    <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                        <span class="button-content">
                            Save
                        </span>
                    </button>                    
                 </form>       
            </div>
            <?php  } ?>
        </div>
    </div>
</div>   