<script setup>
// Importaciones necesarias
import AppLayout from "@/Layouts/AppLayout.vue";
import HeaderAdmin from "@/Components/HeaderAdmin.vue";
import TextInput from "@/Components/TextInput.vue";
import NavLink from "@/Components/NavLink.vue";

import { router, Head } from "@inertiajs/vue3";
import { ref } from "vue";

// Importa SweetAlert desde el CDN
const Swal = window.Swal;

// Props para recibir los datos de roles
defineProps({
    roles: {
        type: Object,
        required: true,
    },
});

// Estado para la cantidad de registros por página
const cantidad = ref(10); // Valor predeterminado

// Función para actualizar la cantidad de registros por página
function updatePerPage() {
    router.get(
        route("roles.index"),
        { perPage: cantidad.value },
        { preserveState: true, replace: true }
    );
}

// Función para eliminar un rol con confirmación
function destroy(id) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "Esta acción no se puede deshacer.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#702b21",
        cancelButtonColor: "#EADFDE",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
        customClass: {
            title: "title-swal",
            text: "text-swal",
            confirmButton: "confirm-button-swal",
            cancelButton: "cancel-button-swal",
            popup: "popup-swal",
        },
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route("roles.destroy", { role: id }));
            Swal.fire({
                title: "¡Eliminado!",
                text: "El rol ha sido eliminado con éxito.",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#702b21",
                icon: "success",
                customClass: {
                    title: "title-swal",
                    text: "text-swal",
                    confirmButton: "confirm-button-swal",
                    popup: "popup-swal",
                },
            });
        }
    });
}
</script>

<template>
    <Head title="Roles" />
    <AppLayout title="Roles" :href="route('admin')">
        <!-- Encabezado -->
        <HeaderAdmin
            icon="/icons/icons-interface/role-darker-icon.svg"
            title="Administración/Roles"
            paragraph="La sección Roles te permite gestionar los roles disponibles en el sistema. Aquí puedes ver, editar o eliminar roles, así como asignar permisos específicos a cada uno. Mantén esta sección organizada para garantizar un control eficiente de los accesos y privilegios."
        />

        <!-- Contenido principal -->
        <div class="content">
            <!-- Configuración de registros por página -->
            <div class="header-content-index">
                <div class="select-container">
                    <label for="role">Registros por página:</label>
                    <select
                        name="role"
                        id="role"
                        class="select-class"
                        v-model="cantidad"
                        @change.prevent="updatePerPage"
                    >
                        <option value="6">6</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <section class="button-search">
                    <div class="elements-button">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            aria-label="Buscar información"
                            class="icons-navbar"
                        >
                            <path
                                d="M19.6 21L13.3 14.7C12.8 15.1 12.225 15.4167 11.575 15.65C10.925 15.8833 10.2333 16 9.5 16C7.68333 16 6.14583 15.3708 4.8875 14.1125C3.62917 12.8542 3 11.3167 3 9.5C3 7.68333 3.62917 6.14583 4.8875 4.8875C6.14583 3.62917 7.68333 3 9.5 3C11.3167 3 12.8542 3.62917 14.1125 4.8875C15.3708 6.14583 16 7.68333 16 9.5C16 10.2333 15.8833 10.925 15.65 11.575C15.4167 12.225 15.1 12.8 14.7 13.3L21 19.6L19.6 21ZM9.5 14C10.75 14 11.8125 13.5625 12.6875 12.6875C13.5625 11.8125 14 10.75 14 9.5C14 8.25 13.5625 7.1875 12.6875 6.3125C11.8125 5.4375 10.75 5 9.5 5C8.25 5 7.1875 5.4375 6.3125 6.3125C5.4375 7.1875 5 8.25 5 9.5C5 10.75 5.4375 11.8125 6.3125 12.6875C7.1875 13.5625 8.25 14 9.5 14Z"
                                fill="#702b21"
                            />
                        </svg>
                    </div>
                </section>
                <NavLink class="btn-class" :href="route('roles.create')">
                    <span class="name-link"> Nuevo rol </span>
                    <img
                        src="/icons/icons-interface/add-white-icon.svg"
                        alt=""
                    />
                </NavLink>
            </div>

            <div class="details">
                <h2>Listado de roles</h2>
            </div>

            <!-- Tabla de roles -->
            <div class="container-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Permisos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="role in roles.data"
                            :key="role.id"
                        >
                            <td>{{ role.id }}</td>
                            <td>{{ role.name }}</td>
                            <td>
                                <ul>
                                    <li v-for="permission in role.permissions" :key="permission.id">
                                        {{ permission.name }}
                                    </li>
                                </ul>
                            </td>
                            <td class="td-actions">
                                    <NavLink
                                        :href="route('roles.edit', role.id)"
                                        class="edit-button"
                                    >
                                        Editar
                                    </NavLink>
                                    <button
                                        @click="destroy(role.id)"
                                        class="delete-button"
                                    >
                                        Eliminar
                                    </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


        </div>
    </AppLayout>
</template>
