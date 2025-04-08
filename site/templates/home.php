<?php snippet('header') ?>

    <div class="article-grid">
    <?php foreach (page('archiv')->children() as $post): ?>
        <div class="article-item">
                <a href="<?= $post->url() ?>">
                    <?php if ($image = $post->image()): ?>
                        <img src="<?= $image->url() ?>" alt="<?= $post->title()->esc() ?>">
                    <?php endif ?>
                </a>
            </div>
        <?php endforeach ?>
    </div>
</div>

<?php snippet('footer') ?>
