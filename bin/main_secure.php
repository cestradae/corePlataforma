<?php
/**
* Created by PhpStorm.
* User: cestrada
* Date: 23/02/2017
* Time: 10:48 AM
*/

function bin_draw_header($boolPublicAccess = false, $fullScreen = false){
    if(bin_checkLogin()){
        bin_only_header();
        if(!$fullScreen){
            include_once("docs/header.php");
        }
    }
    else{
        header("Location: ./login.php");
    }

}

function bin_only_header(){
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8"/>
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta name="description" content="">
            <meta name="author" content="">
            <title>PLATAFORMA</title>
            <link rel = "icon" href =
            ""
                  type = "image/x-icon">
            <?php   include_once("docs/includes.php"); ?>
        </head>

        <body class="sidebar-mini layout-fixed" >
            <?php
    
        }

        function bin_draw_footer($boolPublicAccess = false, $fullScreen = false){
            if(!$fullScreen){
                include_once("docs/footer.php");
            }
            bin_only_footer();
        }

        function bin_only_footer(){
            ?>
            <script type="text/javascript">
                //PARA EL MENU
                var sessionExpired = false;
                $(document).ready(function(){
                    //getMenu("__recover");
                    setInterval(function(){
                        getAlive();
                    }, 35000);
                })
                function getAlive(){

                    if(sessionExpired)return false;

                    $.ajax({
                        type:"POST",
                        url:"./redirect.php?m=bin&o=getAlive&getAlive",
                        beforeSend: function(){},
//                        success:function(data){
//                            try {
//                                data = $.parseJSON(data);
//                                if(!data.error){
//                                    if(data.info && data.info > 0){
//                                        $("#notyNumberNews").html(data.info).show();
//                                    }
//                                }
//                                else{
//                                    sessionExpired = true;
//                                    bootbox.alert("Su sesión ha expirado...", function(){
//                                        window.location.href='index.php';
//                                    });
//                                }
//                            }
//                            catch (e) {}
//                        }
                    });
                }
            </script>
        </body>
    </html>
    <?php
}

function bin_debug($strContent = ""){
    if($strContent == "" || $strContent == null || $strContent == false){
        var_dump($strContent);
    }
    else{
        print_r("<pre style='text-align: left!important'>\r\r");
        print_r($strContent);
        print_r("\r\r</pre>");
    }
}

function bin_fechaTransform($strFecha = "", $format = "d-m-Y"){

    return date($format, strtotime($strFecha));
}

function bin_checkLogin(){
    if(!isset($_GET["getAlive"]))$_SESSION["login"]["timeLastActivity"] = time();
    if(isset($_SESSION["login"]["isLogin"])){
        if($_SESSION["login"]["isLogin"] === true){
            return true;
        }
        else{
            return false;
        }
    }
    else{
        $_SESSION["login"]["isLogin"] = "";
    }
}

function bin_ferifyFirstLogin(){
    if(isset($_SESSION["login"]["firstLogin"])){
        if($_SESSION["login"]["firstLogin"] === true){
            return true;
        }
        else{
            return false;
        }
    }
    else{
        $_SESSION["login"]["firstLogin"] = true;
    }
}

$db = new MsSQL();

function bin_checkFormLogin(){
    global $db;

    //si no estoy logueado
    if(!bin_checkLogin()){
        if(isset($_POST["goLogin"])){
            //bin_debug($arrModulosActivos);
            $strUser = (isset($_POST["user"]))?$_POST["user"]:"";
            //$strUser = $db->escape();
            //            bin_debug($strUser);
            $strPass = (isset($_POST["password"]))?$_POST["password"]:"";
            $expireSession = (isset($_POST["loginDontClose"]) && $_POST["loginDontClose"] == "Y")?false:true;

            $strQuery ="SELECT usuario_id,nombre,usuario,rol_id,STATUS 
                        FROM usuarios WHERE usuario = '{$strUser}' AND PASSWORD ='{$strPass}' AND STATUS = 1";
            $qTMP = $db->consulta($strQuery);

            //bin_debug("prueba");
            $arrUserAttempt = $db->fetch_assoc($qTMP);

            if(isset($arrUserAttempt["usuario_id"])){

                $_SESSION["login"]["time"] = date("Y-m-d H:i:s");
                $_SESSION["login"]["expireSession"] = $expireSession;
                $_SESSION["login"]["isLogin"] = true;
                $_SESSION["login"]["user"] = $arrUserAttempt["usuario"];
                $_SESSION["login"]["name"] = "{$arrUserAttempt["usuario"]} | {$arrUserAttempt["nombre"]}";
                $_SESSION["login"]["user_id"] = $arrUserAttempt["usuario_id"];
                $_SESSION["login"]["roles"] = $arrUserAttempt["rol_id"];
                //$_SESSION["login"]["firstLogin"] = (empty($arrUserAttempt["swdateupdated"]))?true:false;



                //bin_debug($_SESSION);
            }
            else{
                $_SESSION["login"]["isLogin"] = false;
            }

            if(bin_checkLogin()){
               
                    header("Location: index.php");
          
            }
            else{
                header("Location: login.php?error=true");
            }
        }
    }
    else{
        header("Location: index.php");
    }

}


function bin_sessionClose(){
    session_destroy();
}

function bin_sessionCheckLogout(){

    if(isset($_GET["UserLogout"])){
//        $arrParamsLog = array(
//            "id_usuario" => $_SESSION["login"]["user_id"],
//            "id_clinica" => $_SESSION["login"]["bodega_id"],
//            "estado" => "LogOut",
//            "fecha" => date("Y-m-d"),
//            "hora" => date("H:i:s"),
//            "id_terminal" => 0,
//            "observaciones" =>"Sali� del sistema",
//            "id_session" => session_id(),
//            "ip_address" => $ip
//        );

        bin_sessionClose();
        header("Location: index.php");
    }
}
function bin_getAlive(){

        if(!empty($_SESSION["login"]["timeLastActivity"])){

            $tiempoDeExpiracion = 600; //10 minutos en segundos

            //Evaluo
            $tiempoActual = time();

            if($tiempoActual >= ($_SESSION["login"]["timeLastActivity"]+$tiempoDeExpiracion)){
                bin_sessionClose();
                //bin_responseOperation(true, 0, true);
            }
            else{
                header("Location: index.php");
            }
        }
        else{
            //aqui no deberia entrar nunca!
            bin_sessionClose();

        }

}
bin_sessionCheckLogout();