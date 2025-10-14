<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrar Anime</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      background-color: #f8f9fa;
    }

    .card {
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .btn {
      transition: all 0.3s ease;
    }

    .btn:hover {
      transform: scale(1.05);
    }
  </style>
</head>

<body>

  <?php include_once(__DIR__ . '/../../layouts/navbar.php'); ?>

  <div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="text-primary">Registrar Nuevo Anime</h2>
      <button type="button" onclick="window.location.href='./listar.php'" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Volver
      </button>
    </div>

    <form autocomplete="off" id="formulario-anime">
      <div class="card">
        <div class="card-header bg-primary text-white">
          <strong>Formulario de Registro</strong>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <div class="form-floating">
                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre" required>
                <label for="nombre">Nombre</label>
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <div class="form-floating">
                <input type="text" id="genero" name="genero" class="form-control" placeholder="Género" required>
                <label for="genero">Género</label>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4 mb-3">
              <div class="form-floating">
                <input type="number" id="episodios" name="episodios" class="form-control" placeholder="Episodios" required>
                <label for="episodios">Episodios</label>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="form-floating">
                <input type="number" id="puntuacion" name="puntuacion" class="form-control" placeholder="Puntuación" required>
                <label for="puntuacion">Puntuación</label>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="form-floating">
                <select id="estado" name="estado" class="form-select" required>
                  <option value="Emisión">En Emisión</option>
                  <option value="Finalizado">Finalizado</option>
                  <option value="Próximo">Próximo</option>
                </select>
                <label for="estado">Estado</label>
              </div>
            </div>
          </div>
        </div>

        <div class="card-footer text-end">
          <button type="submit" class="btn btn-primary" id="btnGuardar">
            <i class="fa-solid fa-check me-1"></i> Guardar Anime
          </button>
        </div>
      </div>
    </form>
  </div>

  <script>
    const formulario = document.querySelector("#formulario-anime");

    function registrarAnime() {
      const data = {
        nombre: document.querySelector("#nombre").value,
        genero: document.querySelector("#genero").value,
        episodios: document.querySelector("#episodios").value,
        puntuacion: document.querySelector("#puntuacion").value,
        estado: document.querySelector("#estado").value
      };

      fetch("../../controller/AnimeController.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
      })
        .then(response => response.json())
        .then(result => {
          if (result.filas > 0) {
            formulario.reset();
            Swal.fire({
              icon: "success",
              title: "Anime registrado",
              text: "El nuevo anime se registró correctamente.",
              footer: "CRUD ANIME - SENATI",
              confirmButtonColor: "#198754"
            }).then(() => {
              window.location.href = "./listar.php";
            });
          } else {
            Swal.fire({
              icon: "warning",
              title: "Sin cambios",
              text: "No se pudo registrar el anime.",
              confirmButtonColor: "#ffc107"
            });
          }
        })
        .catch(error => {
          console.error(error);
          Swal.fire({
            icon: "error",
            title: "Error del servidor",
            text: "No se pudo registrar el anime.",
            confirmButtonColor: "#dc3545"
          });
        });
    }

    formulario.addEventListener("submit", function (event) {
      event.preventDefault();

      Swal.fire({
        title: "¿Registrar Anime?",
        text: "Confirma si deseas registrar este anime.",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#0d6efd",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Registrar",
        cancelButtonText: "Cancelar"
      }).then((result) => {
        if (result.isConfirmed) {
          registrarAnime();
        }
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"crossorigin="anonymous"></script>
</body>

</html>
