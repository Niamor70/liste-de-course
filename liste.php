<?php
// connexion à la base de données
try {
    $db = new PDO("mysql:host=localhost;dbname=project1;charset=utf8mb4",
        "admin", "admin");
} catch (\PDOException $e) {
    var_dump($e);
    exit;
}

// ajout d'un produit dans la base de données
if ( isset($_POST['product']) ) {
    $add_product = $db->prepare("INSERT INTO product (name) VALUES (:name)");
    $add_product->execute([
        'name' => $_POST['product'],
    ]);
    header('Location: liste.php');
}

// suppression d'un produit de la base de données
if ( isset($_POST['id']) ) {
    $delete_product = $db->prepare("DELETE FROM product WHERE id = :id");
    $delete_product->execute([
        'id' => $_POST['id'],
    ]);
    header('Location: liste.php');
}

?><!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liste de course</title>
    <link rel="stylesheet" href="https://unpkg.com/mvp.css">
</head>
<body>

<main>
    <h1>Liste de course</h1>
    <ul>
        <?php
        // récupération de la liste des produits
        $products = $db->prepare("SELECT * FROM product");
        $products->execute();
        while($product = $products->fetch()){
            // affichage de la list des produits
            echo '<li>'.$product['name'].' <form action="liste.php" method="post"><input type="hidden" value="'.$product['id'].'" name="id"><input type="submit" value="supprimer"></form></li>';
        }
        ?>
    </ul>
    <form action="liste.php" method="post">
        <h3>Ajouter un produit</h3>
        <input type="text" name="product">
        <input type="submit" value="Ajouter">
    </form>
</main>

</body>
</html>
