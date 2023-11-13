<?php
function conectar()
{
    global $con;
    $con = mysqli_connect("localhost", "root", "", "tpf_paradigmas");
    /* comprobar la conexion */
    if (mysqli_connect_errno()) {
        printf("Fallo la conexion : %s\n", mysqli_connect_error());
        exit();
    } else {
        $con->set_charset("utf8");
        $ret = true;
    }
    return $ret;

}
function desconectar()
{
    global $con;
    mysqli_close($con);
}
?>