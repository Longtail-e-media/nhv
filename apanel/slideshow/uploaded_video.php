<?php
include_once('../../includes/initialize.php');
if (!isset($_SESSION['videoNameArr'])) {
    $_SESSION['videoNameArr'] = array();
}
$_SESSION['videoNameArr'][] = $_POST['vidfile'];
$videoNameArr = $_SESSION['videoNameArr'];
$deleteid = rand(0, 99999);
if (!empty($videoNameArr)):
    foreach ($videoNameArr as $key => $val):?>
        <div class="form-row">
            <div class="form-label col-md-2"></div>
            <div class="col-md-3" id="previewUserimage<?php echo $deleteid; ?>">
                <div class="infobox info-bg">
                    <a href="javascript:void(0);" onclick="deleteTempvideo(<?php echo $deleteid; ?>);">
                        <?php echo $val; ?>
                        <span class="badge badge-absolute float-right bg-red" style="right: -10px !important;">
                            <i class="glyph-icon icon-clock-os"></i>
                        </span>
                    </a>
                    <input type="hidden" name="videoArrayname" value="<?php echo $val; ?>"/>
                </div>
            </div>
        </div>
    <?php endforeach; endif;
//uplodify
if (isset($_SESSION['videoNameArr'])) {
    if (count($_SESSION['videoNameArr']) > 0) {
        foreach ($_SESSION['videoNameArr'] as $key => $val) {
            @unlink(IMAGE_PATH . 'slideshow/video/' . $val);
        }
        unset($_SESSION['videoNameArr']);
    }
}
//uplodify
?>
