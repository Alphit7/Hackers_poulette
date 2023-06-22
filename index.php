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

    <form action="index.php" method="post" enctype="multipart/form-data">
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
</body>

<?php

require 'assets/config/config.php';


require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

if (isset($_POST["submit"])) {
    $name = $_POST["namejfznfo"];
    $lastname = $_POST["lastnameksxcins"];
    $email = $_POST["emailsklqds"];
    $file = $_FILES["filekdqsqo"];
    $description = $_POST["descriptionpqcdq"];

    $filterName = filter_var($name, FILTER_SANITIZE_STRING);
    $filterLastname = filter_var($lastname, FILTER_SANITIZE_STRING);
    $filterEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
    $filterDescritption = filter_var($description, FILTER_SANITIZE_STRING);

    $errors = [];

    if (empty($filterName) or strlen($filterName) < 2) {
        $errors[] = 'Firstname is required';
    }
    if (empty($filterLastname) or strlen($filterLastname) < 2) {
        $errors[] = 'Lastname is required';
    }
    if (empty($filterEmail) or strlen($filterEmail) < 2) {
        $errors[] = 'Email is required';
    }
    if (empty($filterDescritption)) {
        $errors[] = 'Description is required';
    }
    if (!empty($_POST['name']) || !empty($_POST['lastname']) || !empty($_POST['email']) || !empty($_POST['description'])) {
        $errors[] = "Nice try bot";
    }

    if ($_FILES["filekdqsqo"]["error"] !== UPLOAD_ERR_NO_FILE) {
        $file = $_FILES["filekdqsqo"];
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $maxFileSize = 2 * 1024 * 1024; // 2MB

        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            $errors[] = 'Invalid file format. Allowed formats: ' . implode(', ', $allowedExtensions);
        }

        if ($file['size'] > $maxFileSize) {
            $errors[] = 'File size exceeds the maximum limit of ' . ($maxFileSize / (1024 * 1024)) . 'MB';
        }
    }

    if (empty($errors)) {
        if ($_FILES["filekdqsqo"]["error"] !== UPLOAD_ERR_NO_FILE) {
            $targetDir = 'uploads/';
            $targetFile = $targetDir . basename($file['name']);

            if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                // File uploaded successfully
            } else {
                $errors[] = 'Failed to move uploaded file';
            }
        }

        try {
            $pdo = new PDO('mysql:host=localhost;dbname=id20943645_support;charset=utf8', $dbUserName, $dbPassword);
            $query = 'INSERT INTO Form (name, lastname, email, file, description)
                    VALUES ("' . $name . '","' . $lastname . '","' . $email . '","' . $file['name'] . '","' . $description . '");
                    ';
            $stmt = $pdo->query($query);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


            echo "<span class='Support__Request__Validation'> Your request has been successfully sent !</span>";
            try {
                // SMTP configuration
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = $mailUsername;
                $mail->Password = $mailPassword;
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Sender and recipient
                $mail->setFrom($mailUsername, 'Support');
                $mail->addAddress($email, $name);

                // Email content
                $mail->Subject = 'Support';
                $mail->Body = "It's finally working";

                // Send the email
                $mail->send();

            } catch (Exception $e) {
                echo 'Email could not be sent. Error: ', $mail->ErrorInfo;
            }

        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo '<p class="error">' . $error . '</p>';
        }
    }
}
?>

<script src="client-side-validation.js"></script>

</html>