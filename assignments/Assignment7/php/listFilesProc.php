<?php

require_once __DIR__ . "/../classes/Pdo_methods.php";


/*
 * Retrieve all uploaded files from database
 */
function getFiles()
{

    $pdo = new PdoMethods();

    $sql = "SELECT *
            FROM files
            ORDER BY id DESC";

    $result = $pdo->selectNotBinded($sql);

    return $result;
}
