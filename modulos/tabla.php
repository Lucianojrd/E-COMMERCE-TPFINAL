<?php
if (!isset($_GET['accion']))
    $_GET['accion'] = '';

//insertar

if ($_GET['accion'] == 'guardar_insertar') {
    //verifico que no exista el producto
    $sql = "SELECT *FROM discos where id = '" . $_POST['id'] . "'";
    $sql = mysqli_query($con, $sql);
    if (mysqli_num_rows($sql) != 0) {
        echo "<script> alert('EL PRODUCTO YA EXISTE EN LA BD');</script>";
    } else {

        //procesar la foto
        if (is_uploaded_file($_FILES['foto']['tmp_name'])) {

            //copiar en un directorio
            $nombre = explode('.', $_FILES['foto']['name']);
            $foto = time() . '.' . end($nombre);
            copy($_FILES['foto']['tmp_name'], 'imagenes/' . $foto);
        }
        //fin de procesar la foto


        //inserto nuevo producto
        $sql = "INSERT INTO discos (id,nombre,descripcion, precio,foto) values ('" . $_POST['id'] . "','" . $_POST['nombre'] . "','" . $_POST['descripcion'] . "','" . $_POST['precio'] . "','" . $foto . "')";
        $sql = mysqli_query($con, $sql);
        if (mysqli_error($con)) {
            echo "<script> alert('ERROR NO SE PUDO INSERTAR EL PRODUCTO);</script>";
        } else {
            echo "<script> alert('Producto cargado con exito');</script>";
        }
    }
}

//editar 
if ($_GET['accion'] == 'guardar_editar') {

    //controlo si tengo que editar la foto
    if (is_uploaded_file($_FILES['foto']['tmp_name'])) {
        //copiar en un directorio
        $nombre = explode('.', $_FILES['foto']['name']);
        $foto = time() . '.' . end($nombre);
        copy($_FILES['foto']['tmp_name'], 'imagenes/' . $foto);

        //armo la cadena para editar las fotos
        $mas_datos = ", foto='" . $foto . "'";
    } else {
        $mas_datos = '';
    }

    $sql = "UPDATE discos SET id='{$_POST['id']}',nombre='{$_POST['nombre']}', descripcion='{$_POST['descripcion']}', precio='{$_POST['precio']}' {$mas_datos}  WHERE id=" . $_GET['id'];
    $sql = mysqli_query($con, $sql);
    if (!mysqli_error($con))
        echo "<script> alert('producto editado con exito');</script>";
    else
        echo "<script> alert('ERROR NO SE PUDO editar el producto);</script>";
}


//eliminar

if ($_GET['accion'] == 'guardar_eliminar') {
    if (isset($_GET['id'])) {
        $sql = "UPDATE discos SET eliminado=1 WHERE id=" . $_GET['id'];
        $sql = mysqli_query($con, $sql);
        if (!mysqli_error($con))
            echo "<script> alert('producto eliminado con exito');</script>";
        else
            echo "<script> alert('ERROR NO SE PUDO eliminar la ropa);</script>";
    }
}

?>

	<div class="form_cargarproductos">
		<div>
			<h1>Carga de Productos</h1>
			<hr>
		</div>
		<div class="org_registro">
			<?php
        if ($_GET['accion'] == 'editar') {
            $url = 'index.php?modulo=tabla&accion=guardar_editar&id=' . $_GET['id'];
            $sql = "SELECT *FROM discos WHERE id = " . $_GET['id'];
            $sql = mysqli_query($con, $sql);
            if (mysqli_num_rows($sql) != 0) {
                $r = mysqli_fetch_array($sql);
            }
        } else {
            $url = 'index.php?modulo=tabla&accion=guardar_insertar';
            $r['id']= $r['nombre'] = $r['descripcion'] = $r['precio'] = $r['foto'] = '';
        }
        ?>
				<form class="org_form_registro" form action="<?php echo $url; ?>" method="POST" enctype="multipart/form-data">
					<div class="mb-3">
						<label class="form-label" for="number">ID</label>
						<input type="number" id="id" class="form-control" placeholder="Ingresa el codigo unitario de producto" name="id" value="<?php echo $r['id']; ?>" required>
					</div>
					<div class="mb-3">
						<label class="form-label" for="nombre">Nombre del producto</label>
						<input type="text" id="nombre" class="form-control" placeholder="Ingresa el nombre del producto" name="nombre" value="<?php echo $r['nombre']; ?>" required>
					</div>
					<div class="mb-3">
						<label class="form-label" for="nombre">Descripcion</label>
						<input type="text" id="descripcion" class="form-control" placeholder="Ingresa una descripcion" name="descripcion" value="<?php echo $r['descripcion']; ?>" required>
					</div>
					<div class="mb-3">
						<label class="form-label" for="precio">Precio</label>
						<input type="number" id="precio" class="form-control" placeholder="Ingresa un precio en pesos ARS" name="precio" value="<?php echo $r['precio']; ?>">
					</div>
					<div class="mb-3">
						<label class="form-label" for="foto">foto</label>
						<input type="file" class="form-control" id="foto" name="foto" required>
						<?php
                if (!empty($r['foto'])) {
                    ?>
							<img src="imagenes/<?php echo $r['foto']; ?>" width="50%">
							<?php
                }
                ?>
					</div>
					<button type="submit" class="btn btn-primary btn-block">Cargar</button>
				</form>
		</div>
	</div>

	<div class="org_carga_tabla">
		<div>
			<h1>Productos cargados</h1>
		</div>
		<table class="table">
			<thead>
				<tr>
					<th scope="col">ID</th>
					<th scope="col">Nombre</th>
					<th scope="col">Descripcion</th>
					<th scope="col">Foto</th>
					<th scope="col">Precio</th>
					<th scope="col">Opciones</th>

				</tr>
			</thead>
			<tbody>
				<?php
            $sql = "SELECT id, nombre,descripcion,foto,precio FROM discos where eliminado = 0 ORDER BY id";
            $sql = mysqli_query($con, $sql);
            if (mysqli_num_rows($sql) != 0) {
                while ($r = mysqli_fetch_array($sql)) {
                    ?>
					<tr>
						<th scope="row">
							<?php echo $r['id']; ?>
						</th>
						<td>
							<?php echo $r['nombre']; ?>
						</td>
						<td>
							<?php echo $r['descripcion']; ?>
						</td>
						<td>
							<?php ?> <img src="imagenes/<?php echo $r['foto']; ?>" width="100">
							<?php ?>
						</td>
						<td>
							<?php echo $r['precio']; ?> ARS
						</td>
						<td> <a href="index.php?modulo=tabla&accion=editar&id=<?php echo $r['id']; ?>">Editar</a> -
							<a href="javascript:if(confirm('Desea eliminar el registro?')) window.location='index.php?modulo=tabla&accion=guardar_eliminar&id=<?php echo $r['id']; ?>'">Eliminar</a>
						</td>
					</tr>
					<tr>
						<?php
                }
            }
            ?>
			</tbody>
		</table>
	</div>