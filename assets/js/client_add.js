$(document).ready(function () {
$("#loader").css('display','none');
    $("#client_add").submit(function(e){
        $("#loader").css('display','block');
        $("#save_client").attr("disabled", true);
        e.preventDefault();
        var formSerialize = $(this).serialize();
        $.ajax({
            url:url,
            data:formSerialize,
            dataType:'JSON',
            method:'POST',
            success:function (response) {
                $("#loader").css('display','none');
                console.log(response.client);
                appenOption(response.client);
                $("#save_client").removeAttr("disabled");
                $("#msg").append(notify('success','Le client a ete cree'));
                $("#client_add").trigger('reset');
                $('#exampleModalLong').modal('toggle');
            }
        });
    });
    function appenOption(object){
        var newOption = new Option(object.nom, object.id, true, true);
        $("select").append(newOption).trigger('change');
    }
    function notify($className,message) {
       return "<div class='alert alert-"+$className+" alert-dismissible fade show' role='alert'>"+message+"<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>"
    }
});
