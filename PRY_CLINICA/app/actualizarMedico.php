<?php 

    require_once '../conexion/db.php';
    // recibir datos por json
    $request =  json_decode(file_get_contents("php://input"), true);

    $id= $request['id'];
    $nombre = $request['nombre'];
    $especialidad = $request['especialidad'];
    $tarifa_por_hora = $request['tarifa_por_hora'];

    // prepara mi query
    $consulta = "UPDATE medicos SET nombre=:nombre, especialidad=:especialidad, tarifa_por_hora=:tarifa_por_hora WHERE id=:id";
    // ejecutar la consulta
    $stmt = $pdo->prepare($consulta);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':especialidad', $especialidad);
    $stmt->bindParam(':tarifa_por_hora', $tarifa_por_hora);
    $stmt->execute();
  
    // imprimir datos recibidos
    echo json_encode(['message' => 'Medico actualizado correctamente.']);


?>