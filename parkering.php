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
<title>Delivery Aalborg - Just Eat</title>
<meta name="description" content="Delivery Aalborg - Just Eat">
<meta name="theme-color" content="#FA0029">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@jensz12">
<meta name="twitter:creator" content="@jensz12">
<meta name="twitter:title" content="Delivery Aalborg - Just Eat">
<meta name="twitter:description" content="Delivery Aalborg - Just Eat">
<meta name="twitter:image:src" content="https://justeat.jensz12.com/img/logo/1024.png">
<link rel="icon" href="https://justeat.jensz12.com/img/logo/1024.png">
<link rel="manifest" href="https://justeat.jensz12.com//manifest.json">
<link rel="apple-touch-icon" href="https://justeat.jensz12.com/img/logo/1024.png">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-title" content="Delivery Aalborg - Just Eat">
<link rel="apple-touch-startup-image" href="https://justeat.jensz12.com/img/andet/je-bg.png">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">
<link rel="stylesheet" href="/css/style.css">
<link href='https://fonts.googleapis.com/css?family=Roboto:100,300' rel='stylesheet' type='text/css'>
<script src="https://kit.fontawesome.com/774ac70799.js"></script>
<script>
	if ('serviceWorker' in navigator) {
  window.addEventListener('load', function() {
    navigator.serviceWorker.register('/js/sw.js').then(function(registration) {
      // Registration was successful
      console.log('ServiceWorker registration successful with scope: ', registration.scope);
    }).catch(function(err) {
      // registration failed :(
      console.log('ServiceWorker registration failed: ', err);
    });
  });
}
</script>
</head>
<body>
<header>
<nav class="navbar fixed-top navbar-dark navbar-expand-lg" style="background-color: #FA0029;">
<div class="container">
<a class="navbar-brand" href="/">
    <img src="/img/logo/je.png" width="30" height="30" alt="">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
        <a class="nav-link" href="/parkering"><i class="fal fa-parking fa-fw"></i> Parkeringsguide</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="/skade"><i class="fal fa-car-crash fa-fw"></i> Skadeark</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="/info"><i class="fal fa-info fa-fw"></i> God information</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="/extra"><i class="fal fa-download fa-fw"></i> Ekstra</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="https://cloud5.amcsgroup.com" target="_blank"><i class="fal fa-clipboard-list fa-fw"></i> TMS</a>
        </li>
      </li>
    </ul>
  </div>
</div>
</nav>
</header>
<div class="container">
  <div class="row">
    <div class="col-lg-12 col-md-12">
      <div class="jumbotron">
        <div class="text-center">
          <img src="https://justeat.jensz12.com/img/logo/1024.png" class="rounded" alt="" width="200px">
        </div>
          <h1>Parkeringsguide</h1>
        </div>
      <div class="jumbotron">
        <h1><i class="fal fa-search"></i> Søg efter restaurant</h1>
          <input type="text" autofocus class="form-control" id="rest-find" aria-describedby="" placeholder="Indtast navn">
      </div>
      <?php
      while ($rest = $result->fetch_assoc()):
      $under_rests = get_under_rests($rest['id']);
      $under_rests_lowercase = array_map('mb_strtolower', $under_rests);
      ?>
      <div class="jumbotron rest" data-search="<?php echo mb_strtolower($rest['navn']).' '.implode(' ', $under_rests_lowercase); ?>">
        <div class="text-center">
          <img src="/rest/<?php echo $rest['logo']; ?>" class="rounded" alt="" width="200px">
        </div>
          <h1><?php echo $rest['navn']; ?></h1>
          <h3><i class="fal fa-map-marker-check"></i> <?php echo $rest['adresse']; ?><?php if (!empty($rest['note'])) echo ' - '.$rest['note']; ?></h3>
          <?php if (!empty($rest['tlf'])): ?>
          <h4><i class="fal fa-phone"></i><a href="tel:<?php echo $rest['tlf']; ?>"> <?php echo $rest['tlf']; ?></a></h4>
          <?php endif; ?>
          <h4><i class="fal fa-parking"></i> Parkering:</h4>
          <p><?php echo $rest['parkering']; ?></p>
          <?php if (!empty($under_rests)): ?>
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
		      <p>Sidst opdateret: 24. oktober 2019. Just Eat er ikke ansvarlig for indholdet på denne side. Fejl og forbedringer kan sendes til <a href="mailto:jens@jensz12.com">Jens</a>. Tak til <a href="https://spirit55555.dk">Anders</a> for SQL & jquery kode</p>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"crossorigin="anonymous"></script>
<script>
var ref;
var update_list = function(){
    var rest_find = jQuery('#rest-find').val().toLowerCase();

    jQuery('.rest').each(function(){
        var search = jQuery(this).data('search').toString();

        if (search.indexOf(rest_find) !== -1)
            jQuery(this).removeClass('hide');
        else
            jQuery(this).addClass('hide');
    });
};

var wrapper = function(){
    window.clearTimeout(ref);
    ref = window.setTimeout(update_list, 150);
};

jQuery(function(){
    jQuery('#rest-find').keyup(function(){
        wrapper();
    });
});
</script>
</body>
</html>