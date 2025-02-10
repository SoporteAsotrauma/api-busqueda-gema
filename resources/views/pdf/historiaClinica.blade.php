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
            padding-top: 55mm; /* Espacio suficiente debajo del header */
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
                <h2 style="margin: 0; font-size: 18px;">HISTORIA DE HOSPITALIZACION</h2>
            </td>
            <td style="text-align: right; font-size: 12px; vertical-align: middle;">
                <p style="margin: 0;">{{ $data['num_id'] ?? 'N/A' }}</p>
                <p style="margin: 0;"><strong>Admisión:</strong> {{ $data['docn'] ?? 'N/A' }}</p>
                <p style="margin: 0;"><strong>Siniestro:</strong> {{ ($data['docn_sin'] ?? '') }}</p>
            </td>
        </tr>
    </table>
    <div class="separator" style="margin: 5px 0;"></div>

    <!-- Información del paciente -->
    <table width="100%" style="border-collapse: collapse;">
        <tr>
            <td style="width: 33%; text-align: left; font-size: 11px;">
                <strong>Nombre: </strong>
                {{ $data['apellido1'] ?? '' }} {{ $data['apellido2'] ?? '' }} {{ $data['nombre'] ?? '' }} {{ $data[0]['nombre2'] ?? '' }}
            </td>
            <td style="width: 33%; text-align: center; font-size: 11px;">
                <strong>Num. ID: </strong> {{ $data['tipo_id'] ?? '' }}. {{ $data['num_id'] ?? '' }}
            </td>
            <td style="width: 33%; text-align: right; font-size: 11px;">
                <strong>Fecha de nacimiento: </strong> {{ $data['fech_nacim'] ?? '' }}
            </td>
        </tr>
        <tr>
            <td style="text-align: left; font-size: 11px;"><strong>Edad: </strong>{{ $data['edad'] ?? '' }}</td>
            <td style="text-align: center; font-size: 11px;"><strong>Sexo: </strong>{{ $data['sexo'] ?? '' }}</td>
            <td style="text-align: right; font-size: 11px;"><strong>Estado
                    civil: </strong>{{ $data['estad_civ'] ?? '' }}</td>
        </tr>
        <tr>
            <td style="text-align: left; font-size: 11px;"><strong>Dirección: </strong>{{ $data['direccion'] ?? '' }}
            </td>
            <td style="text-align: center; font-size: 11px;"><strong>Ciudad: </strong>{{ $data['ciudad'] ?? '' }}
            </td>
            <td style="text-align: right; font-size: 11px;"><strong>Dpto: </strong>{{ $data['depart'] ?? '' }}</td>
        </tr>
        <tr>
            <td style="text-align: left; font-size: 11px;"><strong>Teléfono: </strong>{{ $data['telefono'] ?? '' }}
            </td>
            <td style="text-align: center; font-size: 11px;">
                <strong>Ocupación: </strong>{{ $data['ocupacion'] ?? '' }}</td>
            <td style="text-align: right; font-size: 11px;">
                <strong>Responsable: </strong>{{ $data['nomb_resp'] ?? '' }}</td>
        </tr>
        <tr>
            <td style="text-align: left; font-size: 11px;">
                <strong>AT: </strong>{{ ($data['es_act'] ?? 0) == 1 ? 'SI' : 'NO' }}</td>
            <td style="text-align: center; font-size: 11px;">
                <strong>OBS: </strong>{{ ($data['es_obs'] ?? '') === 'S' ? 'SI' : 'NO' }}</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td style="text-align: right; font-size: 11px;"><strong>Fecha/Hora de
                    registro: </strong>{{ $data['freg'] ?? '' }} {{ \Carbon\Carbon::parse($data['horare'] ?? '')->format('H:i') }}
            </td>
        </tr>
    </table>
    <strong style="font-size: 11px;">OBSERVACIÓN</strong>
    <div class="separator" style="margin: 5px 0;"></div>
</div>

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
        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Motivo Consulta</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data['moti_solic'] ?? ''}}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Reingreso</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ ($data['reingre'] ?? '') === 'S' ? 'SI' : 'NO' }}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Estado al ingreso</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data['est_ingr'] ?? '' }}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
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
        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Cabeza y organos de los sentidos</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data['cabeza'] }}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Cuello</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data['cuello'] ?? '' }}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Torax</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data['torax'] }}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Abdomen</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data['abdomen'] }}</p>
        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Genitourinario</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data['genitouri'] }}</p>
        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Pelvis</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data['pelvis'] }}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Dorsoext</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data['dorsoext'] }}</p>
        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
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

    </div>


</div>

</body>
</html>
