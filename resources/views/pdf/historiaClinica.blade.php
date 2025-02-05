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
                <strong>Responsable: </strong>{{ $data[0]['nom_resp'] ?? '' }}</td>
        </tr>
        <tr>
            <td style="text-align: left; font-size: 11px;">
                <strong>AT: </strong>{{ ($data[0]['es_act'] ?? 0) == 1 ? 'SI' : 'NO' }}</td>
            <td style="text-align: center; font-size: 11px;">
                <strong>OBS: </strong>{{ ($data[0]['es_obs'] ?? '') === 'S' ? 'SI' : 'NO' }}</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td style="text-align: right; font-size: 11px;"><strong>Fecha/Hora de
                    registro: </strong>{{ $data[0]['freg'] ?? '' }} {{ \Carbon\Carbon::parse($data[0]['horare'] ?? '')->format('H:i') }}
            </td>
        </tr>
    </table>
    <strong style="font-size: 11px;">OBSERVACIÓN</strong>
    <div class="separator" style="margin: 5px 0;"></div>
</div>

<div class="content">
    <h3 style="margin-bottom: 1px;"><strong>Fecha: </strong>{{ $data[0]['freg'] ?? ''}}</h3>
    <table width="100%" style="margin-bottom: 1px;">
        <tr>
            <td style="width: 120px;">
                <p style="font-size: 13px; margin-bottom: 1px;">Registro: {{ $data[0]['hora'] }}</p>
            </td>
            <td>
                <p style="font-size: 12px; margin-bottom: 1px;"> (DR(A). {{ $data[0]['codigo'] ?? '' }}
                    - {{ $data[0]['medico'] ?? ''}}
                    -C.C. {{ $data[0]['ceddoc'] ?? ''}}-REG.MEDICO: {{ $data[0]['regmed'] ?? '' }}
                    -{{ $data[0]['especial'] ?? ''}}</p>
            </td>
        </tr>
    </table>
    <div>
        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Motivo Consulta</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data[0]['moti_solic'] ?? ''}}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Reingreso</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ ($data[0]['reingre'] ?? '') === 'S' ? 'SI' : 'NO' }}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Estado al ingreso</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data[0]['est_ingr'] ?? '' }}</p>

        <p style="font-size: 13px; margin-bottom: 1px; display: inline-block; border-bottom: 1px solid black;">
            <strong>Enfermedad actual</strong>
        </p>
        <p style="font-size: 13px; margin-bottom: 1px;">{{ $data[0]['enfer_act'] ?? ''}}</p>
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
            <td style="font-size: 13px;"><strong>FC: {{ $data[0]['ta'] ?? ''}}</strong></td>
            <td style="font-size: 13px;"><strong>FR: {{ $data[0]['fr'] ?? ''}}</strong></td>
            <td style="font-size: 13px;"><strong>Tmp: {{ $data[0]['tem'] ?? ''}}</strong></td>
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

</body>
</html>
