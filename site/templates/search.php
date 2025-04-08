<form class="search-form">
  <input type="search" aria-label="Suche..." name="q" value="<?= html($query) ?>" placeholder="Suche...">
  <input type="submit" value="Suche">
</form>

<table class="search-results">
  <thead>
    <tr>
      <th>Titel</th>
      <th>Datum</th>
      <th>Autor</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($results as $result): ?>
      <tr>
        <td data-label="Titel">
          <a href="<?= $result->url() ?>">
            <?= $result->title() ?>
          </a>
        </td>
        <td data-label="Datum"><?= $result->date()->toDate('d.m.Y') ?></td>
        <td data-label="Autor"><?= $result->author() ?></td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>



