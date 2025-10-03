<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/vue3";
import Form from "@/Pages/Vendor/Category/Form.vue";



const props = defineProps({
    categories: Object,
});

// Método para enviar el formulario y mostrar el mensaje de éxito

</script>

<template>
    <Head title="Crear categoría" />
    <AppLayout title="Crear categoría" :href="route('categories.index')">
        <div class="title-create">
            <h1>Crear categoría</h1>
        </div>

        <Form :categories="categories" @success="showSuccessAlert" />
    </AppLayout>
</template>
