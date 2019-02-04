<?php
include('skrypty/router.class.php');
include('skrypty/kontroler.class.php');
include('skrypty/model.class.php');
include('skrypty/widok.class.php');
session_start();
if(!isset($_GET['url'])){
	$_GET['url'] = null;
}
$r = new Router($_GET['url']);
?>