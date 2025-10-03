<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Form from "@/Pages/Vendor/ProductMaterial";

const props = defineProps({
    productMaterial: Object,
});
</script>

<template>
    <Head title="Editar material"/>

    <AppLayout :href="route('product_materials.index')">
        <div class="title-create">
            <h1>Editar material</h1>
        </div>

        <Form :productMaterial="props.productMaterial" @sucess="showSucessAlert"/>
    </AppLayout>
</template>
