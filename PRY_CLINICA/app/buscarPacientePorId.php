<?php
require_once '../conexion/db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];

$sql = "SELECT * FROM pacientes WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$paciente = $stmt->fetch(PDO::FETCH_ASSOC);

if($paciente) {
    echo json_encode($paciente);
} else {
    echo json_encode(['error' => 'Paciente no encontrado']);
}
?>