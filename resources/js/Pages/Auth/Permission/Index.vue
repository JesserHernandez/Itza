<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import HeaderAdmin from "@/Components/HeaderAdmin.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
    permissions: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <Head title="Permisos" />
    <AppLayout title="Permisos" :href="route('admin')">
        <!-- Encabezado -->
        <HeaderAdmin
            icon="/icons/icons-interface/permission-darker-icon.svg"
            title="Administración/Permisos"
            paragraph="La sección Permisos te permite visualizar todos los permisos disponibles en el sistema. Estos permisos son utilizados para gestionar el acceso a las diferentes funcionalidades de la aplicación."
        />

        <!-- Contenido principal -->
        <div class="content">
            <div class="details">
                <h2>Listado de Permisos</h2>
            </div>

            <!-- Tabla de permisos -->
            <div class="container-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                    <tbody v-if="permissions && permissions.data">
                        <tr v-for="permission in permissions" :key="permission.id">
                            <td>{{ permission }}</td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="2" class="text-center">No hay permisos disponibles.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
