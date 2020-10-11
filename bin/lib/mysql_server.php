<?php

set_time_limit(300);

class MySQL
{
    private $conexion;
    private $total_consultas;
    private $db_srv;
    private $sErrores;

    public function MySQL(){

        if(!empty($_SESSION["conectDB"])){
            $this->conexion = $_SESSION["conectDB"];
        }
        else{
            if(isset($_SESSION["db"]["host"]) && isset($_SESSION["db"]["user"]) && isset($_SESSION["db"]["password"]) && isset($_SESSION["db"]["db_name"])){

                $_SESSION["conectDB"] = @mysql_connect($_SESSION["db"]["host"], $_SESSION["db"]["user"], $_SESSION["db"]["password"]);

                if($_SESSION["conectDB"]){

                    if(mysql_select_db($_SESSION["db"]["db_name"], $_SESSION["conectDB"])){
                        $this->conexion = $_SESSION["conectDB"];
                        $this->db_srv = $_SESSION["db"]["serverName"];
                    }
                    else{
                        unset($_SESSION["db"]);
                        die("Error al seleccionar la base de datos");
                    }
                }
                else{
                    //$this->MsSQL();
                    die("Error al conectar con el servidor, por favor recarge la paginasssss");
                }
            }
            else{
                die("Error al conectar con el servidor, por favor recarge la paginasss");
            }
        }
    }

    public function consulta($consulta){
//        if($this->db_srv == "mysql")
//        {

            $this->total_consultas++;
            $resultado = mysql_query($consulta,$this->conexion);
            if(!$resultado)
            {
                //echo 'Mysql Error: ' . mssql_error();
                echo "Error en la consulta: ".mssql_get_last_message();
                exit;
            }
        return $resultado;
//        }
//        else
//        {
//            $this->total_consultas++;
//            $consulta = quitar_tildes($consulta);
//            $consulta = utf8_decode($consulta);
//            $resultado = mssql_query($consulta,$this->conexion);
//            if(!$resultado){
//                //echo 'Ha ocurrido un error intente nuevamente' . mysql_error();
//                echo "Ha ocurrido un error intente nuevamente:  \n".$consulta."\n".mssql_get_last_message();
//                return "-1error";
//            }
//            else
//            {
//                return $resultado;
//            }
//        }

    }

    public function last_id(){
        if($this->db_srv == "mysql"){
            if ($this->conexion){
                return mysql_insert_id();
            }
        }else{
            if ($this->conexion){
                $result = $this->consulta("SELECT SCOPE_IDENTITY()");
                if (!$result){
                    return false;
                }
                else{
                    return mssql_result($result, 0, 0);
                }
            }
        }
    }
    public function fetch_array($consulta)
    {
        if($this->db_srv == "mysql")
        {
            return mysql_fetch_array($consulta);
        }
        else
        {
            return mssql_fetch_array($consulta);
        }
    }

    public function fetch_assoc($consulta)
    {
        if($this->db_srv == "mysql")
        {
            return mysql_fetch_assoc($consulta);
        }
        else
        {
            return mssql_fetch_assoc($consulta);
        }
    }

    public function num_rows($consulta)
    {
        if($this->db_srv == "mysql")
        {
            return mysql_num_rows($consulta);
        }
        else
        {
            return mssql_num_rows($consulta);
        }
    }

    public function data_seek($consulta,$numeric)
    {
        if($this->db_srv == "mysql")
        {
            return mysql_data_seek($consulta,$numeric);
        }
        else
        {
            return mssql_data_seek($consulta,$numeric);
        }
    }

    public function free_result($consulta)
    {
        if($this->db_srv == "mysql")
        {
            return mysql_free_result($consulta);
        }
        else
        {
            return mssql_free_result($consulta);
        }
    }

    public function getTotalConsultas()
    {
        return $this->total_consultas;
    }

    public function close()
    {
        if($this->db_srv == "mysql")
        {
            if ($this->conexion)
            {
                return mysql_close($this->conexion);
            }
        }
        else
        {
            if ($this->conexion)
            {
                return mssql_close($this->conexion);
            }
        }
    }

    Public function encriptar($string, $key) {
        $result = '';
        for($i=0; $i<strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key))-1, 1);
            $char = chr(ord($char)+ord($keychar));
            $result.=$char;
        }
        return base64_encode($result);
    }

    Public function fch_mod($fecha){
        $fch=strftime('%Y-%m-%d',strtotime($fecha));
        if($fch=='1969-12-31')    {
            return '';
        }else{
            return $fch;
        }
    }
    /**
     * Escapear comillas simples
     *
     * @param mixed $strVariable Variable que se necesita escapear
     */
    public function escape($strVariable = ""){
        return str_replace("'", "''", $strVariable);
    }

    public function get_key($strQuery = ""){

        if($strQuery != ""){

            $qTMP = $this->consulta($strQuery);

            $arrResult = $this->fetch_array($qTMP);

            if(count($arrResult) > 2){
                return $arrResult;
            }
            else{
                if(isset($arrResult[0])){
                    return $arrResult[0];
                }
                else{
                    return false;
                }
            }
        }
    }
}
