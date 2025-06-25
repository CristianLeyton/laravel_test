<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faltas;

class FaltasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    //Niveles de faltas
    //1. Leve
    //2. Media
    //3. Grave

    public function run(): void
    {
        //
        $faltas = [
            //Leves
            ['nombre_de_falta' => 'La presentación tarde a sus obligaciones, sin causa justificada, hasta la cuarta reincidencia.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'La negligencia o falta de celo en el cumplimiento de tareas u órdenes.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'La demora en presentarse a un superior, sin causa justificada. ', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'Sentarse en los puestos de guardia, con excepción en los servicios de imaginaria, retén, Jefe de Guardia o auxiliar de guardia.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'La improlijidad o deterioro en materiales de estudios propios o provistos.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'No guardar la debida postura o comportamiento en aula, comedor o dormitorio y la provocación de desorden.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'La pérdida de elementos provistos y de escaso valor.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'La falta de respeto al subalterno o igual y el uso de palabras impropias o inconvenientes con los mismos.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'El juego de manos.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'Hablar y moverse en formación.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'Dormirse en el aula o comedor.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'Sustraerse del aula, dormitorio, comedor o guardia, sin autorización.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'Fumar en cualquier dependencia interior.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'Delegar el mando sin autorización.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'Hacer realizar tareas con quien no corresponde.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'Comer o conversar con desconocidos, durante los servicios de guardia.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'Demostrar poca voluntad o atención durante clases, ejercicios o tareas asignadas.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'La omisión o retardo de dar aviso del cambio de domicilio, dentro de las 24 horas de efectuado, o de cualquier tipo de novedades internas o externas.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'La inobservancia de normas o reglas establecidas para la higiene y limpieza de locales y sectores a su cargo o no. Como asi tambien para el aseo y conservación de uniformes, armamentos, equipos e higiene personal.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'Los actos de los cadetes que los constituyan deudores entre sí.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'El saludo en forma incorrecta o su simple omisión.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'Salir o ingresar de formación sin autorización.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'El préstamo de elementos provistos.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'No prestar la debida atención a superiores, instructores o profesores', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'Excederse en atribuciones de mando.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'La lectura de libros o revistas no autorizados en el Instituto.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'No guardar la debida compostura en formación o puestos de guardia.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'Llamar con apodos o sobrenombres a sus compañeros o usar el tuteo.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'Retirarse del Instituto con autorización superior, pero evitando dar cuenta a sus superiores inmediatos.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'No usar con corrección el uniforme, dentro y fuera del Instituto.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'Realizar sus funciones fisiológicas en lugares no establecidos.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'La demora o el relevo incorrecto en los puestos de guardia, como así la incorrecta presentación al Superior.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'El olvido de credenciales, uniformes, equipos, elementos provistos, etc. en el domicilio.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'Asistir reuniones públicas no acordes a la ética penitenciaria o comprometedores para su condición de cadete.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'La inobservancia de reglas de urbanidad o sociales, o el uso de palabras o actitudes reñidas con las buenas costumbres.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'Tener la barba o el cabello en forma antirreglamentaria.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'No observar la vía jerárquica para dirigirse a un superior.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'Las observaciones, murmuraciones o inobservancia a las órdenes impartidas por un Superior jerárquico.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'Tener en el Instituto elementos no autorizados.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'No mantener la disciplina y el orden en cadetes subalternos y no informar las faltas cometidas por éstos.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'Tomarse atribuciones que no correspondan, utilizar cadetes en funciones ajenas al servicio u ordenar movimientos no autorizados y sin conocimiento del Oficial de Semana.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'El retardo en dar cuenta a sus superiores de enfermedades contagiosas o en el uso de la Carpeta Médica.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'El retardo en dar cuenta a sus superiores de cualquier hecho o circunstancias que puedan perjudicar o tener relación con el Instituto.', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'Toda transgresión a las normas para el funcionamiento interno y todas aquellas que a su graduación, el superior considere necesario la aplicación de sanciones.', 'niveles_de_faltas_id' => 1],

            //Graves
            ['nombre_de_falta' => 'La segunda reincidencia a las faltas leves previstas en el articulo anterior.', 'niveles_de_faltas_id' => 2],
            ['nombre_de_falta' => 'Fumar o dormir en el puesto de guardia.', 'niveles_de_faltas_id' => 2],
            ['nombre_de_falta' => 'Efectuar un cambio de guardia sin autorización superior.', 'niveles_de_faltas_id' => 2],
            ['nombre_de_falta' => 'Abandonar el establecimiento sin autorización.', 'niveles_de_faltas_id' => 2],
            ['nombre_de_falta' => 'Deteriorar por falta de cuidado o celo, los muebles o inmuebles del Instituto, estén o no a cargo.', 'niveles_de_faltas_id' => 2],
            ['nombre_de_falta' => 'Las observaciones indebidas a los superiores en los asuntos o no del servicio, la murmuración a ello o la inducción en error o engaño a los mismos, con informes o versiones que sean inexactas.', 'niveles_de_faltas_id' => 2],
            ['nombre_de_falta' => 'Entrevista o solicitud de beneficios a superiores sin autorización o sin tener en cuenta la escala jerárquica para el correspondiente pedido de venias.', 'niveles_de_faltas_id' => 2],
            ['nombre_de_falta' => 'La falta de respeto o uso de palabras inconvenientes con particulares.', 'niveles_de_faltas_id' => 2],
            ['nombre_de_falta' => 'No guardar en presencia del superior la debida compostura.', 'niveles_de_faltas_id' => 2],
            ['nombre_de_falta' => 'El ingreso en bares, fondas o bailes públicos a beber o divertirse sin guardar la debida compostura.', 'niveles_de_faltas_id' => 2],
            ['nombre_de_falta' => 'La prueba de debilidad moral en actos del servicio.', 'niveles_de_faltas_id' => 2],
            ['nombre_de_falta' => 'Tener en su poder elementos provistos a un compañero, siempre que no constituya delito.', 'niveles_de_faltas_id' => 2],
            ['nombre_de_falta' => 'Las impuntualidades a sus obligaciones desde la quinta a la novena reincidencia.', 'niveles_de_faltas_id' => 2],
            ['nombre_de_falta' => 'Introducir al Instituto cualquier tipo de bebidas alcohólicas o videos no autorizados.', 'niveles_de_faltas_id' => 2],
            ['nombre_de_falta' => 'Hacer comentario desfavorables respecto de la Escuela o Institución Penitenciaria en medios de transporte o vía pública.', 'niveles_de_faltas_id' => 2],
            ['nombre_de_falta' => 'Cualquier acto de indisciplina que provoque el incumplimiento de normas internas, escritas o implícitas.', 'niveles_de_faltas_id' => 2],
            ['nombre_de_falta' => 'Extravio de credenciales, prendas del uniforme o elementos provistos a cargo.', 'niveles_de_faltas_id' => 2],
            ['nombre_de_falta' => 'Participar en riña con trascendencia pública.', 'niveles_de_faltas_id' => 2],
            ['nombre_de_falta' => 'Participar en actividades políticas.', 'niveles_de_faltas_id' => 2],
            ['nombre_de_falta' => 'No asistir sin causa justificada a cumplir una sanción cuando estaba debidamente notificado para hacerlo.', 'niveles_de_faltas_id' => 2],

            //Muy graves
            ['nombre_de_falta' => 'La segunda reincidencia de faltas enumeradas en el articulo anterior. (Faltas graves) ', 'niveles_de_faltas_id' => 3],
            ['nombre_de_falta' => 'La impuntualidad a sus obligaciones desde la décima a la décimo quinta reincidencia.', 'niveles_de_faltas_id' => 3],
            ['nombre_de_falta' => 'La tercera reincidencia de las faltas enumeradas en las faltas leves.', 'niveles_de_faltas_id' => 3],
            ['nombre_de_falta' => 'Faltar a la consideración a un superior.', 'niveles_de_faltas_id' => 3],
            ['nombre_de_falta' => 'Dormirse o abandonar el puesto de guardia.', 'niveles_de_faltas_id' => 3],
            ['nombre_de_falta' => 'La riña o pelea entre Cadetes.', 'niveles_de_faltas_id' => 3],
            ['nombre_de_falta' => 'Cometer una falta disciplinaria que a criterio del superior comprometa el orden, prestigio o régimen general de la Escuela.', 'niveles_de_faltas_id' => 3],
            ['nombre_de_falta' => 'La presentación, sin causa justificada, a cualquier servicio con una demora superior a las 24 horas.', 'niveles_de_faltas_id' => 3],
            ['nombre_de_falta' => 'La ebriedad o cualquier otra intoxicación.', 'niveles_de_faltas_id' => 3],
            ['nombre_de_falta' => 'El quebrantamiento de arresto.', 'niveles_de_faltas_id' => 3],
            ['nombre_de_falta' => 'La falta de respeto al superior y la desobediencia a sus órdenes.', 'niveles_de_faltas_id' => 3],
            ['nombre_de_falta' => 'El uso incorrecto o innecesario del armamento.', 'niveles_de_faltas_id' => 3],
            ['nombre_de_falta' => 'El préstamo a particulares de distintivos, piezas del uniforme, armamento o equipo provistos.', 'niveles_de_faltas_id' => 3],
            ['nombre_de_falta' => 'El pedido de propinas, indemnizaciones, etc. por servicios prestados en el desempeño de sus funciones o a consecuencia de ellas.', 'niveles_de_faltas_id' => 3],
            ['nombre_de_falta' => 'La demostración de relaciones afectivas o sentimentales entre Cadetes, que provoquen dentro del Instituto acciones que puedan alterar el presente régimen disciplinario, o que a consecuencia de ellas se incurran en faltas civiles o penales.', 'niveles_de_faltas_id' => 3],
            ['nombre_de_falta' => 'Acumular tres inasistencias continuas o cinco discontinuas, no justificadas durante el Ciclo Lectivo.', 'niveles_de_faltas_id' => 3],
            ['nombre_de_falta' => 'Toda situación no prevista en el presente reglamento, será resuelta por la Dirección del Instituto, quien de acuerdo a la importancia del hecho dará participación a sus superiores para la resolución de la misma.', 'niveles_de_faltas_id' => 3],
        ];

        foreach ($faltas as $falta) {
            Faltas::create($falta);
        }
    }
}
