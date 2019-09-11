<?php
$mysqli = new mysqli('localhost' , 'jensz12_je' , 't8ju05Mo7-Ua' , 'jensz12_je');
$mysqli->set_charset('utf8');

if ($mysqli->connect_errno)
  die('Der kunne ikke oprettes forbindelse til databasen. Prøv igen om lidt');

$sql = 'SELECT * FROM rest ORDER BY navn ASC';
$result = $mysqli->query($sql);

function get_under_rests($rest_id) {
  global $mysqli;

  $under_rests = array();
  $sql = "SELECT navn FROM under_rest WHERE rest_id = $rest_id ORDER BY navn ASC";
  $result = $mysqli->query($sql);

  while ($under_rest = $result->fetch_assoc())
    $under_rests[] = $under_rest['navn'];

  return $under_rests;
}
?>
<!DOCTYPE html>
<html lang="da">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no user-scalable=no">
<title>Just Eat - Parkering Aalborg</title>
<meta name="description" content="Just Eat - Parkering Aalborg">
<meta name="theme-color" content="#FA0029">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@jensz12">
<meta name="twitter:creator" content="@jensz12">
<meta name="twitter:title" content="Just Eat - Parkering Aalborg">
<meta name="twitter:description" content="Just Eat - Parkering Aalborg">
<meta name="twitter:image:src" content="https://justeat.jensz12.com/1024.png">
<link rel="icon" href="https://justeat.jensz12.com/1024.png">
<link rel="manifest" href="https://justeat.jensz12.com//manifest.json">
<link rel="apple-touch-icon" href="https://justeat.jensz12.com/1024.png">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-title" content="Just Eat - Parkering Aalborg">
<link rel="apple-touch-startup-image" href="https://justeat.jensz12.com/je-bg.png">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">
<link href='https://fonts.googleapis.com/css?family=Roboto:100,300' rel='stylesheet' type='text/css'>
<script src="https://kit.fontawesome.com/774ac70799.js"></script>
<style>
body {
	background-image: url(https://justeat.jensz12.com/je-back.jpg);
	background-repeat: no-repeat;
	background-size: cover;
	background-position: center center;
	background-attachment: fixed;
	height: 100%;
	font-family: 'Roboto', sans-serif;
	padding-top: 70px;
}
.img {
  margin: 30px;
}
.card {
  margin-bottom: 20px;
  background-color: #e9ecef;
}
.list-group-item {
  background-color: #e9ecef;
}
.jumbotron {
  margin-top:
}
a:link, a:visited {
	color: rgb(102, 102, 102);
	text-decoration: none;
}
a:hover, a:active {
	text-decoration: underline;
}
</style>
<script>
	if ('serviceWorker' in navigator) {
  window.addEventListener('load', function() {
    navigator.serviceWorker.register('/sw.js').then(function(registration) {
      // Registration was successful
      console.log('ServiceWorker registration successful with scope: ', registration.scope);
    }).catch(function(err) {
      // registration failed :(
      console.log('ServiceWorker registration failed: ', err);
    });
  });
}
</script>
<head>
<body>
<div class="container">
  <div class="row">
    <div class="col-lg-12 col-md-12">
      <div class="jumbotron">
        <div class="text-center">
          <img src="https://justeat.jensz12.com/1024.png" class="rounded" alt="" width="200px">
        </div>
          <h1>Parkerings Guide til Just Eat Delivery Aalborg</h1>
          <p>Jens' guide til parkering rundt omkring i Aalborg, når du skal hente mad.</a>
      </div>
      <div class="jumbotron">
        <h1><i class="fal fa-search"></i> Søg efter restaurant</h1>
        <form>
          <div class="form-group">
            <input type="text" class="form-control" id="restaurantSearch" aria-describedby="" placeholder="Indtast navn">
          </div>
        </form>
      </div>
      <?php while ($rest = $result->fetch_assoc()): ?>
      <div class="jumbotron">
        <div class="text-center">
          <img src="/rest/<?php echo $rest['logo']; ?>" class="rounded" alt="" width="200px">
        </div>
          <h1><?php echo $rest['navn']; ?></h1>
          <h3><i class="fal fa-map-marker-check"></i> <?php echo $rest['adresse']; ?><?php if (!empty($rest['note'])) echo ' - '.$rest['note']; ?></h3>
          <?php if (!empty($rest['tlf'])): ?>
          <h4><i class="fal fa-phone"></i> <?php echo $rest['tlf']; ?></h4>
          <?php endif; ?>
          <h4><i class="fal fa-parking"></i> Parkering:</h4>
          <p><?php echo $rest['parkering']; ?></p>
          <?php
          $under_rests = get_under_rests($rest['id']);
         
          if (!empty($under_rests)):
          ?>
          <p>Følgende restauranter er beliggende i <?php echo $rest['navn']; ?>:</p>
          <ul class="list-group list-group-flush">
            <?php foreach ($under_rests as $under_rest): ?>
            <li class="list-group-item"><?php echo $under_rest; ?></li>
            <?php endforeach; ?>
          </ul>
          <?php endif; ?>  
      </div>
      <?php endwhile; ?>
      <div class="card">
        <div class="card-body">
          <p>Senest opdateret: 11. September 2019. Just Eat er ikke ansvarlig for indholdet på denne side. Fejl og forbedringer kan sendes til <a href="mailto:jens@jensz12.com">Jens</a>. Tak til <a href="https://spirit55555.dk">Anders</a> for SQL kode</p>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"crossorigin="anonymous"></script>
</body>
</html>