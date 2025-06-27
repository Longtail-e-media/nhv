<!-- Dashbard Icons -->
<div class="row mrg20B">
<?php $usid = isset($_SESSION['u_id'])?$_SESSION['u_id']:0;  
$urow = User::field_by_id($usid, 'permission');
$mod_chk = !empty($urow)?unserialize($urow):array(); 
$parents = Module::find_all_parent();
  $count = 0;
  $option = array();
  if($parents){
    $option = array(1=>'bg-blue-alt',2=>'bg-orange',3=>'bg-red', 4=>'bg-azure',5=>'bg-green',6=>'bg-blue');
    foreach ($parents as $row) { 
      if(in_array($row->id, $mod_chk)) { 
        $countNo =  ($count++%6==0)?$count=1:$count;
        $chldmenu = Module::find_child_by($row->id);
        $admlink  = !empty($chldmenu)?'javascript:void(0);':ADMIN_URL.$row->link;?>
        <div class="col-md-2 mrg20B">
          <a href="<?php echo $admlink;?>" class="tile-button btn <?php echo $option[$countNo];?>" title="<?php echo $row->name;?>">
            <div class="tile-content-wrapper">
              <i class="glyph-icon <?php echo $row->icon_link;?>"></i>
            </div>
            <div class="tile-footer">
              <?php echo $row->name;?>                
            </div>
          </a>
        </div>
        <?php }
    }
  } ?>
</div>

<!-- Dashboard Section -->
<div class="col-md-12">
<!-- Log section -->
<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
   var oTable = $('#example').dataTable({
      "bJQueryUI": true,
      "sPaginationType": "full_numbers"      
    });
	oTable.fnSetColumnVis( 0,false );
  } );
</script>
<h3>User Log</h3>
<div class="example-box">
    <div class="example-code">
        <table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
            <thead>
                <tr class="hide">                   
                   <th>S.N</th>
				           <th><?php echo $GLOBALS['basic']['action'];?></th>
                   <th>User</th>
                   <th>I.P. Address</th>
                   <th><?php echo $GLOBALS['basic']['dateTime'];?></th>
                </tr>
            </thead>         
            
            <tbody>
                <?php
                $logs = Log::find_by_sql("SELECT * FROM tbl_logs ORDER BY id DESC ");
				$sn=1;
                foreach($logs as $log): 
                  $logaction = Logaction::find_by_id($log->user_action);
                  if($logaction):
                ?>
                    <tr class="tr_logs"> 
					<td><?php echo $sn++;?></td>                       
                        <td>                          
                          <span class="badge btn <?php echo $logaction->bgcolor;?> mrg5L mrg10R float-left">
                            <i class="glyph-icon <?php echo $logaction->icon;?>"></i>
                            <?php echo $logaction->title;?>
                          </span>
                          <span class="float-left"><?php echo $log->action;?></span>
                        </td>
                        <td>
                          <span class="badge btn bg-orange radius-all-10 mrg5L mrg10R float-left">
                            <i class="glyph-icon icon-user"></i>                            
                          </span>
                          <span class="float-left">Super Admin</span>
                        </td>
                        <td>
                          <span class="badge btn bg-azure radius-all-10 mrg5L mrg10R float-left">
                            <i class="glyph-icon icon-bug"></i>                            
                          </span>
                          <span class="float-left"><?php echo $log->ip_track;?></span>                          
                        </td>
                        <td>
                          <span class="badge btn bg-gray radius-all-10 mrg5L mrg10R float-left">
                            <i class="glyph-icon icon-clock-o"></i>                            
                          </span>
                          <span class="float-left"><?php echo $log->registered;?></span>                          
                        </td>
                    </tr>
                <?php endif; endforeach; ?>                                            
            </tbody>
        </table>
        <a class="btn medium primary-bg" href="javascript:void(0);" onclick="Clearlog();">
            <span class="glyph-icon icon-separator float-right">
              <i class="glyph-icon icon-trash-o"></i>
            </span>
            <span class="button-content"> Clear log </span>
        </a>
    </div>    
</div>