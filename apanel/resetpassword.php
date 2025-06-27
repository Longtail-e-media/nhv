<?php
require_once('../includes/initialize.php');
$access_key = (isset($_REQUEST['keys']))?addslashes($_REQUEST['keys']):"myaccess";
$query = "SELECT `id` FROM `tbl_users` WHERE `access_code`='".$access_key."' LIMIT 1 ";
$record = $db->query($query);
$dataResult = $db->num_rows($record);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $GLOBALS['login']['adminPanel'];?> <?php Config::getField('sitename');?> | <?php echo $GLOBALS['login']['signIn'];?></title>
    <base class="base" url="<?php echo BASE_URL;?>">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- Favicons -->
    <link rel="shortcut icon" href="<?php echo ADMIN_URL."favicon.ico";?>">
    <!--[if lt IE 9]>
      <script src="<?php echo ASSETS_PATH;?>js/minified/core/html5shiv.min.js"></script>
      <script src="<?php echo ASSETS_PATH;?>js/minified/core/respond.min.js"></script>
    <![endif]-->
    <!-- AgileUI CSS Core -->
    <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH;?>css/minified/aui-production.min.css">
    <!-- Theme UI -->

    <link id="layout-theme" rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH;?>themes/minified/agileui/color-schemes/layouts/default.min.css">
    <link id="elements-theme" rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH;?>themes/minified/agileui/color-schemes/elements/default.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH;?>themes/minified/agileui/responsive.min.css">
    <!-- AgileUI Animations -->
    <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH;?>themes/minified/agileui/animations.min.css">
    <!-- AgileUI JS -->
    <script type="text/javascript" src="<?php echo ASSETS_PATH;?>js/minified/aui-production.min.js"></script>

    <!-- Validation stylesheet -->
    <link rel="stylesheet" href="<?php echo ADMIN_CSS;?>validationEngine.jquery.css" type="text/css" media="screen" />
    <script type="text/javascript" src="<?php echo JS_PATH;?>jquery.validationEngine-en.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH;?>jquery.validationEngine.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH;?>apanel/login.js"></script>      
</head>
<body>
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->

    <div id="login-page" class="mrg25B">

        <div id="page-header" class="clearfix">
            <div id="page-header-wrapper" class="clearfix">
                <div id="header-logo">
                    <?php Config::getField('sitename');?>
                </div>             
            </div>
        </div><!-- #page-header -->

    </div>
     
	<div class="pad20A">
            <div class="row">            
                <div class="clear"></div>
                <!-- For Reset Password  -->
                <form action="" name="reset-frm" id="reset-frm" class="col-md-3 center-margin form-vertical mrg25T" method="post">
                    <?php if($dataResult){
                        $Rcdate = User::get_uid_by_accessToken($access_key);?>
                    <div class="ui-dialog mrg5T " id="login-reset" style="position: relative !important;">
                        <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                            <span class="ui-dialog-title">Reset password</span>
                            <a href="<?php echo ADMIN_URL;?>" class="switch-button" style="float:right;" title="Back To Login">
                                <i class="glyph-icon icon-clock-os"></i>
                            </a>
                        </div>
                        <div class="pad20A ui-dialog-content ui-widget-content">
                            
                            <div class="infobox clearfix infobox-close-wrapper  error-bg mrg20B" style="display:none;">
                                <a href="javascript:void(0);" title="Close Message" class="glyph-icon infobox-close icon-remove"></a>
                                <p class="display_message"></p>
                            </div>
                            <div class="form-row">
                                <div class="form-label col-md-2">
                                    <label for="">
                                        New Password:
                                    </label>
                                </div>
                                <div class="form-input col-md-10">
                                    <div class="form-input-icon">
                                        <i class="glyph-icon icon-unlock-alt ui-state-default"></i>
                                        <input placeholder="New Password" type="password" name="password" id="password" class="validate[required,minSize[6],maxSize[50]]">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-label col-md-2">
                                    <label for="">
                                        Re-Password:
                                    </label>
                                </div>
                                <div class="form-input col-md-10">
                                    <div class="form-input-icon">
                                        <i class="glyph-icon icon-unlock-alt ui-state-default"></i>
                                        <input placeholder="Re-password" type="password" id="re-password" class="validate[required,equals[password]] ">
                                        <input type="hidden" name="userId" value="<?php echo $Rcdate->id;?>" />
                                    </div>
                                </div>
                            </div>                            
                        </div>
                        <div class="ui-dialog-buttonpane text-center">
                            <button type="submit" name="submit" class="btn large primary-bg radius-all-4 btn-reset" id="submit">
                                <span class="button-content">
                                    Reset Password
                                </span>
                            </button>                            
                        </div>
                    </div>
                    <?php }else{?>
                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="">
                                Given URL not match. <a href="<?php echo ADMIN_URL;?>">Back</a>
                            </label>
                        </div>
                    </div>
                    <?php }?>
                </form>
            </div>

        </div>

    <div id="page-footer-wrapper" class="login-footer">
        <div id="page-footer">
            <?php echo COPYRIGHT;?> | <?php echo $GLOBALS['dashB']['poweredBy'];?> : <?php echo POWERED_BY;?>
        </div>
    </div><!-- #page-footer-wrapper -->

</body>
</html>