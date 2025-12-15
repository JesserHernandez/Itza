<script setup>
import { Head } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import HeaderAdmin from "@/Components/HeaderAdmin.vue";
import Form from "@/Pages/Administrator/CreativeCircuit/Form.vue";

defineProps({
    creative_circuit: Object,
    creative_city: Array
});

</script>

<template>
    <Head title="Crear circuito creativo" />
    <AppLayout title="Crear circuito creativo" :href="route('creative_circuits.index')">
        <HeaderAdmin
            title="Circuitos Creativos/Crear"
            icon="/icons/icons-interface/task-darker-icon.svg"
            :showTitle="false"
        />

        <Form :creative_city="creative_city" />
    </AppLayout>
</template>
