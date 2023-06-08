<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class AuxRolModel extends \Com\Daw2\Core\BaseModel {
    
    public function roles() : array{
        $stmt = $this->pdo->query('SELECT * FROM aux_rol');
        return $stmt->fetchAll();
    }
}
