<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Form from "@/Pages/Vendor/Tag/Form.vue";

const props = defineProps({
});
</script>

<template>
    <Head title="Crear etiqueta" />
    <AppLayout title="Crear etiqueta" :href="route('tags.index')">
        <div class="title-create">
            <h1>Crear etiqueta</h1>
        </div>
        
        <Form :tag="tag" @success="showSuccessAlert"/>
    </AppLayout>
</template>
