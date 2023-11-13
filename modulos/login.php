<?php
if (isset($_GET['salir'])) {
    session_destroy();
    echo "<script>window.location='index.php';</script>";
}
if (isset($_POST['correo']) && isset($_POST['clave'])) {
    $sql = "SELECT * FROM usuarios WHERE correo = '" . $_POST['correo'] . "' AND clave='" . $_POST['clave'] . "'";
    $sql = mysqli_query($con, $sql);
    if (mysqli_num_rows($sql) != 0) {
        $r = mysqli_fetch_array($sql);
        $_SESSION['id'] = $r['id'];
        $_SESSION['nombre_usuario'] = $r['correo'];
        $_SESSION['roles'] = $r['rol'];
        echo "<script> alert ('Bienvenido: " . $_SESSION['nombre_usuario'] . "');</script>";
        //crear la sesion
    } else {
        echo "<script> alert('Verifique los datos.');</script>";
        echo "<script>window.location='index.php?modulo=login';</script>";
    }
    if ($_SESSION['roles'] != 'admin') {
        echo "<script>window.location='index.php';</script>";
        echo "<script>window.location='index.php';</script>";
    } else {
        echo "<script>window.location='index.php?modulo=';</script>";
    }
}
?>
<form action="index.php?modulo=login" method="POST">
<img src="imagenes/login.png" alt="Logo" class="logo">
  <div class="form-outline mb-4">
    <h1>Iniciar Sesión </h1>
    <label class="form-label" for="email">Email</label>
    <input type="email" id="email" class="form-control" placeholder="Ingresa tu email" name="correo" required/>
    <label class="form-label" for="clave">Contraseña</label>
    <input type="password" id="clave" class="form-control" placeholder="Ingresa tu contraseña"name="clave"  required/>

    <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
  </div>
</form>