<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 justify-stretch">
        <div>
            <!-- Información de la Resolución -->
            <div class="p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Información de la Resolución</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Número de Resolución</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $resolucion->numero_de_resolucion }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Fecha de Creación</label>
                        <p class="text-gray-900">{{ $resolucion->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Información del Estudiante -->
            <div class="p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Cadete</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Nombre</label>
                        <p class="text-gray-900">{{ $resolucion->estudiante->nombre_estudiante }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Apellido</label>
                        <p class="text-gray-900">{{ $resolucion->estudiante->apellido_estudiante }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">DNI</label>
                        <p class="text-gray-900">{{ $resolucion->estudiante->dni_estudiante }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Número de Legajo</label>
                        <p class="text-gray-900">{{ $resolucion->estudiante->num_legajo }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Año de la Carrera</label>
                        <p class="text-gray-900">{{ $resolucion->estudiante->aniodelacarrera->nombre ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Estado</label>
                        <p class="text-gray-900">{{ $resolucion->estudiante->estado->nombre_estado ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documento de la Resolución -->

        <div class="p-4 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Documento de la Resolución</h3>
            <div class="flex justify-center">
                @if ($resolucion->foto)
                    <a href="{{ asset('storage/' . $resolucion->foto) }}" target="_blank" class="inline-block">
                        <img src="{{ asset('storage/' . $resolucion->foto) }}" alt="Foto de la resolución"
                            class="max-w-full h-auto max-h-96 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 cursor-pointer">
                        <p class="text-center text-sm text-blue-600 mt-2">Haz clic para ver en tamaño completo</p>
                    </a>
                @else
                    <div class="border rounded-lg w-full p-3 text-center">
                        No se cargó ninguna imagen en esta resolución.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
