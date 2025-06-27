<?php
/*
* header module
*/

$header = '';

$header .= '<section class="header" id="myHeader">
                <div class="top-header">
                    <div class="container">
                        <!--====== HELP LINE & EMAIL ID ==========-->
                        <div class="col-md-12 col-sm-11 col-xs-11 head_right head_right_all">
                            <div class="logo" >
                                '.$jVars['site:logo'].'
                            </div>
                            <jcms:module:helplinetop/>   
                        </div>    
                    </div> 
                </div>   
              
                <div class="container">
                    <nav class="navbar navbar-inverse">
                        <div>
                        <!-- Brand and toggle get grouped for better mobile display(MOBILE MENU) -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <!--<img src="images/logo.png" alt="Image not Found" class="mob_logo" />-->
                        </div>
                        <!-- NAVIGATION MENU -->
                        <div class="collapse navbar-collapse" id="myNavbar">
                            <!-- Menu module -->
                            <jcms:module:menu/>
                        </div>
                        </div>
                    </nav>
                </div>
               
   
            <!--====== BRANDING LOGO ==========-->
            </section>';

$jVars['module:header']=$header;                

?>