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
</script>

<template>
    <Head title="Crear Producto" />
    <AppLayout>
        <div class="content">
            <form class="form" @submit.prevent="submit">
                <div class="items">
                    <InputLabel value="Nombre" textAdd=" *" />
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
                    <InputLabel value="Código" textAdd=" *" />
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
                    <InputLabel value="Técnica" textAdd=" *" />
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
                    <InputLabel value="Cultura de origen" textAdd=" *" />
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
                    <InputLabel value="Dimensiones" textAdd=" *" />
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
                    <InputLabel value="Color" textAdd=" *" />
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
                    <InputLabel value="Forma" textAdd=" *" />
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
                    <InputLabel value="Historia" textAdd=" *" />
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
                    <InputLabel value="Estado" textAdd=" *" />
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
                    <InputLabel value="Ubicación física" textAdd=" *" />
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
                    <InputLabel value="Creador" textAdd=" *" />
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
                    <InputLabel value="Fecha de creación" textAdd=" *" />
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
                    <InputLabel value="Precio" textAdd=" *" />
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
                    <select name="is_active" id="is_active" v-model="form.is_active">
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
                        v-model="form.materials_ids"
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
                        v-model="form.tags_ids"
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

                <div class="items">
                    <InputLabel value="Fotos" textAdd=" *" />
                    <input
                        type="file"
                        multiple
                        @change="e => form.photo_paths = Array.from(e.target.files)"
                        :class="{ errors: form.errors.photo_paths }"
                    />
                    <span v-if="form.errors.photo_paths" class="errors">
                        {{ form.errors.photo_paths }}
                    </span>
                </div>

                <div class="container-button">
                    <button type="submit" class="btn-class" :disabled="form.processing">
                        Crear Producto
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
