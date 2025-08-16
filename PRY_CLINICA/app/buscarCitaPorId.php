<?php
require_once '../conexion/db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];

$sql = "SELECT * FROM citas WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$cita = $stmt->fetch(PDO::FETCH_ASSOC);

if($cita) {
    echo json_encode($cita);
} else {
    echo json_encode(['error' => 'cita no encontrada']);
}
?>