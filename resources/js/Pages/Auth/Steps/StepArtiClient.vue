<script setup>
import { ref, watch, computed } from "vue";
import TextInput from "@/Components/TextInput.vue";
import TitleRegister from "@/Components/TitleRegister.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";

const props = defineProps({
    modelValue: Object,
    is_vendor: [Boolean, String, Number],
    img: String,
});

// isVendor robusto (acepta true/"true"/1/"1"/2/"2")
const isVendor = computed(
    () =>
        props.is_vendor === true ||
        props.is_vendor === "true" ||
        props.is_vendor === 1 ||
        props.is_vendor === "1" ||
        props.is_vendor === 2 ||
        props.is_vendor === "2"
);

const emit = defineEmits(["section-data", "next"]);

// estado local consistente
const local = ref({
    name: props.modelValue?.name || "",
    surname: props.modelValue?.surname || "",
    gender: props.modelValue?.gender || "",
    identification_card: props.modelValue?.identification_card || "",
    phone_number: props.modelValue?.phone_number || "",
});

// sincronizar con el padre si cambia externamente
watch(
    () => props.modelValue,
    (nv) => {
        if (!nv) return;
        if (nv.name !== undefined) local.value.name = nv.name;
        if (nv.surname !== undefined) local.value.surname = nv.surname;
        if (nv.gender !== undefined) local.value.gender = nv.gender;
        if (nv.identification_card !== undefined)
            local.value.identification_card = nv.identification_card;
        // aceptar phone_number o phoneNumber del padre
        if (nv.phone_number !== undefined) {
            local.value.phone_number = nv.phone_number;
        } else if (nv.phoneNumber !== undefined) {
            local.value.phone_number = nv.phoneNumber;
        }
    },
    { deep: true }
);

// emitir solo la sección (no reemplaza form)
function emitSection() {
    const payload = {
        name: local.value.name,
        surname: local.value.surname,
        gender: local.value.gender,
        identification_card: local.value.identification_card,
        phone_number: local.value.phone_number, // asegúrate que es phone_number
    };
    console.log("StepArtiClient -> section-data:", payload);
    emit("section-data", payload);
}

function updateField(field, valueOrEvent) {
    const value =
        valueOrEvent && valueOrEvent.target
            ? valueOrEvent.target.value
            : valueOrEvent;
    local.value[field] = value;
    emitSection();
}

// calcular fecha máxima (>=18 años)
const maxBirth = (() => {
    const d = new Date();
    d.setFullYear(d.getFullYear() - 18);
    const yyyy = d.getFullYear();
    const mm = String(d.getMonth() + 1).padStart(2, "0");
    const dd = String(d.getDate()).padStart(2, "0");
    return `${yyyy}-${mm}-${dd}`;
})();

// validación: birth required solo para no-vendor; identification_card solo para vendor
const isValid = computed(() => {
    const name = (local.value.name || "").trim();
    const surname = (local.value.surname || "").trim();
    const gender = (local.value.gender || "").trim();
    const identification_card = (local.value.identification_card || "").trim();
    const phone_number = (local.value.phone_number || "").trim();
    const idOk = isVendor.value ? identification_card.length > 0 : true;
    const birthOk = isVendor.value || birth.length > 0;

    // Si el teléfono debe ser obligatorio, descomenta la segunda condición:
    return name.length > 1 && surname.length > 1 && gender !== "" && idOk;
});

function handleNext(e) {
    e?.preventDefault?.();
    if (!isValid.value) return;
    emitSection(); // aseguramos que el padre recibe los últimos cambios
    emit("next");
}
</script>

<template>
    <div class="step-one">
        <div class="email-pass articlient">
            <TitleRegister
                :title="
                    isVendor
                        ? '¡Quiero crear mi cuenta de artista!'
                        : '¡Quiero crear mi cuenta de usuario!'
                "
            />
            <TitleRegister
                :paragraph="
                    isVendor
                        ? 'Si eres artesano, tener un perfil completo genera confianza y credibilidad en tus clientes. Además, esta información es clave para que puedas aprovechar al máximo nuestra plataforma'
                        : 'Tener un perfil completo es clave para acceder a rutas creativas y catálogos exclusivos. Con tu información, podemos recomendarte obras y artesanos que se ajusten a tus gustos.'
                "
            />

            <div class="formulario">
                <div class="join">
                    <div class="field">
                        <InputLabel for="name" value="Nombres" texAdd=" *" />
                        <TextInput
                            id="name"
                            :value="local.name"
                            class="articlient-name"
                            @input="(e) => updateField('name', e)"
                            @update:modelValue="
                                (val) => updateField('name', val)
                            "
                            placeholder="Nombres"
                            required
                        />
                        <InputError :message="props.modelValue?.errors?.name" />
                    </div>

                    <div class="field">
                        <InputLabel
                            for="surname"
                            value="Apellidos"
                            texAdd=" *"
                        />
                        <TextInput
                            id="surname"
                            :value="local.surname"
                            class="articlient-surname"
                            @input="(e) => updateField('surname', e)"
                            @update:modelValue="
                                (val) => updateField('surname', val)
                            "
                            placeholder="Apellidos"
                            required
                        />
                        <InputError
                            :message="props.modelValue?.errors?.surname"
                        />
                    </div>
                </div>

                <div class="field">
                    <InputLabel for="gender" value="Género" texAdd=" *" />
                    <select
                        id="gender"
                        :value="local.gender"
                        @change="(e) => updateField('gender', e.target.value)"
                        required
                    >
                        <option value="">Seleccione</option>
                        <option value="male">Masculino</option>
                        <option value="female">Femenino</option>
                    </select>
                    <InputError :message="props.modelValue?.errors?.gender" />
                </div>

                <div class="join">
                    <div class="field">
                        <InputLabel
                            for="identification_card"
                            value="Cédula de Identidad"
                            texAdd=" *"
                        />
                        <TextInput
                            id="identification_card"
                            type="text"
                            class="articlient-card"
                            :value="local.identification_card"
                            placeholder="Ingresa cédula aquí"
                            @input="
                                (e) => updateField('identification_card', e)
                            "
                            @update:modelValue="
                                (val) => updateField('identification_card', val)
                            "
                            required
                        />
                        <InputError
                            :message="
                                props.modelValue?.errors?.identification_card ||
                                props.modelValue?.errors?.id_card
                            "
                        />
                        <p class="example">Necesitamos validar tu identidad</p>
                    </div>

                    <div class="field">
                        <InputLabel
                            for="phone_number"
                            value="Número de teléfono"
                            texAdd=" *"
                        />
                        <TextInput
                            id="phone_number"
                            class="articlient-phone"
                            type="tel"
                            :value="local.phone_number"
                            @input="(e) => updateField('phone_number', e)"
                            @update:modelValue="
                                (val) => updateField('phone_number', val)
                            "
                            placeholder="Teléfono"
                        />
                        <p class="example">Tu formato de contacto</p>
                        <InputError
                            :message="props.modelValue?.errors?.phone_number"
                        />
                    </div>
                </div>

                <div class="button-artist">
                    <button
                        type="button"
                        @click="handleNext"
                        :disabled="!isValid"
                        :class="[
                            'button-base',
                            { 'btn-class': isValid, gray: !isValid },
                        ]"
                    >
                        {{
                            isVendor
                                ? "¡Regístrate como los artistas!"
                                : "¡Confirma tu perfil y continúa!"
                        }}
                    </button>
                </div>
            </div>
        </div>

        <div class="image">
            <img
                :src="
                    isVendor
                        ? '/img/img-interfaces/img-male.png'
                        : '/img/img-interfaces/img-female.png'
                "
                alt=""
            />
        </div>
    </div>
</template>
