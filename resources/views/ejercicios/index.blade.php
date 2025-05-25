@extends('layouts.app')

@section('content')
<div id="app" class="container">
    <h2 class="mb-4">Contenido de la Lección: {{ $leccion->titulo }}</h2>
    <!-- Botón volver al inicio -->
    <div class="mb-3">
        <a href="{{ route('inicio') }}" class="btn btn-secondary">
            <i class="bi bi-house"></i> Volver al inicio
        </a>
    </div>
    <div class="mb-3" v-if="hayEjercicios && hayTeoria">
        <button class="btn btn-secondary me-2" @click="vista = 'teoria'">Ver Teoría</button>
        <button class="btn btn-primary" @click="vista = 'ejercicios'">Ver Ejercicios</button>
    </div>

    <!-- Vista Teoría -->
    <div v-if="vista === 'teoria'">
        <div class="alert alert-info mb-4">
            <h4>Teoría de la Lección</h4>
            <p>{!! $leccion->descripcion ?? 'Contenido.' !!}</p>
        </div>
        <div v-if="teoria.length">
            <div v-for="ejercicio in teoria" :key="ejercicio.id_ejercicio" class="mb-3 border rounded p-3">
                <h5>@{{ ejercicio.pregunta }}</h5>
                <img v-if="ejercicio.imagen" :src="ejercicio.imagen" alt="Imagen de teoría" class="img-fluid mb-2" style="max-width: 400px;">
            </div>
        </div>
    </div>

    <!-- Vista Ejercicios -->
    <div v-if="vista === 'ejercicios'">
        <div v-if="ejercicios.length > 0">
            <div v-for="(ejercicio, index) in ejercicios" :key="ejercicio.id_ejercicio" class="mb-4 border rounded p-3">

                <h5>Ejercicio @{{ index + 1 }}</h5>

                <p><strong>@{{ ejercicio.pregunta }}</strong></p>

                <img v-if="ejercicio.imagen" :src="ejercicio.imagen" alt="Imagen de la pregunta" class="img-fluid mb-3" style="max-width: 400px;">

                <div v-if="ejercicio.opciones && ejercicio.opciones.length > 0">
                    <div v-for="opcion in ejercicio.opciones" :key="opcion.label" class="form-check mb-2">
                        <input
                            class="form-check-input"
                            type="radio"
                            :name="'respuesta_' + index"
                            :id="'opcion_' + index + '_' + opcion.label"
                            :value="opcion.label"
                            v-model="respuestas[index]"
                            :disabled="verificados[index]"
                        >
                        <label class="form-check-label d-flex align-items-center" :for="'opcion_' + index + '_' + opcion.label">
                            <img v-if="opcion.imagen" :src="opcion.imagen" :alt="'Opción ' + opcion.label" class="img-thumbnail me-2" width="100">
                            @{{ opcion.label }}
                        </label>
                    </div>

                    <button class="btn btn-sm btn-primary mt-2" @click="verificarRespuesta(index, ejercicio)" :disabled="verificados[index]">Verificar</button>

                    <div v-if="verificados[index]">
                        <p class="mt-2" :class="resultados[index] ? 'text-success' : 'text-danger'">
                            <span v-if="resultados[index]">✅ Correcto</span>
                            <span v-else>❌ Incorrecto. La correcta era: @{{ ejercicio.respuesta_correcta }}</span>
                        </p>
                    </div>
                </div>
                <div v-else>
                    <p class="text-warning">Este ejercicio no tiene opciones disponibles.</p>
                </div>
            </div>

            <div class="alert alert-info mt-4">
                Has respondido correctamente @{{ totalCorrectas }} de @{{ ejercicios.length }} ejercicios 🎉
            </div>
        </div>
        <div v-else>
            <p class="text-muted">No hay ejercicios disponibles para esta lección.</p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Axios debe ir PRIMERO -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
const { createApp } = Vue

createApp({
    data() {
        // Cargamos todos los registros de la BD, pueden ser ejercicios o teoría
        const ejerciciosBD = @json($ejercicios);

        // Separar ejercicios de teoría (opciones null o vacío => teoría)
        const ejercicios = ejerciciosBD.filter(e => Array.isArray(e.opciones) && e.opciones.length > 0 && e.opciones.some(o => o.label !== null));
        const teoria = ejerciciosBD.filter(e => !e.opciones || e.opciones.length === 0 || e.opciones.every(o => o.label === null));

        return {
            ejercicios,
            teoria,
            respuestas: [],
            verificados: [],
            resultados: [],
            vista: ejercicios.length > 0 ? 'ejercicios' : 'teoria',
        }
    },
    computed: {
        totalCorrectas() {
            return this.resultados.filter(r => r).length;
        },
        hayEjercicios() {
            return this.ejercicios.length > 0;
        },
        hayTeoria() {
            return this.teoria.length > 0;
        }
    },
    methods: {
        verificarRespuesta(index, ejercicio) {
            this.verificados[index] = true;
            const esCorrecta = this.respuestas[index] === ejercicio.respuesta_correcta;
            this.resultados[index] = esCorrecta;

            // Solo sumar progreso si la respuesta es correcta
            if (esCorrecta) {
                axios.post('/progreso-usuario/sumar', {
                    id_leccion_actual: ejercicio.id_leccion // Asegúrate de tener este campo
                })
                .then(response => {
                    // Puedes mostrar un mensaje, actualizar un contador, etc.
                })
                .catch(error => {
                    // Maneja el error si ocurre
                    console.error('Error guardando el progreso:', error);
                });
            }
        }
    }
}).mount('#app')
</script>
@endsection
