<?php

class Connection
{
    public PDO $pdo;

    public function __construct()
    {
        try {

            $this->pdo = new PDO('mysql:server=localhost;dbname=user_manager', 'root', '');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            throw new Exception("coudn't connect with the database " + $e->getMessage());
        }
    }

    public function getUsers()
    {
        $statement = $this->pdo->prepare("SELECT * FROM users");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function addUser($user, $target)
    {
        $statement = $this->pdo->prepare("INSERT INTO users (first_name, last_name, email, password, photo) VALUES (:first_name, :last_name, :email, :password, :photo)");
        $statement->bindValue("first_name", $user['first_name']);
        $statement->bindValue('last_name', $user['last_name']);
        $statement->bindValue('email', $user['email']);
        $statement->bindValue('password', $user['password']);
        $statement->bindValue('photo', $target);
        return $statement->execute();
    }

    public function updateUser($id, $user, $target)
    {

        $statement = $this->pdo->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, password = :password, photo = :photo WHERE id = :id");
        $statement->bindValue(":id", $id);
        $statement->bindValue(":first_name", $user['first_name']);
        $statement->bindValue(":last_name", $user['last_name']);
        $statement->bindValue(':email', $user['email']);
        $statement->bindValue(":password", $user['password']);
        $statement->bindValue(":photo", $target);
        return $statement->execute();
    }

    public function deleteUser($id)
    {
        $statement = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        $statement->bindValue("id", $id);
        return $statement->execute();
    }
}

return new Connection();
