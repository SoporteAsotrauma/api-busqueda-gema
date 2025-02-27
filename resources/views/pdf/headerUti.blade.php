<?php
$path = 'logo-a.jpg'; // Ruta de la imagen
$type = pathinfo($path, PATHINFO_EXTENSION);
$img = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($img);
?>

<div class="header" style="padding-bottom: 20px;">
    <table width="100%" style="border-collapse: collapse;">
        <tr>
            <td style="width: 70px; text-align: left; vertical-align: middle;">
                <img src="{{ $base64 }}" alt="Logo" style="width: 60px; height: 60px;">
            </td>
            <td style="text-align: center; padding-left: 50px;" colspan="3">
                <h2 style="margin: 0; font-size: 18px;">HISTORIA UND TERAPIA</h2>
            </td>
            <td style="text-align: right; font-size: 12px; vertical-align: middle;">
                <p style="margin: 0;">{{ $data['num_id'] ?? 'N/A' }}</p>
                <p style="margin: 0;"><strong>Admisión:</strong> {{ $data['docn'] ?? 'N/A' }}</p>
                <p style="margin: 0;"><strong>Siniestro:</strong> {{ ($data['docn_sin'] ?? '') }}</p>
            </td>
        </tr>
    </table>
    <div class="separator" style="margin: 5px 0; border-top: 1px solid black;"></div>

    <!-- Información del paciente -->
    <table width="100%" style="border-collapse: collapse;">
        <tr>
            <td style="width: 33%; text-align: left; font-size: 11px;">
                <strong>Nombre: </strong>
                {{ $data['apellido1'] ?? '' }} {{ $data['apellido2'] ?? '' }} {{ $data['nombre'] ?? '' }} {{ $data['nombre2'] ?? '' }}
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
            <td style="text-align: right; font-size: 11px;"><strong>Estado civil: </strong>{{ $data['estad_civ'] ?? '' }}</td>
        </tr>
        <tr>
            <td style="text-align: left; font-size: 11px;"><strong>Dirección: </strong>{{ $data['direccion'] ?? '' }}</td>
            <td style="text-align: center; font-size: 11px;"><strong>Ciudad: </strong>{{ $data['ciudad'] ?? '' }}</td>
            <td style="text-align: right; font-size: 11px;"><strong>Dpto: </strong>{{ $data['depart'] ?? '' }}</td>
        </tr>
        <tr>
            <td style="text-align: left; font-size: 11px;"><strong>Teléfono: </strong>{{ $data['telefono'] ?? '' }}</td>
            <td style="text-align: center; font-size: 11px;"><strong>Ocupación: </strong>{{ $data['ocupacion'] ?? '' }}</td>
            <td style="text-align: right; font-size: 11px;"><strong>Responsable: </strong>{{ $data['nomb_resp'] ?? '' }}</td>
        </tr>
        <tr>
            <td style="text-align: left; font-size: 11px;"><strong>AT: </strong>{{ ($data['es_act'] ?? 0) == 1 ? 'SI' : 'NO' }}</td>
            <td style="text-align: center; font-size: 11px;"><strong>OBS: </strong>{{ ($data['es_obs'] ?? '') === 'S' ? 'SI' : 'NO' }}</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td style="text-align: right; font-size: 11px;"><strong>Fecha/Hora de registro: </strong>{{ $data['freg'] ?? '' }} {{ \Carbon\Carbon::parse($data['horare'] ?? '')->format('H:i') }}</td>
        </tr>
    </table>
    <strong style="font-size: 11px;">OBSERVACIÓN</strong>
    <div class="separator" style="margin: 5px 0; border-top: 1px solid black;"></div>

</div>
