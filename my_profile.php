<?php

$connection = require_once "./connection.php";
$users = $connection->getUsers();
$id = $_POST['id'] ?? "";
$error_msg = '';

if (isset($_POST['update'])) {
    $user_password = htmlspecialchars($_POST['password']);
    $confirmPassword = htmlspecialchars($_POST['confirm_password']);

    if ($_FILES['photo']['size'] > 0) {
        $target_dir = "./uploads/";
        $photo = $_FILES['photo']['name'];
        $target_file_path = $target_dir . $photo;

        if ($_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file_path) && $user_password === $confirmPassword) {
                $connection->updateUser($id, $_POST, $target_file_path);
                header("Location: index.php");
                exit();
            } else {
                $error_msg = "Failed to upload the photo or passwords do not match.";
            }
        } else {
            $error_msg = "Failed to upload the photo.";
        }
    } else {
        if ($user_password === $confirmPassword) {
            $user = $connection->getUserById($id);
            $connection->updateUser($id, $_POST, $user['photo']);
            header("Location: index.php");
            exit();
        } else {
            $error_msg = "Passwords do not match.";
        }
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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            /* font-family: sans-serif; */
        }

        .contain-delete form {
            padding: 0 !important;
            max-width: 180px;
            margin-left: 3rem;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        h2 {
            margin-left: 1rem;
        }

        .contain-delete input {
            background-color: rgba(203, 24, 24);
            color: white;
        }

        body {
            background-color: white;
            color: black;
        }

        .image-wrapper {
            width: 160px;
        }

        .image-wrapper img {
            width: 100%;
        }

        body {
            background-color: black;
            color: white;
        }

        form {
            max-width: 450px;
            border-radius: 5px;
            background-color: black;
            padding: 3rem;
            padding-bottom: 0;
        }

        .form-divider {
            display: flex;
            flex-direction: column;
            margin-bottom: 1rem;
        }

        input {
            padding: 8px 5px;
            background-color: transparent;
            color: white;
            font-size: 18px;
            border: none;
            border: solid white .5px;
            border-radius: 2px;

        }

        .button-div {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .have-account {
            margin-top: 1rem;
        }

        .have-account a {
            color: blue;
        }

        .new-user {
            margin-bottom: 1rem;
        }

        input[type='file'] {
            /* border: solid red; */
            padding: 0;
            border: none;
        }

        .passwords {
            display: flex;
            gap: 10px;
        }

        .passwords-button {
            display: flex;
            gap: 10px;
        }

        .passwords-button input {
            display: inline-block;
            width: 350px;
        }

        .passwords input {
            width: 100%;
        }

        .back-button {
            margin-top: 3rem;
            margin-left: 3rem;
        }

        .back-button a {
            color: white;
            text-underline-offset: .5rem;
        }
    </style>
    <title>Update profile</title>
</head>

<body>
    <div class="back-button">
        <a href="index.php">Back</a><br>
    </div><br>
    <h2 style="padding-left: 2rem;">Update your profile</h2>

    <form action="my_profile.php" method="POST" enctype="multipart/form-data">
        <div class="form-divider">
            <?php foreach ($users as $user) : ?>
                <div class="image-wrapper">
                    <img src="<?php echo $user['photo'] ?>" alt="">
                </div>
        </div>
        <div class="form-divider">
            <label for="photo">Update profile picture:</label><br>
            <input type="file" name="photo" id="photo">
        </div>
        <div class="passwords">
            <div class="form-divider">
                <input type="hidden" name="id" value="<?php echo $user['id'] ?>">
                <label for="first_time">First name:</label><br>
                <input type="text" name="first_name" id="first_name" required value="<?php echo isset($_POST['first_name']) ? $_POST['first_name'] : $user['first_name'] ?>">
            </div>
            <div class="form-divider">
                <label for="last_name">Last name:</label><br>
                <input type="text" name="last_name" id="last_name" required value="<?php echo isset($_POST['last_name']) ? $_POST['last_name'] : $user['last_name'] ?>">
            </div>
        </div>
        </div>
        <div class="form-divider">
            <label for="email">Email: </label><br>
            <input type="email" name="email" id="email" required value="<?php echo isset($_POST['email']) ? $_POST['email'] : $user['email'] ?>">
        </div>
        <div class="passwords">
            <div class="form-divider">
                <label for="password">New Password: </label><br>
                <input type="password" name="password" id="password" required value="<?php echo isset($_POST['password']) ? $_POST['password'] : $user['password'] ?>">
            </div>
            <div class="form-divider">
                <label for="confirm_password">Confirm Password: </label><br>
                <input type="password" name="confirm_password" id="confirm_password">
                <span style="color: red; padding: 5px; font-size: 14.42px;"><?php echo $error_msg ?></span>
            </div>
        </div>
        <span style="color: rgb(77, 150, 235); padding: 15px 0px;">Confirm the password first to update</span>

        <div class=" form-divider">
            <input type="hidden" value="<?php echo $user['id'] ?>">
            <input type="submit" name="update" id="update" value="Update" style="background-color: #F9C80E; color:black;">
        </div>
        <div class="form-divider">
        <?php endforeach; ?>

        </div>
    </form>
    <div class="contain-delete">
        <form action="delete.php" method="POST">
            <label for="delete">Delete my account</label>
            <input type="submit" name='delete' id="delete" value="Delete">
            <span style="color: red;">This can't be undone</span>

        </form>
    </div>



</body>

</html>