<?php

$connection = require_once './connection.php';
$users = $connection->getUsers();

$thePhoto = '';

foreach ($users as $user) {
    $thePhoto = $user['photo'];
}
if (isset($_FILES['photo'])) {
    $photo = $_FILES['photo']['name'];
    $target_dir = "./uploads/";
    $target_file_path = $target_dir . $photo;

    if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file_path)) {
        $thePhoto = $target_file_path;
        $connection->updateUserPhoto($user['id'], $thePhoto);
    } else {
        echo "Failed to upload the photo.";
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
    <title>Dashboard</title>
</head>

<body>

    <header>
        <nav>
            <ul>
                <li class="logo"><a href=""></a></li>
                <li><a href="#home">Home</a></li>
                <?php if (empty($users)) : ?>
                    <li><a href="login.php" class="log-in">Log In</a></li>
                <?php else : ?>
                    <li class="user-image"><a href="my_profile.php"><img src="<?php echo $thePhoto ?>" alt=""></a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
        <section id="home" style="margin-top: 2.5rem;">
            <?php if (empty($users)) : ?>
                <h2>Hello <span style="color: yellow">guest</span></h2>
            <?php else : ?>
                <?php foreach ($users as $user) : ?>
                    <h4>Your Profile picture: </h4>
                    <div class="image_wrapper">
                        <img src="<?= $thePhoto ?>" alt="">
                    </div>
                    <h2>Welcome <span style="color: #00FFC5"><?php echo $user['first_name'] . " "  . $user['last_name'] ?></span></h2>
                    <br>
                    <h3 style="margin-left: 1rem;">Your email address is: <span style="color: #00FFC5;"><?= $user['email'] ?></span></h3>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </main>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: black;
            color: white;
            font-family: sans-serif;
        }

        .image_wrapper {
            width: 300px;
            padding: 10px;
        }


        #home {
            border: solid #00FFC5;
            padding: 2rem 1rem;
        }

        .image_wrapper img {
            width: 100%;
        }

        header {
            padding: 10px;
            position: relative;
            padding-bottom: 3.2rem;
        }

        nav {
            border-bottom: white solid;
            margin-inline: auto;
            max-width: 1500px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 99;
            background-color: black;
        }

        ul {
            display: flex;
            color: white;
            align-items: center;
            gap: 10px;
            list-style: none;
            padding: 20px;
        }

        ul li a {
            color: white;
            text-decoration: none;
        }

        .logo {
            margin-right: auto;
        }

        .sign-up,
        .log-in {
            padding: 5px 10px;
            border-radius: 18px;
            transition: all 0.2s ease-in;
        }

        .sign-up {
            background-color: white;
            color: black;
        }

        .log-in {
            background-color: #00FFC5;
            color: black;
            font-weight: bold;
            padding: 8px 15px;
        }

        .sign-up:hover {
            background-color: black;
            color: white;
        }

        .log-in:hover {
            background-color: black;
            color: white;
        }

        section {
            min-height: unset;
        }

        h2 {
            margin-left: 1rem;
        }

        .user-image {
            width: 45px;
            height: 45px;
            overflow: hidden;
        }

        .user-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        header {
            border: none;
        }

        nav {
            border: none;
            border-bottom: solid white !important;
        }

        ul {
            align-items: center;
        }

        .user-image {
            width: 50px;
            height: 50px;
        }

        .user-image img {
            border-radius: 50%;
            width: 100%;
            object-fit: cover;
        }

        h2 {
            margin-left: 1rem;
        }
    </style>
    <footer>

    </footer>
</body>

</html>