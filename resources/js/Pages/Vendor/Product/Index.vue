<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import HeaderAdmin from '@/Components/HeaderAdmin.vue';
import TextInput from '@/Components/TextInput.vue';
import NavLink from '@/Components/NavLink.vue';
import { router, Head } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    products: Object,
    categories: Array,
    productMaterials: Array,
    filters: Object,
});

// SweetAlert desde el CDN
const Swal = window.Swal;

const cantidad = ref(10); // Valor predeterminado para registros por página

function updatePerPage() {
    router.get(route('products.index'), { perPage: cantidad.value }, { preserveState: true });
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
            router.delete(route('products.destroy', { product: id }));
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
    <Head title="Productos" />
    <AppLayout :href="route('admin')">
        <HeaderAdmin
            icon="/icons/icons-ceramics/ceramic-7-white-icon.svg"
            title="Administración/Productos"
            paragraph="Tu panel de administración es el centro de gestión para todos tus productos de cerámica. Cada artículo se administra de forma
            individual usando su Nombre, una Descripción detallada y sus opciones de control, que incluyen datos clave como el precio, el
            stock y las variaciones. Es esencial que mantengas la información de cada pieza siempre actualizada, ya que una ficha de
            producto precisa es fundamental para mostrar fielmente tu inventario, conectar con tu público objetivo y optimizar tus ventas."
        />

        <div class="content">
            <div class="header-content-index">
                <div class="select-container">
                    <label for="product">Registros por página:</label>
                    <select
                        name="product"
                        id="product"
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

                <NavLink class="btn-class" :href="route('products.create')">
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

            <div class="container-table table-scroll">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Código</th>
                            <th>Categoría</th>
                            <th>Materiales</th>
                            <th>Historia</th>
                            <th>Origen culturales</th>
                            <th>Dimensiones</th>
                            <th>Color</th>
                            <th>Forma</th>
                            <th>Técnica</th>
                            <th>Ubicación física</th>
                            <th>Creador</th>
                            <th>Fecha de creación</th>
                            <th>Precio</th>
                            <th>Tags</th>
                            <th>Disponibilidad</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="product in products.data"
                            :key="product.id"
                        >
                        <td>{{ product.name }}</td>
                        <td>{{ product.code }}</td>
                        <td>{{ product.categories?.name }}</td>
                        <td>{{ product.materials?.name }}</td>
                        <td>{{ product.history }}</td>
                        <td>{{ product.cultural_origin }}</td>
                        <td>{{ product.dimensions }}</td>
                        <td>{{ product.color }}</td>
                        <td>{{ product.shape }}</td>
                        <td>{{ product.technique }}</td>
                        <td>{{ product.physical_location }}</td>
                        <td>{{ product.creator }}</td>
                        <td>{{ product.creation_date }}</td>
                        <td>{{ product.price }}</td>
                        <td>{{ product.tags?.name }}</td>
                        <td>{{ product.is_active }}</td>

                            <td class="td-actions">
                                <NavLink
                                    :href="
                                        route('products.edit', {
                                            product: product.id,
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
                                            route('products.show', {
                                                product: product.id,
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
                                        @click="destroy(product.id)"
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
    </AppLayout>
</template>
