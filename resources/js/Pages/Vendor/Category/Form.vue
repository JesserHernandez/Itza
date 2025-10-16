<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

// SweetAlert desde el CDN
const Swal = window.Swal;

const props = defineProps({
    category: Object, // Recibe la categoría a editar
});

const form = useForm({
    name: props.category?.name || "", // Carga el nombre si existe
    description: props.category?.description || "", // Carga la descripción si existe
});

function submitForm() {
    if (props.category && props.category.id) {
        // Actualizar categoría existente
        form.put(route("categories.update", props.category.id), {
            onSuccess: () => {
                Swal.fire({
                    title: "¡Actualizado!",
                    text: "La categoría ha sido actualizada con éxito.",
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
        // Crear nueva categoría
        form.post(route("categories.store"), {
            onSuccess: () => {
                Swal.fire({
                    title: "¡Creado!",
                    text: "La categoría ha sido creada con éxito.",
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
    <div class="container-form">
        <form @submit.prevent="submitForm" class="form">
            <div class="items-form">
                <label for="name" class="form-label">Nombre</label>
                <input
                    type="text"
                    id="name"
                    v-model="form.name"
                    class="form-input"
                    placeholder="Ingrese la categoría"
                    :class="{ errors: form.errors.name }"
                />
                <div v-if="form.errors.name" class="errors">
                    {{ form.errors.name }}
                </div>
            </div>

            <div class="items-form">
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

            <div class="container-button">
                <button
                    type="submit"
                    class="btn-class"
                    :disabled="form.processing"
                >
                    {{ props.category ? "Actualizar categoría" : "Crear categoría" }}
                </button>
            </div>
        </form>
    </div>
</template>
