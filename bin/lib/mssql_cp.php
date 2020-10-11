<?php
/**
 * Created by PhpStorm.
 * User: cestrada
 * Date: 23/02/2017
 * Time: 11:56 AM
 */
set_time_limit(300);

class MsSQL{
    private $conexion;
    private $total_consultas;
    public function MsSQL($db_vlr){
        if(!isset($this->conexion)){
            include_once("bin/conf/config.php");
            //print $dbConfig["server"];
            $this->conexion = (mssql_connect($dbConfig["host"], $dbConfig["user"], $dbConfig["password"])) or die(mssql_get_last_message());
            //mssql_set_charset('utf-8',$this->conexion);
            mssql_select_db($dbConfig['db_name'],$this->conexion) or die(mssql_get_last_message());
        }
    }

    public function consulta($consulta){
        $this->total_consultas++;
        $resultado = mssql_query(utf8_decode($consulta),$this->conexion) or die ('SQL Error: ' . mssql_get_last_message());
        if(!$resultado){
            echo 'SQL Error: ' . mssql_get_last_message();
            exit;
        }
        return $resultado;
    }

    public function last_id(){
        if ($this->conexion){
            return mssql_insert_id();
        }
    }

    public function fetch_array($consulta){
        return mssql_fetch_array($consulta);
    }

    public function fetch_assoc($consulta){
        return mssql_fetch_assoc($consulta);
    }

    public function num_rows($consulta){
        return mssql_num_rows($consulta);
    }

    public function data_seek($consulta,$numeric){
        return mssql_data_seek($consulta,$numeric);
    }

    public function getTotalConsultas(){
        return $this->total_consultas;
    }

    public function close(){
        if ($this->conexion){
            return mssql_close($this->conexion);
        }
    }
}


function correct_txt($texto){
    return htmlentities(($texto));


}

function bin_getFechaEnLetras2($strFecha =""){

    $array_dias['Sunday'] = "DOMINGO";
    $array_dias['Monday'] = "LUNES";
    $array_dias['Tuesday'] = "MARTES";
    $array_dias['Wednesday'] = "MIERCOLES";
    $array_dias['Thursday'] = "JUEVES";
    $array_dias['Friday'] = "VIERNES";
    $array_dias['Saturday'] = "SABADO";

    $array_meses['01'] = "ENERO";
    $array_meses['02'] = "FEBRERO";
    $array_meses['03'] = "MARZO";
    $array_meses['04'] = "ABRIL";
    $array_meses['05'] = "MAYO";
    $array_meses['06'] = "JUNIO";
    $array_meses['07'] = "JULIO";
    $array_meses['08'] = "AGOSTO";
    $array_meses['09'] = "SEPTIEMBRE";
    $array_meses['10'] = "OCTUBRE";
    $array_meses['11'] = "NOVIEMBRE";
    $array_meses['12'] = "DICIEMBRE";

    $arrExplodeFecha = explode("-", $strFecha);

    $strFechaReturn = $arrExplodeFecha[2]." DE ".$array_meses[$arrExplodeFecha[1]]. " DEL " . $arrExplodeFecha[0];

    return $strFechaReturn;

}
?>
