<?php
require_once '../conexion/db.php';
$query = "SELECT 
    citas.id,
    pacientes.nombre AS paciente,
    medicos.nombre AS medico,
    medicos.especialidad,
    citas.fecha,
    citas.hora_inicio,
    citas.hora_fin,
    citas.duracion,
    citas.costo_total,
    citas.estado
FROM citas
JOIN pacientes ON citas.paciente_id = pacientes.id
JOIN medicos ON citas.medico_id = medicos.id";

$stmt = $pdo->prepare($query);
$stmt->execute();
$citas = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM pacientes";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
$sql = "SELECT * FROM medicos";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Citas Médicas</title>
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
        
        .btn-warning {
            background-color: #f59e0b;
            border-color: #f59e0b;
            color: white;
            font-weight: 500;
        }
        
        .btn-warning:hover {
            background-color: #d97706;
            border-color: #d97706;
            color: white;
        }
        
        .estado-pendiente {
            color: #f59e0b;
        }
        
        .estado-completada {
            color: #10b981;
        }
        
        .estado-cancelada {
            color: #ef4444;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="container py-5">
        <div class="table-container">
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <a href="../index.php" class="btn btn-outline-secondary btn-lg d-inline-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="form-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Volver
                    </a>
                    <div class="text-end">
                        <h1 class="h2 fw-bold text-primary mb-1 d-flex align-items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Lista de Citas Médicas
                        </h1>
                        <p class="text-muted mb-0">Gestión completa de citas registradas</p>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tabla-citas">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3">Paciente</th>
                            <th class="py-3">Médico</th>
                            <th class="py-3">Especialidad</th>
                            <th class="py-3">Fecha</th>
                            <th class="py-3">Hora Inicio</th>
                            <th class="py-3">Hora Fin</th>
                            <th class="py-3">Duración</th>
                            <th class="py-3">Costo Total</th>
                            <th class="py-3">Estado</th>
                            <th class="text-center pe-4 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($citas as $cita): ?>
                            <tr id="fila-<?php echo $cita['id']; ?>">
                                <td class="ps-4 fw-semibold"><?php echo htmlspecialchars($cita['paciente']); ?></td>
                                <td><?php echo htmlspecialchars($cita['medico']); ?></td>
                                <td><?php echo htmlspecialchars($cita['especialidad']); ?></td>
                                <td><?php echo htmlspecialchars($cita['fecha']); ?></td>
                                <td><?php echo htmlspecialchars($cita['hora_inicio']); ?></td>
                                <td><?php echo htmlspecialchars($cita['hora_fin']); ?></td>
                                <td><?php echo htmlspecialchars($cita['duracion']); ?> min</td>
                                <td>$<?php echo number_format((float)$cita['costo_total'], 2); ?></td>
                                <td class="fw-bold estado-<?php echo strtolower($cita['estado']); ?>">
                                    <?php echo htmlspecialchars($cita['estado']); ?>
                                </td>
                                <td class="text-center pe-4">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <button
                                            type="button"
                                            class="btn btn-warning btn-sm btn-action btn-editar-cita d-inline-flex align-items-center"
                                            data-id="<?php echo $cita['id']; ?>"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Editar
                                        </button>
                                        <button
                                        type="button"
                                        class="btn btn-danger btn-sm btn-action btn-eliminar-cita d-inline-flex align-items-center"
                                        data-id="<?php echo $cita['id']; ?>"
                                        data-nombre="<?php echo htmlspecialchars($cita['paciente']); ?>"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Eliminar
                                    </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Editar Cita -->
    <div class="modal fade" id="modalEditarCita" tabindex="-1" aria-labelledby="modalEditarCitaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title d-flex align-items-center" id="modalEditarCitaLabel">
                        <svg xmlns="http://www.w3.org/2000/svg" class="me-2" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Editar Cita Médica
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="form-editar-cita">
                        <input type="hidden" id="id">
                        
                        <div class="row g-3 mb-4">
                            <!-- Paciente -->
                            <div class="col-md-6">
                                <label for="paciente_id" class="form-label fw-semibold text-muted mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Paciente
                                </label>
                                <select class="form-select" id="paciente_id" required>
                                    <?php foreach ($pacientes as $paciente): ?>
                                        <option value="<?php echo $paciente['id']; ?>">
                                            <?php echo htmlspecialchars($paciente['nombre']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Médico -->
                            <div class="col-md-6">
                                <label for="medico_id" class="form-label fw-semibold text-muted mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M12 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-2a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm9 11a1 1 0 0 1-2 0v-2a3 3 0 0 0-3-3H8a3 3 0 0 0-3 3v2a1 1 0 0 1-2 0v-2a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v2z"/>
                                    </svg>
                                    Médico
                                </label>
                                <select class="form-select" id="medico_id" required>
                                    <?php foreach ($medicos as $medico): ?>
                                        <option value="<?php echo $medico['id']; ?>" data-especialidad="<?php echo htmlspecialchars($medico['especialidad']); ?>">
                                            <?php echo htmlspecialchars($medico['nombre']); ?> (<?php echo htmlspecialchars($medico['especialidad']); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Fecha -->
                            <div class="col-md-4">
                                <label for="fecha" class="form-label fw-semibold text-muted mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Fecha
                                </label>
                                <input type="date" class="form-control" id="fecha" required min="<?php echo date('Y-m-d'); ?>">
                            </div>

                            <!-- Hora Inicio -->
                            <div class="col-md-4">
                                <label for="hora_inicio" class="form-label fw-semibold text-muted mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Hora Inicio
                                </label>
                                <input type="time" class="form-control" id="hora_inicio" required>
                            </div>

                            <!-- Hora Fin -->
                            <div class="col-md-4">
                                <label for="hora_fin" class="form-label fw-semibold text-muted mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Hora Fin
                                </label>
                                <input type="time" class="form-control" id="hora_fin" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                        
                        <div class="modal-footer bg-light p-4 border-top-0 d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-secondary d-inline-flex align-items-center" data-bs-dismiss="modal">
                                <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary d-inline-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                Guardar cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../public/bootstrap/js/bootstrap.bundle.min.js"></script>
    
    <script>
    const modalEditarCita = new bootstrap.Modal(
        document.getElementById('modalEditarCita'), {
            keyboard: false
        }
    );
    
    // Evento para editar cita
    document.getElementById('tabla-citas').addEventListener('click', function(event) {
        if(event.target.classList.contains('btn-editar-cita') || event.target.closest('.btn-editar-cita')) {
            const button = event.target.classList.contains('btn-editar-cita') ? 
                event.target : event.target.closest('.btn-editar-cita');
            const id = button.dataset.id;

            // Mostrar carga
            Toastify({
                text: "Cargando datos de la cita...",
                duration: 2000,
                gravity: "top",
                position: "right",
                backgroundColor: "linear-gradient(to right, #1e90ff, #3742fa)",
            }).showToast();

            fetch('buscarCitaPorId.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: id })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('id').value = data.id;
                document.getElementById('paciente_id').value = data.paciente_id;
                document.getElementById('medico_id').value = data.medico_id;
                document.getElementById('fecha').value = data.fecha;
                document.getElementById('hora_inicio').value = data.hora_inicio;
                document.getElementById('hora_fin').value = data.hora_fin;

                modalEditarCita.show();
                
                Toastify({
                    text: "Datos de la cita cargados correctamente",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                }).showToast();
            })
            .catch(error => {
                console.error('Error:', error);
                Toastify({
                    text: "Error al cargar los datos de la cita",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                }).showToast();
            });
        }
        if(event.target.classList.contains('btn-eliminar-cita')) {
            var id = event.target.dataset.id;
            var nombre = event.target.dataset.nombre;

            Swal.fire({
                title: '¿Está seguro de eliminar la cita?',
                text: nombre,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar!',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('eliminarCita.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ id: id })
                    }).then(function(response) {
                        return response.json();
                    }).then(function(request) {
                        var fila = document.getElementById('fila-' + id);
                        fila.remove();
                        
                        Toastify({
                            text: `Cita  eliminada correctamente`,
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                        }).showToast();
                    }).catch(error => {
                        Toastify({
                            text: `Error al eliminar la cita`,
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                        }).showToast();
                    })
                }
            });
        }
    });

    // Evento para guardar cambios
    document.getElementById('form-editar-cita').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const fecha = document.getElementById('fecha').value;
        const horaInicio = document.getElementById('hora_inicio').value;
        const horaFin = document.getElementById('hora_fin').value;
        
        if(new Date(fecha) < new Date()) {
            Toastify({
                text: "La fecha no puede ser anterior al día actual",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
            }).showToast();
            return;
        }
        
        if(horaInicio >= horaFin) {
            Toastify({
                text: "La hora de fin debe ser posterior a la hora de inicio",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
            }).showToast();
            return;
        }
        

        const formData = {
            id: document.getElementById('id').value,
            paciente_id: document.getElementById('paciente_id').value,
            medico_id: document.getElementById('medico_id').value,
            fecha: fecha,
            hora_inicio: horaInicio,
            hora_fin: horaFin
        };

        // Mostrar carga
        Toastify({
            text: "Actualizando cita...",
            duration: 2000,
            gravity: "top",
            position: "right",
            backgroundColor: "linear-gradient(to right, #1e90ff, #3742fa)",
        }).showToast();

        fetch('actualizarCita.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                modalEditarCita.hide();
                
                Toastify({
                    text: "Cita actualizada correctamente",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                }).showToast();
                
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                Toastify({
                    text: "Error: " + data.message,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                }).showToast();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Toastify({
                text: "Error al actualizar la cita",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
            }).showToast();
        });
    });

    </script>
</body>
</html>