<?php

declare(strict_types=1);

namespace App\Services;

use PDO;

/**
 * Esta clase representa la conexión con las tablas de FoxPro mediante PDO.
 */
class ConnectionFox
{
    private static ?PDO $conexion = null;

    public static function con(): PDO
    {
        if (self::$conexion === null) {
            try {
                self::$conexion = self::connect();
            } catch (\Exception) {
                die("No se pudo conectar a la base de datos de Visual FoxPro...");
            }
        }

        return self::$conexion;
    }

    private static function connect(): PDO
    {
        $dsn = "odbc:Driver={Microsoft Visual FoxPro Driver};" .
            "SourceType=DBF;SourceDB=Z:\\;Exclusive=No;" .
            "Collate=Machine;NULL=NO;DELETED=YES;BACKGROUNDFETCH=NO";

        return new PDO(
            $dsn,
            "",
            "",
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
    }
}
