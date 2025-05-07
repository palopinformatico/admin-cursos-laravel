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
                        <li class="nav-item"><a href="/adminCursos/public/crearEstudiantes" class="nav-link text-white">Crear estudiante</a></li>
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
                <h1>Asignar estudiante a curso</h1>

                <form id="asignacionForm">
                    <label for="estudiantes">Selecciona un estudiante:</label>
                    <select name="estudiantes" id="estudiantes">
                    </select>
                    <br><br>
                    <label for="cursos">Selecciona cursos:</label>
                    <div id="divCursos"></div>
                    <br><br>
                    <button type="submit">Asignar</button>
                </form>
                <div id="contenedor"></div>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        fetch('http://127.0.0.1:8000/api/students')
                            .then(response => response.json())
                            .then(data => {
                                let estudiantes = document.getElementById('estudiantes'); // Obtener el ComboBox

                                data.forEach(item => {
                                    let option = document.createElement('option'); // Crear una nueva opción
                                    option.value = item.id; // El valor que se envía cuando se selecciona
                                    option.textContent = `${item.Nombre} ${item.Apellido}`; // El texto que se muestra en la opción
                                    estudiantes.appendChild(option); // Agregar la opción al ComboBox
                                });
                            })
                            .catch(error => console.error('Error al obtener los datos:', error));
                    });

                    document.addEventListener("DOMContentLoaded", function() {
                        fetch('http://127.0.0.1:8000/api/courses')
                            .then(response => response.json())
                            .then(data => {
                                let divCursos = document.getElementById('divCursos'); // Obtener el contenedor

                                // Iterar sobre los datos de estudiantes
                                data.forEach(item => {
                                    // Crear el contenedor para el checkbox y su label
                                    let checkboxContainer = document.createElement('div');

                                    // Crear el checkbox
                                    let checkbox = document.createElement('input');
                                    checkbox.type = 'checkbox';
                                    checkbox.id = `curso-${item.id}`; // Asignar un ID único
                                    checkbox.value = item.id; // Valor que se enviará cuando esté seleccionado

                                    // Crear el label para el checkbox
                                    let label = document.createElement('label');
                                    label.setAttribute('for', checkbox.id);
                                    label.textContent = `${item.Nombre}`;

                                    // Añadir el checkbox y el label al contenedor
                                    checkboxContainer.appendChild(checkbox);
                                    checkboxContainer.appendChild(label);

                                    // Agregar el contenedor de checkbox al contenedor principal
                                    divCursos.appendChild(checkboxContainer);
                                });
                            })
                            .catch(error => console.error('Error al obtener los datos:', error));
                    });

                    document.addEventListener("DOMContentLoaded", function() {
                        // Manejar el envío del formulario
                        document.getElementById('asignacionForm').addEventListener('submit', function(event) {
                            event.preventDefault(); // Evitar el envío por defecto del formulario

                            let selectedCheckboxes = [];
                            console.log(document.getElementById('estudiantes').value);
                            idEstudiante = document.getElementById('estudiantes').value;
                            let checkboxes = document.querySelectorAll('input[type="checkbox"]');
                            checkboxes.forEach(checkbox => {
                                if (checkbox.checked) {
                                    console.log(`El checkbox con ID ${checkbox.id} está marcado.`);
                                    selectedCheckboxes.push(checkbox.value); 
                                } else {
                                    console.log(`El checkbox con ID ${checkbox.id} no está marcado.`);
                                }
                            });
                            console.log("Checkboxes seleccionados:", selectedCheckboxes);
                            const arrCourses = selectedCheckboxes.map(idCurso => ({
                                idEstudiante,
                                idCurso
                            }));

                            const courses = {
                                courses: arrCourses
                            };

                            try {
                                const response = fetch("http://127.0.0.1:8000/api/studentsCourses", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "Accept": "application/json"
                                    },
                                    body: JSON.stringify(courses)
                                });

                                //const data = response.json();

                                /*if (response.ok) {
                                    console.log("✅ Respuesta del servidor:");
                                } else {
                                    console.error("❌ Error en la API:");
                                }*/
                                let contenedor = document.getElementById('contenedor');
                                let texto = document.createElement('p');
                                texto.textContent = `Cursos asignados`;
                                contenedor.appendChild(texto);
                            } catch (error) {
                                console.error("❌ Error en la solicitud:", error);
                            }
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
