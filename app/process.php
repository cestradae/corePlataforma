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
        $strReturn = $generalViews->get_Cursos();
    }
    if ($intIdMenu == 2) {

    }
    //print $strReturn;
}
if ($operacion == "getAlive") {
    bin_getAlive();
}
