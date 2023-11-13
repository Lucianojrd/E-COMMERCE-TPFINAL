<div class="fichaproducto">
	<?php
    if ($_GET['accion'] == 'ver_ficha') {
        $url = 'index.php?modulo=producto&accion=ver_fichar&id=' . $_GET['id'];
        $sql = "SELECT *FROM discos WHERE id = " . $_GET['id'];
        $sql = mysqli_query($con, $sql);
        if (mysqli_num_rows($sql) != 0) {
            $r = mysqli_fetch_array($sql);
        }
    }
    ?>
		<div class="product-card">
			<img src="imagenes/<?php echo $r['foto']; ?>" alt="" width="200">
			<div class="product-info">
				<h1>
                <?php echo $r['nombre']; ?>
                <hr>
            </h1>
				<p>
					Codigo de producto :
					<?php echo $r['id']; ?>
					<p>
						<p>
							<?php echo $r['descripcion']; ?>
						</p>
						<h1> Precio</h1>
						<h3>
                <?php echo $r['precio']; ?> ARS
            </h3>

						<?php
            if (!empty($_SESSION['nombre_usuario'])) {
                if ($_SESSION['roles'] == 'usuario') {
                    ?>
							<form action="index.php?modulo=box&accion=agregar_carrito&id=<?php echo $r['id']; ?>" method="post">
								<label for="cantidad">Cantidad:</label>
								<input type="number" id="cantidad" name="cantidad" value="1" min="1">
								<input class="nav_a" type="submit" value="Agregar al carrito">
							</form>
							<?php
            }
        }
            ?>
			</div>
			<a class="btn-black" href="index.php?modulo=box">
				<img src="imagenes/volver.png" alt="" width="50px">Volver al box</a>
		</div>
		<?php
    ?>
</div>