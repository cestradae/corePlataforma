
</div>

<script>
    $(document).ready(function() {
    	  // Toggle the side navigation
        $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
        $("body").toggleClass("sidebar-toggled");
        $(".sidebar").toggleClass("toggled");
        if ($(".sidebar").hasClass("toggled")) {
          $('.sidebar .collapse').collapse('hide');
        };

        });



    });



    function fn_alert(msg,type){
        if (type == 1) {
            toastr.error(msg)
        }else if(type == 2){
            toastr.info(msg)
        }else if(type == 3){
            toastr.success(msg)
        }
    }
    function fn_sendMenu(idMenu){

        $.ajax({
            url: "./redirect.php?o=get_data_menu",
            method: "POST",
            data: {
                "idMenu": idMenu
            },
            beforeSend: function(){
                //fnLoad(1);
            },
            success: function(doc) {
                //fnLoad(2);
                $(".container-fluid").html(doc);
            }
        });
    }

    function fn_sendSubMenu(idSubMenu){
        //console.log(idSubMenu);
        $.ajax({
            url: "./redirect.php?o=get_data_sub_menu",
            method: "POST",
            data: {
                "idSubMenu": idSubMenu
            },
            beforeSend: function(){
                //fnLoad(1);
            },
            success: function(doc) {
                //fnLoad(2);
                $(".container-fluid").html(doc);
            }
        });
    }



    function fn_openDialogProyecto(id){
        var objModal = $('#modalbody');
        $.ajax({
            url: "./redirect.php?o=get_dialog_carga_archivo",
            method: "POST",
            data: {
                "codigo": id
            },
            success: function (doc) {
                objModal.html("");
                objModal.html(doc);
                $('#modalHeader').html('Carga Archivo');
                $('#modal').modal({backdrop: 'static', keyboard: false},'show');
            }
        });
    }

    function fn_openDialogUploads(id){
        var objModal = $('#modalbody');
        $.ajax({
            url: "./redirect.php?o=get_dialog_Uploads",
            method: "POST",
            data: {
                "codigo": id
            },
            success: function (doc) {
                objModal.html("");
                objModal.html(doc);
                $('#modalHeader').html('bitacora');
                $('#modal').modal({backdrop: 'static', keyboard: false},'show');
            }
        });
    }


</script>