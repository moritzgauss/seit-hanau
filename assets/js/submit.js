// simplemde-setup.js
document.addEventListener('DOMContentLoaded', function () {
    var simplemde = new SimpleMDE({
        element: document.getElementById("editor"),
        toolbar: [
            "bold",
            "italic",
            "strikethrough",
            "|",
            "heading-1",
            "heading-2",
            "heading-3",
            "|",
            "quote",
            "unordered-list",
            "|",
            "preview",
            "side-by-side",
            "fullscreen",
            "guide"
        ],
        spellChecker: false // Disable spell checking    
        // 
    });
});
