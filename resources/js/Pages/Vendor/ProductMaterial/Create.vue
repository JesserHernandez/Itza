<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Form from "@/Pages/Vendor/ProductMaterial/Form.vue";



const props = defineProps({
    productMaterial: Object,
});

// Método para enviar el formulario y mostrar el mensaje de éxito

</script>

<template>
    <Head title="Crear material" />
    <AppLayout title="Crear material" :href="route('product_materials.index')">
        <div class="title-create">
            <h1>Crear material</h1>
        </div>

        <Form :productMaterial="productMaterial" @success="showSuccessAlert" />
    </AppLayout>
</template>
