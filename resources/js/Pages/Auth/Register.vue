<script setup>
import { ref, computed, watch } from "vue"; // quitar h
import { Head, useForm } from "@inertiajs/vue3";
import ReturnView from "@/Components/ReturnView.vue";
import StepOne from "@/Pages/Auth/Steps/StepOne.vue";
import { Link } from "@inertiajs/vue3";
import StepArtiClient from "@/Pages/Auth/Steps/StepArtiClient.vue";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import StoreArtisan from "./Steps/StoreArtisan.vue";
import AddressStep from "./Steps/AddressStep.vue";

const step = ref(1);
const form = useForm({
    // user
    name: "",
    surname: "",
    email: "",
    password: "",
    gender: "",
    phone_number: "",
    identification_card: "",
    is_vendor: false,

    // teams (tienda)
    teams: {
        name_team: "",
        type: "",
        city: "",
        municipality: "",
        address: "",
    },

    // user_address
    user_address: {
        user_address: "",
        address_type: "",
        postal_code: "",
        city: "",
        municipality: "",
        facturation: false,
        active: true,
    },
});

// props
const props = defineProps({
    is_vendor: [Boolean, String, Number],
});

// isVendor reactivo y robusto
const isVendor = computed(() => {
    return props.is_vendor === true || props.is_vendor === "true" || props.is_vendor === 1 || props.is_vendor === "1";
});

// sincronizar con form
watch(
    isVendor,
    (val) => {
        form.is_vendor = !!val;
    },
    { immediate: true }
);

function nextStep() {
    step.value++;
}
function prevStep() {
    if (step.value > 1) {
        step.value--;
        return;
    }
    try {
        if (typeof route === "function") {
            window.location.href = route("welcome");
            return;
        }
    } catch (e) {}
    window.history.back();
}

function submit() {
    if (form.processing) return;
    // opcional: asegurar merge final si algún hijo mandó datos directo
    console.log("form antes de post", JSON.parse(JSON.stringify(form)));
    const href = typeof route === "function" ? route("register") : "/register";
    form.post(href, {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
}

function isPlainObject(v) {
    return v && typeof v === "object" && !Array.isArray(v);
}

function mergeForm(partial = {}) {
    console.log("mergeForm recibe:", partial);

    const teamKeys = [
        "name_team",
        "team_type",
        "type",
        "ruc",
        "city",
        "municipality",
        "address",
    ];
    const addrKeys = [
        "user_address",
        "address_type",
        "postal_code",
        "city",
        "municipality",
        "facturation",
        "active",
        "address",
    ];

    // merge teams namespaced si viene
    if (isPlainObject(partial.teams)) {
        form.teams = { ...(form.teams || {}), ...partial.teams };
        delete partial.teams;
    }

    // merge user_address namespaced si viene — NO tocar ni normalizar teléfonos dentro de user_address
    if (isPlainObject(partial.user_address)) {
        const ua = { ...(partial.user_address || {}) };
        // eliminar claves de teléfono si por error llegaron en user_address
        delete ua.phoneNumber;
        delete ua.phone_number;
        form.user_address = { ...(form.user_address || {}), ...ua };
        delete partial.user_address;
    }

    // teléfonos planos: phoneNumber -> teams.phoneNumber (tienda), phone_number -> form.phone_number (usuario)
    if (partial.phoneNumber !== undefined) {
        form.teams = { ...(form.teams || {}), phoneNumber: partial.phoneNumber };
        delete partial.phoneNumber;
    }
    if (partial.phone_number !== undefined) {
        form.phone_number = partial.phone_number;
        delete partial.phone_number;
    }

    // mapear claves sueltas de teams a form.teams
    const teamPart = {};
    Object.keys(partial).forEach((k) => {
        if (teamKeys.includes(k)) {
            teamPart[k] = partial[k];
            delete partial[k];
        }
    });
    if (Object.keys(teamPart).length) {
        form.teams = { ...(form.teams || {}), ...teamPart };
    }

    // mapear claves sueltas de dirección a form.user_address (sin incluir teléfonos)
    const addrPart = {};
    Object.keys(partial).forEach((k) => {
        if (addrKeys.includes(k)) {
            const destKey = k === "address" ? "user_address" : k;
            addrPart[destKey] = partial[k];
            delete partial[k];
        }
    });
    if (Object.keys(addrPart).length) {
        form.user_address = { ...(form.user_address || {}), ...addrPart };
    }

    // asignar el resto (top-level)
    Object.keys(partial).forEach((k) => {
        form[k] = partial[k];
    });

    console.log("form tras merge:", JSON.parse(JSON.stringify(form)));
}

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
                :modelValue="form"
                :is_vendor="isVendor"
                @section-data="mergeForm"
                @next="nextStep"
            />

            <StepArtiClient
                v-if="step === 2"
                :modelValue="form"
                :is_vendor="isVendor"
                @section-data="mergeForm"
                @next="nextStep"
            />

            <!-- escucho ambos eventos (next/finish) por compatibilidad -->
            <StoreArtisan
                v-if="step === 3 && isVendor"
                :modelValue="form"
                @section-data="mergeForm"
                @finish="submit"
                @next="submit"
            />

            <AddressStep
                v-if="step === 3 && !isVendor"
                :modelValue="form"
                @section-data="mergeForm"
                @finish="submit"
            />
        </div>
        <div class="info-end" aria-label="Separador de opciones">
            <hr />
            <span>O</span>
            <hr />
        </div>

        <div class="navigate" aria-label="Acceso para usuarios registrados">
            <span>¿Ya tienes una cuenta? </span>
            <Link
                :href="route('login')"
                class="btn-login"
                aria-label="Acceder a tu cuenta"
            >
                Puedes acceder a ella
            </Link>
        </div>
    </AuthenticationCard>
</template>
