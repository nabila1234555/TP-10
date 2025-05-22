<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <link rel="stylesheet" href="style.css">
</body>
</html>
<?php
$conn = new mysqli("localhost", "root", "", "stock_db");
if ($conn->connect_error) die("Échec de connexion: " . $conn->connect_error);

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $qty = $_POST['quantity'];
    $price = $_POST['price'];
    $conn->query("INSERT INTO products (name, quantity, price) VALUES ('$name', $qty, $price)");
}

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $qty = $_POST['quantity'];
    $price = $_POST['price'];
    $conn->query("UPDATE products SET name='$name', quantity=$qty, price=$price WHERE id=$id");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM products WHERE id=$id");
}

$products = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion de Stock</title>
    <style>
        table { border-collapse: collapse; width: 60%; margin-top: 20px; }
        th, td { border: 1px solid #999; padding: 8px; text-align: center; }
        input { margin: 5px; }
    </style>
</head>
<body>

<center><h2>Gestion de Stock </h2></center>
<center><h3>Ajouter un produit</h3></center>
<center><form method="POST">
    <input type="text" name="name" placeholder="Nom" required>
    <input type="number" name="quantity" placeholder="Quantité" required>
    <input type="number" step="0.01" name="price" placeholder="Prix " required>
    <button type="submit" name="add">Ajouter</button>
</form></center>
<center>
<h3>Produits en stock</h3></center>
<center><table>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Quantité</th>
        <th>Prix</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $products->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['quantity'] ?></td>
            <td><?= $row['price'] ?> </td>
            <td>
                <form method="POST" style="display:inline-block;">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <input type="text" name="name" value="<?= $row['name'] ?>" required>
                    <input type="number" name="quantity" value="<?= $row['quantity'] ?>" required>
                    <input type="number" step="0.01" name="price" value="<?= $row['price'] ?>" required>
                    <button type="submit" name="edit">Modifier</button>
                </form>
                <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Supprimer ce produit ?')">Supprimer</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
</center>




</body>
</html>
