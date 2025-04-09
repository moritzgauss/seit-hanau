import { jsPDF } from 'jspdf';

export function downloadArticles(articles) {
    const doc = new jsPDF({
        orientation: 'p',
        unit: 'mm',
        format: 'a4'
    });

    const pageWidth = doc.internal.pageSize.width;
    const margin = 20;
    const textWidth = pageWidth - (2 * margin);

    articles.forEach((article, index) => {
        if (index > 0) {
            doc.addPage();
        }

        // Set font styles
        doc.setFont('helvetica');
        doc.setFontSize(16);
        
        // Add title
        doc.text(article.dataset.title, margin, margin);

        // Add metadata
        doc.setFontSize(12);
        doc.text(`Von ${article.dataset.author}`, margin, margin + 10);
        doc.text(article.dataset.date, margin, margin + 15);

        // Add main content
        doc.setFontSize(11);
        const content = article.dataset.content;
        // Clean up the content
        const cleanContent = content.replace(/\r?\n/g, ' ').trim();
        const splitText = doc.splitTextToSize(cleanContent, textWidth);
        
        let yPosition = margin + 25;
        const lineHeight = 5;

        splitText.forEach(line => {
            if (yPosition > doc.internal.pageSize.height - margin) {
                doc.addPage();
                yPosition = margin;
            }
            doc.text(line, margin, yPosition);
            yPosition += lineHeight;
        });
    });

    doc.save('meine-sammlung.pdf');
}