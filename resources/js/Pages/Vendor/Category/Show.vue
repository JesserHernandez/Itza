<script setup>

import { Head } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    category: Object,
});
</script>
<template>
    <Head :title="category.name" />
    <AppLayout :title="category.name" :href="route('categories.index')">
        <div class="title-create">
            <h1>Detalles de la categoría</h1>
        </div>

        <div class="container-form">
            <div class="form">
                <div class="items-form">

                    <p><strong>Nombre:</strong> {{ category.name }}</p>
                </div>
                <div class="items-form">
                    <p><strong>Descripción:</strong> {{ category.description }}</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
