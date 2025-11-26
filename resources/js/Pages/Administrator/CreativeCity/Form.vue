<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

const Swal = window.Swal;

const props = defineProps({
    creativeCity: Object,
});

const form = useForm({
    name: props.creativeCity?.name || "",
    description: props.creativeCity?.description || "",
    specialty: props.creativeCity?.specialty || "",
    region: props.creativeCity?.region || "",
    latitude: props.creativeCity?.latitude || "",
    longitude: props.creativeCity?.longitude || "",
    photo_path: null,
});

function submitForm() {
    if (props.creativeCity && props.creativeCity.id) {
        // TRUCO PARA ARCHIVOS EN EDICIÓN:
        // Usamos POST pero enviamos _method: 'put' para que Laravel entienda que es una actualización
        // y pueda leer el archivo correctamente.
        form.transform((data) => ({
            ...data,
            _method: 'put',
        })).post(route("creative_cities.update", props.creativeCity.id), {
            forceFormData: true, // Obligatorio para archivos
            onSuccess: () => {
                Swal.fire({
                    title: "¡Actualizado!",
                    text: "La ciudad creativa ha sido actualizada con éxito.",
                    icon: "success",
                    confirmButtonText: "Aceptar",
                    confirmButtonColor: "#702b21",
                });
            },
        });
    } else {
        // Crear nueva (POST normal)
        form.post(route("creative_cities.store"), {
            forceFormData: true,
            onSuccess: () => {
                Swal.fire({
                    title: "¡Creado!",
                    text: "La ciudad creativa ha sido creada con éxito.",
                    icon: "success",
                    confirmButtonText: "Aceptar",
                    confirmButtonColor: "#702b21",
                });
            },
        });
    }
}

// Función para capturar el archivo
function handleFileUpload(event) {
    form.photo_path = event.target.files[0];
}
</script>

<template>
    <div class="content">
        <form @submit.prevent="submitForm" class="form">
            <div class="items">
                <label for="name" class="form-label">Nombre</label>
                <input
                    type="text"
                    id="name"
                    v-model="form.name"
                    class="form-input"
                    placeholder="Ingrese la ciudad creativa"
                    :class="{ errors: form.errors.name }"
                />
                <div v-if="form.errors.name" class="errors">
                    {{ form.errors.name }}
                </div>
            </div>

            <div class="items">
                <label for="description" class="form-label">Descripción</label>
                <input
                    id="description"
                    v-model="form.description"
                    class="form-textarea"
                    placeholder="Ingrese la descripción"
                    :class="{ errors: form.errors.description }"
                ></input>
                <div v-if="form.errors.description" class="errors">
                    {{ form.errors.description }}
                </div>
            </div>

            <div class="items">
                <label for="specialty" class="form-label">Especialidad</label>
                <input
                    id="specialty"
                    v-model="form.specialty"
                    class="form-input"
                    placeholder="Ingrese la especialidad"
                    :class="{ errors: form.errors.specialty }"
                />
                <div v-if="form.errors.specialty" class="errors">
                    {{ form.errors.specialty }}
                </div>
            </div>

            <div class="items">
                <label for="region" class="form-label">Región</label>
                <input
                    id="region"
                    v-model="form.region"
                    class="form-input"
                    placeholder="Ingrese la región"
                    :class="{ errors: form.errors.region }"
                />
                <div v-if="form.errors.region" class="errors">
                    {{ form.errors.region }}
                </div>
            </div>

            <div class="items">
                <label for="latitude" class="form-label">Latitud</label>
                <input
                    id="latitude"
                    v-model="form.latitude"
                    class="form-input"
                    placeholder="Ingrese la latitud"
                    :class="{ errors: form.errors.latitude }"
                />
                <div v-if="form.errors.latitude" class="errors">
                    {{ form.errors.latitude }}
                </div>
            </div>

            <div class="items">
                <label for="longitude" class="form-label">Longitud</label>
                <input
                    id="longitude"
                    v-model="form.longitude"
                    class="form-input"
                    placeholder="Ingrese la longitud"
                    :class="{ errors: form.errors.longitude }"
                />
                <div v-if="form.errors.longitude" class="errors">
                    {{ form.errors.longitude }}
                </div>
            </div>
            <div class="items">
                <label for="photo_path" class="form-label">Ruta de la Foto</label>
                <!-- CORRECCIÓN AQUÍ: Quitamos v-model y usamos @change -->
                <input
                    id="photo_path"
                    type="file"
                    accept=".jpg,.png,.pdf"
                    @change="handleFileUpload"
                    class="form-input"
                    :class="{ errors: form.errors.photo_path }"
                />
                <div v-if="form.errors.photo_path" class="errors">
                    {{ form.errors.photo_path }}
                </div>
                <!-- Opcional: Mostrar barra de progreso -->
                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                    {{ form.progress.percentage }}%
                </progress>
            </div>

            <div class="container-button">
                <button
                    type="submit"
                    class="btn-class"
                    :disabled="form.processing"
                >
                    {{ props.creativeCity ? "Actualizar ciudad creativa" : "Crear ciudad creativa" }}
                </button>
            </div>
        </form>
    </div>
</template>
