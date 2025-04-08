<?php snippet('header') ?>

<h1>Artikel einreichen</h1>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $title = get('title');
        $subtitle = get('subtitle');
        $author = get('author');
        $date = get('date');
        $category = get('category');
        $text = get('text');
        $image = $_FILES['image'] ?? null;

        $articles = page('archiv'); // Zielordner für Artikel

        // Artikel als Entwurf anlegen
        $newArticle = $articles->createChild([
            'slug' => str::slug($title),
            'template' => 'article',
            'content' => [
                'title' => $title,
                'subtitle' => $subtitle,
                'author' => $author,
                'date' => $date,
                'category' => $category,
                'text' => $text,
            ]
        ]);

        // Artikel auf "In Prüfung" setzen
        $newArticle->changeStatus('unlisted');

        // Falls ein Bild hochgeladen wurde
        if ($image && $image['size'] > 0) {
            $newArticle->createFile([
                'source' => $image['tmp_name'],
                'filename' => $image['name']
            ]);
        }

        echo "<p class='success'>Artikel erfolgreich eingereicht und wartet auf Freigabe.</p>";
    } catch (Exception $e) {
        echo "<p class='error'>Fehler: " . $e->getMessage() . "</p>";
    }
}
?>

<div class="form-container">
    <form method="post" enctype="multipart/form-data">
        <label>Titel: <input type="text" name="title" required></label>
        <label>Untertitel: <input type="text" name="subtitle"></label>
        <label>Autor: <input type="text" name="author" required></label>
        <label>Datum: <input type="date" name="date" required value="<?= date('Y-m-d') ?>"></label>

        <label>Kategorie:
            <select name="category" required>
                <option value="news">News</option>
                <option value="meinung">Meinung</option>
                <option value="interview">Interview</option>
                <option value="reportage">Reportage</option>
                <option value="sonstiges">Sonstiges</option>
            </select>
        </label>

        <label>Artikelinhalt:</label>
        <textarea name="text" required></textarea>

        <label>Bild: <input type="file" name="image"></label>

        <button type="submit">Absenden</button>
    </form>
</div>

<?php snippet('footer') ?>
