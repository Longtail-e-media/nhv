<?php $gcount = $gapi->analytics_total(); 
$opsystem = $gapi->analytics_opsystem(); 
$browser = $gapi->analytics_browser();
$country = $gapi->analytics_country();
$days = $gapi->analytics_days(); 
$gpages = $gapi->analytics_pages(); ?> 
<div class="row mrg20B">
    <div class="col-md-8 mrg20B">
        <canvas id="myChart" height="115"></canvas>
    </div>
    <div class="col-md-4 mrg20B">
        <div class="row">
            <div class="col-md-6 mrg20B">                
                <div class="tile-button btn bg-green">            
                    <div class="tile-content-wrapper">
                        <i class="glyph-icon"><?php echo !empty($gcount[0])?$gcount[0]:0;?></i>
                    </div>
                    <div class="tile-footer">
                        Weekly User           
                    </div>                               
                </div>                              
            </div>
            <div class="col-md-6 mrg20B">                
                <div class="tile-button btn bg-blue-alt">            
                    <div class="tile-content-wrapper">
                        <i class="glyph-icon"><?php echo !empty($gcount[1])?$gcount[1]:0;?></i>
                    </div>
                    <div class="tile-footer">
                        Weekly New User         
                    </div>                               
                </div>                              
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mrg20B">                
                <div class="tile-button btn bg-orange">            
                    <div class="tile-content-wrapper">
                        <i class="glyph-icon"><?php echo !empty($gcount[2])?$gcount[2]:0;?></i>
                    </div>
                    <div class="tile-footer">
                        Weekly Session           
                    </div>                               
                </div>                              
            </div>
            <div class="col-md-6 mrg20B">    
                <div class="tile-button btn bg-azure">            
                    <div class="tile-content-wrapper">
                        <i class="glyph-icon"><?php echo !empty($gcount[3])?$gcount[3]:0;?></i>
                    </div>
                    <div class="tile-footer">
                        Weekly Page View           
                    </div>                               
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mrg20B">
    <div class="col-md-4 mrg20B">  
        <table cellpadding="0" cellspacing="0" border="0" class="table">
            <thead>
                <tr>                   
                   <th>Country</th>
                   <th>Users</th>
                </tr>
            </thead> 
            <tbody>
            <?php if(!empty($country)) {
                foreach($country as $ck=>$cv) {
                    echo '<tr>
                        <td>'.$ck.'</td>
                        <td class="text-center">'.$cv.'</td>
                    </tr>';
                }
            } ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-4 mrg20B">  
        <table cellpadding="0" cellspacing="0" border="0" class="table">
            <thead>
                <tr>                   
                   <th>Browser</th>
                   <th>Users</th>
                </tr>
            </thead> 
            <tbody>
            <?php if(!empty($browser)) {
                foreach($browser as $bk=>$bv) {
                    echo '<tr>
                        <td>'.$bk.'</td>
                        <td class="text-center">'.$bv.'</td>
                    </tr>';
                }
            } ?>
            </tbody>
        </table>
        <table cellpadding="0" cellspacing="0" border="0" class="table">
            <thead>
                <tr>                   
                   <th>Operating System</th>
                   <th>Users</th>
                </tr>
            </thead> 
            <tbody>
            <?php if(!empty($opsystem)) {
                foreach($opsystem as $ok=>$ov) {
                    echo '<tr>
                        <td>'.$ok.'</td>
                        <td class="text-center">'.$ov.'</td>
                    </tr>';
                }
            } ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-4 mrg20B" style="overflow-x: auto;">  
        <table cellpadding="0" cellspacing="0" border="0" class="table">
            <thead>
                <tr>                   
                   <th>Page View</th>
                   <th>Users</th>
                </tr>
            </thead> 
            <tbody>
            <?php if(!empty($gpages)) {
                foreach($gpages['title'] as $pk=>$pv) {
                    echo '<tr>
                        <td><a href="'.BASE_URL.$gpages['title'][$pk].'" target="_blank">'.$gpages['title'][$pk].'</td>
                        <td class="text-center">'.$gpages['total'][$pk].'</td>
                    </tr>';
                }
            } ?>
            </tbody>
        </table>
    </div>
</div>

<?php if(!empty($days)) { ?> 
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    type: 'line',
    data: {
        showLines: false,
        labels: <?php echo json_encode($days['date']);?>,
        datasets: [{
            label: 'Weekly Visitor',
            backgroundColor: 'rgba(0, 0, 0, 0)',
            borderColor: 'rgba(0, 0, 0, 1)',
            data: <?php echo json_encode($days['total']);?>
        }]
    },

    // Configuration options go here
    options: { legend: false }
});</script>
<?php } ?>