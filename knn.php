<html>
   <head>
     <meta charset="UTF-8">
     <title> implementation de la methode KNN </title>
   </head>
   <body>  
<?php

// Fonction pour calculer la distance euclidienne entre deux points
function euclideanDistance($point1, $point2) {
    $sum = 0;
    $dimensions = count($point1);

    for ($i = 0; $i < $dimensions; $i++) {
        $difference = $point1[$i] - $point2[$i];
        $sum += $difference * $difference;
    }

    return sqrt($sum);
}

// Fonction KNN
function knn($k, $dataset, $newData) {
    // Calculer les distances entre le nouvel exemple et tous les exemples du jeu de données
  $distances = array(); // Tableau pour stocker les distances et les indices

foreach ($dataset as $index => $data) {   
    $distance = euclideanDistance($newData, $data);
    $distances[] = array('index' => $index, 'dist' => $distance);
}


    

    //Trier les distances par ordre croissant
    usort($distances, function($a, $b) {
        return $a['dist'] <=> $b['dist']; //L'opérateur <=> est utilisé pour effectuer la comparaison numérique entre les valeurs des distances. Il triera le tableau par ordre croissant des distances.
    });
    

    // Sélectionner les k voisins les plus proches
    $neighbors = array_slice($distances, 0, $k);
    

    $sortedIndices = array_column($neighbors, 'index'); //extrait uniquement les indices deja tries et les stocke dans sortedIndices
    $sortedData = array(); // sortedData tableau vide qui va contenir les lignes memes memes correspondant aux indices

    foreach ($sortedIndices as $index) {
    $sortedData[] = $dataset[$index];   // agit comme 'array_push'
        }

    // Retourner les k voisins les plus proches
    return $sortedData;
}

// Chemin vers le fichier CSV
$filePath = 'numeric_data.csv';

// Ouvrir le fichier en mode lecture
$file = fopen($filePath, 'r');

// Lire la première ligne (en-têtes des colonnes)
$headers = fgetcsv($file);

// Initialiser le tableau pour stocker le jeu de données
$dataset = array();

// Lire les lignes restantes du fichier et extraire les valeurs numériques
while (($data = fgetcsv($file)) !== false) {
    $dataset[] = array_map('floatval', $data);//ajoute une nouvelle entrée(lignes) au tableau $dataset en convertissant chaque élément du tableau $data en une valeur flottante à l'aide de la fonction floatval().
}

// Fermer le fichier
fclose($file);



// Nouvelles données
$newData = [3,9,4.65,7.833,9,7.72,0.0359,0.0803,0.4,0.8833,0.925,23.976,52
];

// Paramètres KNN
$k = 5;

// Appliquer l'algorithme KNN
// $neighbors = knn($k, $dataset, $newData);
$sortedData = knn($k, $dataset, $newData);

// Afficher les k voisins les plus proches
echo "Les k voisins les plus proches sont : ";
// print_r($neighbors);
print_r($sortedData);

?>

   </body>

</html>





