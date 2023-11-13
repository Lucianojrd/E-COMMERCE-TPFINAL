<?php
if (isset($_POST["nombre"]) && isset($_POST["correo"]) && isset($_POST["clave"])) {
    //verifico que no exista el usuario
    $sql = "SELECT *FROM usuarios where correo = '" . $_POST['correo'] . "'";
    $sql = mysqli_query($con, $sql);
    if (mysqli_num_rows($sql) != 0) {
        echo "<script> alert('EL USUARIO YA EXISTE EN LA BD');</script>";
    } else {
        //inserto nuevo usuario
        $rol = 'usuario';
        $sql = "INSERT INTO usuarios (nombre,correo,clave, rol) values ('" . $_POST['nombre'] . "','" . $_POST['correo'] . "','" . $_POST['clave'] . "','" . $rol . "')";
        $sql = mysqli_query($con, $sql);
        if (mysqli_error($con)) {
            echo "<script> alert('ERROR NO SE PUDO INSERTAR EL REGISTRO);</script>";
        } else {
            echo "<script> alert('Registro insertado con exito');</script>";
            echo "<script>window.location='index.php?modulo=login';</script>";
        }
    }
}
?>

	<form action="index.php?modulo=registro" method="POST">
		<img src="imagenes/registro.png" alt="Logo" class="logo">
		<div class="form-outline mb-4">
			<h1>Registro</h1>
			<label class="form-label" for="nombre">Nombre completo</label>
			<input type="text" id="nombre" class="form-control" placeholder="Ingresa tu nombre completo" name="nombre" required />
			<label class="form-label" for="email">Email</label>
			<input type="email" id="email" class="clave" placeholder="Ingresa tu email" name="correo" required/>
			<label class="form-label" for="clave">Contraseña</label>
			<input type="password" id="clave" class="form-control" placeholder="Ingresa tu contraseña" name="clave" required/>

			<button type="submit" class="btn btn-primary btn-block">Registrarse</button>
		</div>
	</form>