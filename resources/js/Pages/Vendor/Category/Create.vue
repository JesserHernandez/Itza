<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/vue3";
import HeaderAdmin from "@/Components/HeaderAdmin.vue";
import Form from "@/Pages/Vendor/Category/Form.vue";



const props = defineProps({
    categories: Object,
});

// Método para enviar el formulario y mostrar el mensaje de éxito

</script>

<template>
    <Head title="Crear categoría" />
    <AppLayout title="Crear categoría" :href="route('categories.index')">
        <HeaderAdmin
        title="Crear"
        icon="/icons/icons-interface/task-darker-icon.svg"
        :showTitle="false"
    />

        <Form :categories="categories" @success="showSuccessAlert" />
    </AppLayout>
</template>
