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
<div class="content">
    <h3 style="margin-bottom: 1px;"><strong>Fecha: </strong>{{ $data['freg'] ?? ''}}</h3>
    <table width="100%" style="margin-bottom: 1px;">
        <tr>
            <td style="width: 120px;">
                <p style="font-size: 13px; margin-bottom: 1px;">Registro: {{ $data['hora'] }}</p>
            </td>
            <td>
                <p style="font-size: 12px; margin-bottom: 1px;"> (DR(A). {{ $data['codigo'] ?? '' }}
                    - {{ $data['medico'] ?? ''}}
                    -C.C. {{ $data['ceddoc'] ?? ''}}-REG.MEDICO: {{ $data['regmed'] ?? '' }}
                    -{{ $data['especial'] ?? ''}}</p>
            </td>
        </tr>
    </table>
    <div>
        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline">
            <strong>Motivo Consulta</strong>
        </p>

        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data['moti_solic'] ?? ''}}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline; text-decoration: underline;">
            <strong>Reingreso</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ ($data['reingre'] ?? '') === 'S' ? 'SI' : 'NO' }}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
            <strong>Estado al ingreso</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data['est_ingr'] ?? '' }}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
            <strong>Enfermedad actual</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data['enfer_act'] ?? ''}}</p>
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
            <td style="font-size: 13px;"><strong>FC: {{ $data['ta'] ?? ''}}</strong></td>
            <td style="font-size: 13px;"><strong>FR: {{ $data['fr'] ?? ''}}</strong></td>
            <td style="font-size: 13px;"><strong>Tmp: {{ $data['tem'] ?? ''}}</strong></td>
            <td style="font-size: 13px;"><strong>Estado
                    Embriaguez: </strong> {{ ($data['embri'] ?? '') === 'S' ? 'SI' : 'NO' }}</td>
        </tr>
        <tr>
            <td style="font-size: 13px; margin-bottom: 1px; vertical-align: middle;"><strong>Estado
                    Conciencia</strong></td>

            <td style="font-size: 13px; vertical-align: middle;">
                <table style="border-collapse: collapse;">
                    <tr>
                        <td style="padding-right: 6px;"><strong>Alerta:</strong></td>
                        <td style="width: 20px; height: 20px; border: 1px solid black; border-radius: 5px; text-align: center; vertical-align: middle;
                    display: inline-block; line-height: 20px;">
                            {{ $data['estcons'] == 1 ? 'X' : '' }}
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
                            {{ $data['estcons'] == 2 ? 'X' : '' }}
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
                            {{ $data['estcons'] == 3 ? 'X' : '' }}
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
                            {{ $data['estcons'] == 4 ? 'X' : '' }}
                        </td>
                        <td style="padding-left: 8px;"><strong>Glasgow: ( {{ $data['glasglow'] }} )</strong></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <div>
        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
            <strong>Cabeza y organos de los sentidos</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data['cabeza'] }}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
            <strong>Cuello</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data['cuello'] ?? '' }}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
            <strong>Torax</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data['torax'] }}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
            <strong>Abdomen</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data['abdomen'] }}</p>
        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
            <strong>Genitourinario</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data['genitouri'] }}</p>
        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
            <strong>Pelvis</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data['pelvis'] }}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
            <strong>Dorsoext</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data['dorsoext'] }}</p>
        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
            <strong>Neurologico</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data['neuro'] }}</p>

        <div
            style="text-align: center; width: 100%; position: absolute; top: 88%; left: 50%; transform: translate(-50%, -50%);">

            <!-- Diagnosticos de ingreso -->
            <h3 style="
        display: inline-block;
        border-bottom: 2px solid black;
        padding-bottom: 3px;
        ">
                <strong>DIAGNOSTICOS INGRESO</strong>
            </h3>
        </div>
        <table width="100%" style="margin-bottom: 10px; margin-top: 30px; border-collapse: collapse;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style="border-bottom:1px solid black; font-size: 13px; margin-bottom: 1px; font-weight: bold; display: inline-block;">
                        Diagnóstico de ingreso
                    </p>
                    <p style="font-size: 13px; margin-bottom: 1px;">{{ $diag[0]['diag_ingre'] ?? '' }}
                        -{{ $diag[0]['nombre_diag_ingre'] ?? '' }}</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    @if(isset($diag[0]['nombre_diag_r1']) && $diag[0]['nombre_diag_r1'])
                        <p style="border-bottom:1px solid black; font-size: 12px; margin-bottom: 1px; font-weight: bold; display: inline-block;">
                            Diagnóstico relacionado 1
                        </p>
                        <p style="font-size: 12px; margin-bottom: 1px;">{{ $diag[0]['diag_in_r1'] }}
                            -{{ $diag[0]['nombre_diag_r1'] }}</p>
                    @endif
                    @if(isset($diag[0]['nombre_diag_r2']) && $diag[0]['nombre_diag_r2'])
                        <p style="border-bottom:1px solid black; font-size: 12px; margin-bottom: 1px; font-weight: bold; display: inline-block;">
                            Diagnóstico relacionado 2
                        </p>
                        <p style="font-size: 12px; margin-bottom: 1px;">{{ $diag[0]['diag_in_r2'] }}
                            -{{ $diag[0]['nombre_diag_r2'] }}</p>
                    @endif
                    @if(isset($diag[0]['nombre_diag_r3']) && $diag[0]['nombre_diag_r3'])
                        <p style="border-bottom:1px solid black; font-size: 12px; margin-bottom: 1px; font-weight: bold; display: inline-block;">
                            Diagnóstico relacionado 3
                        </p>
                        <p style="font-size: 12px; margin-bottom: 1px;">{{ $diag[0]['diag_in_r3'] }}
                            -{{ $diag[0]['nombre_diag_r3'] }}</p>
                    @endif
                    @if(isset($diag[0]['nombre_diag_r4']) && $diag[0]['nombre_diag_r4'])
                        <p style="border-bottom:1px solid black; font-size: 12px; margin-bottom: 1px; font-weight: bold; display: inline-block;">
                            Diagnóstico relacionado 4
                        </p>
                        <p style="font-size: 12px; margin-bottom: 1px;">{{ $diag[0]['diag_in_r4'] }}
                            -{{ $diag[0]['nombre_diag_r4'] }}</p>
                    @endif
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
            <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
                <strong>Evolucion</strong>
            </p>
            <p style="font-size: 13px; margin-bottom: 1px;">{{ $data['evolucion'] }}</p>

            <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; text-decoration: underline;">
                <strong>Examenes/Estudios Solicitados</strong>
            </p>
            <p style="font-size: 13px; margin-bottom: 1px;">{{ $data['examenes'] }}</p>

        </div>
    </div>
</div>
<img src="{{ $imageBase64 }}" alt="Firma" style="width: 150px; height: auto;">
<div>

    <p style="margin-top: 0; margin-bottom: 3px;">_________________________</p>
    <p style="font-size: 12px; margin-top: 0; margin-bottom: 2px;">
        <strong>Dr. {{ $data['medico'] ?? 'N/A' }}</strong></p>
    <p style="font-size: 12px; margin-top: 0; margin-bottom: 2px;"><strong>Registro
            Médico: {{ $data['regmed'] ?? 'N/A' }}</strong></p>
    <p style="font-size: 12px; margin-top: 0; margin-bottom: 2px;"><strong>CC - {{ $data['ceddoc'] }}</strong>
    </p>
    <div style="page-break-before: always;"></div>
    <div class="content">
        <p style="font-size: 12px; text-align: center;"><strong>CERTIFICO QUE TODOS LOS DATOS SUMINISTRADOS EN ESTA
                HISTORIA CLINICA SON VERIDICOS Y QUE
                FUERON EXPLICADOS EN SU TOTALIDAD POR EL MEDICO TRATANTE.</strong></p>
        <p style="font-size: 11px; text-align: left"> NOTA: Se realizó encuesta epidemiológica al ingreso a la
            institución sobre sintomas de COVID-19, contacto de
            pacientes sospechosos o confirmados de COVID-19 y la realización de viajes en los ultimos 15 dias. Se
            realiza
            lavado de manos según las recomendaciones de la OMS, en los cinco momentos, en técnica y duración,
            Ademas se
            utiliza equipo de protección personal y las medidas de proteccion del paciente para COVID-19, también se
            realiza limpieza y desinfección de los equipos después de la atención de cada paciente.</p>
        <p style="font-size: 12px; margin-top: 10px;"><strong>NOMBRE Y FIRMA DEL PACIENTE:
                _________________________________________________________________________</strong></p>
    </div>
</div>
</body>
</html>
