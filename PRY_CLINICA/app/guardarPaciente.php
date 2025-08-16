<?php
// conecar a base de datos con conexion/db.php
require_once '../conexion/db.php';

// recibir los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // recbir los datos del formulario
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
    
    //  ingresar los datos en la base de datos
    $sql = "INSERT INTO pacientes (nombre, correo, telefono, fecha_nacimiento) VALUES (:nombre, :correo, :telefono, :fecha_nacimiento)";
    // enviar varias con binparam para evitar inyeccion sql
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
    // ejecutar la consulta
    if ($stmt->execute()) {
        exit;
    } else {
        echo "Error al crear el paciente.";
    }
}

?>