<?php

require_once '../conexion/db.php';
// capturar los datos del formulario

$paciente_id = $_POST['paciente_id'];
$medico_id = $_POST['medico_id'];
$fecha= $_POST['fecha'];
$hora_inicio= $_POST['hora_inicio'];
$hora_fin= $_POST['hora_fin'];
/* calcular la duracion en minutos restando la hora_fin-hora_inicio */
$hora_inicio_dt = new DateTime($hora_inicio);
$hora_fin_dt = new DateTime($hora_fin);
$duracion = $hora_fin_dt->diff($hora_inicio_dt);
$duracion_minutos = ($duracion->h * 60) + $duracion->i;
// obtener la tarifa por hora del medico
$stmt = $pdo->prepare("SELECT tarifa_por_hora FROM medicos WHERE id = :medico_id");
$stmt->bindParam(':medico_id', $medico_id);
$stmt->execute();
$tarifa_por_hora = $stmt->fetchColumn();
// calcular el costo total de la cita
$costo_total = ($tarifa_por_hora / 60) * $duracion_minutos;
// guardar los datos en la base de datos en la tabla citas
$sql = $pdo->prepare(
    "INSERT INTO citas (paciente_id, 
                        medico_id, 
                        fecha, 
                        hora_inicio, 
                        hora_fin, 
                        duracion, 
                        costo_total) 
    VALUES (:p_id, :m_id, :fecha, :h_inicio, :h_fin, :duracion, :costo)");
$sql->bindParam(':p_id', $paciente_id);
$sql->bindParam(':m_id', $medico_id);
$sql->bindParam(':fecha', $fecha);
$sql->bindParam(':h_inicio', $hora_inicio);
$sql->bindParam(':h_fin', $hora_fin);
$sql->bindParam(':duracion', $duracion_minutos);
$sql->bindParam(':costo', $costo_total);
$sql->execute();
?>