<?php
require 'VerifyController.php';

$controller = new VerifyController();
$controller->verifyToken($_GET['token']);