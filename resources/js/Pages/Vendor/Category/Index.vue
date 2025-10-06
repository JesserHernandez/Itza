<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import HeaderAdmin from "@/Components/HeaderAdmin.vue";
import TextInput from "@/Components/TextInput.vue";
import NavLink from "@/Components/NavLink.vue";

import { router, Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";

// Importa SweetAlert desde el CDN
const Swal = window.Swal;

defineProps({
    categories: {
        type: Object,
        required: true,
    },
});

const cantidad = ref(10); // Valor predeterminado

function updatePerPage() {
    router.get(
        route("categories.index"),
        { perPage: cantidad.value },
        { preserveState: true },
        { replace: true },

    );
}

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
            router.delete(route("categories.destroy", { category: id }));
            Swal.fire({
                title: "¡Eliminado!",
                text: "La categoría ha sido eliminada con éxito.",
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
    <Head title="Categorías" />
    <AppLayout title="Categorías" :href="route('admin')">
        <HeaderAdmin
            icon="/icons/icons-interface/task-darker-icon.svg"
            title="Administración/Categorías"
            paragraph="La sección Categorías, tu centro de gestión virtual en el panel de administración, te permite organizar y administrar todos
            los tipos de productos que ofreces como cerámicas culturales, piezas decorativas, artículos de cocina o cualquier otra línea. Cada categoría se gestiona mediante el Nombre, una Descripción detallada y sus Opciones de control. Es esencial que mantengas tus
            datos siempre actualizados, ya que una ficha precisa es fundamental para entender a tu público objetivo y optimizar tus ventas."
        />

        <div class="content">
            <div class="header-content-index">
                <div class="select-container">
                    <label for="category">Registros por página:</label>
                    <select
                        name="category"
                        id="category"
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
                        <TextInput
                            type="search"
                            placeholder="Buscar"
                            id="search"
                        />
                    </div>
                </section>

                <NavLink class="btn-class" :href="route('categories.create')">
                    <span class="name-link"> Nueva categoría </span>
                    <img
                        src="/icons/icons-interface/add-white-icon.svg"
                        alt=""
                    />
                </NavLink>
            </div>

            <div class="details">
                <h2>Listado de categorías</h2>
            </div>

            <div class="container-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="category in categories.data"
                            :key="category.id"
                        >
                            <td>{{ category.name }}</td>
                            <td>{{ category.description }}</td>
                            <td class="td-actions">
                                <NavLink
                                    :href="
                                        route('categories.edit', {
                                            category: category.id,
                                        })
                                    "
                                    class="btn-class edit"
                                    aria-label="Editar categoría"
                                >
                                    <img
                                        src="/icons/icons-interface/edit-white-icon.svg"
                                        alt=""
                                        class="icons"
                                    />
                                </NavLink>
                                <section class="show">
                                    <NavLink
                                        :href="
                                            route('categories.show', {
                                                category: category.id,
                                            })
                                        "
                                        class="btn-class view"
                                        aria-label="Ver categoría"
                                    >
                                        <img
                                            src="/icons/icons-interface/eye-icon.svg"
                                            alt=""
                                            class="icons"
                                        />
                                    </NavLink>
                                </section>
                                <section class="delete">
                                    <button
                                        @click="destroy(category.id)"
                                        class="btn-class delete"
                                        aria-label="Eliminar categoría"
                                    >
                                        <img
                                            src="/icons/icons-interface/delete-icon.svg"
                                            alt=""
                                            class="icons"
                                        />
                                    </button>
                                </section>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
        <div class="pagination">
            <button
                class="btn-class"
                :disabled="!categories.prev_page_url"
                @click.prevent="$inertia.visit(categories.prev_page_url, { preserveState: true, preserveScroll: true, data : { perPage: cantidad } })"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="7"
                    height="10"
                    viewBox="0 0 7 10"
                    fill="none"
                    class="icons"
                >
                    <path
                        d="M4.95801 0.543213C5.34854 0.152775 5.98158 0.152718 6.37207 0.543213C6.76232 0.933729 6.76243 1.56683 6.37207 1.95728L3.3291 5.00024L6.37207 8.04321C6.76231 8.43376 6.7625 9.06782 6.37207 9.45825C5.98176 9.84813 5.34846 9.84791 4.95801 9.45825L1.20703 5.70728C1.01973 5.51984 0.914147 5.26523 0.914062 5.00024C0.914098 4.73527 1.01979 4.48068 1.20703 4.29321L4.95801 0.543213Z"
                        fill="#F0F0F0"
                    />
                </svg>
            </button>

            <span
                >Página {{ categories.current_page }} de
                {{ categories.last_page }}</span
            >

            <button
                :disabled="!categories.next_page_url"
                @click.prevent="$inertia.visit(categories.next_page_url, { preserveState: true, preserveScroll: true, data : { perPage: cantidad } })"
                class="btn-class"
            >
                <img
                    src="/icons/icons-interface/next-white-icon.svg"
                    alt=""
                    class="icons"
                />
            </button>
        </div>
    </AppLayout>
</template>
