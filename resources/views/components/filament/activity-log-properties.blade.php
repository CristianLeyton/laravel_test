@php
    $properties = $getRecord()->getAttribute('properties');
    if ($properties instanceof \Illuminate\Support\Collection) {
        $properties = $properties->toArray();
    }
    $friendly = \App\Filament\Resources\ActivityLogResource::$friendlyFieldNames ?? [];
    $getLabel = fn($key) => $friendly[$key] ?? ucfirst(str_replace('_', ' ', $key));
    $omitFields = ['updated_at', 'created_at'];
@endphp
@if (!is_array($properties))
    <div style=""><span>Sin cambios registrados</span></div>
@elseif (!isset($properties['attributes']) && !isset($properties['old']))
    <table style="font-size:12px; text-align: left; width: 100%">
        <thead>
            <tr>
                <th>Campo</th>
                <th colspan="2">Valor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($properties as $key => $value)
                @if (!in_array($key, $omitFields))
                    <tr>
                        <td><b>{{ $getLabel($key) }}</b></td>
                        <td colspan="2">{{ $value }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@else
    @php
        $old = $properties['old'] ?? [];
        $new = $properties['attributes'] ?? [];
    @endphp
    @if (!empty($old) && !empty($new))
        <table style="font-size:12px; text-align: left; width: 100%">
            <thead>
                <tr>
                    <th>Campo</th>
                    <th>Antes</th>
                    <th>Después</th>
                </tr>
            </thead>
            <tbody>
                @foreach (array_unique(array_merge(array_keys($old), array_keys($new))) as $key)
                    @if (!in_array($key, $omitFields))
                        <tr>
                            <td><b>{{ $getLabel($key) }}</b></td>
                            <td style="color:#b91c1c">{{ $old[$key] ?? '-' }}</td>
                            <td style="color:#15803d">{{ $new[$key] ?? '-' }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @elseif ((empty($old) && !empty($new)) || (!empty($new) && empty($old)))
        <table style="font-size:12px; text-align: left; width: 100%">
            <thead>
                <tr>
                    <th>Campo</th>
                    <th colspan="2">Valor</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($new as $key => $value)
                    @if (!in_array($key, $omitFields))
                        <tr>
                            <td><b>{{ $getLabel($key) }}</b></td>
                            <td colspan="2">{{ $value }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @elseif (!empty($old) && empty($new))
        <table style="font-size:12px; text-align: left; width: 100%">
            <thead>
                <tr>
                    <th>Campo</th>
                    <th colspan="2">Valor eliminado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($old as $key => $value)
                    @if (!in_array($key, $omitFields))
                        <tr>
                            <td><b>{{ $getLabel($key) }}</b></td>
                            <td colspan="2">{{ $value }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @else
        <div style=""><span>Sin cambios registrados</span></div>
    @endif
@endif
