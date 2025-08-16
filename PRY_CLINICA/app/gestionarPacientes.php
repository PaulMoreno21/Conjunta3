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
                            <th class="text-center pe-4 py-3">Acciones</th>
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

    <!-- Modal Editar -->
    <div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title d-flex align-items-center" id="modalEditarUsuarioLabel">
                        <svg xmlns="http://www.w3.org/2000/svg" class="me-2" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Editar Paciente
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" id="id">
                    
                    <div class="row g-3">
                        <!-- Nombre Completo -->
                        <div class="col-md-6">
                            <label for="nombre" class="form-label fw-semibold text-muted mb-2 d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Nombre completo
                            </label>
                            <input type="text" class="form-control" id="nombre" placeholder="Nombre completo" name="nombre" required>
                        </div>
                        
                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="correo" class="form-label fw-semibold text-muted mb-2 d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Correo electrónico
                            </label>
                            <input type="email" class="form-control" id="correo" placeholder="Correo electrónico" name="correo" required>
                        </div>

                        <!-- Telefono -->
                        <div class="col-md-6">
                            <label for="telefono" class="form-label fw-semibold text-muted mb-2 d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="me-2">
                    <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 0 0 6.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5Z" clip-rule="evenodd" />

                </svg>
                                Telefono
                            </label>
                            <input type="number" class="form-control" id="telefono" placeholder="Telefono" minlength="9" maxlength="10" name="telefono" required>
                        </div>
                        <!-- Fecha de Nacimiento -->
                        <div class="col-md-6">
                            <label for="fecha_nacimiento" class="form-label fw-semibold text-muted mb-2 d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="me-2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                                Fecha de Nacimiento
                            </label>
                            <input type="date" class="form-control" id="fecha_nacimiento"  name="fecha_nacimiento" required min="<?php echo date('Y-m-d'); ?>">
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

            fetch('buscarPacientePorId.php', {
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
                document.getElementById('correo').value = request.correo;
                document.getElementById('telefono').value = request.telefono;
                document.getElementById('fecha_nacimiento').value = request.fecha_nacimiento;
                Toastify({
                    text: `Cargando datos del paciente ${request.nombre}`,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                }).showToast();
            }).catch(error => {
                Toastify({
                    text: "Error al cargar datos del paciente",
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
                title: '¿Está seguro de eliminar al usuario?',
                text: nombre,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar!',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('eliminarPaciente.php', {
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
                        
                        // Toastify para eliminación
                        Toastify({
                            text: `Paciente ${nombre} eliminado correctamente`,
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                        }).showToast();
                    }).catch(error => {
                        Toastify({
                            text: `Error al eliminar al paciente ${nombre}`,
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
    // Obtener valores
    let id = document.getElementById('id').value;
    let nombre = document.getElementById('nombre').value.trim();
    let correo = document.getElementById('correo').value.trim();
    let telefono = document.getElementById('telefono').value.trim();
    let fecha_nacimiento = document.getElementById('fecha_nacimiento').value;
    
    // Validaciones básicas
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
    
    if (!correo || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo)) {
        Toastify({
            text: "Por favor ingrese un correo electrónico válido",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
        }).showToast();
        return false;
    }
    
    if (!telefono || !/^\d{9,10}$/.test(telefono)) {
        Toastify({
            text: "El teléfono debe tener entre 9 y 10 dígitos",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
        }).showToast();
        return false;
    }
    
    if (!fecha_nacimiento) {
        Toastify({
            text: "Por favor seleccione una fecha de nacimiento",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
        }).showToast();
        return false;
    }
    
    // Validar que la fecha no sea futura
    const hoy = new Date().toISOString().split('T')[0];
    if (fecha_nacimiento > hoy) {
        Toastify({
            text: "La fecha de nacimiento no puede ser futura",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
        }).showToast();
        return false;
    }
        fetch('actualizarPaciente.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(
                { 
                    id: id,
                    nombre: nombre,
                    correo: correo,
                    telefono: telefono,
                    fecha_nacimiento: fecha_nacimiento
                }
            )
        }).then(function(response) {
            return response.json();
        }).then(function(request) {
            modalEditarUsuario.hide();
            
            Toastify({
                text: `Paciente ${nombre} actualizado correctamente`,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
            }).showToast();
            
            // Recargar después de mostrar el Toastify
            setTimeout(() => {
                location.reload();
            }, 1500);
        }).catch(error => {
            Toastify({
                text: `Error al actualizar al paciente ${nombre}`,
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