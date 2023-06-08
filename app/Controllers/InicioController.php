<?php

namespace Com\Daw2\Controllers;

class InicioController extends \Com\Daw2\Core\BaseController {

    public function index() {
        $data = array(
            'titulo' => 'Página de inicio',
            'breadcrumb' => ['Inicio']
        );
        $modeloCategorias = new \Com\Daw2\Models\CategoriaModel();
        $data['numCategorias'] = $modeloCategorias->size();

        $modeloProductos = new \Com\Daw2\Models\ProductoModel();
        $data['numProductos'] = $modeloProductos->size();

        $modeloProveedores = new \Com\Daw2\Models\ProveedorModel();
        $data['numProveedores'] = $modeloProveedores->size();

        $this->view->showViews(array('templates/header.view.php', 'inicio.view.php', 'templates/footer.view.php'), $data);
    }

    public function demoUsuariosSistema() {
        $data = [
            'seccion' => '/demos/usuarios-sistema',
            'titulo' => 'Usuarios sistema',
            'breadcrumb' => ['Inicio', 'Usuarios sistema']
        ];
        $this->view->showViews(array('templates/header.view.php', 'demo-listado-usuarios.php', 'templates/footer.view.php'), $data);
    }

    public function demoUsuariosSistemaAdd() {
        $data = [
            'seccion' => '/demos/usuarios-sistema/add',
            'titulo' => 'Alta Usuario sistema',
            'breadcrumb' => ['Inicio', 'Usuarios sistema', 'Editar']
        ];
        $this->view->showViews(array('templates/header.view.php', 'demo-add.usuario.view.php', 'templates/footer.view.php'), $data);
    }

    public function login() {
        $this->view->show('login.view.php');
    }

    public function doLogin() {
        $modelUserSis = new \Com\Daw2\Models\UsuariosSisModel();

        $login = $modelUserSis->doLogin($_POST);
        if ($login !== NULL) {
            $_SESSION['usuario'] = $login;
            $_SESSION['permisos'] = $this->permisos($login['username']);
            header('location: /');
        }
        $data['erroresLogin'] = 'Los datos introducidos son erroneos';
        $this->view->showViews(array('login.view.php'), $data);
    }

    private function permisos(string $rol): array {
        $permisos = [
            'UsuariosSistema' => '',
            'Categorias' => '',
            'Proveedores' => '',
            'Productos' => '',
        ];
        
        if($rol == 'administrador'){
            $permisos['UsuariosSistema'] = 'rwd';
            $permisos['Categorias'] = 'rwd';
            $permisos['Proveedores'] = 'rwd';
            $permisos['Productos'] = 'rwd';
        }
        if($rol == 'auditor'){
            $permisos['UsuariosSistema'] = 'r';
            $permisos['Categorias'] = 'r';
            $permisos['Proveedores'] = 'r';
            $permisos['Productos'] = 'r';
        }
        if($rol == 'facturacion'){
            $permisos['Proveedores'] = 'rwd';
            $permisos['Productos'] = 'rwd';
        }
        
        return $permisos;
    }

}
