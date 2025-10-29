<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({
    permissions: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    name: "",
    permissions: [],
});

function submit() {
    form.post(route("roles.store"));
}
</script>

<template>
    <AppLayout :href="route('roles.index')">
        <div class="contenido">
            <form @submit.prevent="submit" class="form">
                <div class="form-group">
                    <label for="name">Nombre del Rol</label>
                    <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        class="input-class"
                        required
                    />
                </div>

                <div class="permisos">
                    <h3>Permisos</h3>
                    <div
                        v-for="permission in permissions"
                        :key="permission"
                        class="items"
                    >
                        <label>
                            <input
                                type="checkbox"
                                :value="permission"
                                v-model="form.permissions"
                            />
                            {{ permission }}
                        </label>
                    </div>
                </div>
                <div class="container">
                    <button type="submit" class="btn-class">Crear Rol</button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
