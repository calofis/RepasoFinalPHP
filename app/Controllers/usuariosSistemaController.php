<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

class usuariosSistemaController extends \Com\Daw2\Core\BaseController {

    public function usuariosSistema() {
        $data = [];
        $data['titulo'] = 'Todos los usuarios';
        $data['seccion'] = '/usuarios-sistema';
        $modelUsuariosSis = new \Com\Daw2\Models\UsuariosSisModel();
        $usuarios = $modelUsuariosSis->showTable();
        $data['usuarios'] = $usuarios;
        $this->view->showViews(array('templates/header.view.php', 'usuarioSistema.view.php', 'templates/footer.view.php'), $data);
    }

    public function baja($id) {
        $modelUsuariosSis = new \Com\Daw2\Models\UsuariosSisModel();
        $datosUsuario = $modelUsuariosSis->obtenerDatosId($id);
        if ($modelUsuariosSis->baja($datosUsuario['baja'], $id)) {
            header('location: /usuarios-sistema');
        }
    }

    public function delete($id) {
        $modelUsuariosSis = new \Com\Daw2\Models\UsuariosSisModel();
        if ($modelUsuariosSis->delete($id)) {
            header('location: /usuarios-sistema');
        }
    }

    public function crear() {
        $data = [];
        $data['titulo'] = 'Añadir usuario';
        $data['seccion'] = '/usuarios-sistema/add';
        $modelRoles = new \Com\Daw2\Models\AuxRolModel();
        $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        $roles = $modelRoles->roles();
        $data['roles'] = $roles;
        $this->view->showViews(array('templates/header.view.php', 'usuariosmanagement.view.php', 'templates/footer.view.php'), $data);
    }

    public function doCrear() {
        $data = [];
        $data['titulo'] = 'Añadir usuario';
        $data['seccion'] = '/usuarios-sistema/add';
        $modelRoles = new \Com\Daw2\Models\AuxRolModel();
        $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        $roles = $modelRoles->roles();
        $data['roles'] = $roles;

        $errores = $this->comprobarValores($_POST);
        if (empty($errores)) {
            $modelUsuario = new \Com\Daw2\Models\UsuariosSisModel();
            $copia = $_POST;
            unset($copia['enviar']);
            unset($copia['password']);
            $copia['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            if ($modelUsuario->crear($copia)) {
                header('location: /usuarios-sistema');
            } else {
                $data['error'] = 'No se puedo creaar el usuario';
            }
        }
        $data['errores'] = $errores;
        $this->view->showViews(array('templates/header.view.php', 'usuariosmanagement.view.php', 'templates/footer.view.php'), $data);
    }

    public function comprobarValores(array $valores): array {
        $errores = [];
        if (empty($valores['password'])) {
            $errores['password'] = "Campo obligatorio";
        } else if (!preg_match('/.*[a-z].*/', $valores['password']) ||
                !preg_match('/.*[A-Z].*/', $valores['password']) ||
                !preg_match('/.*[0-9].*/', $valores['password']) ||
                strlen($valores['password']) < 8) {
            $errores['pass'] = "El password debe contener una mayúscula, una minúscula y un número y tener una longitud mínima de 8 caracteres.";
        } else if ($valores['password2'] != $valores['password']) {
            $errores['password2'] = 'Las dos contraseñas tienen que ser iguales';
        }

        if (empty($valores['email'])) {
            $errores['email'] = 'este campo es obligatorio';
        } else if (!preg_match('/^[a-zA-Z0-9]+[@][a-zA-Z0-9]+[.][a-zA-Z0-9]{3}$/', $valores['email'])) {
            $errores['email'] = 'El formato no es correcto';
        }
        if (empty($valores['username'])) {
            $errores['username'] = 'este campo es obligatorio';
        }

        return $errores;
    }

}
