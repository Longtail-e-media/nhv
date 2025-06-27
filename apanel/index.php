<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
require_once('../includes/initialize.php');
$accsid    = $session->get('u_id');
$accsagent = $session->get('acc_agent');
$accscode  = $session->get('accesskey');
$actionpaeg= access_permission($accsid,$accsagent,$accscode);
if($actionpaeg==='true'){
    $preId = Config::getconfig_info();
    if($preId->action==1){
        redirect_to(BASE_URL.'apanel/preference/list');
    }else{
        redirect_to(BASE_URL.'apanel/dashboard');
    }
}
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
    <?php $siteRegulars = Config::find_by_id(1); ?>
    <link rel="shortcut icon" href="<?php echo IMAGE_PATH.'preference/'.$siteRegulars->icon_upload;?>"> 
    <link rel="apple-touch-icon" href="<?php echo IMAGE_PATH.'preference/'.$siteRegulars->icon_upload;?>"> 
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo IMAGE_PATH.'preference/'.$siteRegulars->icon_upload;?>"> 
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo IMAGE_PATH.'preference/'.$siteRegulars->icon_upload;?>">
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
    <noscript>This site has features that require javascript. Follow these simple instructions to <a href="http://www.activatejavascript.org" target="_blank">enable JavaScript in your web browser</a>.</noscript>
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
            <div class="text-center">
                <h3>Welcome To <?php Config::getField('sitename');?> Admin Panel</h3> 
            </div>
            
            <div class="row">                       
                <div class="clear"></div>
                <form action="" name="login-frm" id="login-frm" class="col-md-3 center-margin form-vertical mrg25T" method="post">
                    <div id="login-form" class="content-box drop-shadow">
                        <h3 class="content-box-header ui-state-default">
                            <div class="glyph-icon icon-separator">
                                <i class="glyph-icon icon-user"></i>
                            </div>
                            <span>Admin Login</span>
                        </h3>
                        <div class="content-box-wrapper pad20A pad0B">
                        	<div class="infobox clearfix infobox-close-wrapper 	error-bg mrg20B" style="display:none;">
                                <a href="javascript:void(0);" title="Close Message" class="glyph-icon infobox-close icon-remove"></a>
                                <p class="display_message"></p>
                            </div>
                            <div class="form-row">
                                <div class="form-label col-md-2">
                                    <label for="login_email">
                                        Username:                                        
                                    </label>
                                </div>
                                <div class="form-input col-md-10">
                                    <div class="form-input-icon">
                                        <i class="glyph-icon icon-user ui-state-default"></i>
                                        <input placeholder="Username" type="text" name="username" id="username" class="validate[required,length[0,100]]">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-label col-md-2">
                                    <label for="login_pass">
                                        Password:
                                    </label>
                                </div>
                                <div class="form-input col-md-10">
                                    <div class="form-input-icon">
                                        <i class="glyph-icon icon-unlock-alt ui-state-default"></i>
                                        <input placeholder="Password" type="password" name="password" id="password" class="validate[required,length[0,100]]">
                                    </div>
                                </div>
                            </div>   

                            <div class="form-row">                                
                                <div class="form-checkbox-radio text-right col-md-12">
                                    <a href="#" class="switch-button" switch-target="#login-forgot" switch-parent="#login-form" title="Recover password">
                                        Forgot your password?
                                    </a>
                                </div>
                            </div>                         
                        </div>
                        <div class="button-pane">
                            <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-login" id="demo-form-valid">
                                <span class="button-content">
                                    Login
                                </span>
                            </button>
                        </div>
                    </div>                    
                </form>
                <!-- For forget Password  -->
                <form action="" name="forget-frm" id="forget-frm" class="col-md-3 center-margin form-vertical mrg25T" method="post">
                    <div class="ui-dialog mrg5T hide" id="login-forgot" style="position: relative !important;">
                        <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                            <span class="ui-dialog-title">Recover password</span>
                            <a href="#" class="switch-button" style="float:right;" switch-target="#login-form" switch-parent="#login-forgot" title="Recover password">
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
                                        Email address:
                                    </label>
                                </div>
                                <div class="form-input col-md-10">
                                    <div class="form-input-icon">
                                        <i class="glyph-icon icon-envelope-o ui-state-default"></i>
                                        <input placeholder="Email address" type="text" name="mailaddress" id="mailaddress" class="validate[required,custom[email]]">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row"></div>
                        </div>
                        <div class="ui-dialog-buttonpane text-center">
                            <button type="submit" name="submit" class="btn large primary-bg radius-all-4 btn-forget" id="submit">
                                <span class="button-content">
                                    Recover Password
                                </span>
                            </button>                            
                        </div>
                    </div>
                </form>
            </div>

        </div>

    <div id="page-footer-wrapper" class="login-footer">
        <div id="page-footer">
            <?php echo COPYRIGHT;?> | <?php echo $GLOBALS['dashB']['poweredBy'];?> : <?php echo POWERED_BY;?>
        </div>
    </div><!-- #page-footer-wrapper -->

    <!-- First Login section block -->
    <?php require_once('firstlogin.php');?>
</body>
</html>