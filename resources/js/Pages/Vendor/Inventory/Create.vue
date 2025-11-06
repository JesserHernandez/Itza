<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Form from "@/Pages/Vendor/Inventory/Form.vue";
import HeaderAdmin from "@/Components/HeaderAdmin.vue";
</script>

<template>
    <Head title="Crear registro" />
    <AppLayout title="Crear registro" :href="route('tags.index')">
        <HeaderAdmin :showTitle="false"
            icon="/icons/icons-interface/inventory-dark-icon.svg"
            title="Administración/Inventario"
        />

        <Form :inventory="inventory" @success="showSuccessAlert"/>
    </AppLayout>
</template>
