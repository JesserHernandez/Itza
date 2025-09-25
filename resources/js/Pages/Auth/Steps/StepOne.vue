<script setup>
import { computed, ref, watch } from "vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TitleRegister from "@/Components/TitleRegister.vue";

const props = defineProps({
    modelValue: Object,
    is_vendor: [Boolean, String, Number],
});
const emit = defineEmits(["section-data", "next"]);

// normaliza isVendor (true / "true" / 1 / "1")
const isVendor = computed(
    () =>
        props.is_vendor === true ||
        props.is_vendor === "true" ||
        props.is_vendor === 1 ||
        props.is_vendor === "1" ||
        props.is_vendor === 2 ||
        props.is_vendor === "2"
);

// estado local para editar/validar antes de emitir
const local = ref({
    email: props.modelValue?.email || "",
    password: props.modelValue?.password || "",
    errors: { ...(props.modelValue?.errors || {}) },
});

// Mantener local sincronizado si parent cambia externamente
watch(
    () => props.modelValue,
    (nv) => {
        if (!nv) return;
        if (nv.email !== undefined) local.value.email = nv.email;
        if (nv.password !== undefined) local.value.password = nv.password;
        local.value.errors = { ...(nv.errors || {}) };
    },
    { deep: true }
);

// Soporte para TextInput que emite DOM input (event) o update:modelValue (value)
// helper para actualizar local y notificar al padre (opcional)
function updateFieldLocal(field, valueOrEvent) {
    const value =
        valueOrEvent && valueOrEvent.target
            ? valueOrEvent.target.value
            : valueOrEvent;
    local.value[field] = value;

    // emitir solo la sección (no todo el form)
    emit("section-data", { email: local.value.email, password: local.value.password, errors: { ...(local.value.errors || {}) } });
}

// computed que indica si los campos mínimos son válidos
const isValid = computed(() => {
    const email = (local.value.email || "").toString().trim();
    const password = (local.value.password || "").toString();
    const emailOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    const passOk = password.length >= 8;
    return emailOk && passOk;
});

// validación mínima antes de avanzar
function handleNext(e) {
    e?.preventDefault?.();

    const email = (local.value.email || "").toString().trim();
    const password = (local.value.password || "").toString();

    const errors = {};
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        errors.email = "Introduce un correo válido";
    }
    if (password.length < 8) {
        errors.password = "La contraseña debe tener al menos 8 caracteres";
    }

    if (Object.keys(errors).length) {
        local.value.errors = errors;
        emit("section-data", { email, password, errors });
        return;
    }

    local.value.errors = {};
    emit("section-data", { email, password }); // últimos cambios
    emit("next");
}

// visibilidad de contraseña (boolean)
const passwordVisible = ref(false);
const passwordType = computed(() =>
    passwordVisible.value ? "text" : "password"
);
const eyeIcon = computed(() =>
    passwordVisible.value
        ? "/icons/icons-interface/eye-icon.svg"
        : "/icons/icons-interface/eye-closed-icon.svg"
);

function toggleViewPassword() {
    passwordVisible.value = !passwordVisible.value;
}
</script>

<template>
    <div class="step-one">
        <div class="email-pass">
            <TitleRegister
                :title="
                    isVendor === true
                        ? '¡Bienvenido a ITZ´AT! Únete a nuestra comunidad de creadores!'
                        : 'Bienvenido a ITZ´AT, la comunidad más grande de artesanos precolombinos.'
                "
            />
            <TitleRegister
                :paragraph="
                    isVendor === true
                        ? 'Únete a ITZ´AT como artista. Muestra tu talento al mundo y conéctate con una comunidad vibrante que valora y celebra la riqueza de la artesanía precolombina.'
                        : 'Te damos la bienvenida a ITZ´AT, el lugar donde la tradición y el talento local se encuentran. Apoya a nuestros artesanos nacionales y explora la riqueza de la artesanía precolombina.'
                "
            />

            <div class="formulario">
                <div class="field">
                    <InputLabel
                        for="email"
                        value="Correo Electrónico"
                        texAdd=" *"
                    />
                    <!-- Soporta ambos: si TextInput expone v-model, usa @update:modelValue; si expone DOM input, @input -->
                    <TextInput
                        id="email"
                        :value="local.email"
                        @input="updateFieldLocal('email', $event)"
                        @update:modelValue="
                            (val) => updateFieldLocal('email', val)
                        "
                        type="email"
                        autocomplete="username"
                        placeholder="Introduce tu correo electrónico"
                    />
                    <p class="example">Ejemplo: luisgonzales@gmail.com</p>
                    <InputError
                        :message="
                            local.errors.email ||
                            props.modelValue?.errors?.email
                        "
                    />
                </div>

                <div class="field">
                    <InputLabel for="password" value="Password" texAdd=" *" />
                    <div class="input-icon">
                        <TextInput
                            class="input-pass"
                            id="password"
                            :value="local.password"
                            @input="updateFieldLocal('password', $event)"
                            @update:modelValue="
                                (val) => updateFieldLocal('password', val)
                            "
                            :type="passwordType"
                            autocomplete="new-password"
                            placeholder="Ingresa tu contraseña aquí"
                        />

                        <img
                            :src="eyeIcon"
                            alt="mostrar contraseña"
                            @click="toggleViewPassword"
                            style="cursor: pointer"
                        />
                    </div>
                    <p class="example">Mínimo 8 caracteres</p>
                    <InputError
                        :message="
                            local.errors.password ||
                            props.modelValue?.errors?.password
                        "
                    />
                </div>

                <div class="button-next">
                    <!-- mejor: clase base + clase condicional -->
                    <button
                        type="button"
                        @click="handleNext"
                        :disabled="!isValid"
                        :class="['button-base', { 'btn-class': isValid, gray: !isValid }]"
                        :aria-disabled="!isValid"
                    >
                        {{ isVendor ? '¡Adelante! desatemos nuestra creatividad' : '¡Adelante! continuemos explorando' }}
                    </button>
                </div>
            </div>
        </div>

        <div class="image">
            <img
                src="/img/img-interfaces/img-login.png"
                alt="Imagen de inicio de sesión"
            />
        </div>
    </div>
</template>
