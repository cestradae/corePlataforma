<?php
/**
 * Created by PhpStorm.
 * User: cestrada
 * Date: 22/02/2017
 * Time: 10:09 AM
 */

date_default_timezone_set("America/Guatemala");
header('Content-type: text/html; charset=ISO-8859-1');

//incluyo mis funciones del bin
include_once("lib/main_functions.php");

//incluyo controlador de mysql
//include_once("lib/mysql_server.php");
 include_once("lib/sql_server.php");
//include_once("lib/mssql_cp.php");

bin_sessionStart();

include_once("main_secure.php");
include_once("paths.php");
include_once("app/SMS.php");
include_once("app/views.php");


$functionsSMS = new SMS();
$generalViews = new SMS_views();
//$db = new MsSQL();


$operacion="";