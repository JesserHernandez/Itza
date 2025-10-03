<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Form from "@/Pages/Vendor/Tag/Form.vue"; // Cambié el formulario al de tags

const props = defineProps({
    tag: Object, // Cambié productMaterial a tag
});
</script>

<template>
    <Head title="Editar etiqueta" />

    <AppLayout :href="route('tags.index')">
        <div class="title-create">
            <h1>Editar etiqueta</h1>
        </div>

        <!-- Pasamos la etiqueta al formulario -->
        <Form :tag="props.tag" @success="showSuccessAlert" />
    </AppLayout>
</template>
