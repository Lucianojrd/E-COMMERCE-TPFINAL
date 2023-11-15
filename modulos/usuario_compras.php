<?php
$usuario_id = $_SESSION['id'];

// Consulta para obtener las compras realizadas por el usuario
$sql_compras = "SELECT * FROM compras WHERE usuario_id = '$usuario_id'";
$resultado_compras = mysqli_query($con, $sql_compras);

if ($resultado_compras) {
    // Mostrar la información de cada compra
    while ($fila_compra = mysqli_fetch_assoc($resultado_compras)) {
        $compra_id = $fila_compra['id'];
        $total_compra = $fila_compra['total'];
        ?>
	<div class="ticket">
		<?php
            ?>
			<h1>Id de compra:
                <?php echo $compra_id ?>
            </h1>
			<h1>Total:
                <p><?php echo $total_compra ?> ARS </p> 
            </h1>
			<?php
            // Consulta para obtener ticket de la compra
            $sql_ticket = "SELECT * FROM comprasxproducto WHERE compras_id = '$compra_id'";
            $resultado_compra = mysqli_query($con, $sql_ticket);

            // Mostrar los detalles de la compra
            ?>
				<table>
					<tr>
						<th>Producto</th>
						<th>Cantidad</th>
						<th>Precio Unitario</th>
					</tr>
					<?php
                while ($fila_compra = mysqli_fetch_assoc($resultado_compra)) {
                    $producto_id = $fila_compra['producto_id'];
                    $cantidad = $fila_compra['cantidad'];
                    $precio_unitario = $fila_compra['precio_unitario'];

                    // Consulta para obtener nombre del producto desde la tabla 'discos'
                    $sql_producto = "SELECT nombre FROM discos WHERE id = '$producto_id'";
                    $resultado_producto = mysqli_query($con, $sql_producto);

                    if ($resultado_producto && $fila_producto = mysqli_fetch_assoc($resultado_producto)) {
                        $nombre_producto = $fila_producto['nombre'];
                        // Mostrar información del detalle
                        ?>
						<tr>
							<td>
								<?php echo $nombre_producto ?>
							</td>
							<td>
								<?php echo $cantidad ?>
							</td>
							<td>
								<?php echo $precio_unitario ?> ARS
							</td>
						</tr>
						<?php
                    }
                }
            ?>
				</table>
			<hr>
	</div>
	<?php
    }
}
?>