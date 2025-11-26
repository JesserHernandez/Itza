<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

// SweetAlert desde el CDN
const Swal = window.Swal;

const props = defineProps({
    creativeCircuit: Object, // Recibe la ciudad creativa a editar
    creativeCities: Object // Recibe la ciudad creativa a la que pertenece
});

const form = useForm({
    name: props.creativeCircuit?.name || "", // Carga el nombre si existe
    description: props.creativeCircuit?.description || "", // Carga la descripción si existe
});

function submitForm() {
    if (props.creativeCircuit && props.creativeCircuit.id) {
        // Actualizar ciudad creativa existente
        form.put(route("creative_circuits.update", props.creativeCircuit.id), {
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
        form.post(route("creative_circuits.store"), {
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
                    placeholder="Ingrese el circuito creativo"
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
                <label for="creative_city_id" class="form-label">Ciudad Creativa</label>
                <select
                    id="creative_city_id"
                    v-model="form.creative_city_id"
                    class="form-input"
                    :class="{ errors: form.errors.creative_city_id }"
                >
                    <option value="" disabled>Seleccione una ciudad creativa</option>
                    <option
                        v-for="city in creativeCities"
                        :key="city.id"
                        :value="city.id"
                    >
                        {{ city.name }}
                    </option>
                </select>
                <div v-if="form.errors.creative_city_id" class="errors">
                    {{ form.errors.creative_city_id }}
                </div>
            </div>

            <div class="container-button">
                <button
                    type="submit"
                    class="btn-class"
                    :disabled="form.processing"
                >
                    {{ props.creativeCircuit ? "Actualizar circuito" : "Crear circuito" }}
                </button>
            </div>
        </form>
    </div>
</template>
