async function downloadArticles(selectedArticles) {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('p', 'mm', 'a4');
    
    // A4 dimensions and margins
    const pageWidth = 210;
    const pageHeight = 297;
    const margin = 20;
    const contentWidth = pageWidth - (2 * margin);
    
    let yPosition = margin;
    
    // Set default font styles
    doc.setFont('helvetica');
    
    for (const article of selectedArticles) {
        // Extract article data
        const title = article.dataset.title;
        const content = article.dataset.content;
        const author = article.dataset.author;
        const date = article.dataset.date;
        
        // Add new page for each article
        if (yPosition > margin) {
            doc.addPage();
            yPosition = margin;
        }
        
        // Title styling
        doc.setFontSize(24);
        doc.setFont('helvetica', 'bold');
        const titleLines = doc.splitTextToSize(title, contentWidth);
        doc.text(titleLines, margin, yPosition);
        yPosition += (titleLines.length * 10) + 5;
        
        // Metadata styling
        doc.setFontSize(12);
        doc.setFont('helvetica', 'italic');
        doc.text(`${author} - ${date}`, margin, yPosition);
        yPosition += 10;
        
        // Parse and render markdown content
        doc.setFont('helvetica', 'normal');
        doc.setFontSize(12);
        
        // Split content by markdown headers and paragraphs
        const sections = content.split(/\n(?=#{1,6}\s|[^#])/);
        
        for (const section of sections) {
            // Handle headers
            if (section.startsWith('#')) {
                const level = section.match(/^#+/)[0].length;
                const headerText = section.replace(/^#+\s/, '').trim();
                
                // Check for page break
                if (yPosition > pageHeight - margin) {
                    doc.addPage();
                    yPosition = margin;
                }
                
                // Header styling based on level
                const fontSize = 20 - (level * 2); // h1=20, h2=18, h3=16...
                doc.setFontSize(fontSize);
                doc.setFont('helvetica', 'bold');
                
                const headerLines = doc.splitTextToSize(headerText, contentWidth);
                doc.text(headerLines, margin, yPosition);
                yPosition += (headerLines.length * (fontSize/2)) + 5;
                
            } else {
                // Handle paragraphs
                doc.setFontSize(12);
                doc.setFont('helvetica', 'normal');
                
                // Process basic markdown
                let text = section
                    .replace(/\*\*(.*?)\*\*/g, '$1') // bold
                    .replace(/\*(.*?)\*/g, '$1')     // italic
                    .replace(/`(.*?)`/g, '$1')       // code
                    .trim();
                
                if (text) {
                    // Check for page break
                    if (yPosition > pageHeight - margin) {
                        doc.addPage();
                        yPosition = margin;
                    }
                    
                    const lines = doc.splitTextToSize(text, contentWidth);
                    doc.text(lines, margin, yPosition);
                    yPosition += (lines.length * 7) + 5;
                }
            }
        }
        
        // Add page separator
        doc.setDrawColor(200);
        doc.line(margin, pageHeight - margin, pageWidth - margin, pageHeight - margin);
    }
    
    // Save the PDF
    doc.save('meine-sammlung.pdf');
}