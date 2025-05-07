<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador de Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        #wrapper {
            display: flex;
            min-height: 100vh;
        }

        #sidebar {
            min-height: 100vh;
        }

        #content {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .toggle-icon {
            float: right;
            font-size: 16px;
            transition: transform 0.3s ease;
        }
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-dark text-white p-3 d-flex flex-column" id="sidebar">
            <h3><a href="/adminCursos/public/" class="text-decoration-none text-white">Administrador de Cursos</a></h3>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="#" class="nav-link text-white d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#submenuEstudiantes" aria-expanded="false">
                        Administrar estudiantes <span class="toggle-icon">&gt;</span>
                    </a>
                    <ul class="nav flex-column collapse ms-3" id="submenuEstudiantes">
                        <li class="nav-item"><a href="/adminCursos/public/listarEstudiantes" class="nav-link text-white">Listar estudiantes</a></li>
                        <li class="nav-item"><a href="/adminCursos/public/rearEstudiantes" class="nav-link text-white">Crear estudiante</a></li>
                        <li class="nav-item"><a href="#" class="nav-link text-white">Actualizar estudiante</a></li>
                        <li class="nav-item"><a href="#" class="nav-link text-white">Eliminar estudiante</a></li>
                    </ul>
                </li>
                
                <li class="nav-item">
                    <a href="#" class="nav-link text-white d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#submenuCursos" aria-expanded="false">
                        Administrar cursos <span class="toggle-icon">&gt;</span>
                    </a>
                    <ul class="nav flex-column collapse ms-3" id="submenuCursos">
                        <li class="nav-item"><a href="#" class="nav-link text-white">Listar cursos</a></li>
                        <li class="nav-item"><a href="#" class="nav-link text-white">Crear cursos</a></li>
                        <li class="nav-item"><a href="#" class="nav-link text-white">Actualizar cursos</a></li>
                        <li class="nav-item"><a href="#" class="nav-link text-white">Eliminar cursos</a></li>
                    </ul>
                </li>

                <li class="nav-item"><a href="#" class="nav-link text-white">Asignar estudiante a curso</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-white">Top 3 cursos con más estudiantes</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-white">Listado de cursos de un estudiante</a></li>
            </ul>
        </div>

        <!-- Contenido principal -->
        <div id="content">
            <div>
                <h1>Crear Curso</h1>
                <form id="clienteForm">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required><br><br>

                    <label for="horario">Horario:</label>
                    <input type="text" id="horario" name="horario" required><br><br>

                    <label for="fechaInicio">Fecha Inicio:</label>
                    <input type="text" id="fechaInicio" name="fechaInicio" required><br><br>

                    <label for="fechaFin">Fecha Fin:</label>
                    <input type="text" id="fechaFin" name="fechaFin" required><br><br>

                    <button type="submit">Enviar</button>
                </form>

                <div id="contenedor"></div>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        // Manejar el envío del formulario
                        document.getElementById('clienteForm').addEventListener('submit', function(event) {
                            event.preventDefault(); // Evitar el envío por defecto del formulario

                            // Obtener los valores de los campos
                            const nombre = document.getElementById('nombre').value;
                            const horario = document.getElementById('horario').value;
                            const fechaInicio = document.getElementById('fechaInicio').value;
                            const fechaFin = document.getElementById('fechaFin').value;

                            // Enviar los datos a la API con fetch
                            fetch('http://127.0.0.1:8000/api/courses', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({
                                    Nombre: nombre,
                                    Horario: horario,
                                    FechaInicio: fechaInicio,
                                    FechaFin: fechaFin

                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                // Mostrar la respuesta en el contenedor
                                let contenedor = document.getElementById('contenedor');
                                let texto = document.createElement('p');
                                texto.textContent = `Curso creado`;
                                contenedor.appendChild(texto);
                            })
                            .catch(error => {
                                console.error('Error al enviar los datos:', error);
                                let contenedor = document.getElementById('contenedor');
                                let texto = document.createElement('p');
                                texto.textContent = 'Hubo un error al enviar los datos.';
                                contenedor.appendChild(texto);
                            });
                        });
                    });
                </script>

                <script>
                    // Selecciona todos los elementos con el atributo data-bs-toggle="collapse"
                    document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(menu => {
                        menu.addEventListener("click", function () {
                            let icon = this.querySelector(".toggle-icon");
                            let target = document.querySelector(this.getAttribute("data-bs-target"));

                            // Verifica si el menú está abierto o cerrado
                            if (target.classList.contains("show")) {
                                icon.innerHTML = "&gt;"; // Flecha a la derecha
                            } else {
                                icon.innerHTML = "&#x25BC;"; // Flecha hacia abajo (▼)
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</body>
</html>
