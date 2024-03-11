



$(document).ready(function() {

        
    $('#saveAs').click(async function() {
        

        let elem = document.getElementById('pdfContent');
        console.log("printing");

        let fname = document.getElementById('fName').textContent;
        let fileName = fname.concat('.pdf');

        var opt = {
            margin:       0,
            pagebreak:    { mode: ['css', 'legacy'] },
            filename:     fileName,
            image:        { type: 'png' },
            html2canvas:  { scale: 1, scrollY: 0 },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
        };
        
        await html2pdf().set(opt).from(elem).save();
       

       
    });


});