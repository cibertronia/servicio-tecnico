<?php
session_start();

function Create()
{
    if (isset($_POST['idCliente']) && isset($_POST['idProducto']) && isset($_POST['fecha']) && isset($_POST['hora']) && isset($_POST['idUsuario']) && isset($_POST['idSucursal'])) {
        include './../conexion.php';
        $db = $MySQLi;
        $idCliente = mysqli_real_escape_string($db, $_POST['idCliente']);
        $nombreCliente = mysqli_real_escape_string($db, $_POST['nombreCliente']);
        $idProducto = mysqli_real_escape_string($db, $_POST['idProducto']);
        $nombreProducto = mysqli_real_escape_string($db, $_POST['nombreEquipo']);
        $fecha = mysqli_real_escape_string($db, $_POST['fecha']);
        $hora = mysqli_real_escape_string($db, $_POST['hora']);
        $observaciones = mysqli_real_escape_string($db, $_POST['nota']);
        $idUsuario = mysqli_real_escape_string($db, $_POST['idUsuario']);
        $idSucursal = mysqli_real_escape_string($db, $_POST['idSucursal']);

        $query = "INSERT INTO capacitaciones (idCliente, nombreCliente, idProducto, nombreProducto, fecha, hora, observaciones, idUsuario, idSucursal) VALUES ('$idCliente', '$nombreCliente', '$idProducto', '$nombreProducto', '$fecha', '$hora', '$observaciones', '$idUsuario', '$idSucursal')";

        if (mysqli_query($db, $query)) {
            $response = [
                'status' => 'success',
                'message' => 'Capacitación creada exitosamente.'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Error al crear la capacitación: ' . mysqli_error($db)
            ];
        }
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Faltan datos requeridos.'
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);

}

function index()
{
    include './../conexion.php';
    $db = $MySQLi;

    $fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : date('Y-m-01');
    $fechaFin = isset($_GET['fechaFin']) ? $_GET['fechaFin'] : date('Y-m-d');
    $idUsuario = isset($_GET['idUsuario']) ? $_GET['idUsuario'] : null;
    $search = isset($_GET['search']) ? mysqli_real_escape_string($db, $_GET['search']) : '';

    $query = "SELECT capacitaciones.*, usuarios.Nombre, sucursales.sucursal 
    FROM capacitaciones 
    LEFT JOIN usuarios ON capacitaciones.idUsuario = usuarios.idUSer
    LEFT JOIN sucursales ON capacitaciones.idSucursal = sucursales.idTienda
    WHERE DATE(capacitaciones.created_at) BETWEEN '$fechaInicio' AND '$fechaFin'";

    if ($idUsuario) {
        $query .= " AND capacitaciones.idUsuario = '$_SESSION[idUser]'";
    }

    if (!empty($search)) {
        $query .= " AND (capacitaciones.nombreCliente LIKE '%$search%' OR capacitaciones.nombreProducto LIKE '%$search%')";
    }

    $result = mysqli_query($db, $query);

    if (!$result) {
        $response = [
            'status' => 'error',
            'message' => 'Error al obtener las capacitaciones: ' . mysqli_error($db)
        ];
    } else {
        $response = [
            'status' => 'success',
            'data' => mysqli_fetch_all($result, MYSQLI_ASSOC)
        ];
    }

    return $response;
}

function destroy($id)
{
    include './../conexion.php';
    $db = $MySQLi;

    $id = mysqli_real_escape_string($db, $id);
    $query = "DELETE FROM capacitaciones WHERE id = '$id'";

    if (mysqli_query($db, $query)) {
        $response = [
            'status' => 'success',
            'message' => 'Capacitación eliminada exitosamente.'
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Error al eliminar la capacitación: ' . mysqli_error($db)
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
        if (isset($_POST['id'])) {
            destroy($_POST['id']);
        } else {
            $response = [
                'status' => 'error',
                'message' => 'ID de capacitación no proporcionado.'
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    } else {
        Create();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $capacitaciones = index();
    header('Content-Type: application/json');
    echo json_encode($capacitaciones);
}