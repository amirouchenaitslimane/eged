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
//Intialisations des tablbe de projet (frais utilisateur, client document, facturation ...)
$('#frais').DataTable(option_tables);
$('#User_table').DataTable(option_tables);
$('#dataTable_client').DataTable(option_tables);
$('#dataTable_document').DataTable(option_tables);
$('#facturation').DataTable(option_tables);

$(function () {
    //convertir tout les select en select 2
    $("select").select2();
    $('.select_client_cra').select2({
        width: '100%',
        
    });
    $('.select_journee_cra').select2({
        width: '100%',

    });
    //control de la side bar
    $("#sidebarToggle").on('click', function(e) {
        e.preventDefault();
        $("body").toggleClass("sidebar-toggled");
        $(".sidebar").toggleClass("toggled");
    });
    //le button scroll de l'appliction
    $(document).on('scroll', function() {
        var scrollDistance = $(this).scrollTop();
        if (scrollDistance > 80) {
            $('.scroll-to-top').fadeIn();
        } else {
            $('.scroll-to-top').fadeOut();
        }
    });
    $(document).on('click', 'a.scroll-to-top', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: ($($anchor.attr('href')).offset().top)
        }, 1000, 'easeInOutExpo');
        event.preventDefault();
    });
    //Affichage des PDFs dans les formulaires frais et document
    /**
     *
     * @param input file
     * @param id de la div oú sera afficher
     */
    function readURL(input,id="#reder") {
        $(id).html('');//nettoyer le div qui recois le PDF
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var data = `<object data="${e.target.result}" type="application/pdf" width="100%" height="440px"></object>`;
                $(id).append(data);
            };
            var x = reader.readAsDataURL(input.files[0]);
        }
    }
    $("#frais_fichier").change(function () {
        var ext = getFileExtension(this.files[0].name);
        if(ext.toUpperCase() === 'PDF'){
            readURL(this);
        }else{
            $("#reder").html("<h3>l'appication ne support pas les fichiers (. "+ ext +") </h3>");
        }
    });
    $("#frais_duplique_fichier").change(function () {
        var ext = getFileExtension(this.files[0].name);
        if(ext.toUpperCase() === 'PDF'){
            readURL(this);
        }else{
            $("#reder").html("<h3>l'appication ne support pas les fichiers (. "+ ext +") </h3>");
        }
    });
    /**
     * return l'extension de fichier
     * @param filename
     * @returns {T}
     */
    function getFileExtension(filename) {
        return filename.split('.').pop();
    }
    //Ajout des input de resultat dans la facture (calcul TVA TTH TTC ...)
    getResultFacture();
    function getResultFacture(){
        var p = $("#facture_prix_unitaire");
        var result = $("#result");
        p.change(function () {

            if(p.val() !== ""){
                var p_unit = p.val();
                var quant = $("#facture_quantite").val();
                var total_ht = (parseFloat(quant) * parseFloat(p_unit));
                var totalTva =( ( total_ht * 20 ) / 100 );
                var totalTtc = total_ht + totalTva;
                result.append(elementInput('Total hors taxe',total_ht.toFixed(3)+' €'));
                result.append(elementInput('Tva','20 %'))
                result.append(elementInput('Total Tva',totalTva.toFixed(3)+' €'));
                result.append(elementInput('Total TTC',totalTtc.toFixed(3)+' €'));
            }else{
                result.html(' ');
            }


        }) ;
    }

    /**
     * Creation des input dans la facture
     * @param label
     * @param value
     * @returns {string}
     */
    function elementInput(label,value){
        return `<div class="col-md-8">
            <div class="form-group">
            <label for="" >${label}</label>
            <input type="text" disabled value="${value}" class="form-control">
            </div>
            </div>`;

    }



});