<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import HeaderAdmin from "@/Components/HeaderAdmin.vue";
import TextInput from "@/Components/TextInput.vue";
import NavLink from "@/Components/NavLink.vue";
import { router, Head } from "@inertiajs/vue3";
import { ref } from "vue";

defineProps({
    inventories: Object,
    products: Object,
    filters: Object,
});

// SweetAlert desde el CDN
const Swal = window.Swal;

const cantidad = ref(10); // Valor predeterminado para registros por página

function updatePerPage() {
    router.get(
        route("inventories.index"),
        { perPage: cantidad.value },
        { preserveState: true }
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
            router.delete(route("inventories.destroy", { inventory: id }));
            Swal.fire({
                title: "¡Eliminado!",
                text: "El producto ha sido eliminado con éxito.",
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
    <Head title="Inventario" />
    <AppLayout :href="route('admin')">
        <HeaderAdmin
            icon="/icons/icons-interface/inventory-dark-icon.svg"
            title="Administración/Inventario"
            paragraph="Hemos destacado la sección de Gestión de Productos e Inventario, tu centro de administración virtual. Aquí puedes agregar
            nuevos productos y mantener un control total sobre tus existencias, consultando datos como la Existencia de balance y el Saldo
            mínimo, además de tener acceso a opciones para editar, ver o eliminar cada artículo directamente en la tabla"
        />

        <div class="content">
            <div class="header-content-index">
                <div class="select-container">
                    <label for="inventory">Registros por página:</label>
                    <select
                        name="inventory"
                        id="inventory"
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

                <NavLink class="btn-class" :href="route('inventories.create')">
                    <span class="name-link"> Nuevo producto </span>
                    <img
                        src="/icons/icons-interface/add-white-icon.svg"
                        alt=""
                    />
                </NavLink>
            </div>

            <div class="details">
                <h2>Listado de productos</h2>
            </div>

            <div class="container-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Existencia inicial</th>
                            <th>Existencia actual</th>
                            <th>Existencia mínima</th>
                            <th>Estado</th>
                            <th>Activo</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="inventory in inventories.data"
                            :key="inventory.id"
                        >
                        <td>{{ inventory.products?.name }}</td>
                        <td>{{ inventory.code }}</td>
                        <td>{{ inventory.categories?.name }}</td>
                        <td>{{ inventory.initial_stock }}</td>
                        <td>{{ inventory.current_stock }}</td>
                        <td>{{ inventory.minimum_stock }}</td>
                        <td>{{ inventory.status }}</td>
                        <td>{{ inventory.is_active }}</td>

                            <td class="td-actions">
                                <NavLink
                                    :href="
                                        route('inventories.edit', {
                                            inventory: inventory.id,
                                        })
                                    "
                                    class="btn-class edit"
                                    aria-label="Editar producto"
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
                                            route('inventories.show', {
                                                inventory: inventory.id,
                                            })
                                        "
                                        class="btn-class view"
                                        aria-label="Ver producto"
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
                                        @click="destroy(inventory.id)"
                                        class="btn-class delete"
                                        aria-label="Eliminar producto"
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
                :disabled="!inventories.prev_page_url"
                @click.prevent="
                    $inertia.visit(inventories.prev_page_url, {
                        preserveState: true,
                        preserveScroll: true,
                        data: { perPage: cantidad },
                    })
                "
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
                >Página {{ inventories.current_page }} de
                {{ inventories.last_page }}</span
            >

            <button
                :disabled="!inventories.next_page_url"
                @click.prevent="
                    $inertia.visit(inventories.next_page_url, {
                        preserveState: true,
                        preserveScroll: true,
                        data: { perPage: cantidad },
                    })
                "
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
