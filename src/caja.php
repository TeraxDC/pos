<?php include_once "includes/header.php";
    include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "productos";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: permisos.php");
}
    if (!empty($_POST)) {
		$nombre = $_POST['nombre'];
        $alert = "";
        if (empty($nombre)) {
            $alert = '<div class="alert alert-danger" role="alert">
                Todo los campos son obligatorios
              </div>';
        } else {
            $query = mysqli_query($conexion, "SELECT * FROM caja WHERE nombre = '$nombre'");
            $result = mysqli_fetch_array($query);
            if ($result > 0) {
                $alert = '<div class="alert alert-warning" role="alert">
                        El nombre ya existe
                    </div>';
            } else {
				$query_insert = mysqli_query($conexion,"INSERT INTO caja(nombre) values ('$nombre')");
                if ($query_insert) {
                    $alert = '<div class="alert alert-success" role="alert">
                Caja registrada con éxito
              </div>';
                } else {
                    $alert = '<div class="alert alert-danger" role="alert">
                Error al registrar la caja
              </div>';
                }
            }
        }
    }
    ?>
 <button class="btn btn-primary mb-2" type="button" data-toggle="modal" data-target="#nueva_caja">Añadir Caja<i class="fas fa-plus"></i></button>
 <?php echo isset($alert) ? $alert : ''; ?>
 <div class="table-responsive">
     <table class="table table-striped table-bordered" id="tbl">
         <thead class="thead-dark">
             <tr>
                 <th>Codigo</th>
                 <th>Caja</th>
                 <th>Estado</th>
                 <th></th>
             </tr>
         </thead>
         <tbody>
             <?php
                include "../conexion.php";

                $query = mysqli_query($conexion, "SELECT * FROM Caja");
                $result = mysqli_num_rows($query);
                if ($result > 0) {
                    while ($data = mysqli_fetch_assoc($query)) {
                        if ($data['estado'] == 1) {
                            $estado = '<span class="badge badge-pill badge-success">Abierto</span>';
                        } else {
                            $estado = '<span class="badge badge-pill badge-danger">Cerrado</span>';
                        }
                ?>
                     <tr>
                         <td><?php echo $data['id']; ?></td>
                         <td><?php echo $data['nombre']; ?></td>
                         <td><?php echo $estado ?></td> 
                         <td>
                             <?php if ($data['estado'] == 0) { ?>
                                 <a href="abrir_caja.php?id=<?php echo $data['id']; ?>" class="btn btn-success"><i class='fas fa-cart-plus'></i></a>
<!--
                                 <form action="eliminar_producto.php?id=<?php echo $data['id']; ?>" method="post" class="confirmar d-inline">
                                     <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
                                 </form> -->
                             <?php } elseif($data['estado'] == 1){  ?>
                                <!--<a href="cerrar_caja.php?id=<?php echo $data['id']; ?>" class="btn btn-danger"><i class='fas fa-cart-arrow-down'></i></a>-->
                                 <a href="agregar_operaciones.php?id=<?php echo $data['id']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>
                                 <form action="cerrarCaja.php?id=<?php echo $data['id']; ?>" method="post" class="confirmar2 d-inline">
                                     <button class="btn btn-danger" type="submit"><i class='fas fa-cart-arrow-down'></i> </button>
                                 </form>
                                 <?php }?>

                         </td>
                     </tr>
             <?php }
                } ?>
         </tbody>

     </table>
 </div>
 <div id="nueva_caja" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header bg-primary text-white">
                 <h5 class="modal-title" id="my-modal-title">Añadir nueva Caja</h5>
                 <button class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <form action="" method="post" autocomplete="off">
                     <?php echo isset($alert) ? $alert : ''; ?>
                     <div class="form-group">
                         <label for="nombre">Nombre de Caja</label>
                         <input type="text" placeholder="Ingrese nombre de la caja" name="nombre" id="nombre" class="form-control">
                     </div>
                     <input type="submit" value="Guardar Caja" class="btn btn-primary">
                 </form>
             </div>
         </div>
     </div>
 </div>

 <?php include_once "includes/footer.php"; ?>
