<?php
function bin_sessionStart(){
    session_start();

    if(!isset($_SESSION["db"]["host"]) || !isset($_SESSION["db"]["user"]) || !isset($_SESSION["db"]["password"]) || !isset($_SESSION["db"]["db_name"])){
        if(file_exists("bin/conf/config.php")){
            //bin_debug("existe");
            //if(include_once("bin/conf/config.php")){
            include_once("bin/conf/config.php");
                $_SESSION["db"]["host"] = $dbConfig["host"];
                $_SESSION["db"]["user"] = $dbConfig["user"];
                $_SESSION["db"]["password"] = $dbConfig["password"];
                $_SESSION["db"]["db_name"] = $dbConfig["db_name"];
                $_SESSION["db"]["serverName"] = $dbConfig["serverName"];
//            }
        }
        else{
            die("Error, no existe archivo de configuracion");
        }
    }
}

function quitar_tildes($strTexto) {
    $arrNoPermitidas= array ("?","?","?","?","?","?","?","?","?","?","?","?");
    $arrPermitidas= $arrNoPermitidas;
    utf8_encode_array_detect_encoding($arrPermitidas);
    $strLimpio = str_replace($arrNoPermitidas, $arrPermitidas ,$strTexto);
    return $strLimpio;
}

function utf8_encode_array_detect_encoding(&$arrToEncode) {
    reset($arrToEncode);
    while ($arrItem = each($arrToEncode)) {
        if (is_array($arrItem["value"]) || is_object($arrItem["value"])) {
            $arrItem["value"] = false; //Para liberar memoria
            if(is_object($arrToEncode)){
                utf8_encode_array_detect_encoding($arrToEncode->$arrItem["key"]);
            }
            else{
                utf8_encode_array_detect_encoding($arrToEncode[$arrItem["key"]]);
            }
        }
        else if (is_string($arrItem["value"])) {
            if(is_object($arrToEncode)){
                $arrToEncode->$arrItem["key"] = (mb_detect_encoding($arrItem["value"],'UTF-8', true) == 'UTF-8')? $arrItem["value"] : utf8_encode($arrItem["value"]);
            }
            else{
                $arrToEncode[$arrItem["key"]] = (mb_detect_encoding($arrItem["value"],'UTF-8', true) == 'UTF-8')? $arrItem["value"] : utf8_encode($arrItem["value"]);
            }
            $arrItem["value"] = false; //Para liberar memoria
        }
    }
    reset($arrToEncode);
    return true;
}

function json_encode_utf8 ($value, $options = 0, $depth = 512){
    utf8_encode_array_detect_encoding($value);
    return json_encode($value);
}