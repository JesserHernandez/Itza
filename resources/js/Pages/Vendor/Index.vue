<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head } from "@inertiajs/vue3";
import HeaderAdmin from "@/Components/HeaderAdmin.vue";
</script>

<template>
    <Head title="Artesanos" />
    <AppLayout  title="Artesanos">
        <HeaderAdmin
            icon="/icons/icons-ceramics/paint-woman-icon.svg"
            title="Administración"
            text="a la administración de tu tienda"
            paragraph="¡Gracias por elegir ITZ´AT! En este espacio podrás administrar las tiendas que tengas
                    disponibles, las categoría, materiales para la creación de una artesanía,
                    etiquetas para filtrar la búsqueda en la aplicación, los productos mismos, las publicaciones y más."
        />
    </AppLayout>
</template>
