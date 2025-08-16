<?php
// conecar a base de datos con conexion/db.php
require_once '../conexion/db.php';

// recibir los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // recbir los datos del formulario
    $nombre = $_POST['nombre'] ?? '';
    $especialidad = $_POST['especialidad'] ?? '';
    $tarifa = $_POST['tarifa'] ?? '';
    //  ingresar los datos en la base de datos
    $sql = "INSERT INTO medicos (nombre, especialidad, tarifa_por_hora) VALUES (:nombre, :especialidad, :tarifa_por_hora)";
    // enviar varias con binparam para evitar inyeccion sql
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':especialidad', $especialidad);
    $stmt->bindParam(':tarifa_por_hora', $tarifa);
    // ejecutar la consulta
    if ($stmt->execute()) {
        exit;
    } else {
        echo "Error al crear medico.";
    }
}

?>