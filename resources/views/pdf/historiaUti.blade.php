@php
    use Carbon\Carbon;
@endphp
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historia Clínica de Hospitalización</title>
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
<div class="content">
    <h3 style="margin-bottom: 1px;"><strong>Fecha: </strong>{{ $data['freg'] ?? ''}}</h3>
    <table width="100%" style="margin-bottom: 1px;">
        <tr>
            <td style="width: 120px;">
                <p style="font-size: 13px; margin-bottom: 1px;">Registro: {!! $data['hora'] !!}</p>
            </td>
            <td>
                <p style="font-size: 12px; margin-bottom: 1px;">
                    (DR(A). {!! $data['codigo'] ?? '' !!} - {!! $data['medico'] ?? '' !!} -
                    C.C. {!! $data['ceddoc'] ?? '' !!}
                    - REG.MEDICO: {!! $data['regmed'] ?? '' !!} - {!! $data['especial'] ?? '' !!})
                </p>
            </td>
        </tr>
    </table>
    @php
        $fields = [
            'moti_solic' => 'Motivo Consulta',
            'est_ingr' => 'Estado al ingreso',
            'enfer_act' => 'Enfermedad actual',
        ];
    @endphp

    <div>
        @foreach ($fields as $key => $label)
            @if (!empty($data[$key]))
                <p style="font-size: 13px; text-decoration: underline; display: inline-block;">
                    <strong>{{ $label }}</strong>
                </p>
                <p style="font-size: 13px; margin-bottom: 1px;">{!! $data[$key] !!}</p>
            @endif
        @endforeach
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
            <td style="font-size: 13px;"><strong>T.SIST: {!! $data['tsist']?? '' !!}</strong></td>
            <td style="font-size: 13px;"><strong>T.DIAS: </strong>{!! $data['tdia']?? ''!!}</td>
            <td style="font-size: 13px;"><strong>MEDIA: </strong>{!! $data['tmed']?? ''!!}</td>
            <td style="font-size: 13px;"><strong>FC: {!! $data['ta'] ?? '' !!}</strong></td>
            <td style="font-size: 13px;"><strong>FR: {!! $data['fr'] ?? '' !!}</strong></td>
        </tr>
        <tr>
            <td style="font-size: 13px;"><strong>Tmp: {!! $data['tem'] ?? '' !!}</strong></td>
            <td style="font-size: 13px;"><strong>ST 02: {!! $data['o2'] ?? '' !!}</strong></td>
            <td style="font-size: 13px;"><strong>Peso: {!! $data['peso'] ?? '' !!}</strong></td>
            <td style="font-size: 13px;"><strong>Talla: {!! $data['talla'] ?? '' !!}</strong></td>
            <td style="font-size: 13px;"><strong>Imc: {!! $data['imc'] ?? '' !!}</strong></td>
        </tr>
        <tr>
            <td style="font-size: 13px;">
                <strong>Glasgow: ( {!! $data['glasglow'] ?? '' !!} )</strong>
            </td> @php
                $estados = [
                    1 => 'Alerta',
                    2 => 'Obnubilado',
                    3 => 'Estuporoso',
                    4 => 'Coma'
                ];
            @endphp
            <td style="font-size: 13px;">
                <strong>Estado: {{ $estados[$data['estcons'] ?? 0] ?? '' }}</strong>
            </td>
            @php
                $embriMap = ['s' => 'Sí', 'n' => 'No'];
            @endphp

            <td style="font-size: 13px;">
                <strong>P.Embri: ( {{ $embriMap[$data['embri'] ?? ''] ?? '' }} )</strong>
            </td>
            <td><strong>Gases: </strong>{!! $data['gases'] !!}</td>
        </tr>
    </table>
    <div>
        @foreach ([
            'cabeza' => 'Cabeza y órganos de los sentidos',
            'cuello' => 'Cuello',
            'torax' => 'Tórax',
            'genitouri' => 'Genitourinario',
            'pelvis' => 'Pelvis',
            'dorsoext' => 'Dorsoext',
            'neuro' => 'Neurológico'
        ] as $key => $title)
            @if (!empty(trim($data[$key] ?? '')))
                <p style="font-size: 13px; margin-bottom: 3px; text-decoration: underline;">
                    <strong>{{ $title }}</strong>
                </p>
                <p style="font-size: 13px; margin-bottom: 8px;">{!! nl2br(e($data[$key])) !!}</p>
            @endif
        @endforeach

        <div
            style="text-align: center; width: 100%; position: absolute; top: 88%; left: 50%; transform: translate(-50%, -50%);">

            <!-- Diagnosticos de ingreso -->
            <h3 style="
        display: inline-block;
        text-decoration: underline;
        ">
                <strong>DIAGNOSTICOS INGRESO</strong>
            </h3>
        </div>
        <table width="100%" style="margin-bottom: 10px; border-collapse: collapse;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style="border-bottom:1px solid black; font-size: 13px; margin-bottom: 1px; font-weight: bold; display: inline-block;">
                        Diagnóstico de ingreso
                    </p>
                    <p style="font-size: 13px; margin-bottom: 1px;">
                        {!! $diag[0]['diag_ingre'] ?? '' !!} - {!! $diag[0]['nombre_diag_ingre'] ?? '' !!}
                    </p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                        @foreach ([1, 2, 3, 4] as $i)
                            @if (!empty($diag[0]["nombre_diag_r$i"]))
                                <div
                                    style="width: 48%; border-bottom: 1px solid black; font-size: 12px; margin-bottom: 5px;">
                                    <p style="font-weight: bold; margin-bottom: 2px;">
                                        Diagnóstico relacionado {{ $i }}
                                    </p>
                                    <p style="margin-bottom: 2px;">
                                        {!! $diag[0]["diag_in_r$i"] ?? '' !!} - {!! $diag[0]["nombre_diag_r$i"] !!}
                                    </p>
                                </div>
                            @endif
                        @endforeach
                    </div>
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
                'conducta' => 'Plan/Conducta',
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

        <!-- Diagnosticos de ingreso -->
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
                    </tr>
                    <tr>

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
                    !empty($evolucion['conducta']) ||
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
                                <p style="font-size: 13px; margin-bottom: 1px;">
                                    Registro: {!! $evolucion['hora'] ?? '' !!}</p>
                            </td>
                            <td>
                                <p style="font-size: 12px; margin-bottom: 1px;">
                                    (DR(A). {!! $evolucion['codigo'] ?? '' !!} - {!! $evolucion['medico'] ?? '' !!} -
                                    C.C.
                                    {!! $evolucion['ceddoc'] ?? '' !!} - REG.MEDICO: {!! $evolucion['regmed'] ?? '' !!}
                                    -
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
                            'conducta' => 'Plan/Conducta',
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
                        1 => 'ALTA DE HOSPITALIZACION',
                        2 => 'REMISIÓN OTRO NIVEL',
                        3 => 'TRASLADO A UCI',
                        4 => 'CIRUGÍA'
                    ];
                @endphp
                {!! $destinos[$data['dest_sali'] ?? 0] ?? '' !!}
            </td>

            <td style="width: 50%; text-align: center; font-size: 12px; vertical-align: middle;">
                <strong>Servicio: </strong>{!! $data['serv_sali'] ?? '' !!}
            </td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: left; font-size: 12px; vertical-align: middle;">
                <strong>Fecha de egreso: </strong>
                {!! $data['fecha_egr'] ?? '' !!}
            </td>
            <td style="width: 50%; text-align: center; font-size: 12px; vertical-align: middle;">
                <strong>Días de incapacidad: </strong> {!! $data['dias_inca'] ?? '' !!}
            </td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: left; font-size: 12px; vertical-align: middle;">
                <strong>Hora de egreso: </strong> {!! $data['hora_egr'] ?? '' !!}
            </td>
            <td style="width: 50%; text-align: center; font-size: 12px; vertical-align: middle;">
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
            NOTA: Se realizó encuesta epidemiológica al ingreso a la institución sobre síntomas de COVID-19, contacto
            con
            pacientes sospechosos o confirmados de COVID-19 y la realización de viajes en los últimos 15 días. Se
            realiza
            lavado de manos según las recomendaciones de la OMS, en los cinco momentos, en técnica y duración. Además,
            se
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
