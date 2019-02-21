/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */


const $ = require('jquery');
//import "popper.js/dist/popper";
import "bootstrap/dist/js/bootstrap.bundle.min"
import  "@fortawesome/fontawesome-free/js/all.js";
require('datatables.net-bs4/js/dataTables.bootstrap4.min');


//console.log('Hello Webpack Encore! Edit me in assets/js/app.js');


$(document).ready(()=>{
    console.log('hola depuis le encore');
    $("#sidebarToggle").on('click', function(e) {
        e.preventDefault();
        $("body").toggleClass("sidebar-toggled");
        $(".sidebar").toggleClass("toggled");
    });

    $('#dataTable').DataTable();

});