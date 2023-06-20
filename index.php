<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Hackers Poulette</title>
</head>

<body>

    <form action="index.php" method="post">
        <div class="Support__Request">
            <label for="namejfznfo">Name:</label>
            <input type="text" name="namejfznfo" id="namejfznfo" required maxlength="255">
            <label for="lastnameksxcins">Lastname:</label>
            <input type="text" name="lastnameksxcins" id="lastnameksxcins" required maxlength="255">
            <label for="emailsklqds">Email adress:</label>
            <input type="email" name="emailsklqds" id="emailsklqds" required maxlength="255">
            <label for="filekdqsqo" accept=".jpg, .jpeg, .png, .gif">File:</label>
            <input type="file" name="filekdqsqo" id="filekdqsqo" accept="image/x-png,image/gif,image/jpeg">
            <label for="descriptionpqcdq">Description:</label>
            <textarea name="descriptionpqcdq" id="descriptionpqcdq" rows="4" required maxlength="1000"></textarea>
            <button type="submit" name="submit" id="submit">Send</button>
        </div>

        <div class="ohnohoney">
            <label class="ohnohoney" for="name"></label>
            <input class="ohnohoney" autocomplete="off" type="text" id="name" name="name" placeholder="Your name here">
            <label class="ohnohoney" for="lastname"></label>
            <input class="ohnohoney" autocomplete="off" type="lastname" id="lastname" name="lastname"
                placeholder="Your lastname here">
            <label class="ohnohoney" for="email"></label>
            <input class="ohnohoney" autocomplete="off" type="email" id="email" name="email"
                placeholder="Your e-mail here">
            <label class="ohnohoney" for="file"></label>
            <input class="ohnohoney" autocomplete="off" type="file" id="file" name="file" placeholder="Your file here">
            <label class="ohnohoney" for="description"></label>
            <input class="ohnohoney" autocomplete="off" type="text" id="description" name="description"
                placeholder="Your description here">
        </div>
    </form>
    <script src="client-side-validation.js"></script>
</body>

<?php

require 'assets/src/PHPMailer.php';

if (isset($_POST["submit"])) {
    $name = $_POST["namejfznfo"];
    $lastname = $_POST["lastnameksxcins"];
    $email = $_POST["emailsklqds"];
    $file = $_POST["filekdqsqo"];
    $description = $_POST["descriptionpqcdq"];

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
    if (!empty($_POST['name']) or !empty($_POST['lastname']) or !empty($_POST['email']) or !empty($_POST['file']) or !empty($_POST['description'])) {
        $errors[] = "Nice try bot";
    }if(filesize($file) > 2097152){
        echo '<p>This file is too big</p>';
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
            echo "<span class='Support__Request__Validation'> Your request has been successfully sent !</span>";
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
}
?>

</html>