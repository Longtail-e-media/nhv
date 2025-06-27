<?php 
$checkLog = Log::chklog();
$preId = Config::getconfig_info();
$actionval = $preId->action;

if($checkLog=='0' and $actionval==1){ ?>
<style type="text/css">
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
<div class="divMessageBox"></div>      
<div class="MessageBoxContainer">
    <div class="MessageBoxMiddle">
    <span class="MsgTitle">Welcome to SynHawK Version 2.0</span>
    <p class="pText">
        This is your first login to SynHawk Apanel System. <br />
        Login with following credentials: <br />
        Username : <strong>admin</strong> <br />
        Password : <strong>apanel</strong> <br />
        You can change your password from your CMS user management.
    </p>
    <div class="MessageBoxButtonSection">
        <button id="success" class="btnfirst">Got It</button>
    </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".btnfirst").on("click",function(){                       
            var popAct=$(this).attr("id");
            if(popAct=='success'){
                $('.divMessageBox').fadeOut();
                $('.MessageBoxContainer').fadeOut(1000);
            }
        });
    });
</script>
<?php } ?>