<?php include_once "includes/header.php";
    include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "caja";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: permisos.php");
} 
    ?>

 <?php echo isset($alert) ? $alert : ''; ?>
 <h4 class="text-center">Historial de Apertura y Cierre de Caja</h4>
 <div class="table-responsive">
     <table class="table table-striped table-bordered" id="tbl">
         <thead class="thead-dark">
             <tr>
                 <th>Codigo</th>
                 <th>Monto Inicial</th>
                 <th>Monto al cierre</th>
                 <th>Fecha Apertura</th>
                 <th>Fecha de cierre</th>
             </tr>
         </thead>
         <tbody>
             <?php
                include "../conexion.php";

                $query = mysqli_query($conexion, "SELECT * FROM detalle_caja");
                $result = mysqli_num_rows($query);
                if ($result > 0) {
                    while ($data = mysqli_fetch_assoc($query)) {
                ?>
                     <tr>
                         <td><?php echo $data['id']; ?></td>
                         <td><?php echo $data['montoInicial']; ?></td>
                         <td><?php echo $data['total']; ?></td>
                         <td><?php echo $data['fecha_apertura']; ?></td>
                         <td><?php echo $data['fecha_cierre']; ?></td>
                     </tr>
             <?php }
                } ?>
         </tbody>

     </table>
 </div>
 

 <?php include_once "includes/footer.php"; ?>
