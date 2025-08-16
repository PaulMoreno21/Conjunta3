<?php 

    require_once '../conexion/db.php';
    // recibir datos por json
    $request =  json_decode(file_get_contents("php://input"), true);

    $id= $request['id'];
    $nombre = $request['nombre'];
    $correo = $request['correo'];
    $telefono = $request['telefono'];
    $fecha_nacimiento = $request['fecha_nacimiento'];

    // prepara mi query
    $consulta = "UPDATE pacientes SET nombre=:nombre, correo=:correo, telefono=:telefono, fecha_nacimiento=:fecha_nacimiento WHERE id=:id";
    // ejecutar la consulta
    $stmt = $pdo->prepare($consulta);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
    $stmt->execute();
  
    // imprimir datos recibidos
    echo json_encode(['message' => 'Paciente actualizado correctamente.']);


?>