<div class="jumbotron">
  <h1><i class="fal fa-search"></i> Søg efter restaurant</h1>
    <input type="text" autofocus class="form-control" id="rest-find" aria-describedby="" placeholder="Indtast navn">
</div>
<?php foreach ($this->rests as $rest): ?>
<div class="jumbotron rest" data-search="<?php echo mb_strtolower($rest['navn']).' '.implode(' ', $rest['under_rests_lowercase']); ?>">
  <div class="text-center">
    <img src="/rest/<?php echo $rest['logo']; ?>" class="rounded" alt="" width="200px">
  </div>
    <h1><?php echo $rest['navn']; ?></h1>
    <h3><i class="fal fa-map-marker-check"></i> <a href="https://www.google.com/maps/dir/?api=1&origin=&destination=<?php echo urlencode($rest['adresse']); ?>"><?php echo $rest['adresse']; ?></a><?php if (!empty($rest['note'])) echo ' - '.$rest['note']; ?></h3>
    <?php if (!empty($rest['tlf'])): ?>
    <h4><i class="fal fa-phone"></i><a href="tel:<?php echo $rest['tlf']; ?>"> <?php echo $rest['tlf']; ?></a></h4>
    <?php endif; ?>
    <h4><i class="fal fa-parking"></i> Parkering:</h4>
    <p><?php echo $rest['parkering']; ?></p>
    <?php if (!empty($rest['under_rests'])): ?>
    <p>Følgende restauranter er beliggende i <?php echo $rest['navn']; ?>:</p>
    <ul class="list-group list-group-flush">
      <?php foreach ($rest['under_rests'] as $under_rest): ?>
      <li class="list-group-item"><?php echo $under_rest; ?></li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>  
</div>
<?php endforeach; ?>
