<?php
include_once("bin/main.php");

global $db;
$ds = "/";
$storeFolder = 'uploads/';

if (!empty($_FILES)) {

    $tempFile = $_FILES['file']['tmp_name'];
    bin_debug($_POST['data']);

    $targetPath = dirname( __FILE__ ) . $ds . $storeFolder . $ds;

    $fullPath = $storeFolder.$_POST['data'].$ds.$_POST['usuario'].$ds.rtrim($_POST['path'], "/.");
    $folder = substr($fullPath, 0, strrpos($fullPath, "/"));
    $strQuery = "INSERT INTO dbo.uploads
(
    --upload - column value is auto-generated
    url,
    
    proyecto,
    estado,
    fecha,
    usuario_id
)
VALUES
(
    -- upload - int
    '{$folder}', -- url - varchar
    
    {$_POST['data']}, -- proyecto - int
    1, -- estado - int
    getdate(), -- fecha - nchar
    {$_POST['usuario']} -- usuario_id - int
)	";

    $qTMP = $db->consulta($strQuery);
    if (!is_dir($folder)) {
        $old = umask(0);
        mkdir($folder, 0777, true);
        umask($old);
    }

    if (move_uploaded_file($tempFile, $fullPath)) {
        die($fullPath);
    } else {
        die('e');
    }
}