<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import HeaderAdmin from "@/Components/HeaderAdmin.vue";
import { Head } from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import NavLink from "@/Components/NavLink.vue";
import { router } from "@inertiajs/vue3";
import { ref } from "vue";

// Importa SweetAlert desde el CDN
const Swal = window.Swal;

defineProps({
    tags: {
        type: Object,
        required: true,
    },
});

const cantidad = ref(10);

function updatePerPage() {
    router.get(
        route("tags.index"),
        { perPage: cantidad.value },
        { preserveState: true },
        { replace: true }

    );
}

// Método para eliminar un tag
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
            router.delete(route("tags.destroy", { tag: id }));
            Swal.fire({
                title: "¡Eliminado!",
                text: "La etiqueta ha sido eliminada con éxito.",
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
    <Head title="Tags" />
    <AppLayout href="route('admin')">
        <HeaderAdmin
            icon="/icons/icons-interface/tag-darker-icon.svg"
            title="Tags"
            paragraph="En este apartado tiene la facilidad de agregar etiquetas
            para la identificación de sus productos al momento en el que los clientes realicen búsquedas de productos
            en la aplicación"
        />

        <div class="content">
            <div class="header-content-index">
                <div class="select-container">
                    <label for="tag">Registros por página:</label>
                    <select
                        name="tag"
                        id="tag"
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
                            class="icons-admin"
                        >
                            <path
                                d="M19.6 21L13.3 14.7C12.8 15.1 12.225 15.4167 11.575 15.65C10.925 15.8833 10.2333 16 9.5 16C7.68333 16 6.14583 15.3708 4.8875 14.1125C3.62917 12.8542 3 11.3167 3 9.5C3 7.68333 3.62917 6.14583 4.8875 4.8875C6.14583 3.62917 7.68333 3 9.5 3C11.3167 3 12.8542 3.62917 14.1125 4.8875C15.3708 6.14583 16 7.68333 16 9.5C16 10.2333 15.8833 10.925 15.65 11.575C15.4167 12.225 15.1 12.8 14.7 13.3L21 19.6L19.6 21ZM9.5 14C10.75 14 11.8125 13.5625 12.6875 12.6875C13.5625 11.8125 14 10.75 14 9.5C14 8.25 13.5625 7.1875 12.6875 6.3125C11.8125 5.4375 10.75 5 9.5 5C8.25 5 7.1875 5.4375 6.3125 6.3125C5.4375 7.1875 5 8.25 5 9.5C5 10.75 5.4375 11.8125 6.3125 12.6875C7.1875 13.5625 8.25 14 9.5 14Z"
                            />
                        </svg>
                        <TextInput
                            type="search"
                            placeholder="Buscar"
                            id="search"
                        />
                    </div>
                </section>

                <NavLink class="btn-class" :href="route('tags.create')">
                    <span class="name-link"> Nueva etiqueta </span>
                    <img
                        src="/icons/icons-interface/add-white-icon.svg"
                        alt=""
                    />
                </NavLink>
            </div>

            <div class="details">
                <h2>Listado de etiquetas</h2>
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
                        <tr v-for="tag in tags.data" :key="tag.id">
                            <td>{{ tag.name }}</td>
                            <td>{{ tag.description }}</td>
                            <td class="td-actions">
                                <NavLink
                                    :href="
                                        route('tags.edit', {
                                            tag: tag.id,
                                        })
                                    "
                                    class="btn-class edit"
                                    aria-label="Editar etiqueta"
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
                                            route('tags.show', {
                                                tag: tag.id,
                                            })
                                        "
                                        class="btn-class view"
                                        aria-label="Ver etiqueta"
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
                                        @click="destroy(tag.id)"
                                        class="btn-class delete"
                                        aria-label="Eliminar etiqueta"
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
                :disabled="!tags.prev_page_url"
                @click.prevent="
                    $inertia.visit(tags.prev_page_url, {
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
                >Página {{ tags.current_page }} de
                {{ tags.last_page }}</span
            >

            <button
                :disabled="!tags.next_page_url"
                @click.prevent="
                    $inertia.visit(tags.next_page_url, {
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
