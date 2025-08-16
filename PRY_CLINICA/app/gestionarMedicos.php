<?php 
require_once '../conexion/db.php';
$sql = "SELECT * FROM medicos";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LISTA DE MAESTROS</title>
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
                    <a href="../index.php" class="btn btn-outline-secondary btn-lg d-inline-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="form-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Volver
                    </a>
                    <div class="text-end">
                        <h1 class="h2 fw-bold text-primary mb-1 d-flex align-items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-2a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm9 11a1 1 0 0 1-2 0v-2a3 3 0 0 0-3-3H8a3 3 0 0 0-3 3v2a1 1 0 0 1-2 0v-2a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v2z"/>
                            </svg>
                            Lista de Medicos
                        </h1>
                        <p class="text-muted mb-0">Gestión completa de médicos registrados</p>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tabla-usuarios">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3">ID</th>
                            <th class="py-3">Nombre</th>
                            <th class="py-3">Especialidad</th>
                            <th class="py-3">Tarifa por Hora</th>
                            <th class="text-center pe-4 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $user): ?>
                            <tr id="fila-<?php echo $user['id']; ?>">
                                <td class="ps-4 fw-semibold"><?php echo $user['id']; ?></td>
                                <td><?php echo $user['nombre']; ?></td>
                                <td><?php echo $user['especialidad']; ?></td>
                                <td><?php echo $user['tarifa_por_hora']; ?></td>
                                <td class="text-center pe-4">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <button
                                            type="button"
                                            class="btn btn-primary btn-sm btn-action btn-editar-usuario d-inline-flex align-items-center"
                                            data-id="<?php echo $user['id']; ?>"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Editar
                                        </button>
                                        
                                        <button
                                            type="button"
                                            class="btn btn-danger btn-sm btn-action btn-eliminar-usuario d-inline-flex align-items-center"
                                            data-id="<?php echo $user['id']; ?>"
                                            data-nombre="<?php echo $user['nombre']; ?>"
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

    <!-- Modal Edit -->
    <div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title d-flex align-items-center" id="modalEditarUsuarioLabel">
                        <svg xmlns="http://www.w3.org/2000/svg" class="me-2" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Editar Medico
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" id="id">
                    
                    <div class="row g-3">
                        <!-- Nombre -->
                        <div class="col-md-6">
                            <label for="nombre" class="form-label fw-semibold text-muted mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Nombre completo
                            </label>
                            <input type="text" class="form-control" id="nombre" placeholder="Nombre completo" required>
                        </div>

                        <!-- Especialidad -->
                        <div class="col-md-6">
                            <label for="especialidad" class="form-label fw-semibold text-muted mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Especialidad
                            </label>
                            <input type="text" class="form-control" id="especialidad" placeholder="Especialidad" required>
                        </div>
                        
                        <!-- Tarifa por Hora -->
                        <div class="col-md-6">
                            <label for="tarifa_por_hora" class="form-label fw-semibold text-muted mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="me-2">
                    <path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 0 1-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004ZM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 0 1-.921.42Z" />
  <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v.816a3.836 3.836 0 0 0-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 0 1-.921-.421l-.879-.66a.75.75 0 0 0-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 0 0 1.5 0v-.81a4.124 4.124 0 0 0 1.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 0 0-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 0 0 .933-1.175l-.415-.33a3.836 3.836 0 0 0-1.719-.755V6Z" clip-rule="evenodd" />
                </svg>
                                Tarifa por Hora
                            </label>
                            <input type="number" class="form-control" id="tarifa_por_hora" placeholder="0.00" min="0" step="0.01" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light p-4 border-top-0 d-flex justify-content-end">
                    <button type="button" class="btn btn-outline-secondary d-inline-flex align-items-center" data-bs-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-primary d-inline-flex align-items-center" id="btn-actualizar-usuario">
                        <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Guardar cambios
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="../public/bootstrap/js/bootstrap.bundle.min.js"></script>
    
    <script>
    const modalEditarUsuario = new bootstrap.Modal(
        document.getElementById('modalEditarUsuario'), {
            keyboard: false
        }
    )
    
    var tablaUsuarios = document.getElementById('tabla-usuarios');
    tablaUsuarios.addEventListener('click', function(event) {
        if(event.target.classList.contains('btn-editar-usuario')) {
           var id = event.target.dataset.id;

            fetch('buscarMedicoPorId.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: id })
            }).then(function(response) {
                return response.json();
            }).then(function(request) {
                modalEditarUsuario.show();
                document.getElementById('id').value = request.id;
                document.getElementById('nombre').value = request.nombre;
                document.getElementById('especialidad').value = request.especialidad;
                document.getElementById('tarifa_por_hora').value = request.tarifa_por_hora;

                Toastify({
                    text: `Cargando datos del médico ${request.nombre}`,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                }).showToast();
            }).catch(error => {
                Toastify({
                    text: "Error al cargar datos del medico",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                }).showToast();
            })
        }

        if(event.target.classList.contains('btn-eliminar-usuario')) {
            var id = event.target.dataset.id;
            var nombre = event.target.dataset.nombre;

            Swal.fire({
                title: '¿Está seguro de eliminar al médico?',
                text: nombre,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar!',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('eliminarMedico.php', {
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
                            text: `Medico ${nombre} eliminado correctamente`,
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                        }).showToast();
                    }).catch(error => {
                        Toastify({
                            text: `Error al eliminar al medico${nombre}`,
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

    var btnActualizarUsuario = document.getElementById('btn-actualizar-usuario');
    btnActualizarUsuario.addEventListener('click', function() {
       
        let id = document.getElementById('id').value;
        let nombre = document.getElementById('nombre').value;
        let especialidad = document.getElementById('especialidad').value;
        let tarifa_por_hora = document.getElementById('tarifa_por_hora').value;
        if (!nombre || nombre.length < 3) {
        Toastify({
            text: "El nombre debe tener al menos 3 caracteres",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
        }).showToast();
        return false;
    }

    if (!especialidad || especialidad.length < 3) {
        Toastify({
            text: "Por favor ingrese una especialidad válida",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
        }).showToast();
        return false;
    }
    
    if (!tarifa_por_hora || tarifa_por_hora <= 0) {
        Toastify({
            text: "La tarifa por hora debe ser un número positivo",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
        }).showToast();
        return false;
    }


    fetch('actualizarMedico.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
            body: JSON.stringify(
                { 
                    id: id,
                    nombre: nombre,
                    especialidad: especialidad,
                    tarifa_por_hora: tarifa_por_hora
                }
            )
        }).then(function(response) {
            return response.json();
        }).then(function(request) {
            modalEditarUsuario.hide();
            
            Toastify({
                text: `Medico ${nombre} actualizado correctamente`,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
            }).showToast();
            
            setTimeout(() => {
                location.reload();
            }, 1500);
        }).catch(error => {
            Toastify({
                text: `Error al actualizar al medico ${nombre}`,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
            }).showToast();
        })
    });
</script>
</body>
</html>