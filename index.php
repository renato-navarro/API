<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$json = file_get_contents("php://input");
$data = json_decode($json, true);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    // Token da API
    $apiKey = $data['apikey'];
    unset($data['apikey']);

    // URL da API Monday
    $url = 'https://api.monday.com/v2';

    // JSON dos valores das colunas
    $columnValuesJson = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    // Mutation GraphQL com JSON escapado
    $mutation = '
    mutation {
      create_item(
        board_id: 9751681808,
        group_id: "topics",
        item_name: "Novo item via API",
        column_values: "' . addslashes($columnValuesJson) . '"
      ) {
        id
      }
    }
    ';

    // Corpo da requisição
    $postData = json_encode(['query' => $mutation]);

    // cURL para enviar à API
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: ' . $apiKey
    ]);

    $response = curl_exec($ch);
    curl_close($ch);


    echo $response;
} else {
    echo "Campo 'nome' não encontrado.";
}
