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

require('./bootstrap-datepicker.min');
require('./bootstrap-datepicker.fr.min');
require('./chartarea');
//ajouter toutes les configs de data tables dans cette objet option_tables
let option_tables={
    "bFilter": false,
    "bInfo": false,
    "bLengthChange": false,
    "language":{
        processing:     "Traitement en cours...",
        search:         "Rechercher&nbsp;:",
        lengthMenu:    "Afficher _MENU_ &eacute;l&eacute;ments",
        info:           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
        infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
        infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        infoPostFix:    "",
        loadingRecords: "Chargement en cours...",
        zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
        emptyTable:     "Aucune donnée disponible dans le tableau",
        paginate: {
            first:      "Premier",
            previous:   "Pr&eacute;c&eacute;dent",
            next:       "Suivant",
            last:       "Dernier"
        },
        aria: {
            sortAscending:  ": activer pour trier la colonne par ordre croissant",
            sortDescending: ": activer pour trier la colonne par ordre décroissant"
        }
    }
};
//console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
let option_calendar = {
    language:'fr',
    format: 'dd/mm/yyyy',

};
 $('#frais').DataTable(option_tables);
$('#User_table').DataTable(option_tables);
$('#dataTable_client').DataTable(option_tables);
$('#dataTable_document').DataTable(option_tables);


$(document).ready(()=>{
function valid(){
    console.log('clicked');
}

    //console.log('hola depuis le encore');
    $("#sidebarToggle").on('click', function(e) {
        e.preventDefault();
        $("body").toggleClass("sidebar-toggled");
        $(".sidebar").toggleClass("toggled");
    });

    $('#dataTable').DataTable(option_tables);


    $('#datetimepicker1').datepicker({
    language:'fr',
    format: 'dd-mm-yyyy',
    autoclose: true,
    });
    $('#datetimepicker2').datepicker({
        language:'fr',
        format: 'mm-yyyy',

    });
$('#filter').datepicker({
    language:'fr',
    format: 'mm-yyyy',


});
    $('#filter_document').datepicker({
        language:'fr',
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years"

    });
$("#recipient-name").change(function (e) {
    //console.log($("#recipient-namegit ").val());
})
});


$("#document_file").change(function () {

    var ext = getFileExtension(this.files[0].name);

    if(ext.toUpperCase() === 'PDF'){
        readURL(this,"#reader_2");
    }else{
        $("#reader_2").html("<h3>l'appication ne support pas les fichiers (. "+ ext +") </h3>");
    }

});
$("#frais_fichier").change(function () {

    var ext = getFileExtension(this.files[0].name);

    if(ext.toUpperCase() === 'PDF'){
        readURL(this);
    }else{
        $("#reder").html("<h3>l'appication ne support pas les fichiers (. "+ ext +") </h3>");
    }

});

function readURL(input,id="#reder") {
    $(id).html('');//nettoyer le div qui recois le PDF
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {

            var data = `<object data="${e.target.result}" type="application/pdf" width="100%" height="440px">
               
            </object>`
            $(id).append(data);
        };
        var x = reader.readAsDataURL(input.files[0]);



    }
}

function getFileExtension(filename) {
    return filename.split('.').pop();
}

// Scroll to top button appear
$(document).on('scroll', function() {
    var scrollDistance = $(this).scrollTop();
    if (scrollDistance > 80) {
        $('.scroll-to-top').fadeIn();
    } else {
        $('.scroll-to-top').fadeOut();
    }
});

// Smooth scrolling using jQuery easing
$(document).on('click', 'a.scroll-to-top', function(event) {
    var $anchor = $(this);
    $('html, body').stop().animate({
        scrollTop: ($($anchor.attr('href')).offset().top)
    }, 1000, 'easeInOutExpo');
    event.preventDefault();
});

