@extends('layouts.app')

@section('content')
<div id="app" class="container">
    <h2 class="mb-4">Contenido de la Lección: {{ $leccion->titulo }}</h2>

    <div v-if="ejercicios.length > 0">
        <div v-for="(ejercicio, index) in ejercicios" :key="ejercicio.id_ejercicio" class="mb-4 border rounded p-3">

            <h5>Ejercicio @{{ index + 1 }}</h5>

            <p><strong>@{{ ejercicio.pregunta }}</strong></p>

            <!-- Imagen de la pregunta -->
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
                        <!-- Imagen de la opción -->
                        <img v-if="opcion.imagen" :src="opcion.imagen" :alt="'Opción ' + opcion.label" class="img-thumbnail me-2" width="100">
                        @{{ opcion.label }}
                    </label>
                </div>

                <button class="btn btn-sm btn-primary mt-2" @click="verificarRespuesta(index, ejercicio)">Verificar</button>

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
@endsection

@section('scripts')
<script>
const { createApp } = Vue

createApp({
    data() {
        return {
            ejercicios: @json($ejercicios),
            respuestas: [],
            verificados: [],
            resultados: [],
        }
    },
    computed: {
        totalCorrectas() {
            return this.resultados.filter(r => r).length;
        }
    },
    methods: {
        verificarRespuesta(index, ejercicio) {
            this.verificados[index] = true;
            this.resultados[index] = this.respuestas[index] === ejercicio.respuesta_correcta;
        }
    }
}).mount('#app')
</script>
@endsection
