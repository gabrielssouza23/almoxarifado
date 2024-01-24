<?php

namespace Source\Models;

use Source\Core\Connect;
use PDO;
use PDOException;

class User
{
    private $id;
    private $nome;
    private $email;
    private $password;
    private $isAdmin;
    private $isActive;
    private $message;


    public function __construct(
        $id = null,
        $nome = null,
        $email = null,
        $password = null,
        $isAdmin = null,
        $isActive = null
    ) {
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
        $this->password = $password;
        $this->isAdmin = $isAdmin;
        $this->isActive = $isActive;
    }
    public function getId()
    {
        return $this->id;
    }

    
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->nome;
    }

    public function setName($nome): void
    {
        $this->nome = $nome;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function getPassword(): mixed
    {
        return $this->password;
    }

    public function setPassword(mixed $password): void
    {
        $this->password = $password;
    }

    public function getIsAdmin(): int
    {
        return $this->isAdmin;
    }
    public function setIsAdmin(int $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }

    public function getIsActive(): int
    {
        return $this->isActive;
    }
    public function setIsActive(int $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function insert(): bool
    {
        if ($this->findByEmail($this->email)) {
            $this->message = "E-mail já cadastrado!";
            return false;
        }
        $query = "INSERT INTO usuarios VALUES (null, :name,:email,:password, :isAdmin, :isActive)";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":name", $this->nome);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":isAdmin", $this->isAdmin);
        $stmt->bindValue(":isActive", 1);
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $stmt->bindParam(":password", $this->password);
        try {
            $stmt->execute();
            if ($stmt->rowCount()) {
                $this->message = "Usuário inserido com sucesso!";
                return true;
            }
            $this->message = "Erro ao inserir usuário, verifique os dados!";
            return false;
        } catch (PDOException $e) {
            $this->message = "Erro: {$e->getMessage()}";
            return false;
        }
    }
    public function auth(string $email, string $password): bool
    {
        $query = "SELECT * FROM usuarios WHERE email LIKE :email";

        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            $this->message = "Usuário não encontrado";
            return false;
        }
        $user = $stmt->fetch();

        if (!password_verify($password, $user->senha)) {
            $this->message = "Senha incorreta!";
            return false;
        }

        $this->nome = $user->nome;
        $this->email = $user->email;
        $this->id = $user->id;
        $this->isAdmin = $user->isAdmin;
        $this->isActive = $user->isActive;
        return true;
    }

    public function findById(int $id): User
    {
        $query = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":id", $id);
        try {
            $stmt->execute();
            if ($stmt->rowCount()) {
                $user = $stmt->fetch();
                $this->id = $user->id;
                $this->nome = $user->nome;
                $this->email = $user->email;
                $this->isAdmin = $user->isAdmin;
                $this->isActive = $user->isActive;
                $this->password = $user->password;
                return $this;
            }
            $this->message = "Usuário não encontrado!";
            return $this;
        } catch (PDOException $e) {
            $this->message = "Erro: {$e->getMessage()}";
            return $this;
        }
    }
    public function findByEmail(string $email): bool
    {
        $query = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":email", $email);
        try {
            $stmt->execute();
            if ($stmt->rowCount()) {
                $user = $stmt->fetch();
                $this->id = $user->id;
                $this->nome = $user->nome;
                $this->email = $user->email;
                $this->isAdmin = $user->isAdmin;
                $this->isActive = $user->isActive;
                return true;
            }
            $this->message = "Usuário não encontrado!";
            return false;
        } catch (PDOException $e) {
            $this->message = "Erro: {$e->getMessage()}";
            return false;
        }
    }



    public function selectAllUsers()
    {
        $query = "
            SELECT
                * 
            FROM
                usuarios
        ";

        $stmt = Connect::getInstance()->query($query);
        return $stmt->fetchAll();
    }

    public function selectUserById()
    {
        $query = "
            SELECT
                * 
            FROM
                usuarios
            WHERE
                id = :id
        ";

        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        
        // return $stmt->fetchAll();
        try {
            $stmt->execute();
            return true; // Retorna true se a execução for bem-sucedida
        } catch (PDOException $e) {
            // Trate qualquer exceção gerada durante a execução da consulta
            // Você pode fazer log do erro ou lidar de outra maneira adequada ao seu aplicativo
            return false;
        }
    }
    public function updateUser(){
        $query = "UPDATE usuarios SET nome = :nome,
        email = :email,
        isAdmin = :isAdmin,
        isActive = :isActive
        WHERE id = :id";

        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':isAdmin', $this->isAdmin);
        $stmt->bindParam(':isActive', $this->isActive);

        try {
            $stmt->execute();
            return true; // Retorna true se a execução for bem-sucedida
        } catch (PDOException $e) {
            // Trate qualquer exceção gerada durante a execução da consulta
            return false;
        }
    }
}
