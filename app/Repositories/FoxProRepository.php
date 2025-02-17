<?php

namespace App\Repositories;

use App\Interfaces\FoxProRepositoryInterface;
use App\Services\ConnectionFox;
use Barryvdh\DomPDF\Facade\Pdf;

class FoxProRepository implements FoxProRepositoryInterface
{


    public function select(string $query): array
    {
        $pdo = ConnectionFox::con();

        // Función para convertir y formatear solo textos
        $c = fn($s) => $s !== null && is_string($s) ? trim(mb_convert_encoding($s, "UTF-8", "CP1252")) : $s;

        try {
            // Ejecuta la consulta SQL
            $stmt = $pdo->query("SELECT " . $query);

            // Obtiene los resultados como un array asociativo
            $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // Formatea solo las columnas de texto
            foreach ($data as &$row) {
                foreach ($row as $key => &$value) {
                    // Verificar si el valor es una cadena de texto y formatearlo
                    $value = $c($value);
                }
            }

            // Devuelve una respuesta estructurada
            return [
                'status' => 'success',
                'data' => $data,
                'message' => 'Consulta ejecutada correctamente',
            ];
        } catch (\Exception $e) {
            // En caso de error, maneja la excepción y devuelve una respuesta de error
            return [
                'status' => 'error',
                'error' => $e->getMessage(),
                'message' => 'Hubo un problema al ejecutar la consulta',
            ];
        }
    }

    public function insert(string $table, array $fields, array $values): array
    {
        $pdo = ConnectionFox::con();

        try {
            // Construye la lista de campos
            $columns = implode(', ', $fields);

            $escapedValues = array_map(function ($value) {
                if (is_null($value)) {
                    return 'NULL'; // Manejar valores nulos
                } elseif (is_numeric($value)) {
                    return $value; // Si es un número, no lo envolvemos en comillas
                } elseif ($this->isDate($value)) {
                    // Si el valor es una fecha, usa la función CTOD y no lo pongas entre comillas
                    return "ctod('$value')";
                } else {
                    // Convierte a string, elimina las comillas dobles al inicio y final si existen
                    $value = (string)$value;
                    $value = trim($value, "'"); // Elimina las comillas simples adicionales

                    return "'" . $value . "'"; // Coloca las comillas simples alrededor del valor
                }
            }, $values);

            $valuesString = implode(', ', $escapedValues);

            // Construye la consulta SQL
            $sql = "INSERT INTO $table ($columns) VALUES ($valuesString)";

            // Ejecuta la consulta directamente
            $pdo->query($sql);

            return [
                'status' => 'success',
                'message' => 'Registro insertado correctamente',
                'query' => $sql, // Devuelve la consulta generada para depuración
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Hubo un problema al insertar el registro',
                'error' => $e->getMessage(),
            ];
        }
    }

    public function update(string $table, array $fields, array $values, string $condition): array
    {
        $pdo = ConnectionFox::con();

        try {
            // Verifica que la cantidad de campos y valores coincidan
            if (count($fields) !== count($values)) {
                return [
                    'status' => 'error',
                    'message' => 'La cantidad de campos y valores no coincide.',
                ];
            }

            // Limpia los valores para quitar comillas extra y manejar fechas
            $cleanedValues = array_map(function ($value) {
                if (is_string($value)) {
                    // Eliminar comillas extra alrededor de cadenas como "'4545'" => '4545'
                    $value = trim($value, "'");
                }

                // Verificar si es una fecha usando la función isDate
                if ($this->isDate($value)) {
                    // Para las fechas, quitamos las comillas extras al agregar ctod() directamente
                    $value = "ctod('$value')";
                }

                return $value;
            }, $values);

            // Construye las asignaciones de campos (ejemplo: campo1 = ?, campo2 = ?)
            $setClauses = [];
            foreach ($fields as $index => $field) {
                // Verifica si el valor es una fecha y no la rodea con comillas
                $value = $cleanedValues[$index];
                if (strpos($value, "ctod(") === 0) {
                    $setClauses[] = "$field = $value"; // No comillas alrededor del ctod
                } else {
                    $setClauses[] = "$field = '$value'"; // Comillas alrededor de otros valores
                }
            }
            $setClauseString = implode(', ', $setClauses);

            // Construye la consulta SQL
            $sql = "UPDATE $table SET $setClauseString WHERE $condition";

            // Ejecuta la consulta directamente
            $pdo->query($sql);

            return [
                'status' => 'success',
                'message' => 'Registro actualizado correctamente',
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Hubo un problema al ejecutar la consulta',
                'error' => $e->getMessage(),
            ];
        }
    }

    public function delete(string $table, string $condition = null): array
    {
        $pdo = ConnectionFox::con();

        try {

            // Si no hay condición, devolver un error
            if (empty($table) || empty($condition)) {
                return [
                    'status' => 'error',
                    'message' => 'La tabla y la condición son requeridas.',
                ];
            }

            // Construir la consulta DELETE
            $query = "DELETE FROM $table WHERE $condition";
            $pdo->query($query);


            return [
                'status' => 'success',
                'message' => 'Registro eliminado correctamente',
            ];
        } catch (\Exception $e) {
            // En caso de error, maneja la excepción y devuelve una respuesta de error
            return [
                'status' => 'error',
                'error' => $e->getMessage(),
                'message' => 'Hubo un problema al ejecutar la consulta',
            ];
        }


    }

    public function isDate($value): bool
    {
        // Verifica si el valor tiene el formato de fecha adecuado (por ejemplo, '01.20.2025')
        $datePattern = '/^\d{2}\.\d{2}\.\d{4}$/';
        return preg_match($datePattern, $value);
    }

    public function syncAllFoxProToMySQL(string $foxTable): array
    {
        $pdoFoxPro = ConnectionFox::con(); // Conexión a FoxPro
        $pdoMySQL = \DB::connection('mysql'); // Conexión a MySQL

        try {
            // Preparar el nombre de la tabla MySQL
            $mysqlTable = strtolower($foxTable);

            // Contador de registros sincronizados
            $syncedCount = 0;

            // Crear un cursor en FoxPro para iterar registro por registro
            $query = "SELECT * FROM $foxTable LIMIT 3";
            $stmt = $pdoFoxPro->query($query);
            $stmt->setFetchMode(\PDO::FETCH_ASSOC); // Configurar para obtener registros como un arreglo asociativo

            while ($record = $stmt->fetch()) {
                // Preparar los campos y valores para la consulta MySQL
                $mysqlColumns = array_keys($record);
                $mysqlValues = array_values($record);

                // Mapear los valores para evitar inyecciones y adaptarlos
                $escapedValues = array_map(function ($value) {
                    return is_null($value) ? 'NULL' : (is_numeric($value) ? $value : "'" . addslashes($value) . "'");
                }, $mysqlValues);

                $columnsString = implode(',', $mysqlColumns);
                $valuesString = implode(',', $escapedValues);

                // Construir consulta SQL para MySQL
                $mysqlQuery = "INSERT INTO $mysqlTable ($columnsString) VALUES ($valuesString)";

                // Insertar el registro en MySQL
                try {
                    $pdoMySQL->statement($mysqlQuery);
                    $syncedCount++;
                } catch (\Exception $e) {
                    // Ignorar errores individuales y continuar con el siguiente registro
                    throw $e;
                }
            }

            return [
                'status' => 'success',
                'message' => "Sincronización completa: $syncedCount registros sincronizados de $foxTable a $mysqlTable.",
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al sincronizar los registros.',
                'error' => $e->getMessage(),
            ];
        }
    }


    public function historiaUrgencias(string $documento, string $mes, string $año)
    {
        $pdo = ConnectionFox::con();

        // Función para convertir y formatear solo textos
        $c = fn($s) => $s !== null && is_string($s) ? trim(mb_convert_encoding($s, "UTF-8", "CP1252")) : $s;

        try {
            // Ejecuta la consulta SQL
            $stmt = $pdo->query("
    SELECT sa.memo as anexo, re.dest_sali, re.serv_sali, re.fecha_egr, re.hora_egr, re.est_salida, re.codigo, re.num_id, re.docn, e.nombre as especial, v.nombre as medico, v.regmed, v.num_id as ceddoc, p.docn_sin, p.freg as fechaad, p.hora as horaad, s.apellido1, s.apellido2, s.Nombre, s.nombre2,
    s.tipo_id, s.fech_nacim, s.edad, s.sexo, s.estad_civ, s.direccion, s.ciudad, s.telefono, s.nomb_resp,
     o.nombre as ocupacion, d.depart, re.es_obs, re.es_act, re.freg as fechare, re.hora as horare, re.moti_solic,
     re.reingre, re.est_ingr, re.enfer_act, re.rev_sis, re.sv_ta as ta, re.sv_tem as tem, re.sv_fc as fc,
     re.sv_fr as fr, re.estembr as embri, re.glasglow, re.estcons, re.cabeza, re.cuello, re.torax,
     re.abdomen, re.genitouri, re.pelvis, re.dorsoext, re.neuro, re.plan, re.examenes, re.tratami
    FROM GEMA_MEDICOS\\DATOS\\RE_HURGE re
    LEFT JOIN `Z:\\GEMA10.D\\DGEN\\DATOS\\VENDEDOR` v
        ON re.codigo = v.vendedor
    LEFT JOIN `Z:\\GEMA10.D\\SALUD\\DATOS\\SAHISTOC` s
        ON re.num_id = s.num_histo
    LEFT JOIN Z:\GEMA10.D\IPT\DATOS\PTOTC00 p
        ON re.docn = p.docn
    LEFT JOIN Z:\GEMA10.d\DGEN\DATOS\municip m
        ON s.ciudad  = m.nombre
    LEFT JOIN Z:\GEMA10.d\DGEN\DATOS\departam d
        ON m.depto = d.depart
    LEFT JOIN Z:\GEMA10.d\SALUD\DATOS\ocupacio o
        ON s.ocupacion = o.codigo
    LEFT JOIN Z:\GEMA10.d\SALUD\DATOS\Especial e
        ON v.especial = e.codigo
    LEFT JOIN Z:\GEMA_MEDICOS\DATOS\sahistod2 sa
        ON re.num_id = sa.num_histo AND sa.cod_anexo = 'ANTECEDENTES' AND MONTH(sa.fecha) = $mes
    AND YEAR(sa.fecha) = $año
    WHERE re.num_id = $documento
    AND MONTH(re.freg) = $mes
    AND YEAR(re.freg) = $año
");
            $stmtDiag = $pdo->query("
    SELECT re.diag_ingre, ci1.nombre AS nombre_diag_ingre,
           re.diag_in_r1, ci2.nombre AS nombre_diag_r1,
           re.diag_in_r2, ci3.nombre AS nombre_diag_r2,
           re.diag_in_r3, ci4.nombre AS nombre_diag_r3,
           re.diag_in_r4, ci5.nombre AS nombre_diag_r4
    FROM GEMA_MEDICOS\\DATOS\\RE_HURGE re
    LEFT JOIN Z:\\GEMA10.d\\SALUD\\DATOS\\cie9 ci1 ON re.diag_ingre = ci1.codigo
    LEFT JOIN Z:\\GEMA10.d\\SALUD\\DATOS\\cie9 ci2 ON re.diag_in_r1 = ci2.codigo
    LEFT JOIN Z:\\GEMA10.d\\SALUD\\DATOS\\cie9 ci3 ON re.diag_in_r2 = ci3.codigo
    LEFT JOIN Z:\\GEMA10.d\\SALUD\\DATOS\\cie9 ci4 ON re.diag_in_r3 = ci4.codigo
    LEFT JOIN Z:\\GEMA10.d\\SALUD\\DATOS\\cie9 ci5 ON re.diag_in_r4 = ci5.codigo
    WHERE re.num_id = $documento
    AND MONTH(re.freg) = $mes
    AND YEAR(re.freg) = $año
");
            $stmtDiagSali = $pdo->query("
    SELECT
        re.diag_salid, ci6.nombre AS nombre_diag_salid,
        re.diag_sali1, ci7.nombre AS nombre_diag_s1,
        re.diag_sali2, ci8.nombre AS nombre_diag_s2,
        re.diag_sali3, ci9.nombre AS nombre_diag_s3,
        re.diag_sali4, ci10.nombre AS nombre_diag_s4
    FROM GEMA_MEDICOS/DATOS/RE_HURGE re
    LEFT JOIN Z:/GEMA10.d/SALUD/DATOS/cie9 ci6 ON re.diag_salid = ci6.codigo
    LEFT JOIN Z:/GEMA10.d/SALUD/DATOS/cie9 ci7 ON re.diag_sali1 = ci7.codigo
    LEFT JOIN Z:/GEMA10.d/SALUD/DATOS/cie9 ci8 ON re.diag_sali2 = ci8.codigo
    LEFT JOIN Z:/GEMA10.d/SALUD/DATOS/cie9 ci9 ON re.diag_sali3 = ci9.codigo
    LEFT JOIN Z:/GEMA10.d/SALUD/DATOS/cie9 ci10 ON re.diag_sali4 = ci10.codigo
    WHERE re.num_id = $documento
    AND MONTH(re.freg) = $mes
    AND YEAR(re.freg) = $año
");

            $stmtE = $pdo->query("
                SELECT ree.plan, ree.evolucion
                FROM GEMA_MEDICOS\\DATOS\\RE_HURGE re
                LEFT JOIN GEMA_MEDICOS\\DATOS\\RE_HURGEE ree
                ON re.docn = ree.docn
                WHERE re.num_id = $documento AND MONTH(re.freg) = $mes AND YEAR(re.freg) = $año");

            // Obtiene los resultados como un array asociativo
            $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $dataE = $stmtE->fetchAll(\PDO::FETCH_ASSOC);
            $diag = $stmtDiag->fetchAll(\PDO::FETCH_ASSOC);
            $diagSali = $stmtDiagSali->fetchAll(\PDO::FETCH_ASSOC);

            // Formatea solo las columnas de texto
            foreach ($data as &$row) {
                foreach ($row as $key => &$value) {
                    // Verificar si el valor es una cadena de texto y formatearlo
                    $value = $c($value);
                }
            }
            foreach ($dataE as &$row) {
                foreach ($row as $key => &$value) {
                    // Verificar si el valor es una cadena de texto y formatearlo
                    $value = $c($value);
                }
            }
            foreach ($diag as &$row) {
                foreach ($row as $key => &$value) {
                    // Verificar si el valor es una cadena de texto y formatearlo
                    $value = $c($value);
                }
            }
            foreach ($diagSali as &$row) {
                foreach ($row as $key => &$value) {
                    // Verificar si el valor es una cadena de texto y formatearlo
                    $value = $c($value);
                }
            }

            $imagePath = 'Z:/GEMA_MEDICOS/GRAFICAS/firma' . strtolower($data[0]['codigo']) . '.bmp';
            $imageData = file_get_contents($imagePath);
            $base64Image = base64_encode($imageData);
            $imageBase64 = 'data:image/jpeg;base64,' . $base64Image;


            $pdf = PDF::loadView('pdf.historia', [
                'data' => $data,
                'evol' => $dataE,
                'diag' => $diag,
                'diagS' => $diagSali,
                'imageBase64' => $imageBase64,
            ])->setPaper('legal', 'portrait');

            return $pdf->download('historia_urgencias.pdf');

            //return $data;
        } catch (\Exception $e) {
            // En caso de error, maneja la excepción y devuelve una respuesta de error
            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage(),
                'message' => 'Hubo un problema al ejecutar la consulta',
            ], 500);
        }
    }
    public function historiaClinica(string $documento, string $mes, string $año)
    {
        $pdo = ConnectionFox::con();
        $rehospit = "Z:\GEMA_MEDICOS\DATOS\RE_Hospit";
        $ptotc00 = "Z:\GEMA10.D\IPT\DATOS\PTOTC00";
        $sahisto = "Z:\\GEMA10.D\\SALUD\\DATOS\\SAHISTOC";
        $vendedor = "Z:\\GEMA10.D\\DGEN\\DATOS\\VENDEDOR";
        $especial = "Z:\GEMA10.d\SALUD\DATOS\Especial";
        $depar = "Z:\GEMA10.d\DGEN\DATOS\departam";
        $muni = "Z:\GEMA10.d\DGEN\DATOS\municip";

        // Función para convertir y formatear solo textos
        $c = fn($s) => $s !== null && is_string($s) ? trim(mb_convert_encoding($s, "UTF-8", "CP1252")) : $s;

        try {
             //Ejecuta la consulta SQL
            $stmt = $pdo->query("
            SELECT d.depart, v.nombre as medico,v.num_id as ceddoc,v.regmed, e.nombre as especial, p.docn_sin, rt.docn, rt.num_id, s.nombre, s.nombre2, s.apellido1, s.apellido2, s.tipo_id, s.fech_nacim, s.edad, s.sexo, s.estad_civ, s.direccion, s.ciudad, s.telefono, s.nomb_resp, s.ocupacion,
                   rt.freg, rt.hora, rt.moti_solic, rt.reingre, rt.est_ingr, rt.enfer_act, rt.sv_ta as ta, rt.sv_fr as fr, rt.sv_tem as tem, rt.estembr as embri,
                   rt.estcons, rt.glasglow, rt.cabeza, rt.cuello, rt.torax, rt.abdomen, rt.genitouri, rt.pelvis, rt.dorsoext, rt.neuro, rt.codigo, rt.evolucion, rt.examenes
            FROM $rehospit rt
            LEFT JOIN $sahisto s
            ON $documento = s.num_histo
            LEFT JOIN $ptotc00 p
            ON rt.docn = p.docn
            LEFT JOIN $vendedor v
            ON rt.codigo = v.vendedor
            LEFT JOIN $especial e
            ON v.especial = e.codigo
            LEFT JOIN $muni m
            ON s.ciudad = m.nombre
            LEFT JOIN $depar d
            ON m.depto = d.depart
            WHERE rt.num_id = $documento
            AND MONTH(rt.freg) = $mes
            AND YEAR(rt.freg) = $año
            ORDER BY rt.freg DESC
");
            $stmtDiag = $pdo->query("
    SELECT re.diag_ingre, ci1.nombre AS nombre_diag_ingre,
           re.diag_in_r1, ci2.nombre AS nombre_diag_r1,
           re.diag_in_r2, ci3.nombre AS nombre_diag_r2,
           re.diag_in_r3, ci4.nombre AS nombre_diag_r3,
           re.diag_in_r4, ci5.nombre AS nombre_diag_r4
    FROM $rehospit re
    LEFT JOIN Z:\\GEMA10.d\\SALUD\\DATOS\\cie9 ci1 ON re.diag_ingre = ci1.codigo
    LEFT JOIN Z:\\GEMA10.d\\SALUD\\DATOS\\cie9 ci2 ON re.diag_in_r1 = ci2.codigo
    LEFT JOIN Z:\\GEMA10.d\\SALUD\\DATOS\\cie9 ci3 ON re.diag_in_r2 = ci3.codigo
    LEFT JOIN Z:\\GEMA10.d\\SALUD\\DATOS\\cie9 ci4 ON re.diag_in_r3 = ci4.codigo
    LEFT JOIN Z:\\GEMA10.d\\SALUD\\DATOS\\cie9 ci5 ON re.diag_in_r4 = ci5.codigo
    WHERE re.num_id = $documento
    AND MONTH(re.freg) = $mes
    AND YEAR(re.freg) = $año
");
//            $stmtDiagSali = $pdo->query("
//    SELECT
//        re.diag_salid, ci6.nombre AS nombre_diag_salid,
//        re.diag_sali1, ci7.nombre AS nombre_diag_s1,
//        re.diag_sali2, ci8.nombre AS nombre_diag_s2,
//        re.diag_sali3, ci9.nombre AS nombre_diag_s3,
//        re.diag_sali4, ci10.nombre AS nombre_diag_s4
//    FROM GEMA_MEDICOS/DATOS/RE_HURGE re
//    LEFT JOIN Z:/GEMA10.d/SALUD/DATOS/cie9 ci6 ON re.diag_salid = ci6.codigo
//    LEFT JOIN Z:/GEMA10.d/SALUD/DATOS/cie9 ci7 ON re.diag_sali1 = ci7.codigo
//    LEFT JOIN Z:/GEMA10.d/SALUD/DATOS/cie9 ci8 ON re.diag_sali2 = ci8.codigo
//    LEFT JOIN Z:/GEMA10.d/SALUD/DATOS/cie9 ci9 ON re.diag_sali3 = ci9.codigo
//    LEFT JOIN Z:/GEMA10.d/SALUD/DATOS/cie9 ci10 ON re.diag_sali4 = ci10.codigo
//    WHERE re.num_id = $documento
//    AND MONTH(re.freg) = $mes
//    AND YEAR(re.freg) = $año
//");
//
//            $stmtE = $pdo->query("
//                SELECT ree.plan, ree.evolucion
//                FROM GEMA_MEDICOS\\DATOS\\RE_HURGE re
//                LEFT JOIN GEMA_MEDICOS\\DATOS\\RE_HURGEE ree
//                ON re.docn = ree.docn
//                WHERE re.num_id = $documento AND MONTH(re.freg) = $mes AND YEAR(re.freg) = $año");
//
//            // Obtiene los resultados como un array asociativo
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
//            $dataE = $stmtE->fetchAll(\PDO::FETCH_ASSOC);
            $diag = $stmtDiag->fetchAll(\PDO::FETCH_ASSOC);
//            $diagSali = $stmtDiagSali->fetchAll(\PDO::FETCH_ASSOC);

            // Formatea solo las columnas de texto
                foreach ($data as $key => &$value) {
                    // Verificar si el valor es una cadena de texto y formatearlo
                    $value = $c($value);
                }

//            foreach ($dataE as &$row) {
//                foreach ($row as $key => &$value) {
//                    // Verificar si el valor es una cadena de texto y formatearlo
//                    $value = $c($value);
//                }
//            }
            foreach ($diag as &$row) {
                foreach ($row as $key => &$value) {
                    // Verificar si el valor es una cadena de texto y formatearlo
                    $value = $c($value);
                }
            }
//            foreach ($diagSali as &$row) {
//                foreach ($row as $key => &$value) {
//                    // Verificar si el valor es una cadena de texto y formatearlo
//                    $value = $c($value);
//                }
//            }

            $imagePath = 'Z:/GEMA_MEDICOS/GRAFICAS/firma' . strtolower($data[0]['codigo']) . '.bmp';
            $imageData = file_get_contents($imagePath);
            $base64Image = base64_encode($imageData);
            $imageBase64 = 'data:image/jpeg;base64,' . $base64Image;

            return [
                'data' => $data,
                'diag' => $diag,
                'imageBase64' => $imageBase64,
                'status' => true
            ];
        } catch (\Exception $e) {
            // En caso de error, maneja la excepción y devuelve una respuesta de error
            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage(),
                'message' => 'Hubo un problema al ejecutar la consulta',
            ], 500);
        }
    }

}
