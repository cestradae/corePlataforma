<?php
/**
 * Created by PhpStorm.
 * User: cestrada
 * Date: 23/02/2017
 * Time: 3:00 PM
 */
$operacion = $_GET["o"];

/**
 * info menu sin submenu
 */
if ($operacion == 'get_data_menu') {
    //bin_debug("prueba");
    $intIdMenu = (isset($_POST["idMenu"])) ? intval($_POST["idMenu"]) : 0;
//    $strNombreMenu = (isset($_POST["nombre"])) ? $_POST["nombre"] : "";

//    if($intIdMenu == 1){
//        $strReturn = $generalViews->get_clientes();
//    }
    //print $strReturn;
}
if ($operacion == 'get_data_sub_menu') {

    $intIdMenu = (isset($_POST["idSubMenu"])) ? intval($_POST["idSubMenu"]) : 0;
//    $strNombreMenu = (isset($_POST["nombre"])) ? $_POST["nombre"] : "";

    if ($intIdMenu == 1) {
        $strReturn = $generalViews->get_Cursos($intIdMenu);
    }
    if ($intIdMenu == 2) {
        $strReturn = $generalViews->get_Cursos($intIdMenu);
    }
    //print $strReturn;
}
if ($operacion == 'viewProyectosCursos') {

    $intIdCurso = (isset($_POST["id_curso"])) ? intval($_POST["id_curso"]) : 0;
    $strNombreCurso = (isset($_POST["nombreCurso"])) ? $_POST["nombreCurso"] : "";

        $strReturn = $generalViews->get_table_proyectos($intIdCurso,$strNombreCurso);

    //print $strReturn;
}
if ($operacion == 'viewProyectosCursosCat') {

    $intIdCurso = (isset($_POST["id_curso"])) ? intval($_POST["id_curso"]) : 0;
    $strNombreCurso = (isset($_POST["nombreCurso"])) ? $_POST["nombreCurso"] : "";

    $strReturn = $generalViews->view_files_uploads2($intIdCurso,"",1);

    //print $strReturn;
}
if ($operacion == 'get_dialog_carga_archivo') {

    $intIdCurso = (isset($_POST["codigo"])) ? intval($_POST["codigo"]) : 0;
    //$strNombreCurso = (isset($_POST["nombreCurso"])) ? $_POST["nombreCurso"] : "";

    $strReturn = $generalViews->view_modal_bitacora($intIdCurso);

    //print $strReturn;
}
if ($operacion == 'get_Uploads') {
    $intIdProyecto= (isset($_POST["codigo"])) ? intval($_POST["codigo"]) : 0;
    $strUrl = (isset($_POST["URL"])) ? $_POST["URL"] : "";
    $strReturn = $generalViews->view_files_uploads($intIdProyecto, $strUrl);

    print $strReturn;
}

if ($operacion == "getAlive") {
    bin_getAlive();
}
