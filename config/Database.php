<?php

class Database
{
    private static $host = "crudanime.database.windows.net";
    private static $dbname = "ANIME_DB";
    private static $username = "Usuario"; // tu usuario exacto de Azure SQL
    private static $password = "Franco102211";
    private static $conexion = null;

    public static function getConexion()
    {
        if (self::$conexion === null) {
            try {
                // 👇 SQL Server usa este DSN, NO mysql:
                $dsn = "sqlsrv:Server=" . self::$host . ";Database=" . self::$dbname;

                self::$conexion = new PDO($dsn, self::$username, self::$password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (PDOException $e) {
                die("❌ Error al conectar a Azure SQL: " . $e->getMessage());
            }
        }

        return self::$conexion;
    }

    public static function closeConexion()
    {
        self::$conexion = null;
    }
}
