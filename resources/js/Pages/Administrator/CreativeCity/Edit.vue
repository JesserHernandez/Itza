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
    <Head title="Editar ciudad creativa" />
    <AppLayout title="Editar ciudad creativa" :href="route('creative_cities.index')">
        <HeaderAdmin
        title="Editar ciudad creativa"
        icon="/icons/icons-interface/task-darker-icon.svg"
        :showTitle="false"
    />

        <Form :creativeCity="creativeCity" @success="showSuccessAlert" />
    </AppLayout>
</template>
