<?php snippet('header') ?>

<h1>Archiv</h1>

<!-- Tabelle für das Archiv -->
<table class="archive-table">
    <thead>
        <tr>
            <th onclick="sortTable(0)">Titel</th>
            <th onclick="sortTable(1)">Datum</th>
            <th onclick="sortTable(2)">Autor</th>
            <th onclick="sortTable(3)">Kategorie</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach (page('archiv')->children() as $post): ?>
            <tr class="archive-item">
                <td data-label="Titel">
                    <a href="<?= $post->url() ?>"><?= $post->title() ?></a>
                    <?php if ($image = $post->image()): ?>
                        <img class="archive-cover" src="<?= $image->url() ?>" alt="<?= $post->title()->esc() ?>">
                    <?php endif ?>
                </td>
                <td data-label="Datum"><?= $post->date()->toDate('d.m.Y') ?></td>
                <td data-label="Autor"><?= $post->author() ?></td>
                <td data-label="Kategorie"><?= $post->category() ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php snippet('footer') ?>

