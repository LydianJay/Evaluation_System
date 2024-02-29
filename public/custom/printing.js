



$(document).ready(function() {

        
    $('#saveAs').click(async function() {
        

        let elem = document.getElementById('pdfContent');


        let fname = document.getElementById('fName').textContent;
        let fileName = fname.concat('-CourseEvaluation.pdf');
        

        var opt = {
            margin:       0,
            pagebreak:    { mode: ['css', 'legacy'] },
            filename:     fileName,
            image:        { type: 'png' },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
        };
        
        await html2pdf().set(opt).from(elem).save();
       

       
    });


});