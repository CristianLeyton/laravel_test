<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Cadete - {{ $estudiante->nombre_estudiante }} {{ $estudiante->apellido_estudiante }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 10px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #2c3e50;
        }

        .header p {
            margin: 5px 0;
            font-size: 12px;
            color: #7f8c8d;
        }

        .section {
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        .section-title {
            background-color: #34495e;
            color: white;
            padding: 8px 12px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .info-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            width: 30%;
            padding: 6px 8px;
            background-color: #ecf0f1;
            font-weight: bold;
            border: 1px solid #bdc3c7;
        }

        .info-value {
            display: table-cell;
            width: 70%;
            padding: 6px 8px;
            border: 1px solid #bdc3c7;
        }

        .personal-info-container {
            width: 100%;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        .personal-info {
            width: 70%;
            display: inline-block;
            vertical-align: top;
        }

        .photo-container {
            text-align: center;
            width: 25%;
            display: inline-block;
            vertical-align: top;
            margin-left: 10px;
        }

        .photo {
            width: 100%;
            border: 2px solid #bdc3c7;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th {
            background-color: #34495e;
            color: white;
            padding: 8px;
            text-align: left;
        }

        .table td {
            padding: 6px 8px;
            border: 1px solid #bdc3c7;
        }

        .table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-success {
            background-color: #27ae60;
            color: white;
        }

        .badge-danger {
            background-color: #e74c3c;
            color: white;
        }

        .badge-warning {
            background-color: #f39c12;
            color: white;
        }

        .badge-gray {
            background-color: #95a5a6;
            color: white;
        }

        .total-days {
            background-color: #dceeff;
            padding: 10px;
            border-left: 4px solid #34495e;
            margin-bottom: 15px;
        }

        .page-break {
            page-break-before: always;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #7f8c8d;
            border-top: 1px solid #bdc3c7;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>INFORME DEL CADETE</h1>
        <p>Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <!-- Información Personal -->
    <div class="section">
        <div class="section-title">INFORMACIÓN PERSONAL</div>
        <div class="personal-info-container">
            <div class="personal-info">
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-label">Nombre:</div>
                        <div class="info-value">{{ $estudiante->nombre_estudiante }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Apellido:</div>
                        <div class="info-value">{{ $estudiante->apellido_estudiante }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">DNI:</div>
                        <div class="info-value">{{ $estudiante->dni_estudiante }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">CUIL:</div>
                        <div class="info-value">{{ $estudiante->cuil_estudiante ?: 'No especificado' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Fecha de Nacimiento:</div>
                        <div class="info-value">
                            {{ $estudiante->fecha_nacimiento ? $estudiante->fecha_nacimiento->format('d/m/Y') : 'No especificada' }}
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Lugar de Nacimiento:</div>
                        <div class="info-value">
                            {{ $estudiante->lugarNacimiento->nombre_localidad ?? 'No especificado' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Número de Legajo:</div>
                        <div class="info-value">{{ $estudiante->num_legajo ?: 'No especificado' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Tel. Particular:</div>
                        <div class="info-value">{{ $estudiante->numero_contacto_particular ?: 'No especificado' }}
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Tel. Emergencia:</div>
                        <div class="info-value">{{ $estudiante->numero_contacto_emergencia ?: 'No especificado' }}
                        </div>
                    </div>
                </div>
            </div>

            @if ($estudiante->foto_estudiante && file_exists(public_path('storage/' . $estudiante->foto_estudiante)))
                <div class="photo-container">
                    <img src="{{ public_path('storage/' . $estudiante->foto_estudiante) }}" alt="Foto del cadete"
                        class="photo">
                </div>
            @endif
        </div>

        @if ($estudiante->observaciones)
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Observaciones:</div>
                    <div class="info-value">{{ $estudiante->observaciones }}</div>
                </div>
            </div>
        @endif
    </div>

    <!-- Información Académica -->
    <div class="section">
        <div class="section-title">INFORMACIÓN ACADÉMICA</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Año de la Carrera:</div>
                <div class="info-value">{{ $estudiante->aniodelacarrera->nombre }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Estado:</div>
                <div class="info-value">
                    <span
                        class="badge badge-{{ $estudiante->estado->nombre_estado === 'Activo' ? 'success' : ($estudiante->estado->nombre_estado === 'Dado de baja' ? 'danger' : ($estudiante->estado->nombre_estado === 'Licencia especial' ? 'warning' : 'gray')) }}">
                        {{ $estudiante->estado->nombre_estado }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Domicilios -->
    @if ($estudiante->domicilios->count() > 0)
        <div class="section">
            <div class="section-title">DOMICILIOS</div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Dirección</th>
                        <th>Localidad</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($estudiante->domicilios as $domicilio)
                        <tr>
                            <td>{{ $domicilio->tipoDeDomicilio->nombre_tipo_domicilio }}</td>
                            <td>{{ $domicilio->direccion_estudiante }}</td>
                            <td>{{ $domicilio->localidad->nombre_localidad }}</td>
                            <td>{{ $domicilio->descripcion_domicilio ?: 'Sin descripción' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Resoluciones -->
    @if ($estudiante->resoluciones->count() > 0)
        <div class="section">
            <div class="section-title">RESOLUCIONES</div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Número de Resolución</th>
                        <th>Fecha de Registro</th>
                        <th>Fecha de Actualización</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($estudiante->resoluciones as $resolucion)
                        <tr>
                            <td>{{ $resolucion->numero_de_resolucion }}</td>
                            <td>{{ $resolucion->created_at->format('d/m/Y H:i:s') }}</td>
                            <td>{{ $resolucion->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Arrestos -->
    @if ($estudiante->arrestos->count() > 0)
        <div class="section">
            <div class="section-title">ARRESTOS</div>

            <div class="total-days">
                <strong>Total de días de arresto: {{ $estudiante->arrestos->sum('dias_de_arresto') }}</strong>
            </div>

            @foreach ($estudiante->arrestos as $arresto)
                <div style="margin-bottom: 15px; border: 1px solid #bdc3c7; padding: 10px; background-color: #f8f9fa;">
                    <h4 style="margin: 0 0 10px 0; color: #2c3e50; font-size: 11px;">
                        Arresto del
                        {{ $arresto->fecha_de_arresto ? \Carbon\Carbon::parse($arresto->fecha_de_arresto)->format('d/m/Y') : 'Fecha no especificada' }}
                        - {{ $arresto->dias_de_arresto }} días
                    </h4>

                    <table class="table" style="margin-bottom: 10px;">
                        <thead>
                            <tr>
                                <th>Fecha de Arresto</th>
                                <th>Días de Arresto</th>
                                <th>Fecha de Registro</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $arresto->fecha_de_arresto ? \Carbon\Carbon::parse($arresto->fecha_de_arresto)->format('d/m/Y') : 'No especificada' }}
                                </td>
                                <td>{{ $arresto->dias_de_arresto }}</td>
                                <td>{{ $arresto->created_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    @if ($arresto->faltas->count() > 0)
                        <h5 style="margin: 10px 0 5px 0; color: #34495e; font-size: 10px;">FALTAS ASOCIADAS:</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nivel</th>
                                    <th>Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($arresto->faltas as $falta)
                                    <tr>
                                        <td>{{ $falta->nivelesDeFaltas->nombre_de_nivel ?? 'No especificado' }}</td>
                                        <td>{{ $falta->nombre_de_falta ?? 'Sin descripción' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p style="margin: 5px 0; font-size: 9px; color: #7f8c8d; font-style: italic;">No hay faltas
                            asociadas a este arresto.</p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    <div class="footer">
        <p>Documento generado automáticamente el {{ now()->format('d/m/Y') }} a las {{ now()->format('H:i:s') }}</p>
        <p>Sistema de Gestión de Cadetes</p>
    </div>
</body>

</html>
