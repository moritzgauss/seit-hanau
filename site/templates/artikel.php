<?php snippet('header') ?>

<main class="article-container">
  <article class="article-content">
  <h1><?= $page->title() ?></h1>
  <p>Von <?= $page->author() ?></p>
  <p> <?= $page->date()->toDate('d.m.Y') ?></p>
  <p><strong> <?= $page->subtitle() ?></strong></p>

    <div class="richtext">
      <?= $page->text()->kt() ?>
    </div>
  </article>
</main>

<?php snippet('footer') ?>
