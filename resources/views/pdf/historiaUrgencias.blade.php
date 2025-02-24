@php
    use Carbon\Carbon;
@endphp
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historia Clínica de Urgencias</title>
    <style>
        .logo img {
            width: 80px;
            height: 80px;
        }


        .content {
        }

        /* Asegura que el contenido no se mezcle con el header cuando hay un salto de página */
        .content + .content {
            page-break-before: always;
        }

        th {
            text-align: center;
        }
    </style>
</head>
<body>

<!-- Contenido con margen para evitar superposición -->
<div class="content">
    <!-- Segunda seccion historia clinica -->
    <h3 style="margin-bottom: 1px;"><strong>Fecha: </strong>{!! $data['fechare'] ?? '' !!}</h3>
    <table width="100%" style="margin-bottom: 1px;">
        <tr>
            <td style="width: 120px;">
                <p style="font-size: 13px; margin-bottom: 1px;">Registro: {!! $data['hora'] ?? '' !!}</p>
            </td>
            <td>
                <p style="font-size: 12px; margin-bottom: 1px;">
                    (DR(A). {!! $data['codigo'] ?? '' !!}
                    - {!! $data['medico'] ?? '' !!}
                    -C.C. {!! $data['ceddoc'] ?? '' !!}-REG.MÉDICO: {!! $data['regmed'] ?? '' !!}
                    -{!! $data['especial'] !!}
                </p>
            </td>
        </tr>
    </table>

    <!-- Seccion consultas o primeros examenes -->
    <div>
        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
            <strong>Motivo Consulta</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{!! $data['moti_solic'] ?? '' !!}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
            <strong>Reingreso</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{!! ($data['reingre'] ?? '') === 'S' ? 'SI' : 'NO' !!}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
            <strong>Estado al ingreso</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{!! $data['est_ingr'] ?? '' !!}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
            <strong>Enfermedad actual</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{!! $data['enfer_act'] ?? '' !!}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
            <strong>Revisión por sistema</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{!! $data['rev_sis'] ?? '' !!}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
            <strong>Antecedentes</strong>
        </p>
        <p style="font-size: 13px;">{!! $data['anexo'] ?? '' !!}</p>
    </div>

    <!-- Seccion examen fisico -->
    <h3 style="
           text-align: center;
           border: 1px solid black;
           border-radius: 5px;
           padding: 5px 90px;
           display: table;
           margin: auto auto 1px;">
        <strong>EXAMEN FISICO-DIAGNOSTICOS DE INGRESO</strong>
    </h3>
    <table width="100%">
        <tr>
            <td style="font-size: 13px;"><strong>Signos Vitales </strong></td>
            <td style="font-size: 13px;"><strong>FC: {!! $data['ta'] ?? '' !!}</strong></td>
            <td style="font-size: 13px;"><strong>FR: {!! $data['fr'] ?? '' !!}</strong></td>
            <td style="font-size: 13px;"><strong>Tmp: {!! $data['tem'] ?? '' !!}</strong></td>
            <td style="font-size: 13px;"><strong>Estado
                    Embriaguez:</strong> {!! ($data['embri'] ?? '') === 'S' ? 'SI' : 'NO' !!}</td>
        </tr>
        <tr>
            <td style="font-size: 13px; margin-bottom: 1px; vertical-align: middle;"><strong>Estado Conciencia</strong>
            </td>

            @php
                $estadoConciencia = $data['estcons'] ?? '';
            @endphp

            <td style="font-size: 13px; vertical-align: middle;">
                <table style="border-collapse: collapse;">
                    <tr>
                        <td style="padding-right: 6px;"><strong>Alerta:</strong></td>
                        <td style="width: 20px; height: 20px; border: 1px solid black; border-radius: 5px; text-align: center; vertical-align: middle;
                display: inline-block; line-height: 20px;">
                            {!! $estadoConciencia == 1 ? 'X' : '' !!}
                        </td>
                    </tr>
                </table>
            </td>

            <td style="font-size: 13px; vertical-align: middle;">
                <table style="border-collapse: collapse;">
                    <tr>
                        <td style="padding-right: 6px;"><strong>Obnibulado:</strong></td>
                        <td style="width: 20px; height: 20px; border: 1px solid black; border-radius: 5px; text-align: center; vertical-align: middle;
                display: inline-block; line-height: 20px;">
                            {!! $estadoConciencia == 2 ? 'X' : '' !!}
                        </td>
                    </tr>
                </table>
            </td>

            <td style="font-size: 13px; vertical-align: middle;">
                <table style="border-collapse: collapse;">
                    <tr>
                        <td style="padding-right: 6px;"><strong>Estuporoso:</strong></td>
                        <td style="width: 20px; height: 20px; border: 1px solid black; border-radius: 5px; text-align: center; vertical-align: middle;
                display: inline-block; line-height: 20px;">
                            {!! $estadoConciencia == 3 ? 'X' : '' !!}
                        </td>
                    </tr>
                </table>
            </td>

            <td style="font-size: 13px; vertical-align: middle; white-space: nowrap;">
                <table style="border-collapse: collapse;">
                    <tr>
                        <td style="padding-right: 6px;"><strong>Coma:</strong></td>
                        <td style="width: 20px; height: 20px; border: 1px solid black; border-radius: 5px; text-align: center; vertical-align: middle;
                display: inline-block; line-height: 20px;">
                            {!! $estadoConciencia == 4 ? 'X' : '' !!}
                        </td>
                        <td style="padding-left: 8px;"><strong>Glasgow: ( {!! $data['glasglow'] ?? '' !!} )</strong>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <div>
        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
            <strong>Cabeza y órganos de los sentidos</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{!! $data['cabeza'] ?? '' !!}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
            <strong>Cuello</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{!! $data['cuello'] ?? '' !!}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
            <strong>Tórax</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{!! $data['torax'] ?? '' !!}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
            <strong>Abdomen</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{!! $data['abdomen'] ?? '' !!}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
            <strong>Genitourinario</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{!! $data['genitouri'] ?? '' !!}</p>
    </div>
</div>
<div class="content">
    <div>
        @if (!empty($data['pelvis']))
            <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
                <strong>Pelvis</strong>
            </p>
            <p style="font-size: 13px; margin-bottom: 1px;">{!! $data['pelvis'] !!}</p>
        @endif

        @if (!empty($data['dorsoext']))
            <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
                <strong>Dorsoext</strong>
            </p>
            <p style="font-size: 13px; margin-bottom: 1px;">{!! $data['dorsoext'] !!}</p>
        @endif

        @if (!empty($data['neuro']))
            <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
                <strong>Neurológico</strong>
            </p>
            <p style="font-size: 13px; margin-bottom: 1px;">{!! $data['neuro'] !!}</p>
        @endif

        @if (!empty($data['piel']))
            <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
                <strong>Piel</strong>
            </p>
            <p style="font-size: 13px; margin-bottom: 1px;">{!! $data['piel'] !!}</p>
        @endif

        @if (!empty($data['faneras']))
            <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
                <strong>Faneras</strong>
            </p>
            <p style="font-size: 13px; margin-bottom: 1px;">{!! $data['faneras'] !!}</p>
        @endif
    </div>
    <div
        style="text-align: center; width: 100%; position: absolute; top: 32%; left: 50%; transform: translate(-50%, -50%);">

        <!-- Diagnosticos de ingreso -->
        <h3 style="
        display: inline-block;
        text-decoration: underline;
        ">
            <strong>DIAGNOSTICOS INGRESO</strong>
        </h3>
    </div>
    <!-- Diagnosticos ingreso-->
    <table width="100%" style="margin-bottom: 10px; border-collapse: collapse;">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <p style="text-decoration: underline; font-size: 13px; margin-bottom: 1px; font-weight: bold; display: inline-block;">
                    Diagnóstico de ingreso
                </p>
                <p style="font-size: 13px; margin-bottom: 1px;">
                    {!! $diag[0]['diag_ingre'] ?? '' !!} - {!! $diag[0]['nombre_diag_ingre'] ?? '' !!}
                </p>
            </td>

            <td style="width: 50%; vertical-align: top;">
                @foreach ([1, 2, 3, 4] as $i)
                    @if (!empty($diag[0]["nombre_diag_r$i"]))
                        <p style="border-bottom:1px solid black; font-size: 12px; margin-bottom: 1px; font-weight: bold; display: inline-block;">
                            Diagnóstico relacionado {{ $i }}
                        </p>
                        <p style="font-size: 12px; margin-bottom: 1px;">
                            {!! $diag[0]["diag_in_r$i"] ?? '' !!} - {!! $diag[0]["nombre_diag_r$i"] ?? '' !!}
                        </p>
                    @endif
                @endforeach
            </td>
        </tr>
    </table>

    <!-- Analisis plan examenes -->
    <h3 style="
           text-align: center;
           border: 1px solid black;
           border-radius: 5px;
           padding: 5px 90px;
           display: table;
           margin: auto auto 1px;">
        <strong>ANALISIS-PLAN-EXAMENES-PROCEDIMIENTOS-TRATAMIENTOS</strong>
    </h3>
    <div>
        @foreach ([
            'evolucion' => 'Evolución',
            'plan' => 'Plan/Conducta',
            'examenes' => 'Exámenes/Estudios Solicitados',
            'res_exam' => 'Resultado de Exámenes/Estudios',
            'tratami' => 'Prescripciones/Tratamientos'
        ] as $key => $title)
            @if (!empty($data[$key]))
                <p style="font-size: 13px; margin-bottom: 3px; text-decoration: underline;">
                    <strong>{!! $title !!}</strong>
                </p>
                <p style="font-size: 13px; margin-bottom: 8px;">{!! $data[$key] !!}</p>
            @endif
        @endforeach
    </div>

    <!-- Diagnosticos confirmados -->
    <div>
        @php
            $tieneDiagnosticos = !empty($diagS) && (
                !empty($diagS[0]['diag_salid']) ||
                !empty($diagS[0]['nombre_diag_salid']) ||
                !empty($diagS[0]['diag_sali1']) ||
                !empty($diagS[0]['nombre_diag_s1']) ||
                !empty($diagS[0]['diag_sali2']) ||
                !empty($diagS[0]['nombre_diag_s2']) ||
                !empty($diagS[0]['diag_sali3']) ||
                !empty($diagS[0]['nombre_diag_s3']) ||
                !empty($diagS[0]['diag_sali4']) ||
                !empty($diagS[0]['nombre_diag_s4'])
            );
        @endphp

        @if($tieneDiagnosticos)
            <!-- Diagnósticos de ingreso -->
            <h3 style="
        display: inline-block;
        text-decoration: underline;
        text-align: center;

        ">
                <strong>DIAGNÓSTICOS CONFIRMADOS</strong>
            </h3>

            <table width="100%" style="margin-bottom: 10px; border-collapse: collapse;">
                <tr>
                    <td style="width: 50%; vertical-align: top;">
                        <p style="border-bottom:1px solid black; font-size: 13px; margin-bottom: 1px; font-weight: bold; display: inline-block;">
                            Diagnóstico principal
                        </p>
                        <p style="font-size: 13px; margin-bottom: 1px;">
                            {!! $diagS[0]['diag_salid'] ?? '' !!} - {!! $diagS[0]['nombre_diag_salid'] ?? '' !!}
                        </p>
                    </td>
                    <td style="width: 50%; vertical-align: top;">
                        @foreach ([
                            'diag_sali1' => 'nombre_diag_s1',
                            'diag_sali2' => 'nombre_diag_s2',
                            'diag_sali3' => 'nombre_diag_s3',
                            'diag_sali4' => 'nombre_diag_s4'
                        ] as $diagKey => $nameKey)
                            @if (!empty($diagS[0][$nameKey]))
                                <p style="border-bottom:1px solid black; font-size: 12px; margin-bottom: 1px; font-weight: bold; display: inline-block;">
                                    Diagnóstico relacionado {{ substr($diagKey, -1) }}
                                </p>
                                <p style="font-size: 12px; margin-bottom: 1px;">
                                    {!! $diagS[0][$diagKey] ?? '' !!} - {!! $diagS[0][$nameKey] ?? '' !!}
                                </p>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
        @endif
    </div>

    <!-- Evoluciones -->
    <div>
        @php
            $evolucionesValidas = collect($dataE)->filter(fn($evolucion) =>
                !empty($evolucion['evolucion']) ||
                !empty($evolucion['plan']) ||
                !empty($evolucion['examenes']) ||
                !empty($evolucion['res_exam']) ||
                !empty($evolucion['tratami'])
            );
        @endphp

        @if($evolucionesValidas->isNotEmpty())
            @foreach($evolucionesValidas as $evolucion)
                <table width="100%" style="margin-bottom: 1px;">
                    <tr>
                        <td style="width: 120px;">
                            <p style="font-size: 13px; margin-bottom: 1px;">Registro: {!! $evolucion['hora'] ?? '' !!}</p>
                        </td>
                        <td>
                            <p style="font-size: 12px; margin-bottom: 1px;">
                                (DR(A). {!! $evolucion['codigo'] ?? '' !!} - {!! $evolucion['medico'] ?? '' !!} - C.C.
                                {!! $evolucion['ceddoc'] ?? '' !!} - REG.MEDICO: {!! $evolucion['regmed'] ?? '' !!} -
                                {!! $evolucion['especial'] ?? '' !!})
                            </p>
                        </td>
                    </tr>
                </table>

                <h3 style="
                text-align: center;
                border: 1px solid black;
                border-radius: 5px;
                padding: 5px 90px;
                display: table;
                margin: auto auto 1px;
                margin-top: 10px;">
                    <strong>ANÁLISIS - PLAN - EXÁMENES - PROCEDIMIENTOS - TRATAMIENTOS</strong>
                </h3>

                <div style="padding: 10px; margin-bottom: 10px; border-radius: 5px;">
                    @foreach ([
                        'evolucion' => 'Evolución',
                        'plan' => 'Plan/Conducta',
                        'examenes' => 'Exámenes/Estudios Solicitados',
                        'res_exam' => 'Resultado de Exámenes/Estudios',
                        'tratami' => 'Prescripciones/Tratamientos'
                    ] as $key => $title)
                        @if (!empty($evolucion[$key]))
                            <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
                                <strong>{!! $title !!}</strong>
                            </p>
                            <p style="font-size: 13px; margin-bottom: 1px;">{!! $evolucion[$key] !!}</p>
                        @endif
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>


    <h3 style="
                   text-align: center;
                   border: 1px solid black;
                   border-radius: 5px;
                   padding: 5px 90px;
                   display: table;
                   margin: 10px auto 1px;">
        <strong>SALIDA DEL PACIENTE</strong>
    </h3>
    <table width="100%" style="border-collapse: collapse;">
        <tr>
            <td style="width: 50%; text-align: left; font-size: 12px; vertical-align: middle;">
                <strong>Destino salida: </strong>
                @php
                    $destinos = [
                        0 => '',
                        1 => 'ALTA DE URGENCIAS',
                        2 => 'REMISIÓN OTRO NIVEL',
                        3 => 'HOSPITALIZACION',
                        4 => 'CIRUGÍA'
                    ];
                @endphp
                {!! $destinos[$data['dest_sali'] ?? 0] ?? '' !!}
            </td>

            <td style="width: 50%; text-align: right; font-size: 12px; vertical-align: middle;">
                <strong>Servicio: </strong>{!! $data['serv_sali'] ?? '' !!}
            </td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: left; font-size: 12px; vertical-align: middle;">
                <strong>Fecha de egreso: </strong>
                {!! $data['fecha_egr'] ?? '' !!}
            </td>
            <td style="width: 50%; text-align: right; font-size: 12px; vertical-align: middle;">
                <strong>Hora de egreso: </strong> {!! $data['hora_egr'] ?? '' !!}
            </td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: left; font-size: 12px; vertical-align: middle;">
                <strong>Estado a la salida: </strong>
                @php
                    $estadoSalida = [
                        1 => 'VIVO',
                        2 => 'MUERTO'
                    ];
                @endphp
                {!! $estadoSalida[$data['est_salida'] ?? 0] ?? 'N/A' !!}
            </td>
        </tr>
    </table>
</div>
<!-- Pagina evoluciones (si hay) -->

<img src="{{ $imageBase64 }}" alt="Firma" style="width: 150px; height: auto;">
<div>
    <p style="margin-top: 0; margin-bottom: 3px;">_________________________</p>
    <p style="font-size: 12px; margin-top: 0; margin-bottom: 2px;">
        <strong>Dr. {!! $data['medico'] ?? 'N/A' !!}</strong>
    </p>
    <p style="font-size: 12px; margin-top: 0; margin-bottom: 2px;">
        <strong>Registro Médico: {!! $data['regmed'] ?? 'N/A' !!}</strong>
    </p>
    <p style="font-size: 12px; margin-top: 0; margin-bottom: 2px;">
        <strong>CC - {!! $data['ceddoc'] ?? 'N/A' !!}</strong>
    </p>


    <div class="content">
        <p style="font-size: 12px; text-align: center;">
            <strong>CERTIFICO QUE TODOS LOS DATOS SUMINISTRADOS EN ESTA HISTORIA CLÍNICA SON VERÍDICOS Y QUE
                FUERON EXPLICADOS EN SU TOTALIDAD POR EL MÉDICO TRATANTE.</strong>
        </p>

        <p style="font-size: 11px; text-align: left">
            NOTA: Se realizó encuesta epidemiológica al ingreso a la institución sobre síntomas de COVID-19, contacto con
            pacientes sospechosos o confirmados de COVID-19 y la realización de viajes en los últimos 15 días. Se realiza
            lavado de manos según las recomendaciones de la OMS, en los cinco momentos, en técnica y duración. Además, se
            utiliza equipo de protección personal y las medidas de protección del paciente para COVID-19. También se
            realiza limpieza y desinfección de los equipos después de la atención de cada paciente.
        </p>

        <p style="font-size: 12px; margin-top: 10px;">
            <strong>NOMBRE Y FIRMA DEL PACIENTE:
                _________________________________________________________________________</strong>
        </p>
    </div>
</div>
</body>
</html>
