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
    exit();
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

switch ($requestType) {
    case "update":
        $query = 'UPDATE ' . $_GET["table"] . '
        SET ' . $_GET["col"] . ' = ' . $_GET["value"] . '
        WHERE ' . $_GET["colWhere"] . ' = ' . $_GET["valueWhere"] . '';

        break;
    case "insert":
        $query = "INSERT INTO $table ($keys)
        VALUES ($values)";
        break;
    case "select":
        $query = 'SELECT ' . $_GET["col"] . ' FROM  ' . $_GET["table"] . ' WHERE  ' . $_GET["key"] . ' = ' . $_GET["value"] . '';
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
