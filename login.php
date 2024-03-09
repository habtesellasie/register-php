<?php

$connection = require_once './connection.php';

$posted = $_POST;
$file = $_FILES;

$first_name = '';
$last_name = '';
$email = '';
$user_password = '';
$confirmPassword = '';
$error_msg = '';

$id = $_POST['id'] ?? "";

if (isset($posted['sign_up'])) {
    $first_name = filter_var(trim($posted['first_name']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $last_name = filter_var(trim($posted['last_name']), FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var(trim($posted['email']), FILTER_VALIDATE_EMAIL);
    $user_password = filter_var($posted['password']);
    $confirmPassword = filter_var($posted['confirm_password']);
    $photo = $file['photo']['name'];
    $target_dir = "./uploads/";
    $target_file_path = $target_dir . $photo;

    if ($_FILES['photo']['error'] === UPLOAD_ERR_OK && $user_password === $confirmPassword) {
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file_path)) {
            $connection->addUser($posted, $target_file_path);
            $users = $connection->getUsers();
            header("Location: index.php");
            exit();
        } else {
            $error_msg = "Failed to upload the photo.";
        }
    } else {
        $error_msg = "Passwords do not match.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Sign up</title>
</head>

<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <h3>Personal Information</h3><br>
        <div class="passwords">
            <div class="form-divider">
                <label for="first_time">First name:</label><br>
                <input type="text" name="first_name" id="first_name" required value="<?php echo $first_name ?>">
            </div>
            <div class="form-divider">
                <label for="last_name">Last name:</label><br>
                <input type="text" name="last_name" id="last_name" required value="<?php echo $last_name ?>">
            </div>
        </div>
        <div class="form-divider">
            <label for="email">Email: </label><br>
            <input type="email" name="email" id="email" required value="<?php echo $email ?>">
        </div>
        <div class="passwords">
            <div class="form-divider">
                <label for="password">Password: </label><br>
                <input type="password" name="password" id="password" required value="<?php echo $user_password ?>">
            </div>
            <div class="form-divider">
                <label for="confirm_password">Confirm Password: </label><br>
                <input type="password" name="confirm_password" id="confirm_password" required>
                <span style="color: red;"><?php echo $error_msg ?></span>
            </div>
        </div>

        <div class="form-divider">
            <label for="photo">Photo: </label>
            <input type="file" name="photo" id="photo" required>
        </div><br>
        <div class="form-divider button-div">
            <input type="submit" name="sign_up" value="Sign up">
        </div>
    </form>
</body>

</html>