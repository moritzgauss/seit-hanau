<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $site->title()->esc() ?> – <?= $page->title()->esc() ?></title>
    <link rel="stylesheet" href="<?= url('assets/css/index.css') ?>">
    <link rel="stylesheet" href="<?= url('assets/css/footer.css') ?>">
    <link rel="stylesheet" href="<?= url('assets/css/article.css') ?>">
    <link rel="stylesheet" href="<?= url('assets/css/submit.css') ?>">
    <link rel="stylesheet" href="<?= url('assets/css/sammlung.css') ?>">
    <link rel="stylesheet" href="<?= url('assets/css/header.css') ?>">
</head>

<body>

<header class="header">
    <a href="<?= $site->url() ?>" class="header-title"><?= $site->title() ?></a>
    <button class="menu-toggle" aria-label="Toggle menu">☰</button>
    <nav class="nav">
        <div class="nav-links">
            <a href="#" id="load-search">Suche</a>
            <a href="<?= url('einreichen') ?>">Einreichen</a>
            <a href="<?= url('sammlung') ?>">Meine Sammlung</a>
            <a href="<?= url('archiv') ?>">Archiv</a>
        </div>
    </nav>
</header>

<div id="search-container" class="hidden"></div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchContainer = document.getElementById("search-container");
    const loadSearchButton = document.getElementById("load-search");

    loadSearchButton.addEventListener("click", function (event) {
        event.preventDefault();

        // Überprüfen, ob der Container bereits sichtbar ist
        if (!searchContainer.classList.contains("hidden")) {
            searchContainer.classList.add("hidden"); // Container ausblenden
            searchContainer.innerHTML = ""; // Inhalt leeren
            return;
        }

        fetch("search")
            .then(response => response.text())
            .then(data => {
                searchContainer.innerHTML = data;
                searchContainer.classList.remove("hidden");

                // Suche-Formular abfangen
                const searchForm = searchContainer.querySelector("form");
                if (searchForm) {
                    searchForm.addEventListener("submit", function (event) {
                        event.preventDefault();
                        const query = searchForm.querySelector("[name='q']").value;
                        
                        fetch("search?q=" + encodeURIComponent(query))
                            .then(response => response.text())
                            .then(results => {
                                searchContainer.innerHTML = results;
                            });
                    });
                }
            });
    });

    const menuToggle = document.querySelector('.menu-toggle');
    const nav = document.querySelector('.nav');

    menuToggle.addEventListener('click', () => {
        nav.classList.toggle('active');
    });
});
</script>

</body>
</html>
