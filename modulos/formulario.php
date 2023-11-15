<?php
if (!isset($_GET['accion'])) {
    $_GET['accion'] = '';
}
if ($_GET['accion'] == 'form') {
    ?>
	<form form action="index.php?modulo=formulario&accion=cargar_direccion" method="POST">
		<div>
			<label for="provincia">Provincia:</label>
			<input type="text" id="provincia" name="provincia" required>
		</div>
		<div>
			<label for="ciudad">Ciudad:</label>
			<input type="text" id="ciudad" name="ciudad" required>
		</div>
		<div>
			<label for="calle">Calle:</label>
			<input type="text" id="calle" name="calle" required>
		</div>
		<div>
			<label for="altura">Altura:</label>
			<input type="number" id="altura" name="altura" required>
		</div>
		<div>
			<button type="submit" class="btn btn-dark">Cargar Direccion</button>
		</div>
	</form>
	<?php
}
if ($_GET['accion'] == 'cargar_direccion') {
    ?>
		<form form action="index.php?modulo=formulario&accion=cargar_tarjeta" method="POST">
			<div>
				<label>Numero de tarjeta</label>
				<input class="number" type="text" placeholder="Numeros de la tarjeta" maxlength="16" name="numero_tarjeta" required/>
				<label>Nombre propietario</label>
				<input class="inputname" type="text" placeholder="Nombre del propietario de la tarjeta" required name="nombre_tarjeta" />
				<label>Security Number</label>
				<input class="cvv" type="text" placeholder="CVV" maxlength="3" name="cvv" required/>
			</div>
			<div>
				<button type="submit" class="btn btn-dark">Cargar tarjeta</button>
			</div>
		</form>
		<?php
}
if ($_GET['accion'] == 'cargar_tarjeta') {
    ?>
			<div style="text-align:center; padding-top:3rem;">
				<a class="btn btn-danger" href="index.php?modulo=formulario&accion=confirmar_compra">Confirmar Compra</a>
			</div>
			<?php
    
}
?>
				<?php


if ($_GET['accion'] == 'cargar_tarjeta') {
    //CARGAR TARJETA

    $usuario_id = $_SESSION['id'];
    $numero_tarjeta = $_POST['numero_tarjeta'];
    $nombre_tarjeta = $_POST['nombre_tarjeta'];
    $cvv = $_POST['cvv'];
    $sql = "INSERT INTO pagos (id_usuario, numero_tarjeta, nombre_tarjeta, cvv) VALUES ('$usuario_id', '$numero_tarjeta', '$nombre_tarjeta', '$cvv')";
    $sql = mysqli_query($con, $sql);
    if (mysqli_error($con)) {
        echo "<script> alert('Tarjeta no cargada');</script>";
    } else {
        echo "<script> alert('Tarjeta cargada con exito');</script>";
    }
}



if ($_GET['accion'] == 'cargar_direccion') {
    //CARGAR DIRECCION

    $usuario_id = $_SESSION['id'];
    $provincia=$_POST['provincia'];
    $ciudad=$_POST['ciudad'];
    $calle=$_POST['calle'];
    $altura=$_POST['altura'];
    $sql = "INSERT INTO direcciones (usuario_id, provincia, ciudad, calle,altura) VALUES ('$usuario_id', '$provincia', '$ciudad', '$calle', '$altura')";
    $sql = mysqli_query($con, $sql);
    if (mysqli_error($con)) {
        echo "<script> alert('ERROR NO SE PUDO ELIMINAR PRODUCTO DEL CARRITO);</script>";
    } else {
        echo "<script> alert('Direccion guardada con exito');</script>";
    }
}


if ($_GET['accion'] == 'confirmar_compra') {
    $usuario_id = $_SESSION['id'];
    $sql = "INSERT INTO compras (usuario_id, total) VALUES ('$usuario_id', 0)";
    $sql = mysqli_query($con, $sql);
    $id_compra = mysqli_insert_id($con); //Recuperamos id de la compra recien creada

    // Calcular el total del carrito directamente en la base de datos

    // Inicializar el total de la compra
    $total_compra = 0;

    // Obtener los productos del carrito para el usuario actual
    $sql_carrito = "SELECT producto_id, cantidad FROM carrito WHERE usuario_id = '$usuario_id'"; //Obtenemos los productos que compro este usuario
    $resultado_carrito = mysqli_query($con, $sql_carrito);

    if ($resultado_carrito) {
        while ($fila_carrito = mysqli_fetch_assoc($resultado_carrito)) { //Recorremos cada producto del carrito y los insertamos al id en una variable y a la cantidad en otra
            $producto_id = $fila_carrito['producto_id'];
            $cantidad = $fila_carrito['cantidad'];

            // Obtener el precio del producto desde la tabla 'discos'
            $sql_precio = "SELECT precio FROM discos WHERE id = '$producto_id'";
            $resultado_precio = mysqli_query($con, $sql_precio);

            if ($resultado_precio && $fila_precio = mysqli_fetch_assoc($resultado_precio)) {
                // Calcular el subtotal y agregar al total de la compra
                $precio_unitario = $fila_precio['precio'];
                $subtotal = $precio_unitario * $cantidad;
                $total_compra += $subtotal;

                // Crear un registro en la tabla 'detalle_compra' para cada producto con todos los datos reunidos
                $sql_detalle = "INSERT INTO comprasxproducto (compras_id, producto_id, cantidad, precio_unitario) VALUES ('$id_compra', '$producto_id', '$cantidad', '$precio_unitario')";
                $resultado_detalle = mysqli_query($con, $sql_detalle);


            }
        }

        // Actualizar el total de la compra en la tabla 'compras'
        $sql_actualizar_total = "UPDATE compras SET total = '$total_compra' WHERE id = '$id_compra'";
        $resultado_actualizar_total = mysqli_query($con, $sql_actualizar_total);

        if ($resultado_actualizar_total) { //Si se ejecuto es porque se realizo la compra entonces borramos carrito
            $sql_limpiar_carrito = "DELETE FROM carrito WHERE usuario_id = '$usuario_id'";
            mysqli_query($con, $sql_limpiar_carrito);
            echo "<script> alert('SE CONCRETO SU COMPRA! GRACIAS');</script>";
            echo "<script>window.location='index.php';</script>";
        }
    }
}


?>