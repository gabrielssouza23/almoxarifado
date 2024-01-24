<?php

namespace Source\Models;

use Source\Core\Connect;
use PDO;
use PDOException;

class UserDelete
{
    private $id;
 
    private $isActive;


    public function __construct(
        $id = null,
        $isActive = null
    ) {
        $this->id = $id;
        $this->isActive = $isActive;
    }
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }


    public function getIsActive(): int
    {
        return $this->isActive;
    }
    public function setIsActive(int $isActive): void
    {
        $this->isActive = $isActive;
    }


    public function deleteUser()
    {
        $query = "
        UPDATE usuarios
        SET isActive = :isActive
        WHERE id = :id
    ";
    $stmt = Connect::getInstance()->prepare($query);
    $stmt->bindParam(':id', $this->id);
    $stmt->bindValue(':isActive', 0);
    
    try {
        $stmt->execute();
        return true; // Return true if the execution is successful
    } catch (PDOException $e) {
        // Handle any exception generated during the query execution
        return false;
    }

    }
}
