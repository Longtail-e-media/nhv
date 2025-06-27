<?php
$moduleTablename  = "tbl_video"; // Database table name
$moduleId 		  = 11;				// module id >>>>> tbl_modules
$moduleFoldername = "";		// Image folder name	
?>
<style>
.divContent a { position:relative;}
.divContent a span { background-image:url('../../images/apanel/play.png'); background-repeat:no-repeat; width:32px; height:32px; position:absolute; left:10px; bottom:10px;}
</style>
<h3>AddEdit Video</h3>
<div class="my-msg"></div>
<div class="example-box">
    <div class="example-code">
        <form action="" class="col-md-10 center-margin" id="video_frm">    		
            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Video link :
                    </label>
                </div>
                <div class="form-input col-md-10">  
                	<input placeholder="http://www.youtube.com/watch?v=fs2khSNtSu0" class="col-md-8 validate[custom[url]]" type="text" name="source" id="source" >  
                    <input type="hidden" name="url_type" id="url_type">                                       
                    <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4" id="btn-submit" title="Save">
                        <span class="button-content">
                            Save
                        </span>
                    </button>
                    <small>
                        <br />Ex. Soundcloud : http://soundcloud.com/balajipatturaj/chennais-super-kings-with-rj
                        <br />Ex. Youtube : https://www.youtube.com/watch?v=dZpc936_Hgo
                        <br />Ex. Vimeo : http://vimeo.com/65484727
                        <br />Ex. Metacafe : http://www.metacafe.com/watch/10599819/are_katy_perry_and_john_mayer_back_together
                        <br />Ex. Dailymotion : http://www.dailymotion.com/video/xzdijh_hire-data-entry-expert_news 
                    </small>
                </div>                
            </div>         
            <input type="hidden" name="idValue" id="idValue" value="0" />
        </form>
    </div>
</div>    

<?php 
$sql = "SELECT * FROM ".$moduleTablename." ORDER BY sortorder ASC";
$saveVideo = Video::find_by_sql($sql); 
if($saveVideo): ?>
<h3>List Videos</h3>
<div class="example-box">
    <div class="example-code">    
		<div class="row">
            <div class="col-md-12 video-sort">		                
                <?php foreach($saveVideo as $videoRow): ?>
                <div class="col-md-3" id="<?php echo $videoRow->id;?>">
                    <div class="infobox info-bg">                            	                                
                        <div class="button-group" data-toggle="buttons">                                                            
                            <a class="btn small float-right" href="javascript:void(0);" onclick="recordDelete(<?php echo $videoRow->id;?>);">
                                <i class="glyph-icon icon-trash-o"></i>
                            </a>
                            <?php
                                $imageStatus = ($videoRow->status==1)?'icon-check-circle-o':'icon-clock-os-circle-o';
                            ?>
                            <a class="btn small float-right videoStatusToggle" href="javascript:void(0);" rowId="<?php echo $videoRow->id;?>" status="<?php echo $videoRow->status;?>">
                                <i class="glyph-icon <?php echo $imageStatus;?>" id="toggleImg<?php echo $videoRow->id;?>"></i>
                            </a>  
                            <a class="loadingbar-demo btn small float-right" href="javascript:void(0);" onclick="editRecord(<?php echo $videoRow->id;?>);">
                                <i class="glyph-icon icon-edit"></i>
                            </a>       
                            <span><?php echo $videoRow->host;?></span>                           
                        </div>
                            <div class="divContent">
                                <a class="<?php echo $videoRow->class;?>" href="<?php echo $videoRow->url; ?>" rel="media-gallery">
                                    <span></span>
                                    <img src="<?php echo $videoRow->thumb_image; ?>" width="100%" title="Play" alt="Play"/> 
                                </a>
                            </div>
                         <span><?php echo $videoRow->title;?></span>                          
                         <span><?php echo $videoRow->content;?></span>    
                    </div>
                </div>    
				<?php endforeach;?>
            </div>          
        </div>
   </div>
</div>  
<?php endif;?>