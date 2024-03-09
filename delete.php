<?php

$connection = require_once "./connection.php";


$id = $_POST['id'] ?? "";

if (isset($_POST['delete'])) {
    $users = $connection->getUsers();
    foreach ($users as $user) {
        $id = $user['id'];
    }
    $connection->deleteUser($id);
    header("Location: index.php");
}
