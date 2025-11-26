<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

// SweetAlert desde el CDN
const Swal = window.Swal;

const props = defineProps({
    creativeCity: Object, // Recibe la ciudad creativa a editar
});

const form = useForm({
    name: props.creativeCity?.name || "", // Carga el nombre si existe
    description: props.creativeCity?.description || "", // Carga la descripción si existe
    specialty: props.creativeCity?.specialty || "", // Carga la especialidad si existe
    region: props.creativeCity?.region || "", // Carga la región si existe
    latitude: props.creativeCity?.latitude || "", // Carga la latitud si existe
    longitude: props.creativeCity?.longitude || "", // Carga la longitud si existe

});

function submitForm() {
    if (props.creativeCity && props.creativeCity.id) {
        // Actualizar ciudad creativa existente
        form.put(route("creative_cities.update", props.creativeCity.id), {
            onSuccess: () => {
                Swal.fire({
                    title: "¡Actualizado!",
                    text: "La ciudad creativa ha sido actualizada con éxito.",
                    icon: "success",
                    confirmButtonText: "Aceptar",
                    confirmButtonColor: "#702b21",
                    customClass: {
                        title: "title-swal",
                        text: "text-swal",
                        popup: "popup-swal",
                        confirmButton: "confirm-button-swal",
                    },
                });
            },
        });
    } else {
        // Crear nueva etiqueta
        form.post(route("creative_cities.store"), {
            onSuccess: () => {
                Swal.fire({
                    title: "¡Creado!",
                    text: "La ciudad creativa ha sido creada con éxito.",
                    icon: "success",
                    confirmButtonText: "Aceptar",
                    confirmButtonColor: "#702b21",
                    customClass: {
                        title: "title-swal",
                        text: "text-swal",
                        popup: "popup-swal",
                        confirmButton: "confirm-button-swal",
                    },
                });
            },
        });
    }
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
