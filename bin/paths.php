<?php
/**
 * Created by PhpStorm.
 * User: cestrada
 * Date: 20/02/2017
 * Time: 5:51 PM
 */
$host= $_SERVER["HTTP_HOST"];
$appPath =$_SERVER["REQUEST_URI"];
$nameProject = explode('/',$appPath);
define('URL',"http://".$host."/".$nameProject[1]."/" );