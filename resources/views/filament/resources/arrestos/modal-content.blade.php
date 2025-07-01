<div class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Información del Cadete</h3>
            <div class="space-y-2">
                <p><strong class="text-gray-500">Nombre:</strong> {{ $arresto->estudiante->nombre_estudiante }}
                    {{ $arresto->estudiante->apellido_estudiante }}</p>
                <p><strong class="text-gray-500">DNI:</strong> {{ $arresto->estudiante->dni_estudiante }}</p>
                <p><strong class="text-gray-500">Legajo:</strong> {{ $arresto->estudiante->num_legajo }}</p>
                <p><strong class="text-gray-500">Año de Carrera:</strong>
                    {{ $arresto->estudiante->aniodelacarrera->nombre ?? 'N/A' }}</p>
                <p><strong class="text-gray-500">Estado:</strong>
                    {{ $arresto->estudiante->estado->nombre_estado ?? 'N/A' }}</p>
            </div>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Información del Arresto</h3>
            <div class="space-y-2">
                <p><strong class="text-gray-500">Fecha de Arresto:</strong>
                    {{ \Carbon\Carbon::parse($arresto->fecha_de_arresto)->format('d/m/Y') }}</p>
                <p><strong class="text-gray-500">Días de Arresto:</strong> {{ $arresto->dias_de_arresto }} día(s)</p>
                <p><strong class="text-gray-500">Fecha de Creación:</strong>
                    {{ \Carbon\Carbon::parse($arresto->created_at)->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>

    @if ($arresto->faltas->count() > 0)
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Faltas Asociadas
                <span>({{ $arresto->faltas->count() }})</span></h3>
            <div class="p-3 rounded-lg">
                <ul class="space-y-1">
                    @foreach ($arresto->faltas as $falta)
                        <li class="flex items-center justify-between border-b py-2 px-1 w-full">
                            <span class="" >{{ $falta->nombre_de_falta }}</span>
                            <span style="font-size: 0.9em; padding: 2px 8px; border-radius: 4px;">
                                {{ '(' . $falta->nivelesDeFaltas->nombre_de_nivel . ')' }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</div>
