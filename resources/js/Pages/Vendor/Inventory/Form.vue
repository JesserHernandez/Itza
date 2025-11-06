<script setup>
import { useForm } from "@inertiajs/vue3";

// SweetAlert desde el CDN
const Swal = window.Swal;

const props = defineProps({
    inventory: Object,
    products: Array,
});

const form = useForm({
    product_id: props.inventory ? props.inventory.product_id : "",
    move: props.inventory ? props.inventory.move : "",
    type_move: props.inventory ? props.inventory.type_move : "",
    quantity: props.inventory ? props.inventory.quantity : "",
    date_move: props.inventory ? props.inventory.date_move : "",
    initial_stock: props.inventory ? props.inventory.initial_stock : "",
    current_stock: props.inventory ? props.inventory.current_stock : "",
    minimum_stock: props.inventory ? props.inventory.minimum_stock : "",
    state: props.inventory ? props.inventory.state : "",
    observations: props.inventory ? props.inventory.observations : "",
    is_active: props.inventory ? props.inventory.is_active : true,
});

function submitForm() {
        // Crear nuevo inventario
        form.post(route("inventories.store"), {
            onSuccess: () => {
                Swal.fire({
                    title: "¡Creado!",
                    text: "El inventario ha sido creado con éxito.",
                    icon: "success",
                    confirmButtonText: "Aceptar",
                    confirmButtonColor: "#702b21",
                    customClass: {
                        title: "title-swal",
                        text: "text-swal",
                        popup: "popup-swal",
                        confirmButton: "confirm-button-swal",
                    },
                });
            },
        });
    }

</script>

<template>
    <div class="container-form">
        <form @submit.prevent="submitForm" class="formIn">
            <div class="item-form">
                <label for="name">Producto</label>
                <select
                    name="product_id"
                    id="product_id"
                    v-model="form.product_id"
                    :class="{ 'input-error': form.errors.product_id }"
                >
                    <option value="" disabled selected>
                        Seleccione un producto
                    </option>
                    <option
                        v-for="product in products"
                        :key="product.id"
                        :value="product.id"
                    >
                        {{ product.name }}
                    </option>
                </select>
                <div v-if="form.errors.product_id" class="error-message">
                    {{ form.errors.product_id }}
                </div>
            </div>

            <div class="item-form">
                <div class="subitems">
                    <label for="move">Movimientos</label>
                    <select
                        name="move"
                        id="move"
                        v-model="form.move"
                        :class="{ 'input-error': form.errors.move }"
                    >
                    <option disabled selected>Seleccione un movimiento</option>
                        <option value="out">Salida</option>
                        <option value="in">Entrada</option>
                    </select>
                    <div v-if="form.errors.move" class="error-message">
                        {{ form.errors.move }}
                    </div>
                </div>
                <div class="subitems">
                    <label for="type_move">Tipo de Movimiento</label>
                    <select
                        name="type_move"
                        id="type_move"
                        v-model="form.type_move"
                        :class="{ 'input-error': form.errors.type_move }"
                    >
                        <option disabled selected>Seleccione un tipo de movimiento</option>
                        <option value="sale">Venta al cliente</option>
                        <option value="deletion">Eliminación</option>
                        <option value="transfer">Transferencia</option>
                        <option value="restock">Reabastecimiento</option>
                        <option value="return">Devolución</option>
                        <option value="initial_stock">Stock inicial</option>
                    </select>
                    <div v-if="form.errors.type_move" class="error-message">
                        {{ form.errors.type_move }}
                    </div>
                </div>
            </div>

            <div class="item-form">
                <div class="subitems">
                    <label for="quantity">Cantidad</label>
                    <input
                        type="number"
                        name="quantity"
                        id="quantity"
                        placeholder="Ingresa aquí"
                        v-model="form.quantity"
                        :class="{ 'input-error': form.errors.quantity }"
                    />
                    <div v-if="form.errors.quantity" class="error-message">
                        {{ form.errors.quantity }}
                    </div>
                </div>
                <div class="subitems">
                    <label for="date_move">Fecha de movimiento</label>
                    <input
                        type="date"
                        name="date_move"
                        id="date_move"
                        v-model="form.date_move"
                        :class="{ 'input-error': form.errors.date_move }"
                    />
                    <div v-if="form.errors.date_move" class="error-message">
                        {{ form.errors.date_move }}
                    </div>
                </div>
            </div>
            <div class="item-form stock">
                <div class="subitems">
                    <label for="initial_stock">Existencia inicial</label>
                    <input
                        type="number"
                        name="initial_stock"
                        id="initial_stock"
                        placeholder="Ingresa aquí"
                        v-model="form.initial_stock"
                        :class="{ 'input-error': form.errors.initial_stock }"
                    />
                    <div v-if="form.errors.initial_stock" class="error-message">
                        {{ form.errors.initial_stock }}
                    </div>
                </div>
                <div class="subitems">
                    <label for="current_stock">Existencia actual</label>
                    <input
                        type="number"
                        name="current_stock"
                        id="current_stock"
                        placeholder="Ingresa aquí"
                        v-model="form.current_stock"
                        :class="{ 'input-error': form.errors.current_stock }"
                    />
                    <div v-if="form.errors.current_stock" class="error-message">
                        {{ form.errors.current_stock }}
                    </div>
                </div>
                <div class="subitems">
                    <label for="minimum_stock">Existencia mínima</label>
                    <input
                        type="number"
                        name="minimum_stock"
                        id="minimum_stock"
                        placeholder="Ingresa aquí"
                        v-model="form.minimum_stock"
                        :class="{ 'input-error': form.errors.minimum_stock }"
                    />
                    <div v-if="form.errors.minimum_stock" class="error-message">
                        {{ form.errors.minimum_stock }}
                    </div>
                </div>
            </div>
            <div class="item-form">
                <label for="state">Estado</label>
                <select
                    name="state"
                    id="state"
                    v-model="form.state"
                    :class="{ 'input-error': form.errors.state }"
                >
                    <option value="active">Activo</option>
                    <option value="inactive">Inactivo</option>
                </select>
                <div v-if="form.errors.state" class="error-message">
                    {{ form.errors.state }}
                </div>
            </div>
            <div class="item-form">
                <label for="observations">Observaciones</label>
                <textarea
                    name="observations"
                    id="observations"
                    v-model="form.observations"
                    :class="{ 'input-error': form.errors.observations }"
                ></textarea>
                <div v-if="form.errors.observations" class="error-message">
                    {{ form.errors.observations }}
                </div>
            </div>
            <div class="item-form active">
                <label for="">Activo</label>
                <input
                    type="checkbox"
                    name="is_active"
                    id="is_active"
                    v-model="form.is_active"
                />
                <p>Confirma si está disponible en el inventario</p>
            </div>

            <div class="actions-form">
                <button type="submit" class="btn-class">

                    {{ props.inventory ? "Actualizar contenido del inventario" : "Guardar contenido del inventario" }}
                </button>
            </div>
        </form>
    </div>
</template>
