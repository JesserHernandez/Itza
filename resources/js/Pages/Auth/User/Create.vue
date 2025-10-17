<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

const form = useForm({
    name: "",
    surname: "",
    email: "",
    password: "",
    status: "Activo", // Valor predeterminado
    gender: "Masculino", // Valor predeterminado
    phone_number: "",
    identification_card: "",
    experience: "",
    is_vendor: false,
    is_outstanding: false,
    profile_photo_path: null,
    current_team_id: null,
    email_verified_at: null,
});

function submit() {
    form.post(route("users.store"));
}
</script>

<template>
    <AppLayout>
        <div class="create-user">
            <form @submit.prevent="submit" class="form">
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        class="input-class"
                        required
                    />
                </div>

                <div class="form-group">
                    <label for="surname">Apellido</label>
                    <input
                        id="surname"
                        v-model="form.surname"
                        type="text"
                        class="input-class"
                        required
                    />
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="input-class"
                        required
                    />
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        class="input-class"
                        required
                    />
                </div>

                <div class="form-group">
                    <label for="status">Estado</label>
                    <select
                        id="status"
                        v-model="form.status"
                        class="input-class"
                    >
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="gender">Género</label>
                    <select
                        id="gender"
                        v-model="form.gender"
                        class="input-class"
                    >
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="phone_number">Teléfono</label>
                    <input
                        id="phone_number"
                        v-model="form.phone_number"
                        type="text"
                        class="input-class"
                    />
                </div>

                <div class="form-group">
                    <label for="identification_card">Cédula de Identidad</label>
                    <input
                        id="identification_card"
                        v-model="form.identification_card"
                        type="text"
                        class="input-class"
                    />
                </div>
                <div class="container-button">

                    <button type="submit" class="btn-class">Crear Usuario</button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
