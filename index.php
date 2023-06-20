<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hackers Poulette</title>
</head>

<body>
    <form action="index.php" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name">
        <label for="lastname">Lastname:</label>
        <input type="text" name="lastname">
        <label for="email">Email adress:</label>
        <input type="email" name="email">
        <label for="file" accept=".jpg, .jpeg, .png, .gif">File:</label>
        <input type="file" name="file">
        <label for="description">Description:</label>
        <input type="text" name="description">
        <button type="submit" name="submit">Send</button>
    </form>
</body>

<?php

if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $file = $_POST["file"];
    $description = $_POST["description"];

    $filterName = filter_var($name, FILTER_SANITIZE_STRING);
    $filterLastname = filter_var($lastname, FILTER_SANITIZE_STRING);
    $filterEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
    $filterDescritption = filter_var($description, FILTER_SANITIZE_STRING);

    $errors = [];

    if (empty($filterName)) {
        $errors[] = 'Firstname is required';
    }
    if (empty($filterLastname)) {
        $errors[] = 'Lastname is required';
    }
    if (empty($filterEmail)) {
        $errors[] = 'Email is required';
    }
    if (empty($filterDescritption)) {
        $errors[] = 'Description is required';
    }
    if (empty($file)) {
        $errors[] = 'File is required';
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo '<p class="error">' . $error . '</p>';
        }
    } else
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=Support;charset=utf8', 'root', '');
            $query = 'INSERT into Form (name,lastname,email,file,description)
        values ("' . $name . '","' . $lastname . '","' . $email . '","' . $file . '","' . $description . '");
        ';
            $stmt = $pdo->query($query);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
}
?>

</html>