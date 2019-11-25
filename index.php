<?php 
require 'vendor/autoload.php';
require 'inc/functions.php';
$klein = new \Klein\Klein();

$klein->respond(function($request, $response, $service) {
	$service->layout('views/main.php');
});

$klein->respond('GET', '/', function($request, $response, $service) {
  $service->title = 'Forside';
	$service->render('views/front.php');
});

$klein->respond('GET', '/ekstra', function($request, $response, $service) {
  $service->title = 'Ekstra';
	$service->render('views/ekstra.php');
});

$klein->respond('GET', '/info', function($request, $response, $service) {
  $service->title = 'God information';
	$service->render('views/info.php');
});

$klein->respond('GET', '/parkering', function($request, $response, $service) {

  $mysqli = new mysqli('localhost' , 'jensz12_je' , '' , 'jensz12_je');
  $mysqli->set_charset('utf8');

  if ($mysqli->connect_errno)
    die('Der kunne ikke oprettes forbindelse til databasen. Prøv igen om lidt');

  $sql = 'SELECT * FROM rest ORDER BY navn ASC';
  $result = $mysqli->query($sql);
 
  $rests = []; 

  while ($rest = $result->fetch_assoc()) {
    $rest['under_rests'] = get_under_rests($mysqli, $rest['id']);
    $rest['under_rests_lowercase'] = array_map('mb_strtolower', $under_rests);

    $rests[] = $rest;
  }

  $service->title = 'Parkeringsguide';
  $service->rests = $rests; 
	$service->render('views/parkering.php');
});

$klein->onHttpError(function ($code, $router) {
	if ($code == 404) {
		$service = $router->service();
		$service->title = '404 - Side ikke fundet';
		$service->render('views/404.php');
	}
});

$klein->dispatch();
?>
