<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import HeaderAdmin from "@/Components/HeaderAdmin.vue";
import Form from "@/Pages/Administrator/CreativeCircuit/Form.vue";



const props = defineProps({
    creativeCircuit: Object,
    creativeCities: Array
});


</script>

<template>
    <Head title="Crear circuito creativo" />
    <AppLayout title="Crear circuito creativo" :href="route('creative_circuits.index')">
        <HeaderAdmin
        title="Crear"
        icon="/icons/icons-interface/task-darker-icon.svg"
        :showTitle="false"
    />

        <Form :creativeCircuit="creativeCircuit" @success="showSuccessAlert" />
    </AppLayout>
</template>
