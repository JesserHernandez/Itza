<script setup>
import { Head } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    productMaterial: Object,
});
</script>

<template>
    <Head :title="productMaterial.name" />
    <AppLayout :href="route('product_materials.index')">
        <div class="title-create">
            <h1>Detalles del material</h1>
        </div>

        <div class="container-form">
            <div class="form">
                <div class="items-form">
                    <p><strong>Nombre: </strong>{{ productMaterial.name }}</p>
                </div>
                <div class="items-form">
                    <p>
                        <strong>Descripción: </strong>
                        {{ productMaterial.description }}
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
