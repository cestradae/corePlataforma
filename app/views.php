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
                            //bin_debug($_SESSION['login']);
                                foreach ($arrCursos as $key => $dataArray) {

                                    ?>
                                    <tr>
                                        <td><?php print $dataArray['nombreCurso'] ?></td>
                                        <td class="text-right py-0 align-middle">
                                            <div class="btn-group btn-group-sm">
                                                <?php if($_SESSION['login']['roles'] != 2){ ?>
                                                    <a href="#" class="btn btn-info" onclick="busqueda_curso(<?php print $dataArray['curso'] ?>,'<?php print $dataArray['nombreCurso'] ?>')" ><i class="fas fa-eye"></i></a>
                                                <?php }
                                                else{
                                                    ?>
                                                    <a href="#" class="btn btn-info" onclick="busqueda_proyectosCurso(<?php print $dataArray['curso'] ?>,'<?php print $dataArray['nombreCurso'] ?>')" ><i class="fas fa-eye"></i></a>

                                                <?php
                                                }
                                                ?>
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
            function busqueda_proyectosCurso(id_curso,nombreCurso){
                $.ajax({
                    url: "./redirect.php?o=viewProyectosCursosCat",
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
        //bin_debug($_SESSION['login']);


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
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn-primary">Agregar Proyecto</button>
                        </div>
                    </div>
                    <div class="row"></div>
                    <div class="row">
                        <div class="col-md-12">
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
                                        $strHide ="";
                                        if($_SESSION['login']['roles'] == 3){
                                            $intCount = $this->getInfoProyecto($strDataProyectos['proyecto'],$_SESSION['login']['user_id']);
                                            if($intCount['conteo'] != 0){
                                                $strHide = "hidden";
                                            }else {
                                                $strHide = "";
                                            }
                                        }
                                        ?>
                                        <tr>
                                            <td><?php print $strDataProyectos['proyecto']; ?></td>
                                            <td><?php print $strDataProyectos['descripcion']; ?></td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="...">
                                                    <button type="button" class="btn btn-dark" <?php print $strHide; ?> onclick="fn_openDialogProyecto(<?php print $strDataProyectos['proyecto']; ?>)"  title="Agregar Documento" data-toggle="tooltip"> <i class="fas fa-laptop-house"></i></button>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="...">
                                                    <button type="button" class="btn btn-dark" onclick="fn_openUploads(<?php print $strDataProyectos['proyecto']; ?>)"  title="Ver Documentos o Archivos" data-toggle="tooltip"> <i class="fas fa-laptop-code"></i></button>
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
            </div>
        </div>
        <script>
            $('#dataTable').DataTable();
            $('[data-toggle="tooltip"]').tooltip();

            function fn_openUploads(id){

                $.ajax({
                    url: "./redirect.php?o=get_Uploads",
                    method: "POST",
                    data: {
                        "codigo": id
                    },
                    success: function (doc) {
                        $(".container-fluid").html(doc);
                    }
                });
            }
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
    public function view_files_uploads($intCodigo, $pathFiles="")
    {
        if ($_SESSION['login']['roles'] != 2) {
            ?>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card card-default color-palette-box">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-tag"></i>
                                Proyectos
                            </h3>
                        </div>
                        <div class="card-body">

                            <?php
                            //$arrFiles = obtenerListadoDeArchivos("./uploads/".$intCodigo."/".$_SESSION['login']['user_id']."/");
                            $path = "";
                            if (!empty($pathFiles)) {
                                $path = $pathFiles;
                            } else {
                                $path = "./uploads/" . $intCodigo . "/" . $_SESSION['login']['user_id'];
                            }
                            $arrFiles = scan($path);
                            $arrPath = explode('/', $pathFiles);
                            $pathimplode = "";
                            for ($i = 0; $i < count($arrPath) - 1; $i++) {
                                $pathimplode = $pathimplode . $arrPath[$i] . "/";
                            }
                            //($pathimplode);
                            ?>
                            <table>
                                <thead>
                                <tr>
                                    <th>Archivos / Carpetas</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><a href="#" style="color: red"><span
                                                    onclick="myfnData('<?php print $pathimplode ?>','back','folder')"><i
                                                        class="fas fa-file-upload"></i>  ...</span></a></td>
                                </tr>
                                <?php
                                foreach ($arrFiles as $keyFiles => $dataFiles) {
                                    //bin_debug($dataFiles);
                                    $type = "";
                                    $color = "";

                                    if ($dataFiles['type'] == "folder") {
                                        $type = "fa-folder";
                                        $color = "";

                                    } else {
                                        $type = "fa-file";
                                        $color = "black";
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <a href="#"><span style="color:<?php print $color; ?> "
                                                              onclick="myfnData('<?php print $dataFiles['path'] ?>','<?php print $dataFiles['name'] ?>','<?php print $dataFiles['type'] ?>')"><i
                                                            class="fas <?php print $type; ?>"></i>  <?php print $dataFiles['name']; ?></span></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-6"></div>
                    </div>
                </div>
            </div>
            <?php
        }
        else{
            $arrPro = $this->getuploads();
            //bin_debug($arrPro);
            ?>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card card-default color-palette-box">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-tag"></i>
                                Proyectos
                            </h3>
                        </div>
                        <div class="card-body">

                            <?php
                            foreach ($arrPro as $key => $arrData) {

                                $path = "./uploads/" . $key ;
                                $arrFiles = scan($path);

                            }
                            //($pathimplode);
                            ?>
                            <table>
                                <thead>
                                <tr>
                                    <th>Archivos / Carpetas</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                foreach ($arrFiles as $keyFiles => $dataFiles) {
                                    $type = "";
                                    $color = "";
                                    //bin_debug($dataFiles);

                                        $Usuario = $this->getUserName($dataFiles['name']);

                                    if ($dataFiles['type'] == "folder") {
                                        $type = "fa-folder";
                                        $color = "";

                                    } else {
                                        $type = "fa-file";
                                        $color = "black";
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <a href="#"><span style="color:<?php print $color; ?> "><i class="fas <?php print $type; ?>"></i>  <?php print $Usuario['nombre']; ?></span></a>
                                        </td>
                                        <td>
                                            <a href="download.php?file=fichero.png">Descargar fichero</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-6"></div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}
