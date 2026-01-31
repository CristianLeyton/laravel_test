# Sistema de Arrestos Anuales

## Descripción General

El sistema de arrestos ha sido modificado para implementar un **reseteo automático anual** de los contadores, manteniendo el historial completo de todos los arrestos registrados.

## Funcionalidades Principales

### 1. Reseteo Automático Anual

- **Contador del año actual**: Solo cuenta los arrestos del año en curso
- **Historial completo**: Se mantienen todos los arrestos de años anteriores
- **Notificaciones por año**: Las alertas de límite excedido son específicas por año

### 2. Límite Anual Configurable

```php
public const LIMITE_DIAS_ARRESTO = 20; // Días límite de arrestos por año
```

### 3. Cálculo Inteligente

- El sistema calcula automáticamente los días acumulados solo del año actual
- Al cambiar de año, el contador se reinicia automáticamente
- Las notificaciones se envían solo cuando se supera el límite del año en curso

## Cambios Implementados

### Modelo Arrestos (`app/Models/Arrestos.php`)

#### Métodos Helper Agregados

```php
// Obtiene días acumulados para un año específico
Arrestos::getDiasAcumuladosPorAnio($estudianteId, $anio)

// Obtiene total histórico de días
Arrestos::getTotalHistorico($estudianteId)

// Verifica si superó el límite en un año específico
Arrestos::superaLimiteEnAnio($estudianteId, $anio)
```

#### Lógica de Notificaciones

- Las notificaciones ahora incluyen el año específico
- Se evitan duplicados por año
- El mensaje indica claramente el año del exceso

### Modelo Estudiantes (`app/Models/Estudiantes.php`)

#### Métodos Helper Agregados

```php
// Días de arresto del año actual
$estudiante->getDiasArrestoAnioActual()

// Total histórico de arrestos
$estudiante->getTotalHistoricoArrestos()

// Verifica si superó el límite del año actual
$estudiante->superaLimiteArrestosAnioActual()

// Obtiene arrestos de un año específico
$estudiante->getArrestosPorAnio($anio)
```

### Vista de Estudiante (`ViewEstudiante.php`)

#### Información Mostrada

- **Días de arresto del año actual** (color warning)
- **Total histórico de arrestos** (color info)
- **Límite anual** (color danger)

### Recurso de Arrestos (`ArrestosResource.php`)

#### Filtro por Año

- Filtro desplegable para seleccionar año específico
- Muestra estadísticas por año en la descripción de la columna

#### Información en Tabla

- Días del arresto individual
- Descripción con días del año actual y total histórico

### Vista PDF (`estudiante-perfil.blade.php`)

#### Información Incluida

- Días de arresto del año actual
- Total histórico de arrestos
- Límite anual configurado

### Widget de Estadísticas (`EstadisticasArrestosWidget.php`)

#### Nuevas Métricas

- Arrestos del año actual
- Estudiantes superando el límite del año
- Estadísticas comparativas

## Comando Artisan

### Comando de Reseteo y Estadísticas

```bash
# Ver estadísticas del año actual
php artisan arrestos:reset-anual

# Ver estadísticas de un año específico
php artisan arrestos:reset-anual --anio=2024
```

#### Información Mostrada

- Total de días de arresto por año
- Estudiantes con arrestos por año
- Estudiantes superando el límite por año
- Total histórico de arrestos
- Resumen del funcionamiento del sistema

## Ejemplos de Uso

### 1. Verificar Estado de un Estudiante

```php
$estudiante = Estudiantes::find(1);

// Días del año actual
$diasActual = $estudiante->getDiasArrestoAnioActual();

// Total histórico
$totalHistorico = $estudiante->getTotalHistoricoArrestos();

// Verificar si superó el límite este año
$superaLimite = $estudiante->superaLimiteArrestosAnioActual();
```

### 2. Obtener Estadísticas por Año

```php
// Días acumulados en 2024
$dias2024 = Arrestos::getDiasAcumuladosPorAnio($estudianteId, 2024);

// Verificar si superó límite en 2024
$supero2024 = Arrestos::superaLimiteEnAnio($estudianteId, 2024);
```

### 3. Filtrar Arrestos por Año

```php
// Arrestos de 2024
$arrestos2024 = $estudiante->getArrestosPorAnio(2024);
```

## Ventajas del Nuevo Sistema

1. **Transparencia**: Los usuarios pueden ver claramente el estado del año actual vs. histórico
2. **Flexibilidad**: Se mantiene acceso completo al historial
3. **Automatización**: No requiere intervención manual para el reseteo
4. **Precisión**: Las notificaciones son específicas por año
5. **Escalabilidad**: Fácil de mantener y extender

## Consideraciones Técnicas

- **Performance**: Los cálculos por año son eficientes con índices de base de datos
- **Consistencia**: Todas las vistas muestran la misma información
- **Mantenibilidad**: Código modular y bien documentado
- **Extensibilidad**: Fácil agregar nuevas funcionalidades relacionadas

## Migración y Compatibilidad

- **Sin cambios en BD**: No se requieren migraciones
- **Compatibilidad total**: Funciona con datos existentes
- **Rollback fácil**: Se puede revertir a la lógica anterior si es necesario

## Próximas Mejoras Sugeridas

1. **Dashboard anual**: Vista comparativa de años
2. **Alertas automáticas**: Notificaciones al inicio del año
3. **Reportes anuales**: Exportación de estadísticas por año
4. **Configuración por año**: Límites diferentes por año académico
5. **Auditoría**: Log de cambios en límites y configuraciones
