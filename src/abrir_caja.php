<?php
include_once "includes/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "caja";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: permisos.php");
}
if (empty($_GET['id'])) {
    header("Location: caja.php");
} else {
    $id_caja = $_GET['id'];
    if (!is_numeric($id_caja)) {
        header("Location: caja.php");
    }
    $consulta = mysqli_query($conexion, "SELECT * FROM caja WHERE id = $id_caja");
    $data_caja = mysqli_fetch_assoc($consulta);
}
if (!empty($_POST)) {
    $alert = "";
    if (!empty($_POST['monto_inicial']) || !empty($_POST['caja_id'])) {
        //$precio = $_POST['precio'];
        $monto_inicial = $_POST['monto_inicial'];
        $caja_id = $_GET['id'];
        //$total = $monto_inicial + $data_caja['existencia'];
        $query_update = mysqli_query($conexion, "UPDATE caja SET estado = 1 WHERE id = $id_caja");
        $query_insert = mysqli_query($conexion, "INSERT INTO detalle_caja(montoInicial,  idCaja) values ($monto_inicial,$caja_id)");

        if ($query_update &&  $query_insert) {
            $alert = '<div class="alert alert-success" role="alert">
                        Caja Abierta
                    </div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">
                        Error al abrir la caja
                    </div>';
        }
        mysqli_close($conexion);
    } else {
        $alert = '<div class="alert alert-danger" role="alert">
                        Todo los campos son obligatorios
                    </div>';
    }
}
?>
<div class="row">
    <div class="col-lg-6 m-auto">
        <div class="card">
            <div class="card-header bg-primary text-center">
                <h4 class="text-white">Abri Caja</h4>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <?php echo isset($alert) ? $alert : ''; ?>
                    <div class="form-group">
                        <label for="monto_inicial">Agregar monto inicial de apertura</label>
                        <input type="number" placeholder="Ingrese monto inicial" name="monto_inicial" id="monto_inicial" class="form-control">
                    </div>
                    <input type="submit" value="Abrir Caja" class="btn btn-primary">
                    <a href="caja.php" class="btn btn-danger">Regresar</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once "includes/footer.php"; ?>