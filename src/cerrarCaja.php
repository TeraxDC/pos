<?php
session_start();
require("../conexion.php");
$id_user = $_SESSION['idUser'];
$permiso = "usuarios";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: permisos.php");
}
if (!empty($_GET['id'])) {
    $id_caja = $_GET['id'];
    //$query_delete = mysqli_query($conexion, "UPDATE producto SET estado = 0 WHERE codproducto = $id");
    $query_update = mysqli_query($conexion, "UPDATE caja SET estado = 0 WHERE id = $id_caja");
    $get_id = mysqli_fetch_assoc(mysqli_query($conexion,"SELECT MAX(id) from detalle_caja"));
    $detalleId = $get_id['id']; 
    $get_fechaApertura = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT fecha_apertura FROM detalle_caja where id = $detalleId AND idCaja = $id_caja"));
    $fechaApertura = $get_fechaApertura['fecha_apertura'];
    $get_ventas = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT SUM(total) totalVentas from ventas where fecha >= $fechaApertura and fecha <= now()"));
    $total_ventas = $get_ventas['totalVentas'];

    mysqli_close($conexion);
    header("Location: caja.php");
}
