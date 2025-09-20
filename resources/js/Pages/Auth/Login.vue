<!-- Lo ques js va aquí -->
<script setup>
//? Importa los componentes necesarios
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import Checkbox from "@/Components/Checkbox.vue";
import { ref } from "vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

// Inicializa el formulario
const form = useForm({
    email: "",
    password: "",
    remember: false,
});

// Maneja el botón de envío del formulario
const submit = () => {
    form.transform((data) => ({
        ...data,
        remember: form.remember ? "on" : "",
    })).post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};

const viewPassword = ref(null);

const showPassword = () => {
    if (viewPassword.value.src.includes("eye-closed-icon.svg")) {
        viewPassword.value.classList.add("gif-icons");
        viewPassword.value.src = "/icons/icons-interface/eye-icon.svg";
        document.getElementById("password").type = "text";
        viewPassword.value.style.cursor = "pointer";
    } else {
        viewPassword.value.src = "/icons/icons-interface/eye-closed-icon.svg";
        document.getElementById("password").type = "password";
    }
};
</script>

<template>
    <Head title="Iniciar sesión" />
    <AuthenticationCard>
        <div v-if="status" class="">
            {{ status }}
        </div>

        <!-- Contenedor 1: Volver y Logo -->
        <div class="login-header">
            <section>
                <img
                    src="/icons/icons-interface/back-icon.svg"
                    alt="Volver"
                    class="icon-back"
                />
                <p>Volver</p>
            </section>
            <img
                src="/img/img-logo/Logo_itzat.svg"
                alt="Logo de Itz'at"
                class="logo-itzat"
            />
        </div>

        <div class="welcome-container-login">
            <div class="container-one">
                <div class="header">
                    <h1>
                        ¡Bienvenido a ITZ'AT! Ya tienes una cuenta en nuestra
                        plataforma. Accede a ella con total seguridad.
                    </h1>
                    <p>
                        Accede a tu cuenta de ITZ'AT sin problemas. Ya seas
                        artista o comprador, ingresa a nuestro marketplace y
                        apoya la identidad cultural nicaragüense.
                    </p>
                </div>

                <form @submit.prevent="submit" class="form-login">
                    <div class="element-login-container">
                        <div class="items-login">
                            <InputLabel
                                for="email"
                                value="Correo electrónico"
                                texAdd=" *"
                            />
                            <TextInput
                                id="email"
                                type="email"
                                placeholder="Ingresa tu email"
                                v-model="form.email"
                                required
                                autofocus
                                autocomplete="username"
                            />
                            <p class="example-email">
                                Ejemplo: luisgonzales@gmail.com
                            </p>
                        </div>
                        <InputError class="" :message="form.errors.email" />

                        <div class="items-login">
                            <InputLabel
                                for="password"
                                value="Contraseña"
                                texAdd=" *"
                            />

                            <div class="input-icon-container-login password">
                                <TextInput
                                    type="password"
                                    id="password"
                                    placeholder="Ingresa tu contraseña aquí"
                                    v-model="form.password"
                                    required
                                    autofocus
                                    autocomplete="current-password"
                                />
                                <img
                                    src="/icons/icons-interface/eye-closed-icon.svg"
                                    alt="Ocultar icono para contraseña"
                                    class="gif-icons"
                                    @click="showPassword"
                                    ref="viewPassword"
                                />
                            </div>

                            <p class="example-email" for="password">
                                Debe tener al menos 6 caracteres
                            </p>
                            <InputError
                                class=""
                                :message="form.errors.password"
                            />
                        </div>
                        <div class="container-button">
                            <PrimaryButton
                                class="btn-class"
                                id="btn-login"
                                :disabled="form.processing"
                            >
                                ¡Vamos! Ingresa a tu cuenta de ITZ'AT
                            </PrimaryButton>
                        </div>
                    </div>
                </form>

                <div class="hr">
                    <hr />
                    <span>o</span>
                    <hr />
                </div>

                <span class="questions" id="question-login"
                    >¿Aún no te registras?
                    <Link href="/register" class="register-link"
                        >Únete ahora.</Link
                    >
                </span>
            </div>
            <div class="img-login">
                <img
                    src="/img/img-interfaces/img-login.png"
                    alt="Imagen-login"
                />
            </div>
        </div>
    </AuthenticationCard>
</template>
