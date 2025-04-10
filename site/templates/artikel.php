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

    <button class="download-btn" onclick="downloadArticle(this)" data-id="<?= $page->id() ?>" data-title="<?= $page->title()->esc() ?>" data-author="<?= $page->author()->esc() ?>" data-date="<?= $page->date()->toDate('d.m.Y') ?>">
      Als PDF herunterladen
    </button>
    <div id="article-content" style="display: none;">
      <?= $page->text()->kt() ?>
    </div>
  </article>
</main>

<script src="<?= url('assets/js/jspdf.umd.min.js') ?>"></script>
<script>
window.jsPDF = window.jspdf.jsPDF;

function downloadArticle(button) {
    try {
        const articleId = button.dataset.id;
        const title = button.dataset.title;
        const author = button.dataset.author;
        const date = button.dataset.date;
        const content = document.getElementById('article-content').innerHTML;

        const doc = new jsPDF({
            orientation: 'p',
            unit: 'mm',
            format: 'a4'
        });

        // A4 dimensions and margins
        const pageWidth = 210;
        const pageHeight = 297;
        const margin = 20;
        const contentWidth = pageWidth - (2 * margin);
        let yPosition = margin;

        // Title styling
        doc.setFont('helvetica', 'bold');
        doc.setFontSize(24);
        const titleLines = doc.splitTextToSize(title, contentWidth);
        doc.text(titleLines, margin, yPosition);
        yPosition += (titleLines.length * 10) + 5;

        // Metadata styling
        doc.setFontSize(12);
        doc.setFont('helvetica', 'italic');
        doc.text(`Von ${author} - ${date}`, margin, yPosition);
        yPosition += 10;

        // Process content
        doc.setFont('helvetica', 'normal');
        doc.setFontSize(12);

        // Convert HTML to plain text and split into paragraphs
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = content;
        const textContent = tempDiv.textContent;
        const paragraphs = textContent.split('\n').filter(p => p.trim());

        for (const paragraph of paragraphs) {
            // Check for page break
            if (yPosition > pageHeight - (margin + 20)) {
                doc.addPage();
                yPosition = margin;
            }

            const lines = doc.splitTextToSize(paragraph.trim(), contentWidth);
            doc.text(lines, margin, yPosition);
            yPosition += (lines.length * 7) + 5;
        }

        // Add footer line
        for (let i = 1; i <= doc.internal.getNumberOfPages(); i++) {
            doc.setPage(i);
            doc.setDrawColor(200);
            doc.line(margin, pageHeight - 15, pageWidth - margin, pageHeight - 15);
        }

        // Save with just the title as filename (remove special characters)
        const safeTitle = title.replace(/[^a-z0-9]/gi, '-').toLowerCase();
        doc.save(`${safeTitle}.pdf`);

    } catch (error) {
        console.error('PDF generation failed:', error);
        alert('PDF konnte nicht erstellt werden. Fehler: ' + error.message);
    }
}
</script>

<?php snippet('footer') ?>
