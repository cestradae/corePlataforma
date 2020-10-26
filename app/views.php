<?php

/**
 * Created by PhpStorm.
 * User: cestrada
 * Date: 23/02/2017
 * Time: 3:14 PM
 */
class SMS_views extends SMS
{

    public function get_Cursos()
    {
        $arrCursos = $this->get_list_cursos();

        //bin_debug($arrCursos);
        ?>
        <h1>Cursos</h1>
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4 py-3 border-bottom-primary">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Curso</th>

                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach ($arrCursos as $key => $dataArray) {
                                    ?>
                                    <tr>
                                        <td><?php print $dataArray['nombreCurso'] ?></td>
                                        <td class="text-right py-0 align-middle">
                                            <div class="btn-group btn-group-sm">
                                                <a href="#" class="btn btn-info" onclick="busqueda_curso(<?php print $dataArray['curso'] ?>,'<?php print $dataArray['nombreCurso'] ?>')" ><i class="fas fa-eye"></i></a>

                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                    ?>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function busqueda_curso(id_curso,nombreCurso){
                $.ajax({
                    url: "./redirect.php?o=viewProyectosCursos",
                    method: "POST",
                    data: {
                        "id_curso": id_curso,
                        "nombreCurso":nombreCurso
                    },
                    beforeSend: function(){
                    },
                    success: function(doc) {
                        $(".container-fluid").html(doc);
                    }
                });

            }
        </script>
        <?php
    }
    public function get_table_proyectos($strCodigo = "", $srtNombre = "")
    {
        $arrListaProyectos = $this->get_data_Proyectos($strCodigo);
        //bin_debug($arrListaEmpleados);
        ?>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><?php print $srtNombre; ?></h1>
                    </div>

                </div>
            </div><!-- /.container-fluid -->
        </section>
        <div class="card card-default color-palette-box">
            <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tag"></i>
                        Proyectos
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Codigo Curso</th>
                                <th>Proyecto</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($arrListaProyectos as $intProyectos => $strDataProyectos){
                                ?>
                                <tr>
                                    <td><?php print $strDataProyectos['proyecto']; ?></td>
                                    <td><?php print $strDataProyectos['descripcion']; ?></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="...">
                                            <button type="button" class="btn btn-dark" onclick="fn_openDialogProyecto(<?php print $strDataProyectos['proyecto']; ?>)"  title="Agregar Documento" data-toggle="tooltip"> <i class="fas fa-laptop-house"></i></button>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="...">
                                            <button type="button" class="btn btn-dark" onclick="fn_openDialogUploads(<?php print $strDataProyectos['proyecto']; ?>)"  title="Ver Documentos o Archivos" data-toggle="tooltip"> <i class="fas fa-laptop-code"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
        <script>
            $('#dataTable').DataTable();
            $('[data-toggle="tooltip"]').tooltip();
        </script>
        <?php
    }
    public function view_modal_bitacora($intCodigo)
    {
          //bin_debug($_SESSION['login']);
        ?>
        <div class="row">
            <div class="col-lg-12">
                <form action="./Upload.php" class="dropzone" id="uploadFile" name="uploadFile" method="POST">
                    <span id="tmp-path"></span>
                </form>
            </div>
        </div>


        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        </div>
        <script>
            Dropzone.autoDiscover = false;

            Dropzone.options.uploadFile = {
                init: function() {
                    this.on("success", function(file, responseText) {
                        file.previewTemplate.appendChild(document.createTextNode(responseText));
                        $('#modal').modal('hide');
                    });

                    this.on("sending", function(file,xhr,formData) {
                        formData.append("data",<?php print $intCodigo; ?>);
                        formData.append("usuario",<?php print $_SESSION['login']['user_id']; ?>);
                        $("#tmp-path").html('<input type="hidden" name="path" value="'+file.fullPath+'" />')
                    });
                }
            };

            var myDropzone = new Dropzone("#uploadFile", {
                url: "./Upload.php"

            });
        </script>
        <?php
    }
    public function view_modal_files($intCodigo)
    {
        //bin_debug($_SESSION['login']);
        ?>
        <div class="row">
            <div class="col-lg-12">
                <?php
                $arrFiles = obtenerListadoDeArchivos("./uploads/".$intCodigo."/".$_SESSION['login']['user_id']."/");


                //bin_debug($arrFiles);
                ?>
                <table class="table table-striped">
                    <thead>
                    <tr>
                    <th>URL</th>
                    <th>Size</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            $arrSplit = array();
                            foreach($arrFiles as $keyFiles => $dataFiles){
                                $arrSplit = explode("/", $dataFiles["Nombre"]);
                                ?>
                                <tr>
                                    <td><a href="$"><?php print $arrSplit[count($arrSplit)-2]; ?> </a></td>
                                    <td><?php print $dataFiles["size"]; ?> </td>
                                </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-6"></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        </div>
       <?php

    }
}
