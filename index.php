<?php


$coucou = $_POST['nomAnime'];
function graphql_query(string $endpoint, string $query, array $variables = []): array
{
    $headers = ['Content-Type: application/json', 'User-Agent: Anemy Client'];

    if (false === $data = @file_get_contents($endpoint, false, stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => $headers,
                'content' => json_encode(['query' => $query, 'variables' => $variables]),
            ]
        ]))) {
        $error = error_get_last();
        throw new \ErrorException($error['message'], $error['type']);
    }

    return json_decode($data, true);
}

$url = "https://api.anemy.fr/v3/";

$query = '
query($nom: String){
	Page {
		Animes(nom: $nom) {
		id
		noms {
			romaji
			anglais
			natif
		}
		images{
			affiche
			banniere
			autres {
				id
				affiche
				nom
			}
		}
		description
	}
	}
}
';

$variables = [
    "nom" => $coucou
];


$result = graphql_query($url, $query, $variables);

$animes = $result['data']['Page']['Animes'];
?>
<form action="index.php" method="post">
    <input type="search" placeholder="Anime" name="nomAnime">
    <button type="submit">Search</button>
</form>



<?php foreach ($animes as $anime) :  ?>

    <div>
        <h3><?= $anime['noms']['romaji'] ?></h3>
        <img src="<?php echo $anime['images']['affiche'] ?>">
    </div>

<?php endforeach; ?>



