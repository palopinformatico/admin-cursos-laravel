<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador de Cursos</title>
    <!-- Incluir Font Awesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
    <style>
        .item {
            display: inline-flex;
            align-items: center;
            margin-bottom: 10px; /* Espaciado entre los items */
        }

        .item p {
            margin-right: 10px; /* Espaciado entre el texto y el ícono */
        }

        .item i {
            cursor: pointer;
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
                        <li class="nav-item"><a href="/adminCursos/public/actualizarEstudiantes" class="nav-link text-white">Actualizar estudiante</a></li>
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
                <h1>Listado de Cursos</h1>
                <div id="contenedor"></div>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        fetch('http://127.0.0.1:8000/api/courses')
                            .then(response => response.json())
                            .then(data => {
                                let contenedor = document.getElementById('contenedor');
                                data.forEach(item => {
                                    let contenedorItem = document.createElement('div');
                                    contenedorItem.classList.add('item');

                                    // Crear el texto con los datos
                                    let texto = document.createElement('p');
                                    texto.textContent = `${item.id} - ${item.Nombre} - ${item.Horario} - ${item.FechaInicio} - ${item.FechaFin}`;

                                    // Crear el ícono de lápiz
                                    let iconoEditar = document.createElement('i');
                                    iconoEditar.classList.add('fas', 'fa-pencil-alt');
                                    iconoEditar.style.cursor = 'pointer';
                                    //iconoEditar.style.marginLeft = '10px';

                                    // Agregar el evento de clic para editar
                                    iconoEditar.addEventListener('click', function() {
                                        // Crear un formulario
                                        let data = { id: item.id, nombre: item.Nombre, horario: item.Horario, fechaInicio: item.FechaInicio, fechaFin: item.FechaFin };
                                        let form = document.createElement("form");
                                        form.method = "GET";
                                        form.action = "/adminCursos/public/actualizarCursos2";

                                        // Agregar los datos al formulario
                                        for (let key in data) {
                                            if (data.hasOwnProperty(key)) {
                                                let input = document.createElement("input");
                                                input.type = "hidden";
                                                input.name = key;
                                                input.value = data[key];
                                                form.appendChild(input);
                                            }
                                        }

                                        // Agregar el formulario al cuerpo y enviarlo
                                        document.body.appendChild(form);
                                        form.submit();
                                    });

                                    // Agregar los elementos al contenedor
                                    contenedorItem.appendChild(texto);
                                    contenedorItem.appendChild(iconoEditar);
                                    contenedor.appendChild(contenedorItem);
                                    let etiqP = document.createElement('p');;
                                    contenedor.appendChild(etiqP);
                                });

                            })
                            .catch(error => console.error('Error al obtener los datos:', error));
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
