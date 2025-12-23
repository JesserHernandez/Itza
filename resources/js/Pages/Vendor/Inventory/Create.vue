<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Form from "@/Pages/Vendor/Inventory/Form.vue";
import HeaderAdmin from "@/Components/HeaderAdmin.vue";

const props = defineProps({
    inventory: Object,
    products: Array,
    movements: Array,
    teams: Array,
});

// function showSuccessAlert() {
//     Swal.fire({
//         title: "¡Creado!",
//         text: "El inventario ha sido creado con éxito.",
//         icon: "success",
//         confirmButtonText: "Aceptar",
//         confirmButtonColor: "#702b21",
//         customClass: {
//             title: "title-swal",
//             text: "text-swal",
//             popup: "popup-swal",
//             confirmButton: "confirm-button-swal",
//         },
//     });
// }
</script>

<template>
    <Head title="Crear registro" />
    <AppLayout title="Crear registro" :href="route('tags.index')">
        <HeaderAdmin :showTitle="false"
            icon="/icons/icons-interface/inventory-dark-icon.svg"
            title="Administración/Inventario"
        />

        <Form :products="products" :movements="movements" :teams="teams"/>
    </AppLayout>
</template>
