<script setup>
import { ref } from "vue";
import { useForm, Head } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Multiselect from "vue-multiselect";
import HeaderAdmin from "@/Components/HeaderAdmin.vue";

const Swal = window.Swal;

const form = useForm({
    name: "",
    surname: "",
    email: "",
    password: "",
    status: "",
    gender: "",
    phone_number: "",
    identification_card: "",
    is_outstanding: false,
    roles: [],
});

const props = defineProps({
    roles: Array,

});
function submit() {
    // Transformar el array de objetos a array de IDs
    form.transform((data) => ({
        ...data,
        roles: data.roles.map(r => r.id),
    })).post(route("users.store"), {
        onSuccess: () => {
            Swal.fire({
                title: "¡Creado!",
                text: "El usuario ha sido creado con éxito.",
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
        onError: (errors) => {
            // Convertimos los errores en una lista HTML
            const listaErrores = Object.values(errors).map(err => `<li>${err}</li>`).join('');

            Swal.fire({
                title: "¡Error!",
                html: `<ul style="text-align: left; margin-left: 20px;">${listaErrores}</ul>`,
                icon: "error",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#702b21",
                customClass: {
                    title: "title-swal",
                    popup: "popup-swal",
                    confirmButton: "confirm-button-swal",
                },
            });
        }
    });
}
</script>

<template>
    <Head title="Crear Usuario" />
    <AppLayout>
        <HeaderAdmin
            icon="/icons/icons-interface/user-darker-icon.svg"
            title="Administración/Usuarios"
            :showTitle="false"
        />
        <div class="create-user">
            <form @submit.prevent="submit" class="form" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        class="input-class"
                        :class="{ 'input-error': form.errors.name }"
                        required
                    />
                    <div v-if="form.errors.name" class="error-message">
                        {{ form.errors.name }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="surname">Apellido</label>
                    <input
                        id="surname"
                        v-model="form.surname"
                        type="text"
                        class="input-class"
                        :class="{ 'input-error': form.errors.surname }"
                        required
                    />
                    <div v-if="form.errors.surname" class="error-message">
                        {{ form.errors.surname }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="input-class"
                        :class="{ 'input-error': form.errors.email }"
                        required
                    />
                    <div v-if="form.errors.email" class="error-message">
                        {{ form.errors.email }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        class="input-class"
                        :class="{ 'input-error': form.errors.password }"
                        required
                    />
                    <div v-if="form.errors.password" class="error-message">
                        {{ form.errors.password }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="status">Estado</label>
                    <select
                        id="status"
                        v-model="form.status"
                        class="input-class"
                        :class="{ 'input-error': form.errors.status }"
                    >
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                    <div v-if="form.errors.status" class="error-message">
                        {{ form.errors.status }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="gender">Género</label>
                    <select
                        id="gender"
                        v-model="form.gender"
                        class="input-class"
                        :class="{ 'input-error': form.errors.gender }"
                    >
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                    </select>
                    <div v-if="form.errors.gender" class="error-message">
                        {{ form.errors.gender }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone_number">Teléfono</label>
                    <input
                        id="phone_number"
                        v-model="form.phone_number"
                        type="text"
                        class="input-class"
                        :class="{ 'input-error': form.errors.phone_number }"
                    />
                    <div v-if="form.errors.phone_number" class="error-message">
                        {{ form.errors.phone_number }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="identification_card">Cédula de Identidad</label>
                    <input
                        id="identification_card"
                        v-model="form.identification_card"
                        type="text"
                        class="input-class"
                        :class="{ 'input-error': form.errors.identification_card }"
                    />
                    <div v-if="form.errors.identification_card" class="error-message">
                        {{ form.errors.identification_card }}
                    </div>
                </div>


                <div class="form-group destacado">
                    <label for="is_outstanding">¿Es Destacado?</label>
                    <input
                        id="is_outstanding"
                        v-model="form.is_outstanding"
                        type="checkbox"
                        class="input-class"
                        :class="{ 'input-error': form.errors.is_outstanding }"
                    />
                    <div v-if="form.errors.is_outstanding" class="error-message">
                        {{ form.errors.is_outstanding }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="roles">Rol</label>
                    <Multiselect
                        v-model="form.roles"
                        :options="roles"
                        :multiple="true"
                        :searchable="false"
                        :close-on-select="true"
                        :clear-on-select="false"
                        :preserve-search="false"
                        placeholder="Seleccione uno o más roles"

                        :class="{ errors: form.errors.roles }"
                    />
                    <div v-if="form.errors.roles" class="error-message">
                        {{ form.errors.roles }}
                    </div>
                </div>

                <div class="container-button">
                    <button type="submit" class="btn-class">Crear Usuario</button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
