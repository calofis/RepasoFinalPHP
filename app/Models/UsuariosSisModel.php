<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class UsuariosSisModel extends \Com\Daw2\Core\BaseModel {

    public function doLogin(array $valores): ?array {
        $stmt = $this->pdo->prepare('SELECT usuario_sistema.*, aux_rol.nombre_rol FROM usuario_sistema LEFT JOIN  aux_rol ON usuario_sistema.id_rol = aux_rol.id_rol WHERE email = ? and baja = 0');
        $stmt->execute([$valores['username']]);
        if ($stmt->rowCount() == 1) {
            $datosUsuario = $stmt->fetch();

            if (password_verify($valores['pass'], $datosUsuario['pass'])) {
                if (!$this->fechaDeLogin(date('Y-m-d G:i:s'), $datosUsuario['email'])) {
                    return NULL;
                }
                unset($datosUsuario['pass']);
                return $datosUsuario;
            }
        }
        return NULL;
    }

    private function fechaDeLogin(string $fecha, string $email): bool {
        $stmt = $this->pdo->prepare('UPDATE usuario_sistema SET last_date = ? WHERE email = ? ');
        $stmt->execute([$fecha, $email]);
        return $stmt->rowCount() > 0;
    }

    public function showTable() {
        $stmt = $this->pdo->query('SELECT usuario_sistema.*, aux_rol.nombre_rol FROM usuario_sistema LEFT JOIN  aux_rol ON usuario_sistema.id_rol = aux_rol.id_rol');
        return $stmt->fetchAll();
    }

    public function baja(int $estado, string $id_usuario): bool {
        if ($estado == 1) {
            $stmt = $this->pdo->prepare('UPDATE usuario_sistema SET baja = 0 WHERE id_usuario = ? ');
        } else {
            $stmt = $this->pdo->prepare('UPDATE usuario_sistema SET baja = 1 WHERE id_usuario = ? ');
        }
        $stmt->execute([$id_usuario]);
        return $stmt->rowCount() > 0;
    }

    public function obtenerDatosId($id): array {
        $stmt = $this->pdo->prepare('SELECT * FROM usuario_sistema WHERE id_usuario = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function delete(string $id_usuario): bool {
        $stmt = $this->pdo->prepare('DELETE FROM usuario_sistema WHERE id_usuario = ? ');
        $stmt->execute([$id_usuario]);
        return $stmt->rowCount() > 0;
    }
    
     public function crear(array $valores): bool {
        $stmt = $this->pdo->prepare('INSERT INTO usuario_sistema (id_rol, email, pass, username, idioma) VALUES (:rol, :email, :password, :username, :idioma)');
        $stmt->execute($valores);
        return $stmt->rowCount() > 0;
    }

}
