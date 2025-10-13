<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const Swal = window.Swal;

const form = useForm({
    name: "",
    code: "",
    technique: "",
    cultural_origin: "",
    dimensions: "",
    color: "",
    shape: "",
    history: "",
    status: "",
    physical_location: "",
    creator: "",
    creation_date: "",
    price: "",
    is_active: true,
    materials: [],
    tags: [],
    categories: [],
    photo_paths: [],
});

// Datos provienientes de otras tablas
defineProps({
    categories: Array,
    materials: Array,
    tags: Array,
});

function submit() {
    form.post(route("products.store"), {
        forceFormData: true,
        onSuccess: () => {
            Swal.fire({
                title: "¡Creado!",
                text: "El producto ha sido creado con éxito.",
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

const preview = ref([]); // Array para almacenar las URLs de vista previa

function previewImage(event) {
    const files = event.target.files;

    // Convierte los archivos seleccionados en un array y los acumula en form.photo_paths
    Array.from(files).forEach((file) => {
        // Verifica si el archivo ya existe en el array para evitar duplicados
        if (!form.photo_paths.some((existingFile) => existingFile.name === file.name)) {
            form.photo_paths.push(file);

            // Genera la vista previa
            const reader = new FileReader();
            reader.onload = (event) => {
                preview.value.push({
                    url: event.target.result,
                    name: file.name,
                    type: file.type,
                });
            };
            reader.readAsDataURL(file);
        }
    });
}
</script>

<template>
    <Head title="Crear Producto" />
    <AppLayout :href="route('products.index')">
        <div class="content">
            <form class="form" @submit.prevent="submit">
                <div class="items photo_paths">
                    <div class="add-image">
                        <InputLabel
                            value="Imagen/Producto"
                            textAdd=" *"
                            for="photo"
                            class="label"
                        />
                        <input
                            type="file"
                            multiple
                            id="photo"
                            accept=".jpg,.png,.pdf"
                            class="input_photo"
                            @change="previewImage"
                            :class="{ errors: form.errors.photo_paths }"
                        />
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                        >
                            <path
                                d="M2.50678 4.00782C1.60124 4.58285 1 5.59621 1 6.75V17.25C1 20.1495 3.35051 22.5 6.25 22.5H16.75C17.9038 22.5 18.9172 21.8988 19.4939 20.9925L19.3717 20.9982L19.25 21H6.25C4.17893 21 2.5 19.3211 2.5 17.25V4.25C2.5 4.16872 2.50228 4.08798 2.50678 4.00782ZM6.75 1C4.95507 1 3.5 2.45507 3.5 4.25V16.75C3.5 18.5449 4.95507 20 6.75 20H19.25C21.0449 20 22.5 18.5449 22.5 16.75V4.25C22.5 2.45507 21.0449 1 19.25 1H6.75ZM6.16845 18.4011L12.4754 12.2231C12.7405 11.9635 13.1501 11.9399 13.4414 12.1523L13.525 12.2231L19.8315 18.4011C19.6496 18.4651 19.4539 18.5 19.25 18.5H6.75C6.54613 18.5 6.3504 18.4651 6.16845 18.4011ZM6.75 2.5H19.25C20.2165 2.5 21 3.2835 21 4.25V16.75C21 16.958 20.9637 17.1576 20.8971 17.3427L14.5746 11.1515C13.7415 10.3355 12.4327 10.2967 11.5543 11.0349L11.4259 11.1515L5.10326 17.3437C5.03643 17.1583 5 16.9584 5 16.75V4.25C5 3.2835 5.7835 2.5 6.75 2.5ZM9.49955 5.75116C8.80959 5.75116 8.25026 6.31048 8.25026 7.00045C8.25026 7.69041 8.80959 8.24974 9.49955 8.24974C10.1895 8.24974 10.7488 7.69041 10.7488 7.00045C10.7488 6.31048 10.1895 5.75116 9.49955 5.75116Z"
                                fill="#702B21"
                            />
                        </svg>
                        <p class="p">Haga click para subir sus imágenes</p>
                        <small>Maximo subir 5MB de formato jpg o png</small>
                    </div>
                    <div class="view-image">
                        <div
                            v-for="(img, index) in preview"
                            :key="index"
                            class="container-image"
                        >
                            <img :src="img.url" :alt="img.name" class="image" />
                            <span class="name-image">{{ img.name }}</span>
                        </div>
                        <span v-if="form.errors.photo_paths" class="errors">
                            {{ form.errors.photo_paths }}
                        </span>
                    </div>
                </div>
                <div class="items">
                    <InputLabel value="Nombre/Producto" textAdd=" *" />
                    <TextInput
                        type="text"
                        required
                        v-model="form.name"
                        :class="{ errors: form.errors.name }"
                    />
                    <span v-if="form.errors.name" class="errors">
                        {{ form.errors.name }}
                    </span>
                </div>
                <div class="items">
                    <InputLabel value="Código/Producto" textAdd=" *" />
                    <TextInput
                        type="text"
                        required
                        v-model="form.code"
                        :class="{ errors: form.errors.code }"
                    />
                    <span v-if="form.errors.code" class="errors">
                        {{ form.errors.code }}
                    </span>
                </div>
                <div class="items">
                    <InputLabel value="Técnica/Producto " textAdd=" *" />
                    <TextInput
                        type="text"
                        v-model="form.technique"
                        :class="{ errors: form.errors.technique }"
                    />
                    <span v-if="form.errors.technique" class="errors">
                        {{ form.errors.technique }}
                    </span>
                </div>
                <div class="items">
                    <InputLabel value="Origen cultural/Producto" textAdd=" *" />
                    <TextInput
                        type="text"
                        v-model="form.cultural_origin"
                        :class="{ errors: form.errors.cultural_origin }"
                    />
                    <span v-if="form.errors.cultural_origin" class="errors">
                        {{ form.errors.cultural_origin }}
                    </span>
                </div>
                <div class="items">
                    <InputLabel value="Dimensiones/Producto" textAdd=" *" />
                    <TextInput
                        type="text"
                        required
                        v-model="form.dimensions"
                        :class="{ errors: form.errors.dimensions }"
                    />
                    <span v-if="form.errors.dimensions" class="errors">
                        {{ form.errors.dimensions }}
                    </span>
                </div>
                <div class="items">
                    <InputLabel value="Color/Producto" textAdd=" *" />
                    <TextInput
                        type="text"
                        required
                        v-model="form.color"
                        :class="{ errors: form.errors.color }"
                    />
                    <span v-if="form.errors.color" class="errors">
                        {{ form.errors.color }}
                    </span>
                </div>
                <div class="items">
                    <InputLabel value="Forma/Producto" textAdd=" *" />
                    <TextInput
                        type="text"
                        required
                        v-model="form.shape"
                        :class="{ errors: form.errors.shape }"
                    />
                    <span v-if="form.errors.shape" class="errors">
                        {{ form.errors.shape }}
                    </span>
                </div>
                <div class="items">
                    <InputLabel value="Historia/Producto" textAdd=" *" />
                    <TextInput
                        type="text"
                        required
                        v-model="form.history"
                        :class="{ errors: form.errors.history }"
                    />
                    <span v-if="form.errors.history" class="errors">
                        {{ form.errors.history }}
                    </span>
                </div>
                <div class="items">
                    <InputLabel value="Estado/Producto" textAdd=" *" />
                    <TextInput
                        type="text"
                        required
                        v-model="form.status"
                        :class="{ errors: form.errors.status }"
                    />
                    <span v-if="form.errors.status" class="errors">
                        {{ form.errors.status }}
                    </span>
                </div>
                <div class="items">
                    <InputLabel
                        value="Ubicación física/Producto"
                        textAdd=" *"
                    />
                    <TextInput
                        type="text"
                        v-model="form.physical_location"
                        :class="{ errors: form.errors.physical_location }"
                    />
                    <span v-if="form.errors.physical_location" class="errors">
                        {{ form.errors.physical_location }}
                    </span>
                </div>
                <div class="items">
                    <InputLabel value="Creador/Producto" textAdd=" *" />
                    <TextInput
                        type="text"
                        v-model="form.creator"
                        :class="{ errors: form.errors.creator }"
                    />
                    <span v-if="form.errors.creator" class="errors">
                        {{ form.errors.creator }}
                    </span>
                </div>
                <div class="items">
                    <InputLabel
                        value="Fecha de creación/Producto"
                        textAdd=" *"
                    />
                    <TextInput
                        type="date"
                        required
                        v-model="form.creation_date"
                        :class="{ errors: form.errors.creation_date }"
                    />
                    <span v-if="form.errors.creation_date" class="errors">
                        {{ form.errors.creation_date }}
                    </span>
                </div>
                <div class="items">
                    <InputLabel value="Precio/Producto" textAdd=" *" />
                    <TextInput
                        type="number"
                        required
                        v-model="form.price"
                        :class="{ errors: form.errors.price }"
                    />
                    <span v-if="form.errors.price" class="errors">
                        {{ form.errors.price }}
                    </span>
                </div>
                <div class="items">
                    <InputLabel value="Disponibilidad" textAdd=" *" />
                    <select
                        name="is_active"
                        id="is_active"
                        v-model="form.is_active"
                    >
                        <option value="true">Activo</option>
                        <option value="false">Inactivo</option>
                    </select>
                </div>

                <div class="items">
                    <InputLabel value="Categorías" textAdd=" *" />
                    <select
                        name="categories"
                        v-model="form.categories"
                        multiple
                        :class="{ errors: form.errors.categories }"
                    >
                        <option
                            v-for="category in categories"
                            :key="category.id"
                            :value="category.id"
                        >
                            {{ category.name }}
                        </option>
                    </select>
                    <span v-if="form.errors.categories" class="errors">
                        {{ form.errors.categories }}
                    </span>
                </div>

                <div class="items">
                    <InputLabel value="Materiales" textAdd=" *" />
                    <select
                        name="materials"
                        v-model="form.materials"
                        multiple
                        :class="{ errors: form.errors.materials_ids }"
                    >
                        <option
                            v-for="material in materials"
                            :key="material.id"
                            :value="material.id"
                        >
                            {{ material.name }}
                        </option>
                    </select>
                    <span v-if="form.errors.materials_ids" class="errors">
                        {{ form.errors.materials_ids }}
                    </span>
                </div>

                <div class="items">
                    <InputLabel value="Tags" textAdd=" *" />
                    <select
                        name="tags"
                        v-model="form.tags"
                        multiple
                        :class="{ errors: form.errors.tags_ids }"
                    >
                        <option
                            v-for="tag in tags"
                            :key="tag.id"
                            :value="tag.id"
                        >
                            {{ tag.name }}
                        </option>
                    </select>
                    <span v-if="form.errors.tags_ids" class="errors">
                        {{ form.errors.tags_ids }}
                    </span>
                </div>
                <div class="container-button">
                    <button
                        type="submit"
                        class="btn-class"
                        :disabled="form.processing"
                    >
                        Crear Producto
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
