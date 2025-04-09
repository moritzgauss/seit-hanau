<?php snippet('header') ?>

<main class="article-container">
  <article class="article-content">
    <h1><?= $page->title() ?></h1>
    <p>Von <?= $page->author() ?></p>
    <p><?= $page->date()->toDate('d.m.Y') ?></p>
    <p><strong><?= $page->subtitle() ?></strong></p>

    <div class="richtext">
      <?= $page->text()->kt() ?>
    </div>

    <button class="download-btn" onclick="downloadArticle('<?= $page->id() ?>', '<?= $page->title()->esc() ?>', '<?= $page->author()->esc() ?>', '<?= $page->date()->toDate('d.m.Y') ?>', '<?= $page->text()->esc() ?>')">
      Als PDF herunterladen
    </button>
  </article>
</main>

<script src="<?= url('assets/js/jspdf.umd.min.js') ?>"></script>
<script>
window.jsPDF = window.jspdf.jsPDF;

function downloadArticle(articleId, title, author, date, content) {
    try {
        const doc = new jsPDF({
            orientation: 'p',
            unit: 'mm',
            format: 'a4'
        });

        const pageWidth = doc.internal.pageSize.width;
        const margin = 20;
        const textWidth = pageWidth - (2 * margin);

        // Set font styles
        doc.setFont('helvetica');
        
        // Add title
        doc.setFontSize(16);
        doc.text(title, margin, margin);

        // Add metadata
        doc.setFontSize(12);
        doc.text(`Von ${author}`, margin, margin + 10);
        doc.text(date, margin, margin + 15);

        // Add main content
        doc.setFontSize(11);
        
        // Clean up the content
        const cleanContent = content.replace(/\r?\n/g, ' ').trim();
        const splitText = doc.splitTextToSize(cleanContent, textWidth);
        
        // Calculate if we need a new page based on content height
        let yPosition = margin + 25;
        const lineHeight = 5; // approximately 5mm line height

        splitText.forEach((line, index) => {
            if (yPosition > doc.internal.pageSize.height - margin) {
                doc.addPage();
                yPosition = margin;
            }
            doc.text(line, margin, yPosition);
            yPosition += lineHeight;
        });

        doc.save(`artikel-${articleId}.pdf`);
    } catch (error) {
        console.error('PDF generation failed:', error);
        alert('PDF konnte nicht erstellt werden.');
    }
}
</script>

<?php snippet('footer') ?>
