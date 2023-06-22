<?php
include_once "includes/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "productos";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
  header("Location: permisos.php");
}
if (!empty($_POST)) {
        $codproducto = $_GET['id'];
        $nombre = $_POST['nombre'];
        $producto = $_POST['producto'];
        $vencimiento = $_POST['vencimiento'];
        $precioCompra = $_POST['precioCompra'];
        $precio = $_POST['precio'];
        $cantidad = $_POST['cantidad'];
        $usuario_id = $_SESSION['idUser'];
  $alert = "";
  if (empty($nombre) || empty($producto) || empty($vencimiento) || empty($precioCompra) || $precioCompra <  0 || empty($precio) || $precio <  0 || empty($cantidad) || $cantidad < 0) {
    $alert = '<div class="alert alert-primary" role="alert">
              Todo los campos son requeridos
            </div>';
  } else {
    $query_update = mysqli_query($conexion, "UPDATE producto SET nombre = '$nombre', descripcion = '$producto', vencimiento = '$vencimiento', precioCompra = '$precioCompra', precio= '$precio', existencia = '$cantidad' WHERE codproducto = $codproducto");
    if ($query_update) {
      $alert = '<div class="alert alert-primary" role="alert">
              Producto Modificado
            </div>';
    } else {
      $alert = '<div class="alert alert-primary" role="alert">
                Error al Modificar
              </div>';
    }
  }
}

// Validar producto

if (empty($_REQUEST['id'])) {
  header("Location: productos.php");
} else {
  $id_producto = $_REQUEST['id'];
  if (!is_numeric($id_producto)) {
    header("Location: productos.php");
  }
  $query_producto = mysqli_query($conexion, "SELECT * FROM producto WHERE codproducto = $id_producto");
  $result_producto = mysqli_num_rows($query_producto);

  if ($result_producto > 0) {
    $data_producto = mysqli_fetch_assoc($query_producto);
  } else {
    header("Location: productos.php");
  }
}
?>
<div class="row">
  <div class="col-lg-6 m-auto">

    <div class="card">
      <div class="card-header bg-primary text-white">
        Modificar producto
      </div>
      <div class="card-body">
        <form action="" method="post">
          <?php echo isset($alert) ? $alert : ''; ?>
          <div class="form-group">
                         <label for="nombre">Producto</label>
                         <input type="text" placeholder="Ingrese nombre del producto" name="nombre" id="nombre" class="form-control" value="<?php echo $data_producto['nombre']; ?>">
                     </div>
                     <div class="form-group">
                         <label for="producto">Descripción</label>
                         <input type="text" placeholder="Ingrese descripción" name="producto" id="producto" class="form-control" value="<?php echo $data_producto['descripcion']; ?>">
                     </div>
                     <div class="form-group">
                         <label for="vencimiento">vencimiento</label>
                         <input type="date" name="vencimiento" id="vencimiento" class="form-control" value="<?php echo $data_producto['vencimiento']; ?>">
                     </div>
                     <div class="form-group">
                         <label for="precioCompra">Precio de Compra</label>
                         <input type="number" step='0.01' placeholder="Ingrese precio de compra" class="form-control" name="precioCompra" id="precioCompra" value="<?php echo $data_producto['precioCompra']; ?>">
                     </div>
                     <div class="form-group">
                         <label for="precio">Precio de Venta</label>
                         <input type="number" step='0.01' placeholder="Ingrese precio de venta" class="form-control" name="precio" id="precio" value="<?php echo $data_producto['precio']; ?>">
                     </div>
                     <div class="form-group">
                         <label for="cantidad">Cantidad</label>
                         <input type="number" placeholder="Ingrese cantidad" class="form-control" name="cantidad" id="cantidad" value="<?php echo $data_producto['existencia']; ?>">
                     </div>
          <input type="submit" value="Actualizar Producto" class="btn btn-primary">
          <a href="productos.php" class="btn btn-danger">Atras</a>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include_once "includes/footer.php"; ?>