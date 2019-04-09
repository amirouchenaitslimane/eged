window.showModal = function (td) {
    $(".loader_cra").css('display','none');//image gif
    $("#cra_form").html('');//nettoie le formulaire de modal_form_cra.html.twig
    $("#craModal").modal('show');//activation de modal pour chaque click de la td
    setInputsForm(td);//remplir le formulaire avec les inputs necessaire recuperer dans chaque td
    //Ajax pour ajout de cra
    $("#save_form").click(function (e) {
       e.preventDefault();
        $(".loader_cra").css('display','block');
       var date_c = $("#date").val();
        var journnee_c = $("#journnee").val();
        var client_id = $("#client_id").val();

        console.log("client id "+client_id);console.log('valeur jour '+journnee_c);console.log('date '+date_c)
       $.ajax({
           url:route_add_cra,//regarde dans routes.yaml et modal_form_html.twig
           method:'POST',
           data:{date:date_c,journee:journnee_c,client:client_id},
           success:function (res) {
               $(".loader_cra").css('display','none');
               $("#craModal").modal('toggle');
               location.reload();


           }
       })
   });
    //ajax pour la suppression de cra
    $("#btn_delete").click(function (e) {
       if(confirm('voulez-vous supprimer ce cra ? ') ){
           $(".loader_cra").css('display','block');
          var cra_id = $("#cra").val();
          $.ajax({
              url:route_remove_cre,//regarde dans routes.yaml et modal_form_html.twig
              method: 'POST',
              data:{id:cra_id},
              success:function (res) {
                  $(".loader_cra").css('display','none');
                  $("#craModal").modal('toggle');
                  location.reload();
              }
          })
       }
   });
    //ajax pour actualisation de cra
    $("#btn_update").click(function () {
       var cra_id = $("#cra").val();
       var journnee_c = $("#journnee").val();
       var date_c = $("#date").val();
        $(".loader_cra").css('display','block');
       $.ajax({
           url:route_update_cra,//regarde dans routes.yaml et modal_form_html.twig
           method: 'POST',
           data:{id:cra_id,date:date_c,journee:journnee_c},
           success:function (res) {
               $(".loader_cra").css('display','none');
               $("#craModal").modal('toggle');
               location.reload();
           }
       })

});
};

/**
 * Creation des input de formulaire en recuperant les valeur dans chaque td cliqué ;
 * @param td
 */
function setInputsForm(td){
   // console.log(td);
    var client_id = $(td).attr('data-client-id');
    var date_cra = $(td).attr('data-date-cra');
    var cra_journee = $(td).attr('data-cra-journee');
    var date_current_td = $(td).attr('data-date-td');
    var cra_id =  $(td).attr('data-cra-id');
    var data_date = (date_cra === '' ? date_current_td : date_cra);
    cra_journee = (date_cra !== '' ? cra_journee : '');
    var form_elements = `
    <div class="form-group">
    <div class="input-group date datepicker_cra" data-provide="datepicker" >
    <input type="text" class="form-control" name="date" id="date">
    <div class="input-group-addon">
        <span class="glyphicon glyphicon-th"></span>
    </div>
    </div>
    </div> 
    <div class="form-group">
        <label for="journnee">Journee</label>
        <select name="journnee" id="journnee" class="form-control">
         <option value="0.25" ${(cra_journee === '0.25' ? 'selected':'' )}>0,25</option>
        <option value="0.5" ${(cra_journee === '0.5' ? 'selected':'' )}>0,5</option>
        <option value="0.75" ${(cra_journee === '0.75' ? 'selected':'' )}>0,75</option>
        <option value="1" ${(cra_journee === '1' ? 'selected':'' )}>1 </option>
        </select>
    </div>   
    <input type="hidden" name="client_id" id="client_id" value="${client_id}">
    <input type="hidden" name="cra_id" id="cra" value="${cra_id}">`;
    if(date_cra !== ""){
        var buttons = `<boutton class="btn btn-danger" id="btn_delete">Supprimer</boutton><boutton class="btn btn-primary" id="btn_update">Editer</boutton>`;
    }else{
        buttons = "";
    }
    $("#cra_form").append(form_elements);
    $("#cra_form").append(buttons);
    $(".datepicker_cra").datepicker({format:'yyyy-mm-dd',}).datepicker("setDate",data_date);
}
$(".loader_cra_save").css('display','none');
$('#form_cra').on('submit', function(e){

    e.preventDefault();
  var cra_date = $("#cra_date").val();
  var journee_select = $("#cra_journee").val();
  var cra_client = $("#cra_client").val();
    $(".loader_cra_save").css('display','block');

    $.post(route_add_client_cra, {
        date:cra_date,
        journee:journee_select,
        client:cra_client,
    },function (res) {
        $(".loader_cra_save").css('display','none');
        $("#pointModal").modal('toggle');
        location.reload();
    } );

    return false;
});
