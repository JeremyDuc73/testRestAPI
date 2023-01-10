<?php
require_once ('callAPI.php');

$get_data = callAPI('GET', 'https://kitsu.io/api/edge/anime?filter[text]=chainsaw-man'.$user['User']['customer_id'], false);
$response = json_decode($get_data, true);


?>

<h1> <?= $response['data'][0]['attributes']['slug'] ?> </h1>
<p> <?= $response['data'][0]['attributes']['description'] ?> </p>

