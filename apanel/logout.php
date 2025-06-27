<?php
require_once("../includes/initialize.php");
$session->clear('u_id');
$session->clear('accesskey');
redirect_to(BASE_URL.'apanel/login');
?>