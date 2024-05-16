



$(document).ready(function() {

        
    $('#saveAs').click(async function() {
        

        let elem = document.getElementById('pdfContent');
        

        let fname = "docs";
        let fileName = fname.concat('.pdf');

        var opt = {
            margin:       0,
            pagebreak:    { mode: ['avoid-all', 'css', 'legacy'] },
            filename:     fileName,
            image:        { type: 'png' },
            html2canvas:  { scale: 2, scrollY: 0, scrollX: 0 },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'p' }
        };
        await html2pdf().set(opt).from(elem).toPdf().save();
       

       
    });


});