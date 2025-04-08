document.addEventListener("DOMContentLoaded", function () {
    const searchToggle = document.getElementById("search-toggle");
    const searchContainer = document.getElementById("search-container");
    const searchInput = document.getElementById("search-input");

    if (!searchToggle || !searchContainer) return;

    searchToggle.addEventListener("click", function (event) {
        event.preventDefault();
        searchContainer.classList.toggle("hidden");
        if (!searchContainer.classList.contains("hidden")) {
            searchInput.focus(); // Focus on input when shown
        }
    });

    searchInput.addEventListener("input", function () {
        const query = searchInput.value.trim();
        if (query.length < 2) {
            document.getElementById("search-results").innerHTML = "";
            return;
        }

        fetch("/search-results?q=" + encodeURIComponent(query))
            .then(response => response.text())
            .then(html => {
                document.getElementById("search-results").innerHTML = html;
            })
            .catch(error => console.error("Search error:", error));
    });
});
