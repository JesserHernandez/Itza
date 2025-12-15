<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

// SweetAlert desde el CDN
const Swal = window.Swal;

const props = defineProps({
    creative_circuit: Object, 
    creative_city: Array 
});

const form = useForm({
    name: props.creative_circuit?.name || "", 
    description: props.creative_circuit?.description || "", 
    photo_path: props.creative_circuit?.photo_path || "", 
    creative_city_id: props.creative_circuit?.creative_city_id || "" 
});

const hasNewImage = ref(false);

function handleImageChange(event) {
    const file = event.target.files[0];
    if (file) {
        form.photo_path = file;
        hasNewImage.value = true;
    }
}

function submitForm() {
    
    if (props.creative_circuit && props.creative_circuit.id) {
        // Actualizar ciudad creativa existente
        form.transform((data) => {
            const formData = new FormData();
            
            formData.append("name", data.name);
            formData.append("description", data.description);
            formData.append("creative_city_id", data.creative_city_id);
            if (hasNewImage.value) {
                formData.append("photo_path", data.photo_path);
            }

            formData.append("_method", "PUT");
            return formData;
        })
        .post(route("creative_circuits.update", props.creative_circuit.id), {
            preserveScroll: true,
            onSuccess: () => {
                Swal.fire({
                    title: "¡Actualizado!",
                    text: "El circuito creativo ha sido actualizado con éxito.", // Corrected text context
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
            preserveScroll: true,
            onSuccess: () => {
                Swal.fire({
                    title: "¡Creado!",
                    text: "El circuito creativo ha sido creado con éxito.", // Corrected text context
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
                <label for="photo_path" class="form-label">Foto</label>
                <input
                    type="file"
                    accept=".jpg, .png, .jpeg, .svg"
                    id="photo_path"
                    @change="handleImageChange"
                    class="form-input"
                    :class="{ errors: form.errors.photo_path }"
                />
                <div v-if="form.errors.photo_path" class="errors">
                    {{ form.errors.photo_path }}
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
                        v-for="city in creative_city"
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
                    {{ props.creative_circuit ? "Actualizar circuito" : "Crear circuito" }}
                </button>
            </div>
        </form>
    </div>
</template>
