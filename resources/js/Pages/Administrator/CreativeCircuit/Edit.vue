<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Form from "@/Pages/Administrator/CreativeCircuit/Form.vue";
import HeaderAdmin from "@/Components/HeaderAdmin.vue";

const props = defineProps({
    creative_circuit: {
        type: Object,
        required: true,
    },
    creative_city: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <AppLayout title="Editar circuito creativo">
        <HeaderAdmin />
        <Form :creative_circuit="creative_circuit" :creative_city="creative_city" />
    </AppLayout>
</template>