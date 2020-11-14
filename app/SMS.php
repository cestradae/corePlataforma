<?php

/**
 * Created by PhpStorm.
 * User: cestrada
 * Date: 22/02/2017
 * Time: 3:19 PM
 */
class SMS
{

    /*menu lateral*/
    function get_menu()
    {
        global $db;
        $strQuery = "SELECT u.usuario username, r.rol descrol,u.rol_id rol,m.idMenu,m.descripcion,m.status,m.icon,
                    sm.idSubMenu,sm.descripcion descSubmenu,sm.status
                    FROM usuarios u
                    INNER JOIN roles r ON u.rol_id = r.rol_id 
                    INNER JOIN menurol mr ON mr.idRol = u.rol_id
                    INNER JOIN menu m ON m.idMenu = mr.idMenu
                    LEFT JOIN submenu sm ON sm.idSubMenu = mr.idSubMenu
        WHERE r.rol_id = {$_SESSION['login']['roles']}
        AND mr.status = 1
        ORDER BY m.idMenu,sm.idSubMenu ASC";
        $qTMP = $db->consulta($strQuery);
        $arrMenu = array();
        while ($rTMP = $db->fetch_assoc($qTMP)) {
            $arrMenu[$rTMP['idMenu']]['id_menu'] = $rTMP['idMenu'];
            $arrMenu[$rTMP['idMenu']]['menu'] = $rTMP['descripcion'];
            $arrMenu[$rTMP['idMenu']]['icono'] = $rTMP['icon'];
            if (isset($rTMP["idSubMenu"])) {
                $arrMenu[$rTMP['idMenu']]['SubMenu'][$rTMP['idSubMenu']]['idsMenu'] = $rTMP['idSubMenu'];
                $arrMenu[$rTMP['idMenu']]['SubMenu'][$rTMP['idSubMenu']]['sMenu'] = $rTMP['descSubmenu'];
            }
        }
        return $arrMenu;
    }

    function get_list_cursos($curso = 0)
    {
        if ($curso != 0) {
            $strFiltro = $curso != 0 ? "WHERE c.curso = {$curso} " : "";
        }
        global $db;
        $strDato ="";
        if ($_SESSION['login']['roles'] == 2){
            $strDato = " inner join cursosCatedratico cc on c.curso = cc.idcurso where cc.idusuario = {$_SESSION['login']['user_id']}";
        }
        else {
            $strDato="";
        }
        $strQuery = "SELECT c.curso,c.descripcion nombreCurso, c.ciclo  FROM dbo.cursos c
                     {$strDato}";
        $qTMP = $db->consulta($strQuery);
        $arrCurso = array();
        while ($rTMP = $db->fetch_assoc($qTMP)) {
            $arrCurso[$rTMP['curso']]= $rTMP;
        }
        return $arrCurso;
    }

    function get_data_Proyectos($id_curso = 0){
        global $db;
        $strQuery = "SELECT p.proyecto, p.descripcion, p.estado FROM dbo.proyectos p
                    INNER JOIN dbo.cursos c ON p.curso = c.curso
                    WHERE p.estado = 1 AND  p.curso ={$id_curso}";
        $qTMP = $db->consulta($strQuery);
        $arrProyecto = array();
        while ($rTMP = $db->fetch_assoc($qTMP)) {
            $arrProyecto[$rTMP['proyecto']]= $rTMP;
        }
        return $arrProyecto;
    }

    function getdataTree($strpath =''){
        return json_encode(dir_to_jstree_array($strpath));
    }

    function getInfoProyecto($intidpro = 0,$intidUser = 0){
        global $db;
        $strQuery = "select count(*) conteo from uploads where proyecto = {$intidpro} and usuario_id = {$intidUser}";
        $qTMP = $db->consulta($strQuery);
        $intContador = array();
        $rTMP = $db->fetch_assoc($qTMP);
        $intContador= $rTMP;

        return $intContador;
    }

    function getuploads(){
        global $db;
        $strQuery = "SELECT u.url, p.curso,u.proyecto,u2.nombre,u.usuario_id FROM dbo.uploads u	 
                    INNER JOIN dbo.proyectos p	ON u.proyecto = p.proyecto
                    INNER JOIN dbo.cursosCatedratico cc	ON cc.idCurso = p.curso	
                    INNER JOIN dbo.usuarios u2	ON	u.usuario_id = u2.usuario_id
                    WHERE cc.idUsuario	 = {$_SESSION['login']['user_id']}
                    GROUP BY u.url, p.curso,u.proyecto,u2.nombre,u.usuario_id ";
        $qTMP = $db->consulta($strQuery);
        $arrProyecto = array();
        while ($rTMP = $db->fetch_assoc($qTMP)) {
            $arrProyecto[$rTMP['proyecto']][$rTMP['usuario_id']]= $rTMP;
        }

        return $arrProyecto;
    }

    function getUserName($idUser = 0){
        global $db;
        $strQuery = "SELECT nombre FROM usuarios
                    WHERE usuario_id	 = {$idUser}
                    ";
        $qTMP = $db->consulta($strQuery);
        $strUsuario = "";
        $rTMP = $db->fetch_assoc($qTMP);
        $strUsuario= $rTMP;

        return $strUsuario;
    }

}