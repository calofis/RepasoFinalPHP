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
        if (isset($_SESSION['errorUsuario'])) {
            $data['errorUsuario'] = $_SESSION['errorUsuario'];
            unset($_SESSION['errorUsuario']);
        }
        $this->view->showViews(array('templates/header.view.php', 'usuarioSistema.view.php', 'templates/footer.view.php'), $data);
    }

    public function baja($id) {
        $modelUsuariosSis = new \Com\Daw2\Models\UsuariosSisModel();
        $datosUsuario = $modelUsuariosSis->obtenerDatosId($id);
        if ($_SESSION['usuario']['id_usuario'] != $id) {
            $modelUsuariosSis->baja($datosUsuario['baja'], $id);
        } else {
            $_SESSION['errorUsuario'] = 'No puedes deshabilitarte a ti mismo a ti mismo';
        }
        header('location: /usuarios-sistema');
    }

    public function delete($id) {
        $modelUsuariosSis = new \Com\Daw2\Models\UsuariosSisModel();
        if ($_SESSION['usuario']['id_usuario'] != $id) {
            $modelUsuariosSis->delete($id);
        } else {
            $_SESSION['errorUsuario'] = 'No puedes borrarte a ti mismo';
        }
        header('location: /usuarios-sistema');
    }

    public function view(int $id) {
        $data = [];
        $data['titulo'] = 'Datos usuario';
        $data['seccion'] = '/usuarios-sistema/view';
        $modelUsuario = new \Com\Daw2\Models\UsuariosSisModel();
        $modelRoles = new \Com\Daw2\Models\AuxRolModel();
        $datosUsuario = $modelUsuario->obtenerDatosId($id);
        $datosUsuario['view'] = true;
        $data['input'] = $datosUsuario;
        $roles = $modelRoles->roles();
        $data['roles'] = $roles;
        $this->view->showViews(array('templates/header.view.php', 'usuariosmanagement.view.php', 'templates/footer.view.php'), $data);
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
            unset($copia['password2']);
            if ($modelUsuario->crear($copia)) {
                header('location: /usuarios-sistema');
            } else {
                $data['error'] = 'No se puedo creaar el usuario';
            }
        }
        $data['errores'] = $errores;
        $this->view->showViews(array('templates/header.view.php', 'usuariosManagement.view.php', 'templates/footer.view.php'), $data);
    }

    public function modificar(int $id) {
        $data = [];
        $data['titulo'] = 'Modificar usuario';
        $data['seccion'] = '/usuarios-sistema/edit';
        $modelUsuario = new \Com\Daw2\Models\UsuariosSisModel();
        $modelRoles = new \Com\Daw2\Models\AuxRolModel();
        $datosUsuario = $modelUsuario->obtenerDatosId($id);
        $datosUsuario['edit'] = true;
        $data['input'] = $datosUsuario;
        $roles = $modelRoles->roles();
        $data['roles'] = $roles;
        $this->view->showViews(array('templates/header.view.php', 'usuariosmanagement.view.php', 'templates/footer.view.php'), $data);
    }

    public function doModificar(int $id) {
        $data = [];
        $data['titulo'] = 'Modificar Usuario';
        $data['seccion'] = '/usuarios-sistema/edit';

        $modelUsuario = new \Com\Daw2\Models\UsuariosSisModel();
        $modelRoles = new \Com\Daw2\Models\AuxRolModel();
        $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        $datosUsuario = $modelUsuario->obtenerDatosId($id);
        $datosUsuario['edit'] = true;
        $data['input'] = $datosUsuario;
        $roles = $modelRoles->roles();
        $data['roles'] = $roles;

        $comprobacion = $_POST;
        $comprobacion['edit'] = true;
        if (!isset($comprobacion['id_rol'])) {
            $comprobacion['id_rol'] = '1';
        }
        $comprobacion['id_usuario'] = $id;
        $errores = $this->comprobarValores($comprobacion);
        if (empty($errores)) {
            $modelUsuario = new \Com\Daw2\Models\UsuariosSisModel();
            $copia = $_POST;
            $copia['id_usuario'] = $id;
            if (!isset($copia['id_rol'])) {
                $copia['id_rol'] = '1';
            }
            unset($copia['enviar']);
            if (!empty($copia['password'])) {
                unset($copia['password']);
                $copia['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                unset($copia['password2']);
            } else {
                unset($copia['password']);
                unset($copia['password2']);
            }

            $modelUsuario->modificar($copia);
            header('location: /usuarios-sistema');
        }
        $data['errores'] = $errores;
        $this->view->showViews(array('templates/header.view.php', 'usuariosManagement.view.php', 'templates/footer.view.php'), $data);
    }

    public function comprobarValores(array $valores): array {
        $errores = [];
        $modelRoles = new \Com\Daw2\Models\AuxRolModel();
        $modelUsuario = new \Com\Daw2\Models\UsuariosSisModel();
        if (!isset($valores['edit'])) {
            if (empty($valores['password'])) {
                $errores['password'] = "Campo obligatorio";
            } else if (!preg_match('/.*[a-z].*/', $valores['password']) ||
                    !preg_match('/.*[A-Z].*/', $valores['password']) ||
                    !preg_match('/.*[0-9].*/', $valores['password']) ||
                    strlen($valores['password']) < 8) {
                $errores['password'] = "El password debe contener una mayúscula, una minúscula y un número y tener una longitud mínima de 8 caracteres.";
            } else if ($valores['password2'] != $valores['password']) {
                $errores['password2'] = 'Las dos contraseñas tienen que ser iguales';
            }
        } else if (!empty($valores['password'])) {
            if (!preg_match('/.*[a-z].*/', $valores['password']) ||
                    !preg_match('/.*[A-Z].*/', $valores['password']) ||
                    !preg_match('/.*[0-9].*/', $valores['password']) ||
                    strlen($valores['password']) < 8) {
                $errores['password'] = "El password debe contener una mayúscula, una minúscula y un número y tener una longitud mínima de 8 caracteres.";
            } else if ($valores['password2'] != $valores['password']) {
                $errores['password2'] = 'Las dos contraseñas tienen que ser iguales';
            }
        }


        if (empty($valores['email'])) {
            $errores['email'] = 'este campo es obligatorio';
        } else if (!preg_match('/^[a-zA-Z0-9]+[@][a-zA-Z0-9]+[.][a-zA-Z0-9]{3}$/', $valores['email'])) {
            $errores['email'] = 'El formato no es correcto';
        } else if ($modelUsuario->existEmail($valores['email'], $valores['id_usuario'])) {
            $errores['email'] = 'El email ya existe';
        }
        if (empty($valores['username'])) {
            $errores['username'] = 'este campo es obligatorio';
        }
        if (isset($valores['edit']) && $_SESSION['usuario']['id_rol'] == 1 && $_SESSION['usuario']['id_usuario'] == $valores['id_usuario'] && $_SESSION['usuario']['id_rol'] != $valores['id_rol']) {
            $errores['rol'] = 'No puedes cambiarte el rol siendo administrador';
        } else {
            if (!$modelRoles->existRol($valores['id_rol'])) {
                $errores['rol'] = 'El rol introducido no esta en la base de datos';
            }
        }

        if ($valores['idioma'] != 'es' && $valores['idioma'] != 'en' && $valores['idioma'] != 'gl') {
            $errores['idioma'] = 'El idioma introducido no es valido';
        }

        return $errores;
    }

}
