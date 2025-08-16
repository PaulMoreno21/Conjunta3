<?php 
require_once '../conexion/db.php';
$sql = "SELECT * FROM pacientes";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LISTA DE ESTUDIANTES</title>
    <link href="../public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@magicbruno/swalstrap5@1.0.8/dist/js/swalstrap5_all.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <style>
        :root {
            --bs-primary-rgb: 79, 70, 229;
            --bs-border-radius: 12px;
        }
        
        body {
            background-color: #f8fafc;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }
        
        .table-container {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 2rem;
            margin-top: 1.5rem;
        }
        
        .page-header {
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }
        
        .btn-action {
            min-width: 100px;
        }
        
        .form-icon {
            width: 20px;
            height: 20px;
            margin-right: 0.5rem;
        }
        
        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            color: #64748b;
            background-color: #f8fafc;
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(99, 102, 241, 0.05);
        }
        
        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            letter-spacing: 0.05em;
        }
        
        .modal-header {
            border-bottom: none;
            padding: 1.5rem;
        }
        
        .modal-title {
            font-weight: 600;
        }
        
        .modal-content {
            border: none;
            border-radius: 12px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .form-floating>label {
            color: #64748b;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }
        
        .btn-primary {
            background-color: #6366f1;
            border-color: #6366f1;
            font-weight: 500;
        }
        
        .btn-primary:hover {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }
        
        .btn-outline-secondary {
            border-color: #e2e8f0;
            color: #64748b;
            font-weight: 500;
        }
        
        .btn-outline-secondary:hover {
            background-color: #f1f5f9;
            border-color: #e2e8f0;
            color: #475569;
        }
        
        .btn-danger {
            background-color: #ef4444;
            border-color: #ef4444;
            font-weight: 500;
        }
        
        .btn-danger:hover {
            background-color: #dc2626;
            border-color: #dc2626;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="container py-5">
        <div class="table-container">
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="text-end">
                        <h1 class="h2 fw-bold text-primary mb-1 d-flex align-items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-2a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm9 11a1 1 0 0 1-2 0v-2a3 3 0 0 0-3-3H8a3 3 0 0 0-3 3v2a1 1 0 0 1-2 0v-2a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v2z"/>
                            </svg>
                            Lista de Pacientes
                        </h1>
                        <p class="text-muted mb-0">Gestión completa de pacientes registrados</p>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tabla-usuarios">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3">ID</th>
                            <th class="py-3">Nombre</th>
                            <th class="py-3">correo</th>
                            <th class="py-3">Teléfono</th>
                            <th class="py-3">Fecha de Nacimiento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $user): ?>
                            <tr id="fila-<?php echo $user['id']; ?>">
                                <td class="ps-4 fw-semibold"><?php echo $user['id']; ?></td>
                                <td><?php echo $user['nombre']; ?></td>
                                <td><?php echo $user['correo']; ?></td>
                                <td class="text-center pe-4"><?php echo $user['telefono']; ?></td>
                                <td class="text-center pe-4"><?php echo $user['fecha_nacimiento']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="../public/bootstrap/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>