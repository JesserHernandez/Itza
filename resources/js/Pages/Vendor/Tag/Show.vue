<script setup>
import { Head } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    tag: Object, // Cambié productMaterial a tag
});
</script>

<template>
    <Head :title="tag.name" />
    <AppLayout :href="route('tags.index')">
        <div class="title-create">
            <h1>Detalles de la etiqueta</h1>
        </div>

        <div class="container-form">
            <div class="form">
                <div class="items-form">
                    <p><strong>Nombre: </strong>{{ tag.name }}</p>
                </div>
                <div class="items-form">
                    <p>
                        <strong>Descripción: </strong>
                        {{ tag.description }}
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
