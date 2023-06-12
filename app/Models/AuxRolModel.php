<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class AuxRolModel extends \Com\Daw2\Core\BaseModel {
    
    public function roles() : array{
        $stmt = $this->pdo->query('SELECT * FROM aux_rol');
        return $stmt->fetchAll();
    }
    
    public function existRol(string $id) : bool{
        $stmt = $this->pdo->prepare('SELECT * FROM aux_rol WHERE id_rol = ?');
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
}
