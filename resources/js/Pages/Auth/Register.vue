<script setup>
import { h, ref } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import ReturnView from "@/Components/ReturnView.vue";
import StepOne from "@/Pages/Auth/Steps/StepOne.vue";
import TitleRegister from "@/Components/TitleRegister.vue";
import StepArtiClient from "@/Pages/Auth/Steps/StepArtiClient.vue";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import StoreArtisan from "./Steps/StoreArtisan.vue";
import AddressStep from "./Steps/AddressStep.vue";

const step = ref(1);
const form = useForm({
    name: "",
    surname: "",
    email: "",
    password: "",
    status: "",
    gender: "",
    phone_number: "",
    identification_card: "",
    profile_photo_path: null,
    is_vendor: false,
    name_team: "",
    address: "",
    type: "",
    city: "",
    municipality: "",
    ruc: "",
    postal_code: "",
});

// Establece si el usuario es un vendedor o un cliente. Proviene desde la vista RegisterType.
const props = defineProps({
    is_vendor: [Boolean, String],
});

const isVendor =
    props.is_vendor === true ||
    props.is_vendor === "true" ||
    props.is_vendor === "1";
// aplicar al form para que esté sincronizado con el backend
form.is_vendor = isVendor;

function nextStep() {
    step.value++;
}
function prevStep() {
    if (step.value > 1) {
        step.value--;
        return;
    }
    // estás en el primer step: navegar atrás con fallback seguro
    try {
        // eslint-disable-next-line no-undef
        if (typeof route === "function") {
            window.location.href = route("welcome");
            return;
        }
    } catch (e) {}
    window.history.back();
}

const submit = () => {
    // enviar form al backend (route debe venir de Ziggy o estar disponible globalmente)
    try {
        // eslint-disable-next-line no-undef
        const href =
            typeof route === "function" ? route("register") : "/register";
        form.post(href, {
            onFinish: () => form.reset("password", "password_confirmation"),
        });
    } catch (e) {
        // fallback si route no existe
        form.post("/register", {
            onFinish: () => form.reset("password", "password_confirmation"),
        });
    }
};
</script>

<template>
    <Head title="Registro" />

    <AuthenticationCard>
        <div class="container-register">
            <!-- ReturnView emite 'back' -->
            <ReturnView @back="prevStep" :prevent="true" />

            <!-- pasos -->
            <StepOne
                v-if="step === 1"
                v-model="form"
                :is_vendor="isVendor"
                @next="nextStep"
            />

            <StepArtiClient
                v-if="step === 2"
                v-model="form"
                :is_vendor="isVendor"
                @next="nextStep"
            />

            <!-- escucho ambos eventos (next/finish) por compatibilidad -->
            <StoreArtisan
                v-if="step === 3 && isVendor === true"
                v-model="form"
                @next="submit"
                @finish="submit"
            />

            <AddressStep
                v-if="step === 3 && isVendor === false"
                v-model="form"
                @next="submit"
                @finish="submit"
            />
        </div>
    </AuthenticationCard>
</template>
