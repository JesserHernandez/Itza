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

const isVendor = computed(
    () =>
        props.is_vendor === true ||
        props.is_vendor === "true" ||
        props.is_vendor === 2 ||
        props.is_vendor === "2"
);

const emit = defineEmits(["update:modelValue", "next"]);

// estado local: usa siempre identification_card (consistente)
const local = ref({
    name: props.modelValue?.name || "",
    surname: props.modelValue?.surname || "",
    gender: props.modelValue?.gender || "",
    birth_date: props.modelValue?.birth_date || "",
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
        if (nv.birth_date !== undefined) local.value.birth_date = nv.birth_date;
        if (nv.identification_card !== undefined)
            local.value.identification_card = nv.identification_card;
        if (nv.phone_number !== undefined)
            local.value.phone_number = nv.phone_number;
    },
    { deep: true }
);

// emitir cambio al padre (mantén clave consistente)
function updateField(field, valueOrEvent) {
    const value =
        valueOrEvent && valueOrEvent.target
            ? valueOrEvent.target.value
            : valueOrEvent;
    local.value[field] = value;
    emit("update:modelValue", { ...(props.modelValue || {}), [field]: value });
}

// validación: birth required solo para no-vendor; identification_card solo para vendor
const isValid = computed(() => {
    const name = (local.value.name || "").trim();
    const surname = (local.value.surname || "").trim();
    const gender = (local.value.gender || "").trim();
    const birth = (local.value.birth_date || "").trim();
    const idCard = (local.value.identification_card || "").trim();

    const idOk = isVendor.value ? idCard.length > 0 : true;
    const birthOk = isVendor.value ? true : birth.length > 0;

    return (
        name.length > 1 &&
        surname.length > 1 &&
        gender !== "" &&
        idOk &&
        birthOk
    );
});

function handleNext(e) {
    e?.preventDefault?.();
    if (!isValid.value) return;
    // sincronizar antes de avanzar
    emit("update:modelValue", { ...(props.modelValue || {}), ...local.value });
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
                            :value="local.name" class="articlient-name"
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
                            id="surname" class="articlient-surname"
                            :value="local.surname"
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

                <!-- Cédula: solo para vendors -->
                <div class="join">
                    <div class="field" v-if="isVendor">
                        <InputLabel
                            for="identification_card"
                            value="Cédula de Identidad"
                            texAdd=" *"
                        />
                        <TextInput
                            id="identification_card"
                            type="text" class="articlient-card"
                            :value="local.identification_card"
                            placeholder="Ingresa cédula aquí"
                            @input="(e) => updateField('identification_card', e)"
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
                    </div>


                    <!-- Fecha de nacimiento: solo para no-vendors -->
                    <div class="field" v-if="!isVendor">
                        <InputLabel
                            for="birth_date"
                            value="Fecha de Nacimiento"
                            texAdd=" *"
                        />
                        <TextInput
                            id="birth_date" class="articlient-birth"
                            type="date"
                            :value="local.birth_date"
                            @input="(e) => updateField('birth_date', e)"
                            @update:modelValue="
                                (val) => updateField('birth_date', val)
                            "
                            required
                        />
                        <InputError
                            :message="props.modelValue?.errors?.birth_date"
                        />
                    </div>

                    <div class="field">
                        <InputLabel
                            for="phone_number"
                            value="Número de teléfono"
                            texAdd=" *"
                        />
                        <TextInput
                            id="phone_number" class="articlient-phone"
                            :value="local.phone_number"
                            @input="(e) => updateField('phone_number', e)"
                            @update:modelValue="
                                (val) => updateField('phone_number', val)
                            "
                            placeholder="Teléfono (opcional)"
                        />
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
