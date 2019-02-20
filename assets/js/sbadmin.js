const $ = require('jquery');

require('datatables.net-bs4/js/dataTables.bootstrap4.min');


//console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
console.log('hola depuis le encore');

$(document).ready(()=>{
    $("#sidebarToggle").on('click', function(e) {
        e.preventDefault();
        $("body").toggleClass("sidebar-toggled");
        $(".sidebar").toggleClass("toggled");
    });

    $('#dataTable').DataTable();

});