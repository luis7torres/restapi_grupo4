<?php
header("Access-Control-Allow-Origin: *"); 

header("Content-Type: application/json; charset=UTF-8");

header("Access-Control-Allow-Methods: POST");

header("Access-Control-Max-Age: 3600");

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once 'Database.php';
include_once 'contacto.php';

$database = new Database();
$db = $database->getConnection();

$item = new Contacto($db);

$data = json_decode(file_get_contents("php://input"));

if(isset($data->searchTerm)) {
    $result = $item->GetOneContact($data->searchTerm);

    $num = $result->rowCount();

    if($num > 0){
        $contactos_arr = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $contacto_item = array(
                "id" => $id,
                "nombre" => $nombre,
                "numero" => $telefono,
                "latitud" => $latitud,
                "longitud" => $longitud,
            );
            array_push($contactos_arr, $contacto_item);
        }
        echo json_encode($contactos_arr);
    } else {
        echo json_encode(array("message" => "No se encontraron contactos"));
    }
} else {
}

?>
