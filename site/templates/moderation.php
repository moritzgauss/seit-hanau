<?php
$kirby = kirby();
$user = $kirby->user();

// Wenn kein Benutzer eingeloggt ist, zeige das Login-Formular
if (!$user):
    if ($kirby->request()->is('POST') && get('email') && get('password')) {
        try {
            $kirby->auth()->login(get('email'), get('password'));
            go('moderation'); // Nach Login zur Moderation
        } catch (Exception $e) {
            $error = 'Falsche Zugangsdaten!';
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background: #f4f4f4;
            }
            .login-box {
                background: white;
                padding: 20px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                border-radius: 5px;
                text-align: center;
            }
            .login-box input {
                display: block;
                width: 100%;
                padding: 10px;
                margin: 10px 0;
            }
            .login-box button {
                padding: 10px;
                background: blue;
                color: white;
                border: none;
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <div class="login-box">
            <h2>Login</h2>
            <?php if (isset($error)): ?>
                <p style="color:red"><?= $error ?></p>
            <?php endif; ?>
            <form method="POST">
                <input type="email" name="email" placeholder="E-Mail" required>
                <input type="password" name="password" placeholder="Passwort" required>
                <button type="submit">Anmelden</button>
            </form>
        </div>
    </body>
    </html>

<?php
    exit;
endif;

// Logout-Funktion
if (get('logout')) {
    $kirby->auth()->logout();
    go('login'); // Nach Logout zur Login-Seite
}

// Unmoderierte Artikel abrufen
$articles = page('articles')->children()->filterBy('status', 'unlisted');

// Wenn ein Artikel freigegeben werden soll
if ($kirby->request()->is('POST') && get('approve')) {
    $article = page(get('approve'));
    if ($article) {
        try {
            $article->changeStatus('listed'); // Artikel veröffentlichen
            go('moderation'); // Seite neu laden
        } catch (Exception $e) {
            $error = "Fehler: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        .moderation-item {
            background: #fff;
            padding: 15px;
            margin: 10px auto;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
        }
        .moderation-item h2 {
            margin: 0;
            font-size: 18px;
        }
        .moderation-item p {
            font-size: 14px;
            color: #333;
        }
        .moderation-item button {
            background: green;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .logout {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>
<body>

<h1>Artikel zur Prüfung</h1>
<a class="logout" href="?logout=true">Logout</a>

<?php if (isset($error)): ?>
    <p class="error"><?= $error ?></p>
<?php endif; ?>

<?php foreach ($articles as $post): ?>
    <div class="moderation-item">
        <h2><?= $post->title() ?></h2>
        <p><strong>Autor:</strong> <?= $post->author() ?></p>
        <p><strong>Datum:</strong> <?= $post->date()->toDate('d.m.Y') ?></p>
        <p><?= $post->text()->excerpt(100) ?></p>

        <form method="POST">
            <input type="hidden" name="approve" value="<?= $post->id() ?>">
            <button type="submit">Freigeben</button>
        </form>
    </div>
<?php endforeach; ?>

</body>
</html>
