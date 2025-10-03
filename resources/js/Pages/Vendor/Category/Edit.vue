<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Form from "@/Pages/Vendor/Category/Form.vue";

const props = defineProps({
    category: Object,
});

</script>

<template>
    <Head title="Editar categoría" />
    <AppLayout title="Editar categoría" :href="route('categories.index')">
        <div class="title-create">
            <h1>Editar categoría</h1>
        </div>

        <Form :category="props.category" @success="showSuccessAlert" />
    </AppLayout>
</template>
