<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

// SweetAlert desde el CDN
const Swal = window.Swal;

const props = defineProps({
    productMaterial: Object, // Recibe el producto a editar
});

const form = useForm({
    name: props.productMaterial?.name || "", // Carga el nombre si existe
    description: props.productMaterial?.description || "", // Carga la descripción si existe
});

function submitForm() {
    if (props.productMaterial && props.productMaterial.id) {
        // Actualizar material existente
        form.put(route("product_materials.update", props.productMaterial.id), {
            onSuccess: () => {
                Swal.fire({
                    title: "¡Actualizado!",
                    text: "El material ha sido actualizado con éxito.",
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
        // Crear nuevo material
        form.post(route("product_materials.store"), {
            onSuccess: () => {
                Swal.fire({
                    title: "¡Creado!",
                    text: "El material ha sido creado con éxito.",
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
                    placeholder="Ingrese el material"
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
                    {{ props.productMaterial ? "Actualizar material" : "Crear material" }}
                </button>
            </div>
        </form>
    </div>
</template>
