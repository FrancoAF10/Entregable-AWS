<?php
require_once "../config/Database.php";
class Anime{
  private $conexion;
  public function __construct() {
    $this->conexion = Database::getConexion();
  }
  /**
   * Devuelve un conjunto de Animes contenidos en un arreglo
   * @return array
   */
  public function getAll(): array{
    $sql="SELECT * FROM ANIME";
    $stmt = $this->conexion->prepare($sql); //preparación
    $stmt->execute(); //ejecución
    return $stmt->fetchAll(PDO::FETCH_ASSOC); //retorno
  }

  /**
   * Registra un Anime en la base de datos
   * @param mixed $params
   * @return int
   */
  public function add($params = []): int{
   $sql="INSERT INTO ANIME (nombre,genero,episodios,puntuacion,estado) VALUES(?,?,?,?,?)";
   $stmt = $this->conexion->prepare($sql);
   $stmt->execute(
    array(
      $params["nombre"],
      $params["genero"],
      $params["episodios"],
      $params["puntuacion"],
      $params["estado"]
    )
    );
    return $stmt->rowCount();
  }
  public function update($params = []): int{
    $sql = "UPDATE ANIME SET nombre = ?,genero = ?,episodios = ?,puntuacion = ?,estado = ? WHERE id = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([
        $params["nombre"],
        $params["genero"],
        $params["episodios"],
        $params["puntuacion"],
        $params["estado"],
        $params["id"]
    ]);
    return $stmt->rowCount();  
  }
  public function delete($params = []): int{
    $sql= "DELETE FROM ANIME WHERE id=? ";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array(
        $params["id"]
      )

      );
    return $stmt->rowCount();
  }
  public function getById ($id): array{
    //obtenemos los datos mediante el id
    $sql= "SELECT * FROM ANIME WHERE id=?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array($id)
      );  
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  
}