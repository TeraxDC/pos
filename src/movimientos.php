<?php include_once "includes/header.php";
    include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "caja";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: permisos.php");
}
    if (!empty($_POST)) {
		$monto = $_POST['monto'];
        $detalle = $_POST['detalle'];
        $tipo = $_POST['tipo'];
        $usuario_id = $_SESSION['idUser'];
        $alert = "";
        if (empty($monto) || empty($detalle) || empty($tipo)) {
            $alert = '<div class="alert alert-danger" role="alert">
                Todo los campos son obligatorios
              </div>';
        } else {
            $query = mysqli_query($conexion, "SELECT * FROM caja WHERE estado = 1");
            $result = mysqli_fetch_array($query);
            if ($result == 0) {
                $alert = '<div class="alert alert-warning" role="alert">
                        No hay ninguna caja abierta
                    </div>';
            } else {
                $get_id = mysqli_fetch_assoc(mysqli_query($conexion,"SELECT MAX(id) id from detalle_caja"));
                $detalleId = $get_id['id']; 
                    $query_insert = mysqli_query($conexion,"INSERT INTO movimientos(monto,detalle,tipo,id_detalle) values ('$monto', '$detalle','$tipo','$detalleId')");
                    if ($query_insert) {
                        $alert = '<div class="alert alert-success" role="alert">
                    Movimiento Registrado
                  </div>';
                    } else {
                        $alert = '<div class="alert alert-danger" role="alert">
                    Error al registrar movimiento
                  </div>';
                    }
            }
    }
}
    ?>
 <button class="btn btn-primary mb-2" type="button" data-toggle="modal" data-target="#nuevo_movimiento"><i class="fas fa-plus"></i></button>
 <?php echo isset($alert) ? $alert : ''; ?>
 <div class="table-responsive">
     <table class="table table-striped table-bordered" id="tbl">
         <thead class="thead-dark">
             <tr>
                 <th>ID</th>
                 <th>Monto</th>
                 <th>Detalle</th>
                 <th>Tipo</th>
                 <th></th>
             </tr>
         </thead>
         <tbody>
             <?php
                include "../conexion.php";

                $query = mysqli_query($conexion, "SELECT * FROM movimientos");
                $result = mysqli_num_rows($query);
                if ($result > 0) {
                    while ($data = mysqli_fetch_assoc($query)) {
                ?>
                     <tr>
                         <td><?php echo $data['id']; ?></td>
                         <td><?php echo $data['monto']; ?></td>
                         <td><?php echo $data['detalle']; ?></td>
                         <td><?php echo $data['tipo']; ?></td>  
                         <td>
                             
                                <!-- <a href="editar_movimiento.php?id=<?php echo $data['id']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>-->
                             
                         </td>
                     </tr>
             <?php }
                } ?>
         </tbody>

     </table>
 </div>
 <div id="nuevo_movimiento" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header bg-primary text-white">
                 <h5 class="modal-title" id="my-modal-title">Nuevo movimiento</h5>
                 <button class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <form action="" method="post" autocomplete="off">
                     <?php echo isset($alert) ? $alert : ''; ?>
                     <div class="form-group">
                         <label for="monto">Monto</label>
                         <input type="number" step='0.01' placeholder="Ingrese monto del movimiento" name="monto" id="monto" class="form-control">
                     </div>

                     <div class="form-group">
    <label for="detalle">Detalle</label>
    <textarea class="form-control" name='detalle' id="detalle" rows="2"></textarea>
  </div>

<div class="form-group">
    <label for="tipo">Tipo</label>
    <select class="form-control" name= 'tipo' id="tipo">
      <option>Ingreso</option>
      <option>Egreso</option>
    </select>
</div>
                     <input type="submit" value="Agregar movimiento" class="btn btn-primary">
                 </form>
             </div>
         </div>
     </div>
 </div>

 <?php include_once "includes/footer.php"; ?>
