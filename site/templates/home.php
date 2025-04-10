<?php snippet('header') ?>

<div class="intro-text">
    <p>Vor fast 5 Jahren wurden in Hanau neun Menschen aus rassistischen Motiven ermordet. Seitdem ist eine Vielzahl an Perspektiven und Erkenntnissen gewachsen, doch fehlt eine zentrale Plattform um diese Informationen zu bündeln.</p>
    <p>Auf dieser Seite möchte ich diesen Ort erschaffen. Hier sollen Menschen sich vernetzen können und auf leichtem Weg Zugang zu Informationen finden.</p>
</div>

<div class="article-grid">
    <?php foreach (page('archiv')->children()->filterBy('status', 'listed') as $post): ?>
        <div class="article-item">
            <a href="<?= $post->url() ?>">
                <?php if ($image = $post->image()): ?>
                    <img src="<?= $image->url() ?>" alt="<?= $post->title()->esc() ?>">
                <?php endif ?>
                <h2><?= $post->title()->esc() ?></h2>
                <p class="article-meta">
                    Von <?= $post->author()->esc() ?> | 
                    <?= $post->date()->toDate('d.m.Y') ?> | 
                    <?= $post->category()->esc() ?>
                </p>
            </a>
        </div>
    <?php endforeach ?>
</div>

<?php snippet('footer') ?>
