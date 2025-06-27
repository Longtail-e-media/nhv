<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
require_once('../includes/initialize.php');
// Check if the user is login or not
$accsid    = $session->get('u_id');
$accsagent = $session->get('acc_agent');
$accscode  = $session->get('accesskey');
$actionpaeg= access_permission($accsid,$accsagent,$accscode);
if($actionpaeg==='false'){
    redirect_to(BASE_URL.'apanel/login');
}
?>
<!DOCTYPE html>
   <html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $GLOBALS['dashB']['welcomeMsg'];?><?php Config::getField('sitename');?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <!--[if lt IE 9]>
          <script src="<?php echo ASSETS_PATH;?>js/minified/core/html5shiv.min.js"></script>
          <script src="<?php echo ASSETS_PATH;?>js/minified/core/respond.min.js"></script>
        <![endif]-->
        <!-- AgileUI CSS Core -->
        <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH;?>css/minified/aui-production.min.css">
        <!-- Theme UI -->
        <link id="layout-theme" rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH;?>themes/minified/agileui/color-schemes/layouts/default.min.css">
        <link id="elements-theme" rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH;?>themes/minified/agileui/color-schemes/elements/default.min.css">
        <!-- AgileUI Responsive -->
        <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH;?>themes/minified/agileui/responsive.min.css">
        <!-- AgileUI Animations -->
        <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH;?>themes/minified/agileui/animations.min.css">
        <!-- jQuery -->
        <noscript>This site has features that require javascript. Follow these simple instructions to <a href="http://www.activatejavascript.org" target="_blank">enable JavaScript in your web browser</a>.</noscript>
        <script type="text/javascript" src="<?php echo JS_PATH;?>jquery-1.8.2.min.js"></script>                
        <!-- Facebox jQuery Plugin -->
        <!--<script type="text/javascript" src="<?php echo JS_PATH;?>facebox.js"></script>-->
        <!-- AgileUI JS -->
        <script type="text/javascript" src="<?php echo ASSETS_PATH;?>js/minified/aui-production.min.js"></script>
        
        <!-- Data Table -->
        <link rel="stylesheet" href="<?php echo ASSETS_PATH;?>Datatable/media/css/demo_table_jui.css" type="text/css" media="screen" />
        <!--<link rel="stylesheet" href="<?php echo ASSETS_PATH;?>Datatable/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" media="screen" />-->
        <script type="text/javascript" src="<?php echo ASSETS_PATH;?>Datatable/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="<?php echo ASSETS_PATH;?>Datatable/media/js/jquery.dataTables.rowReordering.js"></script>
        <!-- Validation stylesheet -->
        <link rel="stylesheet" href="<?php echo ADMIN_CSS;?>validationEngine.jquery.css" type="text/css" media="screen" />
        <script type="text/javascript" src="<?php echo JS_PATH;?>jquery.validationEngine-en.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH;?>jquery.validationEngine.js"></script>
        <!-- PLUGINS-->
        <script type="text/javascript" src="<?php echo JS_PATH;?>jquery.tablednd.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH;?>jquery.alphanumeric.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH;?>jquery.passroids.js"></script>
        <script type="text/javascript" src="<?php echo ASSETS_PATH.'ckeditor/ckeditor.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo ASSETS_PATH.'ckfinder/ckfinder.js'; ?>"></script>
        <!-- My Windows Popup -->

        <!-- For Soundcloud -->
        <script src="<?php echo ADMIN_JS;?>sdk.js"></script>
        <!-- Fancybox -->
        <script type="text/javascript" src="<?php echo ASSETS_PATH;?>fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

        <!-- Add fancyBox main JS and CSS files -->
        <script type="text/javascript" src="<?php echo ASSETS_PATH;?>fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH;?>fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />

        <!-- Add Button helper (this is optional) -->
        <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH;?>fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
        <script type="text/javascript" src="<?php echo ASSETS_PATH;?>fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>

        <!-- Add Thumbnail helper (this is optional) -->
        <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH;?>fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
        <script type="text/javascript" src="<?php echo ASSETS_PATH;?>fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

        <!-- Add Media helper (this is optional) -->
        <script type="text/javascript" src="<?php echo ASSETS_PATH;?>fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

        <!-- End links -->
        <style type="text/css">
            .check-all{width: 20px;}
            .divMessageBox{width:100%;height:100%;position:fixed;top:0;left:0;z-index:100000;opacity:0.7;background-color:rgb(0, 0, 0);}
            .MessageBoxMiddle{position:relative;left:20%;width:50%;font-family:'Segoe UI',Tahoma,Helvetica,Sans-Serif;padding:10px}
            .MessageBoxContainer{position:fixed;top:35%;color:white;width:100%;background-color:#232323;font-family:'Segoe UI',Tahoma,Helvetica,Sans-Serif;z-index: 100001;}
            .MessageBoxMiddle .MsgTitle{font-size:26px}
            .MessageBoxMiddle .pText{font-style:30px}
            .MessageBoxButtonSection{width:100%;height:30px}
            .MessageBoxButtonSection button{float:right;border-color:white;border-width:2px;border-style:solid;color:white;margin-right:5px;padding:5px;padding-left:15px;padding-right:15px;font-family:arial}
            .MessageBoxButtonSection button{background-color:#232323;}  
            .MessageBoxButtonSection button:hover{background-color:green;}          
            @media screen and (max-width:450px) and (max-width:767px){
                .divMessageBox{width:100%;height:100%;position:fixed;top:0;left:0;background:rgba(0,0,0,0.6);z-index:100000;opacity:0.7;background-color:rgb(0, 0, 0);}
                .MessageBoxContainer{position:fixed;top:25%;color:white;width:100%;background-color:#232323;font-family:'Segoe UI',Tahoma,Helvetica,Sans-Serif;z-index: 100001;}
                .MessageBoxMiddle{position:relative;left:10%;width:80%;font-family:'Segoe UI',Tahoma,Helvetica,Sans-Serif;padding:3px}
                .MessageBoxMiddle .MsgTitle{font-size:22px}
                .MessageBoxMiddle .pText{font-style:10px}
                .MessageBoxButtonSection{width:100%;height:30px}
                .MessageBoxButtonSection button{float:right;border-color:white;border-width:2px;border-style:solid;color:white;margin-right:5px;padding:5px;padding-left:15px;padding-right:15px;font-family:arial}
                .MessageBoxButtonSection button{background-color:#232323;}  
                .MessageBoxButtonSection button:hover{background-color:green;}
            }
        </style>
        <!-- My won css -->
        <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH;?>css/reset.css">
        <?php
        require_once('../js/apanel/js.apanel.php');
        if(isset($_GET['page']) && file_exists('../js/apanel/js.'.$_GET['page'].'.php')){
            require_once('../js/apanel/js.'.$_GET['page'].'.php');
        }
        ?>
    <!--FAVICONS-->
    <?php $siteRegulars = Config::find_by_id(1); ?>
    <link rel="shortcut icon" href="<?php echo IMAGE_PATH.'preference/'.$siteRegulars->icon_upload;?>"> 
    <link rel="apple-touch-icon" href="<?php echo IMAGE_PATH.'preference/'.$siteRegulars->icon_upload;?>"> 
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo IMAGE_PATH.'preference/'.$siteRegulars->icon_upload;?>"> 
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo IMAGE_PATH.'preference/'.$siteRegulars->icon_upload;?>">
    <!--END FAVICONS-->
    </head>
    <body class="fixed-sidebar fixed-header">       
        <!-- Window Popup content -->
        <div class="divMessageBox" style="display:none;"></div>      
        <div class="MessageBoxContainer" style="display:none;">
            <div class="MessageBoxMiddle">
            <span class="MsgTitle"></span>
            <p class="pText"></p>
                <div class="MessageBoxButtonSection">
                <button id="no" class="botTempo"> No</button>
                <button id="yes" class="botTempo"> Yes</button>
                </div>
            </div>
        </div>
        <!--<div id="loading" class="ui-front loader ui-widget-overlay bg-white opacity-100">
            <img src="<?php echo ASSETS_PATH;?>images/loader-dark.gif" alt="">
        </div>-->
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <div id="page-wrapper" class="demo-example">

            <div id="page-sidebar">
                <?php include_apanel_template('menu.php');?>
            </div><!-- #page-sidebar -->
            <div id="page-main">

                <div id="page-main-wrapper">

                    <div id="page-header" class="clearfix">
                        <div id="page-header-wrapper" class="clearfix">                           
                            <div class="top-icon-bar dropdown">
                                <a href="javascript:void(0);" title="" class="user-ico clearfix" data-toggle="dropdown">
                                    <img width="75" alt="<?php echo $siteRegulars->sitetitle;?>" src="<?php echo IMAGE_PATH.'preference/'.$siteRegulars->logo_upload;?>">
                                    <span><?php echo $session->get('loginUser');?></span>
                                    <i class="glyph-icon icon-chevron-down"></i>
                                </a>
                                <ul class="dropdown-menu float-right">                                    
                                    <li>
                                        <a href="<?php echo BASE_URL;?>" title="<?php Config::getField('sitename');?>" target="_blank">
                                            <i class="glyph-icon icon-eye mrg5R"></i>
                                            View Site
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="<?php echo ADMIN_URL;?>logout" title="">
                                            <i class="glyph-icon icon-sign-out font-size-13 mrg5R"></i>
                                            <span class="font-bold">Logout</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!--<div class="top-icon-bar" style="background-color: #F00;">
                                <!-- Feedback Notification -->
                                <!--<a href="<?php echo ADMIN_URL.'analytics/report';?>" class="user-ico clearfix" title="Google Analytics"><span style="color: #FFF;">Analytics Report</span></a>
                            </div>-->
                            <div class="top-icon-bar">
                                <!-- Feedback Notification -->
                                <a href="<?php echo $siteRegulars->linksrc;?>" target="_blank " class="user-ico clearfix" title="Google Analytics "><span><i class="glyph-icon icon-sign-out font-size-12" style="margin: 0px !important;" ></i> Google Analytics</span></a>
                            </div>
                            
                            <!-- <div class="top-icon-bar"> -->
                                <!-- Feedback Notification -->
                                
                                
                                <!-- Notification for Answer complete -->
                                
                            <!-- </div> -->
                        </div>
                    </div><!-- #page-header -->
                                    
                    <div id="page-breadcrumb-wrapper">
                        <div id="page-breadcrumb">
                            <?php if(isset($_REQUEST['page']) && !empty($_REQUEST['page'])): ?>
                            <a href="<?php echo ADMIN_URL;?>dashboard" title="Dashboard">
                                <i class="glyph-icon icon-dashboard"></i>
                                Dashboard
                            </a>
                            <span class="current">
                                <?php echo $_REQUEST['page'];
                                if($_REQUEST['page']=='analytics') { ?>
                                <span style="position: absolute; right: 30px; color: #333;">
                                    <strong>Report Date:&nbsp;</strong><?php echo date('M d', strtotime("-6 days")).' To '.date('M d');?>
                                </span>
                                <?php } ?>
                            </span>
                            <?php else: ?>
                            <span class="current">
                                <i class="glyph-icon icon-dashboard"></i>
                                Dashboard
                            </span>
                            <?php endif; ?>

                        </div>                        
                    </div><!-- #page-breadcrumb-wrapper -->
                    <div id="page-content">                   
                       
                        <?php include("includeme.php"); ?>  
                    </div><!-- #page-content -->
                </div><!-- #page-main -->
            </div><!-- #page-main-wrapper -->
        </div><!-- #page-wrapper -->       
        <script type="text/javascript">
            var isFlashInstalled = (function() {
                var b=new function(){var n=this;n.c=!1;var a="ShockwaveFlash.ShockwaveFlash",r=[{name:a+".7",version:function(n){return e(n)}},{name:a+".6",version:function(n){var a="6,0,21";try{n.AllowScriptAccess="always",a=e(n)}catch(r){}return a}},{name:a,version:function(n){return e(n)}}],e=function(n){var a=-1;try{a=n.GetVariable("$version")}catch(r){}return a},i=function(n){var a=-1;try{a=new ActiveXObject(n)}catch(r){a={activeXError:!0}}return a};n.b=function(){if(navigator.plugins&&navigator.plugins.length>0){var a="application/x-shockwave-flash",e=navigator.mimeTypes;e&&e[a]&&e[a].enabledPlugin&&e[a].enabledPlugin.description&&(n.c=!0)}else if(-1==navigator.appVersion.indexOf("Mac")&&window.execScript)for(var t=-1,c=0;c<r.length&&-1==t;c++){var o=i(r[c].name);o.activeXError||(n.c=!0)}}()};  
                return b.c;
            })();

            if(isFlashInstalled){
                // Do something with flash
            }else{
                // Don't use flash  
                $('div.wflash').removeClass('hide');
            }
        </script>
    </body>
</html>