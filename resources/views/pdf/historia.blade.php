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

        @page {
            size: legal portrait; /* Tamaño oficio */
            margin: 7mm 14mm; /* Márgenes personalizados */
        }

        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: white;
            padding-bottom: 10px;
        }

        .separator {
            border-top: 1px solid black;
            margin: 10px auto;
        }

        .content {
            padding-top: 54mm; /* Espacio suficiente debajo del header */
        }

        th {
            text-align: center;
        }


    </style>
</head>
<?php
$path = 'logo-a.jpg'; // Ruta de la imagen
$type = pathinfo($path, PATHINFO_EXTENSION);
$img = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($img);
?>
<body>
<div class="header">
    <table width="100%" style="border-collapse: collapse;">
        <tr>
            <td style="width: 70px; text-align: left; vertical-align: middle;">
                <img src="<?php echo $base64; ?>" alt="Logo" style="width: 60px; height: 60px;">
            </td>
            <td style="text-align: center; padding-left: 50px;" colspan="3">
                <h2 style="margin: 0; font-size: 18px;">HISTORIA CLÍNICA</h2>
            </td>
            <td style="text-align: right; font-size: 12px; vertical-align: middle;">
                <p style="margin: 0;">{{ $data[0]['num_id'] ?? 'N/A' }}</p>
                <p style="margin: 0;"><strong>Admisión:</strong> {{ $data[0]['docn'] ?? 'N/A' }}</p>
                <p style="margin: 0;"><strong>Siniestro:</strong> {{ ($data[0]['docn_sin'] ?? '') }}</p>
            </td>
        </tr>
    </table>
    <div class="separator" style="margin: 5px 0;"></div>

    <!-- Información del paciente -->
    <table width="100%" style="border-collapse: collapse;">
        <tr>
            <td style="width: 33%; text-align: left; font-size: 11px;">
                <strong>Nombre: </strong>
                {{ $data[0]['apellido1'] ?? '' }} {{ $data[0]['apellido2'] ?? '' }} {{ $data[0]['nombre'] ?? '' }} {{ $data[0]['nombre2'] ?? '' }}
            </td>
            <td style="width: 33%; text-align: center; font-size: 11px;">
                <strong>Num. ID: </strong> {{ $data[0]['tipo_id'] ?? '' }}. {{ $data[0]['num_id'] ?? '' }}
            </td>
            <td style="width: 33%; text-align: right; font-size: 11px;">
                <strong>Fecha de nacimiento: </strong> {{ $data[0]['fech_nacim'] ?? '' }}
            </td>
        </tr>
        <tr>
            <td style="text-align: left; font-size: 11px;"><strong>Edad: </strong>{{ $data[0]['edad'] ?? '' }}</td>
            <td style="text-align: center; font-size: 11px;"><strong>Sexo: </strong>{{ $data[0]['sexo'] ?? '' }}</td>
            <td style="text-align: right; font-size: 11px;"><strong>Estado
                    civil: </strong>{{ $data[0]['estad_civ'] ?? '' }}</td>
        </tr>
        <tr>
            <td style="text-align: left; font-size: 11px;"><strong>Dirección: </strong>{{ $data[0]['direccion'] ?? '' }}
            </td>
            <td style="text-align: center; font-size: 11px;"><strong>Ciudad: </strong>{{ $data[0]['ciudad'] ?? '' }}
            </td>
            <td style="text-align: right; font-size: 11px;"><strong>Dpto: </strong>{{ $data[0]['depart'] ?? '' }}</td>
        </tr>
        <tr>
            <td style="text-align: left; font-size: 11px;"><strong>Teléfono: </strong>{{ $data[0]['telefono'] ?? '' }}
            </td>
            <td style="text-align: center; font-size: 11px;">
                <strong>Ocupación: </strong>{{ $data[0]['ocupacion'] ?? '' }}</td>
            <td style="text-align: right; font-size: 11px;">
                <strong>Responsable: </strong>{{ $data[0]['nomb_resp'] ?? '' }}</td>
        </tr>
        <tr>
            <td style="text-align: left; font-size: 11px;">
                <strong>AT: </strong>{{ ($data[0]['es_act'] ?? 0) == 1 ? 'SI' : 'NO' }}</td>
            <td style="text-align: center; font-size: 11px;">
                <strong>OBS: </strong>{{ ($data[0]['es_obs'] ?? '') === 'S' ? 'SI' : 'NO' }}</td>
            <td style="text-align: right; font-size: 11px;"><strong>Fecha/Hora de
                    admisión: </strong>{{ $data[0]['fechaad'] ?? '' }} {{ \Carbon\Carbon::parse($data[0]['horaad'] ?? '')->format('H:i') }}
            </td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td style="text-align: right; font-size: 11px;"><strong>Fecha/Hora de
                    registro: </strong>{{ $data[0]['fechare'] ?? '' }} {{ \Carbon\Carbon::parse($data[0]['horare'] ?? '')->format('H:i') }}
            </td>
        </tr>
    </table>
    <strong style="font-size: 11px;">OBSERVACIÓN</strong>
    <div class="separator" style="margin: 5px 0;"></div>
</div>

<!-- Contenido con margen para evitar superposición -->
<div class="content">
    <!-- Segunda seccion historia clinica -->
    <h3 style="margin-bottom: 1px;"><strong>Fecha: </strong>{{ $data[0]['fechare'] ?? ''}}</h3>
    <table width="100%" style="margin-bottom: 1px;">
        <tr>
            <td style="width: 120px;">
                <p style="font-size: 13px; margin-bottom: 1px;">Registro: {{ $data[0]['fechare'] }}</p>
            </td>
            <td>
                <p style="font-size: 12px; margin-bottom: 1px;"> (DR(A). {{ $data[0]['codigo'] ?? '' }}
                    - {{ $data[0]['medico'] ?? ''}}
                    -C.C. {{ $data[0]['ceddoc'] ?? ''}}-REG.MEDICO: {{ $data[0]['regmed'] ?? '' }}
                    -{{ $data[0]['especial'] }}</p>
            </td>
        </tr>
    </table>
    <div>
        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Motivo Consulta</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data[0]['moti_solic'] }}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Reingreso</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ ($data[0]['reingre'] ?? '') === 'S' ? 'SI' : 'NO' }}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Estado al ingreso</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data[0]['est_ingr'] }}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Enfermedad actual</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data[0]['enfer_act'] }}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Revision por sistema</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data[0]['rev_sis'] }}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Antecedentes</strong>
        </p>
        <p style="font-size: 13px; ">{{ $data[0]['anexo'] }}</p>
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
            <td style="font-size: 13px;"><strong>FC: {{ $data[0]['ta'] }}</strong></td>
            <td style="font-size: 13px;"><strong>FR: {{ $data[0]['fr'] }}</strong></td>
            <td style="font-size: 13px;"><strong>Tmp: {{ $data[0]['tem'] }}</strong></td>
            <td style="font-size: 13px;"><strong>Estado
                    Embriaguez: </strong> {{ ($data[0]['embri'] ?? '') === 'S' ? 'SI' : 'NO' }}</td>
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
                            {{ $data[0]['estcons'] == 1 ? 'X' : '' }}
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
                            {{ $data[0]['estcons'] == 2 ? 'X' : '' }}
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
                            {{ $data[0]['estcons'] == 3 ? 'X' : '' }}
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
                            {{ $data[0]['estcons'] == 4 ? 'X' : '' }}
                        </td>
                        <td style="padding-left: 8px;"><strong>Glasgow: ( {{ $data[0]['glasglow'] }} )</strong></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <div>
        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Cabeza y organos de los sentidos</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data[0]['cabeza'] }}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Cuello</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data[0]['cuello'] ?? '' }}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Torax</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data[0]['torax'] }}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Abdomen</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data[0]['abdomen'] }}</p>
        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Genitourinario</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data[0]['genitouri'] }}</p>
    </div>
</div>
<div style="page-break-before: always;"></div>
<!-- Pagina 2 -->
<div class="content">
    <div>
        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Pelvis</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data[0]['pelvis'] }}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Dorsoext</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data[0]['dorsoext'] }}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Neurologico</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data[0]['neuro'] }}</p>
    </div>
    <div
        style="text-align: center; width: 100%; position: absolute; top: 32%; left: 50%; transform: translate(-50%, -50%);">

        <!-- Diagnosticos de ingreso -->
        <h3 style="
        display: inline-block;
        border-bottom: 2px solid black;
        padding-bottom: 3px;
        ">
            <strong>DIAGNOSTICOS INGRESO</strong>
        </h3>
    </div>
    <!-- Diagnosticos ingreso-->
    <table width="100%" style="margin-bottom: 10px; margin-top: 30px; border-collapse: collapse;">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <p style="border-bottom:1px solid black; font-size: 13px; margin-bottom: 1px; font-weight: bold; display: inline-block;">
                    Diagnostico de ingreso</p>
                <p style="font-size: 13px; margin-bottom: 1px;">{{ $diag[0]['diag_ingre'] }}
                    -{{ $diag[0]['nombre_diag_ingre'] }}</p>
            </td>
            <td style="width: 50%; vertical-align: top;">
                @if(isset($diag[0]['nombre_diag_r1']) && $diag[0]['nombre_diag_r1'])
                    <p style="border-bottom:1px solid black; font-size: 12px; margin-bottom: 1px; font-weight: bold; display: inline-block;">
                        Diagnóstico relacionado 1</p>
                    <p style="font-size: 12px; margin-bottom: 1px;">{{ $diag[0]['diag_in_r1'] }}
                        -{{ $diag[0]['nombre_diag_r1'] }}</p>
                @endif
                @if(isset($diag[0]['nombre_diag_r2']) && $diag[0]['nombre_diag_r2'])
                    <p style="border-bottom:1px solid black; font-size: 12px; margin-bottom: 1px; font-weight: bold; display: inline-block;">
                        Diagnóstico relacionado 2</p>
                    <p style="font-size: 12px; margin-bottom: 1px;">{{ $diag[0]['diag_in_r2'] }}
                        -{{ $diag[0]['nombre_diag_r2'] }}</p>
                @endif
                @if(isset($diag[0]['nombre_diag_r3']) && $diag[0]['nombre_diag_r3'])
                    <p style="border-bottom:1px solid black; font-size: 12px; margin-bottom: 1px; font-weight: bold; display: inline-block;">
                        Diagnóstico relacionado 3</p>
                    <p style="font-size: 12px; margin-bottom: 1px;">{{ $diag[0]['diag_in_r3'] }}
                        -{{ $diag[0]['nombre_diag_r3'] }}</p>
                @endif
                @if(isset($diag[0]['nombre_diag_r4']) && $diag[0]['nombre_diag_r4'])
                    <p style="border-bottom:1px solid black; font-size: 12px; margin-bottom: 1px; font-weight: bold; display: inline-block;">
                        Diagnóstico relacionado 4</p>
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
        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Plan/Conducta</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data[0]['plan'] }}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Examenes/Estudios Solicitados</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data[0]['examenes'] }}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Prescripciones/Tratamientos</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data[0]['tratami'] }}</p>
    </div>

    <!-- Diagnosticos confirmados -->
    <div
        style="text-align: center; width: 100%; position: absolute; top: 64%; left: 50%; transform: translate(-50%, -50%);">

        <!-- Diagnosticos de ingreso -->
        <h3 style="
        display: inline-block;
        border-bottom: 2px solid black;
        padding-bottom: 3px;
        ">
            <strong>DIAGNOSTICOS CONFIRMADOS</strong>
        </h3>
    </div>
    <table width="100%" style="margin-bottom: 10px; margin-top: 55px; border-collapse: collapse;">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <p style="border-bottom:1px solid black; font-size: 13px; margin-bottom: 1px; font-weight: bold; display: inline-block;">
                    Diagnostico principal</p>
                <p style="font-size: 13px; margin-bottom: 1px;">{{ $diagS[0]['diag_salid'] }}
                    -{{ $diagS[0]['nombre_diag_salid'] }}</p>
            </td>
            <td style="width: 50%; vertical-align: top;">
                @if(isset($diagS[0]['nombre_diag_s1']) && $diagS[0]['nombre_diag_s1'])
                    <p style="border-bottom:1px solid black; font-size: 12px; margin-bottom: 1px; font-weight: bold; display: inline-block;">
                        Diagnóstico relacionado 1</p>
                    <p style="font-size: 12px; margin-bottom: 1px;">{{ $diagS[0]['diag_sali1'] }}
                        -{{ $diagS[0]['nombre_diag_s1'] }}</p>
                @endif
                @if(isset($diagS[0]['nombre_diag_s2']) && $diagS[0]['nombre_diag_s2'])
                    <p style="border-bottom:1px solid black; font-size: 12px; margin-bottom: 1px; font-weight: bold; display: inline-block;">
                        Diagnóstico relacionado 2</p>
                    <p style="font-size: 12px; margin-bottom: 1px;">{{ $diagS[0]['diag_sali2'] }}
                        -{{ $diagS[0]['nombre_diag_s2'] }}</p>
                @endif
                @if(isset($diagS[0]['nombre_diag_s3']) && $diagS[0]['nombre_diag_s3'])
                    <p style="border-bottom:1px solid black; font-size: 12px; margin-bottom: 1px; font-weight: bold; display: inline-block;">
                        Diagnóstico relacionado 3</p>
                    <p style="font-size: 12px; margin-bottom: 1px;">{{ $diagS[0]['diag_sali3'] }}
                        -{{ $diagS[0]['nombre_diag_s3'] }}</p>
                @endif
                @if(isset($diagS[0]['nombre_diag_s4']) && $diagS[0]['nombre_diag_s4'])
                    <p style="border-bottom:1px solid black; font-size: 12px; margin-bottom: 1px; font-weight: bold; display: inline-block;">
                        Diagnóstico relacionado 4</p>
                    <p style="font-size: 12px; margin-bottom: 1px;">{{ $diagS[0]['diag_sali4'] }}
                        -{{ $diagS[0]['nombre_diag_s4'] }}</p>
                @endif
            </td>
        </tr>
    </table>
    <table width="100%" style="margin-bottom: 10px;">
        <tr>
            <td style="width: 120px;">
                <p style="font-size: 13px; margin-bottom: 1px;">Registro: {{ $data[0]['fechare'] }}</p>
            </td>
            <td>
                <p style="font-size: 12px; margin-bottom: 1px;"> (DR(A). {{ $data[0]['codigo'] ?? '' }}
                    - {{ $data[0]['medico'] ?? ''}}
                    -C.C. {{ $data[0]['ceddoc'] ?? ''}}-REG.MEDICO: {{ $data[0]['regmed'] ?? '' }}
                    -{{ $data[0]['especial'] }}</p>
            </td>
        </tr>
    </table>
</div>
<!-- Pagina evoluciones (si hay) -->

@if (!empty($evol) && collect($evol)->contains(fn($ev) => !is_null($ev['evolucion']) || !is_null($ev['plan'])))
    <div style="page-break-before: always;"></div>
    <div class="content" style="margin-top: 30px;">
        @php
            $counter = 0;
            $evolCount = count($evol); // Contamos la cantidad total de evoluciones
        @endphp

        @foreach ($evol as $ev)
            @if (!is_null($ev['evolucion']) || !is_null($ev['plan']))
                <h3 style="text-align: center; border: 1px solid black; border-radius: 5px; padding: 5px 90px; display: table; margin: auto;">
                    <strong>ANALISIS-PLAN-EXAMENES-PROCEDIMIENTOS-TRATAMIENTOS</strong>
                </h3>
                <div>
                    <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
                        <strong>Evolución</strong>
                    </p>
                    <p style="font-size: 13px; margin-bottom: 1px;">{{ $ev['evolucion'] }}</p>

                    <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
                        <strong>Plan/Conducta</strong>
                    </p>
                    <p style="font-size: 13px; margin-bottom: 1px;">{{ $ev['plan'] }}</p>
                </div>

                @php
                    $counter++;
                @endphp

                    <!-- Después de cada 4 evoluciones, agrega un salto de página y un nuevo div.content -->
                @if ($counter % 4 == 0 && $counter < $evolCount) <!-- Verifica si hay más evoluciones por mostrar -->
                <div style="page-break-before: always;"></div> <!-- Salto de página -->
                <div class="content" style="margin-top: 30px;">
                    <!-- Nuevo div.content con margen superior -->
                </div>
                @endif
            @endif
        @endforeach

        <!-- Si no se han completado 4 evoluciones en la página, mostrar las líneas de salto de página y el nuevo div.content -->
        @if ($counter % 4 == 0)
            <div class="content">
                <!-- Este div.content es solo para la página que no completó las 4 evoluciones -->
            </div>
        @endif
        <h3 style="
                   text-align: center;
                   border: 1px solid black;
                   border-radius: 5px;
                   padding: 5px 90px;
                   display: table;
                   margin: auto auto 1px;">
            <strong>SALIDA DEL PACIENTE</strong>
        </h3>
        <table width="100%" style="border-collapse: collapse;">
            <tr>
                <td style="width: 50%; text-align: left; font-size: 12px; vertical-align: middle;">
                    <strong>Destino salida: </strong>
                    @php
                        $destinos = [
                            0 => 'N/A',
                            1 => 'ALTA DE URGENCIAS',
                            2 => 'REMISIÓN OTRO NIVEL',
                            3 => 'HOSPITALIZACIÓN',
                            4 => 'CIRUGÍA'
                        ];
                    @endphp
                    {{ $destinos[$data[0]['dest_sali'] ?? 0] }}
                </td>

                <td style="width: 50%; text-align: center; font-size: 12px; vertical-align: middle;">
                    <strong>Servicio: </strong>{{ $data[0]['serv_sali'] ?? '' }}
                </td>
            </tr>
            <tr>
                <td style="width: 50%; text-align: left; font-size: 12px; vertical-align: middle;">
                    <strong>Fecha de egreso: </strong>
                    {{ $data[0]['fecha_egr'] ?? '' }}
                </td>
                <td style="width: 50%; text-align: center; font-size: 12px; vertical-align: middle;">
                    <strong>Hora de egreso: </strong> {{ $data[0]['hora_egr'] ?? '' }}
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
                    {{ $estadoSalida[$data[0]['est_salida'] ?? 0] ?? 'N/A' }}
                </td>
            </tr>
        </table>

        @if (isset($imageBase64))
            <img src="{{ $imageBase64 }}" alt="Firma" style="width: 150px; height: auto;">
        @endif
        <div>
            <p style="margin-top: 0; margin-bottom: 3px;">_________________________</p>
            <p style="font-size: 12px; margin-top: 0; margin-bottom: 2px;">
                <strong>Dr. {{ $data[0]['medico'] ?? 'N/A' }}</strong></p>
            <p style="font-size: 12px; margin-top: 0; margin-bottom: 2px;"><strong>Registro
                    Médico: {{ $data[0]['regmed'] ?? 'N/A' }}</strong></p>
            <p style="font-size: 12px; margin-top: 0; margin-bottom: 2px;"><strong>CC - {{ $data[0]['ceddoc'] }}</strong>
            </p>
            @if ($counter == 3)
                <div style="page-break-before: always;"></div>
                <div class="content">
            @endif
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
    </div>

@else
    <h3 style="
                   text-align: center;
                   border: 1px solid black;
                   border-radius: 5px;
                   padding: 5px 90px;
                   display: table;
                   margin: auto auto 1px;">
        <strong>SALIDA DEL PACIENTE</strong>
    </h3>
    <table width="100%" style="border-collapse: collapse;">
        <tr>
            <td style="width: 50%; text-align: left; font-size: 12px; vertical-align: middle;">
                <strong>Destino salida: </strong>
                @php
                    $destinos = [
                        0 => 'N/A',
                        1 => 'ALTA DE URGENCIAS',
                        2 => 'REMISIÓN OTRO NIVEL',
                        3 => 'HOSPITALIZACIÓN',
                        4 => 'CIRUGÍA'
                    ];
                @endphp
                {{ $destinos[$data[0]['dest_sali'] ?? 0] }}
            </td>

            <td style="width: 50%; text-align: center; font-size: 12px; vertical-align: middle;">
                <strong>Servicio: </strong>{{ $data[0]['serv_sali'] ?? '' }}
            </td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: left; font-size: 12px; vertical-align: middle;">
                <strong>Fecha de egreso: </strong>
                {{ $data[0]['fecha_egr'] ?? '' }}
            </td>
            <td style="width: 50%; text-align: center; font-size: 12px; vertical-align: middle;">
                <strong>Hora de egreso: </strong> {{ $data[0]['hora_egr'] ?? '' }}
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
                {{ $estadoSalida[$data[0]['est_salida'] ?? 0] ?? 'N/A' }}
            </td>
        </tr>
    </table>

    @if (isset($imageBase64))
        <img src="{{ $imageBase64 }}" alt="Firma" style="width: 150px; height: auto;">
    @endif
    <div>

        <p style="margin-top: 0; margin-bottom: 3px;">_________________________</p>
        <p style="font-size: 12px; margin-top: 0; margin-bottom: 2px;">
            <strong>Dr. {{ $data[0]['medico'] ?? 'N/A' }}</strong></p>
        <p style="font-size: 12px; margin-top: 0; margin-bottom: 2px;"><strong>Registro
                Médico: {{ $data[0]['regmed'] ?? 'N/A' }}</strong></p>
        <p style="font-size: 12px; margin-top: 0; margin-bottom: 2px;"><strong>CC - {{ $data[0]['ceddoc'] }}</strong>
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
@endif

</body>
</html>
