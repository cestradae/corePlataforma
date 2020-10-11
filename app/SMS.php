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
        if($curso != 0){
            $strFiltro = $curso != 0 ?"WHERE c.curso = {$curso} ": "";
        }
        global $db;
        $strQuery = "SELECT c.curso,c.descripcion nombreCurso, c.ciclo  FROM dbo.cursos c";
        $qTMP = $db->consulta($strQuery);
        $arrCurso = array();
        while ($rTMP = $db->fetch_assoc($qTMP)) {
            $arrCurso[$rTMP['curso']]= $rTMP;
        }
        return $arrCurso;
    }


}