<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import HeaderAdmin from "@/Components/HeaderAdmin.vue";
import Form from "@/Pages/Administrator/CreativeCity/Form.vue";



const props = defineProps({
    creativeCity: Object,
});


</script>

<template>
    <Head title="Crear ciudad creativa" />
    <AppLayout title="Crear ciudad creativa" :href="route('creative_cities.index')">
        <HeaderAdmin
        title="Crear"
        icon="/icons/icons-interface/task-darker-icon.svg"
        :showTitle="false"
    />

        <Form :creativeCity="creativeCity" @success="showSuccessAlert" />
    </AppLayout>
</template>
