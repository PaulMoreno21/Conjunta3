<?php
require_once '../conexion/db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];

$sql = "SELECT * FROM medicos WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$medico = $stmt->fetch(PDO::FETCH_ASSOC);

if($medico) {
    echo json_encode($medico);
} else {
    echo json_encode(['error' => 'medico no encontrado']);
}
?>