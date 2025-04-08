// Sortierung der Tabelle nach Spalten
function sortTable(n) {
    const table = document.querySelector(".archive-table");
    let rows = Array.from(table.querySelectorAll("tbody tr"));
    let isNumeric = n === 1; // Datum ist die einzige numerische Spalte

    rows.sort((rowA, rowB) => {
        const cellA = rowA.cells[n].innerText.trim();
        const cellB = rowB.cells[n].innerText.trim();

        if (isNumeric) {
            const dateA = new Date(cellA);
            const dateB = new Date(cellB);
            return dateB - dateA; // Vergleichen von Datum (neueste zuerst)
        } else {
            return cellA.localeCompare(cellB); // Vergleichen von Strings (alphabetisch)
        }
    });

    // Füge die sortierten Reihen wieder in die Tabelle ein
    rows.forEach(row => table.querySelector("tbody").appendChild(row));

    // Event-Listener erneut hinzufügen
    attachHoverEffectToItems();
}

// Event-Listener für Hover-Effekt auf .archive-item hinzufügen
function attachHoverEffectToItems() {
    document.querySelectorAll('.archive-item').forEach(item => {
        const cover = item.querySelector('.archive-cover');

        item.addEventListener('mousemove', (e) => {
            const rect = item.getBoundingClientRect(); // Holen Sie sich die Position des Elements
            const offsetX = e.pageX - rect.left; // Berechnen Sie den Abstand vom linken Rand des Items
            const offsetY = e.pageY - rect.top; // Berechnen Sie den Abstand vom oberen Rand des Items

            // Positioniere das Cover an der Cursor-Position relativ zum .archive-item
            cover.style.left = `${offsetX}px`;
            cover.style.top = `${offsetY}px`;
        });

        item.addEventListener('mouseenter', () => {
            // Zeige das Cover, wenn der Mauszeiger über dem Artikel ist
            cover.style.opacity = 1;
        });

        item.addEventListener('mouseleave', () => {
            // Verstecke das Cover, wenn der Mauszeiger den Artikel verlässt
            cover.style.opacity = 0;
        });
    });
}

// Beim Laden der Seite Event-Listener hinzufügen
document.addEventListener("DOMContentLoaded", function() {
    // Füge Hover-Effekte zu den Artikeln hinzu, wenn die Seite geladen wird
    attachHoverEffectToItems();
});