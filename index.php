<?php

include "auth.php";

$arrOfTypes = ["update", "alter", "select", "insert"];
$arrOfGet = ["key", "value", "table", "order", "col", "valueWhere", "keyWhere"];
$arrErr = [];
$arrUpdateErr = ["key" => "", "value" => "", "valueWhere" => "", "keyWhere" => "", "table" => ""];
$arralterErr = [];
$arrSelectErr = ["key" => "", "value" => "", "table" => "", "col" => ""];
$arrInsertErr = ["key" => "", "value" => "", "table" => ""];
$key = $value = $table = $order = $col = $valueWhere = $keyWhere = "";
$keyerr = $valueerr = $colerr = $tableerr = $keyserr = $keyWhereerr = $valueWhereerr = "";

$mysqli = mysqli_connect($host, $user, $password, $dbName);
if (!$mysqli) {
    die('Could not connect: ' . mysql_error());
}

if (!isset($_GET['requestType'])) {
    $requestType = false;
    print_r("'requestType' tiene que tener un valor (update,create, select)");
    exit();
} elseif (!in_array($_GET['requestType'], $arrOfTypes)) {
    print_r("requestType: '" . $_GET['requestType'] . "' No parece una opcion correcta");
    exit();
} else {
    $requestType = $_GET['requestType'];
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
}

function checkIsSet($val, &$getkeys, &$arrErr)
{

    if (isset($_GET[$val])) {
        $getkeys[$val] = $_GET[$val];
        $error = false;
    } else {
        if (array_key_exists($val, $arrErr)) {
            $arrErr[$val] = "no asignado";
        }
    }

}
var_dump($getKeys);

switch ($requestType) {
    case "update":
        $query = "INSERT INTO $table ($keys)
        VALUES ($values)";
        break;
    case "insert":
        $query = 0;
        break;
    case "select":
        $query = "SELECT $col FROM $table WHERE $key = $value";
        break;
}
$result = $mysqli->query($query);
if (!$result) {
    echo ("Error description: " . $mysqli->error);
} else {
    print_r("Ingresado correctamente");

}

?>
<body style="background-color:black; color: white">

</body>
