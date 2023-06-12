<!-- Content Row -->

<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Introduzca los datos del nuevo usuario</h6>                                    
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <form action=" <?php isset($input['edit']) ? '/usuarios-sistema/edit/'.$input["id_usuario"] : '/usuarios-sistema/add'?>" method="post">
                    <!--form method="get"-->
                    <div class="row">
                        <div class="mb-3 col-sm-3">
                            <label for="username">Username</label>
                            <input class="form-control" id="username" type="text" name="username" placeholder="Username" value="<?php echo isset($input['username']) ? $input['username'] : ''; ?>" <?php echo isset($input['username']) && isset($input['view']) ? 'disabled' : ''; ?>>
                            <p class="text-danger"><?php echo isset($errores['username']) ? $errores['username'] : ''; ?></p>
                        </div>
                        <div class="mb-3 col-sm-5">
                            <label for="codigo">Email</label>
                            <input class="form-control" id="email" type="text" name="email" placeholder="email@example.com" value="<?php echo isset($input['email']) ? $input['email'] : ''; ?>" <?php echo isset($input['email']) && isset($input['view']) ? 'disabled' : ''; ?>>
                            <p class="text-danger"><?php echo isset($errores['email']) ? $errores['email'] : ''; ?></p>
                        </div>
                        <?php if(!isset($input['view'])){ ?>
                        <div class="mb-3 col-sm-5">
                            <label for="codigo">Password</label>
                            <input class="form-control" id="password" type="password" name="password" placeholder="****">
                            <p class="text-danger"><?php echo isset($errores['password']) ? $errores['password'] : ''; ?></p>
                        </div>
                        <div class="mb-3 col-sm-5">
                            <label for="codigo">Repetir password</label>
                            <input class="form-control" id="password2" type="password" name="password2" placeholder="****">
                            <p class="text-danger"><?php echo isset($errores['password2']) ? $errores['password2'] : ''; ?></p>
                        </div>
                        <?php } ?>
                        <div class="mb-3 col-sm-4">
                            <label for="id_rol">Rol</label>
                            <select class="form-control select2-container--default" name="id_rol" <?php echo isset($input['id_rol']) && isset($input['edit'])  && $input['id_rol'] == 1 ? 'disabled' : ''; ?> <?php echo isset($input['id_rol']) && isset($input['view']) ? 'disabled' : ''; ?>>                                
                                <option value="" selected></option>
                                <?php
                                if (count($roles) > 0) {
                                    foreach ($roles as $r) {
                                        ?>
                                        <option value="<?php echo $r['id_rol'] ?>" <?php echo isset($input['id_rol']) && $input['id_rol'] == $r['id_rol'] ? 'selected' : ''; ?>><?php echo $r['nombre_rol'] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <p class="text-danger"><?php echo isset($errores['rol']) ? $errores['rol'] : ''; ?></p>

                        </div>
                        <div class="mb-3 col-sm-4">
                            <label for="idioma">Idioma</label>
                            <select class="form-control select2-container--default" name="idioma" <?php echo isset($input['idioma']) && isset($input['view']) ? 'disabled' : ''; ?>>                                
                                <option value="" selected></option>
                                <option value="es" <?php echo isset($input['idioma']) && $input['idioma'] == 'es' ? 'selected' : ''; ?>>Español</option>
                                <option value="en" <?php echo isset($input['idioma']) && $input['idioma'] == 'en' ? 'selected' : ''; ?> >Ingles</option>
                                <option value="gl" <?php echo isset($input['idioma']) && $input['idioma'] == 'gl' ? 'selected' : ''; ?>>Gallego</option>
                            </select>
                            <p class="text-danger"><?php echo isset($errores['idioma']) ? $errores['idioma'] : ''; ?></p>

                        </div>
                        <div class="col-12 text-right">
                            <?php if(!isset($input['view'])){ ?>
                            <input type="submit" value="Enviar" name="enviar" class="btn btn-primary"/>
                            <?php } ?>
                            <a href="/usuarios-sistema" class="btn btn-danger ml-3">Cancelar</a>                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>                        
</div>

