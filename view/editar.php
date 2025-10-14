<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Actualizar Anime</title>

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
      transition: all 0.3s ease-in-out;
    }

    .btn:hover {
      transform: scale(1.05);
    }
  </style>
</head>

<body>

  <div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="text-primary">Actualizar Anime</h2>
      <button onclick="window.location.href='./listar.php'" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Volver
      </button>
    </div>

    <form id="formulario-actualizar" autocomplete="off">
      <div class="card">
        <div class="card-header bg-info text-white">
          <strong>Formulario de Actualización</strong>
        </div>
        <div class="card-body">

          <div class="row mb-3">
            <div class="col-md-6 form-floating">
              <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre" required />
              <label for="nombre">Nombre</label>
            </div>
            <div class="col-md-6 form-floating">
              <input type="text" id="genero" name="genero" class="form-control" placeholder="Género" required />
              <label for="genero">Género</label>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4 form-floating">
              <input type="number" id="episodios" name="episodios" class="form-control" placeholder="Episodios" required />
              <label for="episodios">Episodios</label>
            </div>
            <div class="col-md-4 form-floating">
              <input type="number" id="puntuacion" name="puntuacion" class="form-control" placeholder="Puntuación"
                required />
              <label for="puntuacion">Puntuación</label>
            </div>
            <div class="col-md-4 form-floating">
              <select id="estado" name="estado" class="form-select" required>
                <option value="Emisión">Emisión</option>
                <option value="Finalizado">Finalizado</option>
                <option value="Próximo">Próximo</option>
              </select>
              <label for="estado">Estado</label>
            </div>
          </div>
        </div>

        <div class="card-footer text-end">
          <button class="btn btn-primary" type="submit">
            <i class="fa-solid fa-floppy-disk me-1"></i> Guardar Cambios
          </button>
        </div>
      </div>
    </form>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const urlParams = new URLSearchParams(window.location.search);
      const idAnime = urlParams.get("id");

      // Cargar datos actuales del anime
      fetch(`/controller/AnimeController.php?task=getById&id=${idAnime}`)
        .then(res => res.json())
        .then(data => {
          if (data.length > 0) {
            const anime = data[0];
            document.getElementById("nombre").value = anime.nombre;
            document.getElementById("genero").value = anime.genero;
            document.getElementById("episodios").value = anime.episodios;
            document.getElementById("puntuacion").value = anime.puntuacion;
            document.getElementById("estado").value = anime.estado;
          }
        })
        .catch(err => {
          console.error("Error al obtener datos del anime:", err);
          Swal.fire("Error", "No se pudo cargar la información del anime.", "error");
        });

      // Evento para actualizar el anime
      document.getElementById("formulario-actualizar").addEventListener("submit", function (e) {
        e.preventDefault();

        const nombre = document.getElementById("nombre").value.trim();
        const genero = document.getElementById("genero").value.trim();
        const episodios = document.getElementById("episodios").value;
        const puntuacion = document.getElementById("puntuacion").value;
        const estado = document.getElementById("estado").value;

        if (!nombre || !genero) {
          Swal.fire("Campos vacíos", "Por favor complete todos los campos.", "warning");
          return;
        }

        Swal.fire({
          title: '¿Actualizar anime?',
          text: "Esta acción modificará la información del registro.",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#0d6efd',
          cancelButtonColor: '#6c757d',
          confirmButtonText: 'Sí, actualizar',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            fetch('/controller/AnimeController.php', {
              method: 'PUT',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({
                id: idAnime,
                nombre,
                genero,
                episodios,
                puntuacion,
                estado
              })
            })
              .then(res => res.json())
              .then(data => {
                if (data.filas > 0) {
                  Swal.fire({
                    title: 'Actualizado',
                    text: 'Anime actualizado correctamente.',
                    icon: 'success',
                    confirmButtonColor: '#198754'
                  }).then(() => {
                    window.location.href = "./listar.php";
                  });
                } else {
                  Swal.fire("Sin cambios", "No se actualizó el registro.", "info");
                }
              })
              .catch(err => {
                console.error("Error al actualizar:", err);
                Swal.fire("Error", "No se pudo actualizar el anime.", "error");
              });
          }
        });
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"crossorigin="anonymous"></script>
</body>

</html>
