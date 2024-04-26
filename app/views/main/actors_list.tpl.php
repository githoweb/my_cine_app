<h1>Liste d'acteurs</h1>

<?php foreach ($actors as $actor) : ?>

  <div class="card">
    
    <div class="card-poster">
      <img src="<?= $actor->getPoster() ?>" alt="" />
    </div>
    <div class="card-data">      
      <h2 class="card-title"><?= $actor->getFirstname() ?> <?= $actor->getLastname() ?></h2>
      <div class="card-item">
        Naissance : <?= $actor->getBirth() ?>
      </div>
      <p>
        <?= $actor->getBiography() ?>
      </p>
    </div>
  </div>

<?php endforeach ?>