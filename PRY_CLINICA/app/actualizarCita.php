<?php 
require_once '../conexion/db.php';

// Obtener los datos JSON de la solicitud
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if ($data === null) {
    // Si falla la decodificación JSON, intentar con POST normal
    $data = $_POST;
}

// Validar campos requeridos
$requiredFields = ['id', 'paciente_id', 'medico_id', 'fecha', 'hora_inicio', 'hora_fin'];
foreach ($requiredFields as $field) {
    if (!isset($data[$field])) {
        http_response_code(400);
        echo json_encode(['error' => 'Faltan campos requeridos', 'campo_faltante' => $field]);
        exit;
    }
}

try {
    $hora_inicio_dt = new DateTime($data['hora_inicio']);
    $hora_fin_dt = new DateTime($data['hora_fin']);
    $duracion = $hora_fin_dt->diff($hora_inicio_dt);
    $duracion_minutos = ($duracion->h * 60) + $duracion->i;
    $stmt = $pdo->prepare("SELECT tarifa_por_hora FROM medicos WHERE id = :medico_id");
    $stmt->bindParam(':medico_id', $data['medico_id']);
    $stmt->execute();
    $tarifa_por_hora = $stmt->fetchColumn();

    // Calcular costo total
    $costo_total = ($tarifa_por_hora / 60) * $duracion_minutos;

    // Preparar la consulta de actualización
    $consulta = "UPDATE citas SET 
                paciente_id = :paciente_id, 
                medico_id = :medico_id, 
                fecha = :fecha, 
                hora_inicio = :hora_inicio, 
                hora_fin = :hora_fin, 
                duracion = :duracion,
                costo_total = :costo_total
                WHERE id = :id";
    
    // Ejecutar la consulta
    $stmt = $pdo->prepare($consulta);
    $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
    $stmt->bindParam(':paciente_id', $data['paciente_id'], PDO::PARAM_INT);
    $stmt->bindParam(':medico_id', $data['medico_id'], PDO::PARAM_INT);
    $stmt->bindParam(':fecha', $data['fecha']);
    $stmt->bindParam(':hora_inicio', $data['hora_inicio']);
    $stmt->bindParam(':hora_fin', $data['hora_fin']);
    $stmt->bindParam(':duracion', $duracion_minutos, PDO::PARAM_INT);
    $stmt->bindParam(':costo_total', $costo_total);
    
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Cita actualizada correctamente',
            'data' => [
                'duracion_minutos' => $duracion_minutos,
                'costo_total' => number_format($costo_total, 2)
            ]
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'error' => 'Error al actualizar la cita',
            'database_error' => $stmt->errorInfo()
        ]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Error en la base de datos',
        'message' => $e->getMessage()
    ]);
}
?>