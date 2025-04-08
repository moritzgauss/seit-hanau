<?php snippet('header') ?>

<div class="collection-container">
    <!-- Interaktive Raster (4/3) -->
    <div class="drop-area">
        <?php for ($i = 0; $i < 6; $i++): ?>
            <div class="drop-zone" data-slot="<?= $i ?>"></div>
        <?php endfor; ?>
    </div>

    <!-- Cover-Auswahlleiste -->
<div class="cover-bar">
<?php foreach (page('archiv')->images() as $image): ?>
    <img src="<?= $image->url() ?>" class="draggable" draggable="true" data-cover="<?= $image->filename() ?>">
<?php endforeach; ?>

</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        let covers = document.querySelectorAll(".draggable");
        let dropZones = document.querySelectorAll(".drop-zone");

        covers.forEach(cover => {
            cover.addEventListener("dragstart", (e) => {
                e.dataTransfer.setData("text/plain", e.target.dataset.cover);
            });
        });

        dropZones.forEach(zone => {
            zone.addEventListener("dragover", (e) => e.preventDefault());

            zone.addEventListener("drop", (e) => {
                e.preventDefault();
                let coverId = e.dataTransfer.getData("text/plain");
                let img = document.querySelector(`[data-cover='${coverId}']`).cloneNode(true);
                zone.innerHTML = "";  
                zone.appendChild(img);
            });
        });
    });
</script>

<?php snippet('footer') ?>
