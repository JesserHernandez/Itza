<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref, watch, computed } from "vue"; // <-- Agregamos watch y computed
import HeaderAdmin from "@/Components/HeaderAdmin.vue";
import Multiselect from "vue-multiselect";

const Swal = window.Swal;

const props = defineProps({
    categories: Array,
    tags: Array,
    teams: Array,
    tags: Array,
    category_attributes: Array,
});

const form = useForm({
    name: "",
    code: "",
    status: "",
    description: "",
    physical_location: "",
    creator: "",
    creation_date: "",
    price: "",
    is_active: true,
    team_id: null,
    categories: [],
    photo_paths: [],
    tags: [],
    category_attributes: [],
});


watch(() => form.categories, (selectedCategories) => {
    const selectedIds = (selectedCategories || []).map(c => c.id);


    const relevantAttributes = (props.category_attributes || []).filter(attr =>
        selectedIds.includes(attr.category_id)
    );


    const newAttributesState = relevantAttributes.map(attr => {
        const existing = form.category_attributes.find(fa => fa.attribute_id === attr.id);

        return {
            attribute_id: attr.id,
            category_id: attr.category_id,
            label: attr.label,
            value: existing ? existing.value : ''
        };
    });

    form.category_attributes = newAttributesState;
}, { deep: true });

const groupedAttributes = computed(() => {
    const groups = {};

    (form.category_attributes || []).forEach(attr => {
        const category = props.categories.find(c => c.id === attr.category_id);
        const categoryName = category ? category.name : 'Otros';

        if (!groups[categoryName]) {
            groups[categoryName] = [];
        }
        groups[categoryName].push(attr);
    });

    return groups;
});


function submit() {
    form.transform((data) => ({
        ...data,
        categories: data.categories.map(c => c.id),

        tags: data.tags.map(t => t.id),

        category_attributes: data.category_attributes.map(attr => ({
            id: attr.attribute_id,
            value: attr.value,
            product_id: attr.product_id,
        }))

    })).post(route("products.store"), {
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
        onError: (errors) => {
            const listaErrores = Object.values(errors).map(err => `<li>${err}</li>`).join('');

            Swal.fire({
                title: "¡Error de validación!",
                html: `<ul style="text-align: left; margin-left: 20px;">${listaErrores}</ul>`,
                icon: "error",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#702b21",
                customClass: {
                    title: "title-swal",
                    popup: "popup-swal",
                    confirmButton: "confirm-button-swal",
                },
            });
        },
    });
}

const preview = ref([]);

function previewImage(event) {
    const files = event.target.files;

    Array.from(files).forEach((file) => {
        if (
            !form.photo_paths.some(
                (existingFile) => existingFile.name === file.name
            )
        ) {
            form.photo_paths.push(file);

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

function toggleSelection(field, id) {
    if (form[field].includes(id)) {
        form[field] = form[field].filter((item) => item !== id);
    } else {
        form[field].push(id);
    }
}
</script>

<template>
    <Head title="Crear Productos" />
    <AppLayout :href="route('products.index')">
        <HeaderAdmin
            :showTitle="false"
            icon="/icons/icons-ceramics/ceramic-7-white-icon.svg"
            title="Administración/Productos"
        />
        <div class="content">
            <form class="form" @submit.prevent="submit">
                <div class="items photo_paths">
                    <div class="add-image">
                        <InputLabel
                            value="Imagenes/Producto"
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
                    <InputLabel value="Tienda del producto" textAdd=" *" />
                    <select name="store" id="store">
                        <option value="" disabled selected>
                            Seleccione una tienda
                        </option>
                        <option value="1">Artesanías Helio Gutierrez</option>
                        <option value="2">Artesanías Doña Doriz</option>
                        <option value="3">Artesanías Urracas</option>
                    </select>
                </div>

                <div class="items">
                    <InputLabel value="Etiquetas" textAdd=" *" />

                    <Multiselect
                        v-model="form.tags"
                        :options="tags"
                        :multiple="true"
                        :searchable="false"
                        class="select"
                        :close-on-select="true"
                        :clear-on-select="false"
                        :allow-empty="true"
                        :preserve-search="false"
                        placeholder="Seleccione una etiqueta"
                        label="name"
                        track-by="id"
                        :class="{ errors: form.errors.tags }"
                    />
                    <span v-if="form.errors.tags" class="errors">
                        {{ form.errors.tags }}
                    </span>
                </div>

                <div class="items">
                    <InputLabel value="Código/Producto" textAdd=" *" />
                    <TextInput
                        type="text"
                        required
                        placeholder="Ingresar el código del producto"
                        v-model="form.code"
                        :class="{ errors: form.errors.code }"
                    />
                    <span v-if="form.errors.code" class="errors">
                        {{ form.errors.code }}
                    </span>
                </div>

                <div class="items items-des">
                    <InputLabel value="Descripción/Producto" textAdd=" *" />
                    <TextInput
                        type="text"
                        required
                        placeholder="De donde nace este producto"
                        v-model="form.description"
                        :class="{ errors: form.errors.description }"
                    />
                    <span v-if="form.errors.description" class="errors">
                        {{ form.errors.description }}
                    </span>
                </div>
                <div class="items">
                    <InputLabel value="Estado físico/Producto" textAdd=" *" />
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
                <div class="items items-des">
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
                <div class="items items-active">
                    <label for="">Activo</label>
                    <input
                        type="checkbox"
                        name="is_active"
                        id="is_active"
                        v-model="form.is_active"
                    />
                    <p>Confirma si esta obra se encuentra disponible</p>
                </div>
                <div class="items">
                    <InputLabel value="Creador/Producto" textAdd=" *" />
                    <TextInput
                        type="text"
                        required
                        v-model="form.creator"
                        :class="{ errors: form.errors.creator }"
                    />
                    <span v-if="form.errors.creator" class="errors">
                        {{ form.errors.creator }}
                    </span>
                </div>

                <div class="items">
                    <InputLabel value="Categorías" textAdd=" *" />

                    <Multiselect
                        v-model="form.categories"
                        :options="categories"
                        :multiple="true"
                        :searchable="false"
                        class="select"
                        :close-on-select="true"
                        :clear-on-select="false"
                        :allow-empty="true"
                        :preserve-search="false"
                        placeholder="Seleccione una categoría"
                        label="name"
                        track-by="id"
                        :class="{ errors: form.errors.categories }"
                    />
                    <span v-if="form.errors.categories" class="errors">
                        {{ form.errors.categories }}
                    </span>
                </div>

                <!-- ESTO ES LO QUE HACE QUE SE VEAN LOS INPUTS -->
            <div
                v-for="(attributes, categoryName) in groupedAttributes"
                :key="categoryName"
                class="items"
            >

                <div
                    v-for="attr in attributes"
                    :key="attr.attribute_id"
                    class="items"
                >
                    <InputLabel :value="attr.label" />
                    <TextInput
                        type="text"
                        v-model="attr.value"
                        :placeholder="`Ingrese ${attr.label}`"
                        class="w-full"
                    />
                </div>
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
