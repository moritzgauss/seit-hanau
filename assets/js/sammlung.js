document.addEventListener('DOMContentLoaded', () => {
    const gridArea = document.querySelector('.grid-area');
    const maxArticles = 12; // Update max articles to 16
    let placedArticles = [];

    // Clear any existing content
    gridArea.innerHTML = '';

    // Create 4x4 grid (16 zones) instead of 6x6
    for (let i = 0; i < 12; i++) {
        const dropZone = document.createElement('div');
        dropZone.className = 'drop-zone';
        dropZone.dataset.index = i;
        gridArea.appendChild(dropZone);
    }

    const articles = document.querySelectorAll('.article-thumbnail');
    articles.forEach(article => {
        article.setAttribute('draggable', true);
        article.addEventListener('dragstart', handleDragStart);
        article.addEventListener('dragend', handleDragEnd);
    });

    const dropZones = document.querySelectorAll('.drop-zone');
    dropZones.forEach(zone => {
        zone.addEventListener('dragover', handleDragOver);
        zone.addEventListener('drop', handleDrop);
        zone.addEventListener('dragenter', handleDragEnter);
        zone.addEventListener('dragleave', handleDragLeave);
    });

    function handleDragStart(e) {
        if (this.classList.contains('placed')) return;
        e.dataTransfer.setData('text/plain', this.dataset.articleId);
        this.classList.add('dragging');
    }

    function handleDragEnd() {
        this.classList.remove('dragging');
    }

    function handleDragOver(e) {
        e.preventDefault();
    }

    function handleDragEnter(e) {
        e.preventDefault();
        if (!this.hasAttribute('data-occupied')) {
            this.classList.add('hover');
        }
    }

    function handleDragLeave(e) {
        this.classList.remove('hover');
    }

    function handleDrop(e) {
        e.preventDefault();
        this.classList.remove('hover');

        if (this.hasAttribute('data-occupied') || placedArticles.length >= maxArticles) return;

        const articleId = e.dataTransfer.getData('text/plain');
        const article = document.querySelector(`[data-article-id="${articleId}"]`);
        
        if (!article || article.classList.contains('placed')) return;

        const clone = article.cloneNode(true);
        this.appendChild(clone);
        this.setAttribute('data-occupied', articleId);
        article.classList.add('placed');
        placedArticles.push(articleId);

        saveConfiguration();
        updateDownloadButton();
    }

    function updateDownloadButton() {
        const downloadButton = document.querySelector('.download-collection-btn');
        downloadButton.disabled = placedArticles.length === 0;
    }

    // Initialize button state
    updateDownloadButton();

    // Add remove functionality
    gridArea.addEventListener('click', (e) => {
        const article = e.target.closest('.article-thumbnail');
        if (!article) return;

        const zone = article.parentElement;
        const articleId = zone.getAttribute('data-occupied');
        
        if (articleId) {
            const originalArticle = document.querySelector(`.article-bar [data-article-id="${articleId}"]`);
            originalArticle.classList.remove('placed');
            zone.removeAttribute('data-occupied');
            article.remove();
            placedArticles = placedArticles.filter(id => id !== articleId);
            
            saveConfiguration();
            updateDownloadButton();
        }
    });

    function saveConfiguration() {
        const config = {
            articles: placedArticles,
            positions: Array.from(dropZones).map(zone => zone.getAttribute('data-occupied')).filter(Boolean)
        };

        // Save to localStorage for now (could be replaced with server-side storage)
        localStorage.setItem('sammlung-config', JSON.stringify(config));
    }
});