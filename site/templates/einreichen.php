<?php snippet('header') ?>

<h1>Artikel einreichen</h1>

<?php
if ($kirby->request()->is('POST')) {
    try {
        $articles = page('archiv');
        $title = $kirby->request()->get('title');
        
        // Sicheren Slug generieren
        $slug = Str::slug($title);
        
        // Artikel erstellen mit Kirbys createChild Methode
        $newArticle = $articles->createChild([
            'slug'     => $slug,
            'template' => 'article',
            'content'  => [
                'title'    => $title,
                'subtitle' => $kirby->request()->get('subtitle'),
                'author'   => $kirby->request()->get('author'),
                'date'     => $kirby->request()->get('date'),
                'category' => $kirby->request()->get('category'),
                'text'     => $kirby->request()->get('text')
            ]
        ]);

        // Status setzen
        $newArticle->changeStatus('unlisted');

        // Bildupload mit Kirbys Datei-API
        if ($file = $kirby->request()->file('image')) {
            try {
                $newArticle->createFile([
                    'source'   => $file->tmp_name(),
                    'filename' => $file->name(),
                ]);
            } catch (Exception $e) {
                // Bildupload fehlgeschlagen, aber Artikel wurde erstellt
            }
        }

        go($page->url() . '?success=1');
    } catch (Exception $e) {
        go($page->url() . '?error=' . urlencode($e->getMessage()));
    }
}

// Erfolgs- oder Fehlermeldung anzeigen
if (isset($_GET['success'])) {
    echo "<p class='success'>Artikel erfolgreich eingereicht und wartet auf Freigabe.</p>";
} elseif (isset($_GET['error'])) {
    echo "<p class='error'>Fehler: " . htmlspecialchars($_GET['error']) . "</p>";
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

        <label>Bild: <input type="file" name="image" accept="image/*"></label>

        <button type="submit">Absenden</button>
    </form>
</div>

<?php snippet('footer') ?>
