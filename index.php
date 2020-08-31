<?php

include "auth.php";

$arrOfTypes = ["update", "alter", "select", "insert"];
$arrOfGet = ["key", "value", "table", "order", "col", "valueWhere", "colWhere"];

$arrErr = [];
$arrUpdateErr = ["value" => "", "valueWhere" => "", "colWhere" => "", "table" => ""];
$arralterErr = [];
$arrSelectErr = ["key" => "", "value" => "", "table" => "", "col" => ""];
$arrInsertErr = ["key" => "", "value" => "", "table" => ""];
$key = $value = $table = $order = $col = $valueWhere = $colWhere = "";
$keyerr = $valueerr = $colerr = $tableerr = $keyserr = $colWhereeerr = $valueWhereerr = "";

$mysqli = mysqli_connect($host, $user, $password, $dbName);
if (!$mysqli) {
    die('Could not connect: ' . mysql_error());
}

if (!isset($_POST['requestType'])) {
    $requestType = false;
    print_r("'requestType' tiene que tener un valor (update,create, select)");
    exit();
} elseif (!in_array($_POST['requestType'], $arrOfTypes)) {
    print_r("requestType: '" . $_POST['requestType'] . "' No parece una opcion correcta");
    exit();
} else {
    $requestType = $_POST['requestType'];
}

switch ($requestType) {
    case "update":
        $arrErr = $arrUpdateErr;
        break;
    case "insert":
        $arrErr = $arrInsertErr;
        break;
    case "select":
        $arrErr = $arrSelectErr;
        break;
    case "alter":
        $arrErr = $arrAlterErr;
        break;
}

for ($i = 0; $i < count($arrOfGet); $i++) {
    $getKeys = $arrOfGet[$i];
    $refVal = $getKeys;

    checkIsSet($getKeys, $getkeys, $arrErr);
}

if (in_array("no asignado", $arrErr)) {
    foreach ($arrErr as $errKey => $errValue) {
        if ($arrErr[$errKey] == "no asignado") {
            print_r("'" . $errKey . "' " . $errValue . ". ");

        }
    }
    exit();
}

function checkIsSet($val, &$getkeys, &$arrErr)
{

    if (isset($_POST[$val])) {
        $getkeys[$val] = $_POST[$val];
        $error = false;
    } else {
        if (array_key_exists($val, $arrErr)) {
            $arrErr[$val] = "no asignado";
        }
    }

}

switch ($requestType) {
    case "update":
        $query = 'UPDATE ' . $_POST["table"] . '
        SET ' . $_POST["col"] . ' = ' . $_POST["value"] . '
        WHERE ' . $_POST["colWhere"] . ' = ' . $_POST["valueWhere"] . '';

        break;
    case "insert":
        $query = 'INSERT INTO ' . $_POST["table"] . ' (' . $_POST["key"] . ')
        VALUES (' . $_POST["value"] . ')';
        break;
    case "select":
        $query = 'SELECT ' . $_POST["col"] . ' FROM  ' . $_POST["table"] . ' WHERE  ' . $_POST["key"] . ' = ' . $_POST["value"] . '';
        break;
}
$result = $mysqli->query($query);
if (!$result) {
    echo ("Error description: " . $mysqli->error);
} else {
    if ($requestType == "select") {
        print_r(json_encode(mysqli_fetch_all($result)));
    } else {
        print_r("Ingresado correctamente");
    }

}
