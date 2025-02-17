<?php

namespace App\Http\Controllers\Api;

use App\Services\FoxProServices;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mpdf\Mpdf;

class FoxProController extends Controller
{
    protected FoxProServices $foxProService;

    public function __construct(FoxProServices $foxProService)
    {
        $this->foxProService = $foxProService;
    }

    /**
     * @OA\Get(
     *     path="/select",
     *     summary="Selecciona datos de la base de datos",
     *     tags={"FoxPro"},
     *     @OA\Parameter(
     *         name="query",
     *         in="query",
     *         required=true,
     *         description="Consulta SQL a ejecutar",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Consulta ejecutada con éxito",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="message", type="string", example="Consulta ejecutada correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en la solicitud",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Error en la solicitud")
     *         )
     *     )
     * )
     */
    public function select(Request $request): \Illuminate\Http\JsonResponse
    {
        $query = $request->query('query'); // Captura el parámetro 'query' desde la URL

        // Validación: Si el parámetro no se proporciona, devuelve un error
        if (empty($query)) {
            return response()->json([
                'status' => 'error',
                'message' => 'El parámetro query es obligatorio',
            ], 400);
        }

        // Llama al servicio para ejecutar la consulta
        $result = $this->foxProService->select($query);

        return response()->json($result, $result['status'] === 'success' ? 200 : 400);
    }


    /**
     * @OA\Post(
     *     path="/insert",
     *     summary="Inserta un registro en la base de datos",
     *     tags={"FoxPro"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="table", type="string", description="Nombre de la tabla"),
     *             @OA\Property(property="fields", type="array", @OA\Items(type="string"), description="Campos a insertar"),
     *             @OA\Property(property="values", type="array", @OA\Items(type="string"), description="Valores correspondientes")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Registro insertado correctamente"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en la solicitud"
     *     )
     * )
     */
    public function insert(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $table = $request->input('table');
            $fields = $request->input('fields');
            $values = $request->input('values');

            if (empty($table) || empty($fields) || empty($values)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Los parámetros table, fields y values son obligatorios'
                ], 400);
            }

            $result = $this->foxProService->insert($table, $fields, $values);

            return response()->json($result, $result['status'] === 'success' ? 201 : 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al procesar la solicitud',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Patch(
     *     path="/update",
     *     summary="Actualiza un registro en la base de datos",
     *     tags={"FoxPro"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="table", type="string", description="Nombre de la tabla"),
     *             @OA\Property(property="fields", type="array", @OA\Items(type="string"), description="Campos a actualizar"),
     *             @OA\Property(property="values", type="array", @OA\Items(type="string"), description="Valores correspondientes"),
     *             @OA\Property(property="condition", type="string", description="Condición para la actualización")
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Registro actualizado correctamente"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en la solicitud"
     *     )
     * )
     */
    public function update(Request $request): \Illuminate\Http\JsonResponse
    {
        $table = $request->input('table');
        $fields = $request->input('fields');
        $values = $request->input('values');
        $condition = $request->input('condition');

        $result = $this->foxProService->update($table, $fields, $values, $condition);

        if ($result['status'] === 'success') {
            return response()->json([], 204);
        }

        return response()->json([
            'status' => 'error',
            'message' => $result['message'],
            'error' => $result['error'] ?? null,
        ], 400);
    }

    /**
     * @OA\Delete(
     *     path="/delete",
     *     summary="Elimina un registro en la base de datos",
     *     tags={"FoxPro"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="table", type="string", description="Nombre de la tabla"),
     *             @OA\Property(property="condition", type="string", description="Condición para la eliminación")
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Registro eliminado correctamente"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en la solicitud"
     *     )
     * )
     */
    public function delete(Request $request): \Illuminate\Http\JsonResponse
    {
        $table = $request->input('table');
        $condition = $request->input('condition');

        $result = $this->foxProService->delete($table, $condition);

        if ($result['status'] === 'success') {
            return response()->json([], 204);
        }

        return response()->json($result, 400);
    }

    public function syncAllRecords(Request $request): \Illuminate\Http\JsonResponse
    {
        // Obtén la tabla FoxPro desde los parámetros de la consulta
        $foxTable = $request->query('foxTable');

        // Validar que el parámetro sea proporcionado
        if (!$foxTable) {
            return response()->json([
                'status' => 'error',
                'message' => 'El parámetro "foxTable" es requerido.',
            ], 400);
        }

        $result = $this->foxProService->syncAllFoxProToMySQL($foxTable);

        return response()->json($result);
    }

    public function historiaUrgencias(Request $request)
    {
        // Obtener el parámetro "documento" desde la consulta
        $documento = $request->query('documento');
        $mes = $request->query('mes');
        $año = $request->query('año');

        // Verificar que el parámetro "documento" esté presente
        if (!$documento) {
            return response()->json([
                'status' => 'error',
                'message' => 'El parámetro "documento" es requerido.',
            ], 400);
        }


        return $this->foxProService->historiaUrgencias($documento, $mes, $año); // Esto te permitirá ver la estructura real en Postman

    }

    public function historiaClinica(Request $request)
    {
        try {
            $documento = $request->query('documento');
            $mes = $request->query('mes');
            $año = $request->query('año');

            if (!$documento) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'El parámetro "documento" es requerido.',
                ], 400);
            }

            // Llamar al servicio
            $response = $this->foxProService->historiaClinica($documento, $mes, $año);

            // Si la respuesta es un objeto JsonResponse, convertirlo en array
            if ($response instanceof \Illuminate\Http\JsonResponse) {
                $data = $response->getData(true);
            } else {
                $data = $response; // La respuesta ya es un array válido
            }

            // Verificar si la estructura de datos es correcta
            if (!isset($data['data']) || !isset($data['status'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Estructura de datos inesperada en la respuesta del servicio.',
                    'data' => $data, // Mostrar la estructura que se recibió
                ], 500);
            }

            // Preparar los datos para la vista del PDF
            $pdfData = [
                'data' => $data['data'],
                'diag' => $data['diag'] ?? [], // Si diag no existe, usa un array vacío
                'status' => $data['status']
            ];

            // Cargar la vista HTML con los datos
            $html = view('pdf.historiaClinica', $pdfData)->render();

            // ⚠️ Guardar HTML para depuración
            file_put_contents(storage_path('pdf_debug.html'), $html);

            // Validar si el HTML está vacío
            if (empty(trim($html))) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'El HTML generado para el PDF está vacío.',
                ], 500);
            }

            // Crear una instancia de mPDF
            $mpdf = new \Mpdf\Mpdf([
                'margin_top' => 70, // Espacio por encima del contenido
                'margin_bottom' => 10, // Espacio en la parte inferior
                'margin_left' => 15, // Espacio izquierdo
                'margin_right' => 15 // Espacio derecho
            ]);
            $mpdf->SetHTMLHeader(view('pdf.header', $pdfData)->render());  // Aquí cargamos la vista header.blade.php
            $html = view('pdf.historiaClinica', $pdfData)->render();

            $mpdf->WriteHTML($html);

            // Generar y mostrar el PDF
            return $mpdf->Output('historia_clinica_' . $documento . '.pdf', 'I');
            //return $pdfData;

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al generar el PDF: ' . $e->getMessage(),
            ], 500);
        }
    }

}
