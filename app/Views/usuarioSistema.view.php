<div class="row">       
    <?php
    if (isset($errorUsuario)) {
        ?>
        <div class="col-12">
            <div class="alert alert-danger"><p><?php echo $errorUsuario; ?></p></div>
        </div>
        <?php
    }
    ?>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <div class="col-6">
                    <h6 class="m-0 installfont-weight-bold text-primary">Usuarios</h6> 
                </div>
                <div class="col-6">
                    <?php if (isset($_SESSION['permisos']) && strpos($_SESSION['permisos']['Categorias'], 'w') !== false) { ?>
                        <div class="m-0 font-weight-bold justify-content-end">
                            <a href="/usuarios-sistema/add" class="btn btn-primary ml-1 float-right"> Nuevo Usuario <i class="fas fa-plus-circle"></i></a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body" id="card_table">
                <div id="button_container" class="mb-3"></div>
                <?php
                if (count($usuarios) > 0) {
                    ?>
                    <!--<form action="./?sec=formulario" method="post"> -->
                    <table id="tabladatos" class="table table-striped">                    
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>                                                                                   
                                <th>Rol</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($usuarios as $u) {
                                ?>
                                <tr class="<?php echo $u['baja'] != 0 ? 'table-danger' : ''; ?>">
                                    <td><?php echo $u['username']; ?></td>
                                    <td><?php echo $u['email']; ?></td>                                     
                                    <td><?php echo $u['nombre_rol']; ?></td>   
                                    <td> 
                                        <?php if (isset($_SESSION['permisos']) && strpos($_SESSION['permisos']['UsuariosSistema'], 'r') !== false) { ?>
                                            <a href="/usuarios-sistema/view/<?php echo $u['id_usuario']; ?>" class="btn btn-default ml-1"><i class="fas fa-eye"></i></a>
                                        <?php } ?>
                                        <?php if (isset($_SESSION['permisos']) && strpos($_SESSION['permisos']['UsuariosSistema'], 'w') !== false) { ?>
                                            <a href="/usuarios-sistema/edit/<?php echo $u['id_usuario']; ?>" class="btn btn-success ml-1"><i class="fas fa-edit"></i></a>
                                        <?php } ?>
                                        <?php if (isset($_SESSION['permisos']) && strpos($_SESSION['permisos']['UsuariosSistema'], 'w') !== false) { ?>
                                            <a href="/usuarios-sistema/baja/<?php echo $u['id_usuario']; ?>" class="btn btn-primary"> <i class="<?php echo $u['baja'] == 1 ? 'fas fa-toggle-off' : 'fas fa-toggle-on'; ?>"></i></a>
                                        <?php } ?>
                                        <?php if (isset($_SESSION['permisos']) && strpos($_SESSION['permisos']['UsuariosSistema'], 'd') !== false) { ?>
                                            <a href="/usuarios-sistema/delete/<?php echo $u['id_usuario']; ?>" class="btn btn-danger ml-1"><i class="fas fa-trash"></i></a>
                                            <?php }
                                        ?>
                                    </td>

                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            Total de registros: <?php echo count($usuarios); ?>
                        </tfoot>
                    </table>
                    <?php
                } else {
                    ?>
                    <p class="text-danger">No existen registros que cumplan los requisitos.</p>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>                        
</div>
