<script setup>
import { ref, watch, computed } from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import TitleRegister from "@/Components/TitleRegister.vue";
import { municipalitiesByDept, departments } from "@/mapa";

// Props / emits
const props = defineProps({ modelValue: Object });
const emit = defineEmits(["update:modelValue", "finish", "next"]);

const localAddress = ref({
    address_type: props.modelValue?.user_address?.address_type || "",
    user_address: props.modelValue?.user_address?.user_address || "",
    postal_code: props.modelValue?.user_address?.postal_code || "",
    city: props.modelValue?.user_address?.city || "",
    municipality: props.modelValue?.user_address?.municipality || "",
    phone_number: props.modelValue?.user_address?.phone_number || "",
    facturation: props.modelValue?.user_address?.facturation || false,
    active: props.modelValue?.user_address?.active ?? true,
});

watch(
    () => props.modelValue?.user_address,
    (nv) => {
        if (!nv) return;
        Object.assign(localAddress.value, { ...(nv || {}) });
    },
    { deep: true }
);

function emitAddress() {
    emit("update:modelValue", {
        ...(props.modelValue || {}),
        user_address: {
            ...(props.modelValue?.user_address || {}),
            ...localAddress.value,
        },
    });
}

function updateAddressField(field, valueOrEvent) {
    const v =
        valueOrEvent && valueOrEvent.target
            ? valueOrEvent.target.value
            : valueOrEvent;
    localAddress.value[field] = v;
    emitAddress();
}

function handleNext() {
    emitAddress();
    emit("next");
}

// estado local (sin mensajes de error en JS)
const local = ref({
    type: props.modelValue?.type || "envio", // 'envio' | 'factura'
    city: props.modelValue?.city || "",
    municipality: props.modelValue?.municipality || "",
    postal_code: props.modelValue?.postal_code || "",
    address: props.modelValue?.address || "",
});

// sincronizar si padre actualiza modelValue
watch(
    () => props.modelValue,
    (nv) => {
        if (!nv) return;
        if (nv.type !== undefined) local.value.type = nv.type;
        if (nv.city !== undefined) local.value.city = nv.city;
        if (nv.municipality !== undefined)
            local.value.municipality = nv.municipality;
        if (nv.postal_code !== undefined)
            local.value.postal_code = nv.postal_code;
        if (nv.address !== undefined) local.value.address = nv.address;
    },
    { deep: true }
);

// opciones computed
const departmentOptions = computed(() => departments);
const municipalityOptions = computed(
    () => municipalitiesByDept[local.value.city] || []
);

// cuando cambia departamento, resetear municipio y notificar al padre
watch(
    () => local.value.city,
    (nv, ov) => {
        if (nv !== ov) {
            local.value.municipality = "";
            emitUpdated();
        }
    }
);

// helper para actualizar campo y notificar al padre
function updateField(field, valueOrEvent) {
    const val =
        valueOrEvent && valueOrEvent.target
            ? valueOrEvent.target.value
            : valueOrEvent;
    local.value[field] = val;
    emitUpdated();
}

function emitUpdated() {
    emit("update:modelValue", { ...(props.modelValue || {}), ...local.value });
}

// validación mínima para habilitar continuar
const isValid = computed(() => {
    const city = (local.value.city || "").trim();
    const municipality = (local.value.municipality || "").trim();
    const address = (local.value.address || "").trim();
    const postal = (local.value.postal_code || "").trim();
    const postalOk = postal === "" || /^[0-9A-Za-z\s-]{3,10}$/.test(postal); // postal opcional pero formato simple
    return city !== "" && municipality !== "" && address.length > 4 && postalOk;
});

function continueStep() {
    // emitir datos finales al padre
    emit("update:modelValue", { ...(props.modelValue || {}), ...local.value });
    // emitir 'next' (y también 'finish' por compatibilidad con implementaciones previas)
    emit("next");
    emit("finish");
}
</script>

<template>
    <div class="step-one">
        <div class="email-pass address">
            <TitleRegister
                title="¡Felicidades! Ahora eres parte de nuestra comunidad"
            />
            <TitleRegister
                paragraph="Aún necesitamos datos adicionales para completar tu perfil es tu mejor carta de presentación."
            />

            <div class="formulario">
                <div class="join">
                    <div class="field">
                        <InputLabel
                            for="city"
                            value="Departamento"
                            texAdd=" *"
                        />
                        <select
                            id="city"
                            :value="local.city"
                            @change="(e) => updateField('city', e.target.value)"
                        >
                            <option value="">Departamento</option>
                            <option
                                v-for="d in departmentOptions"
                                :key="d"
                                :value="d"
                            >
                                {{ d }}
                            </option>
                        </select>
                        <InputError :message="props.modelValue?.errors?.city" />
                    </div>

                        <div class="field">
                            <InputLabel
                                for="municipality"
                                value="Municipio"
                                texAdd=" *"
                            />
                            <select
                                id="municipality"
                                :value="local.municipality"
                                @change="
                                    (e) =>
                                        updateField(
                                            'municipality',
                                            e.target.value
                                        )
                                "
                            >
                                <option value="">Selecciona municipio</option>
                                <option
                                    v-for="m in municipalityOptions"
                                    :key="m"
                                    :value="m"
                                >
                                    {{ m }}
                                </option>
                            </select>
                            <InputError
                                :message="
                                    props.modelValue?.errors?.municipality
                                "
                            />
                        </div>
                </div>

                <div class="field">
                    <InputLabel
                        for="postal_code"
                        value="Código postal"
                        texAdd=" *"
                    />
                    <TextInput
                        id="postal_code"
                        :value="local.postal_code"
                        @input="(e) => updateField('postal_code', e)"
                        @update:modelValue="
                            (val) => updateField('postal_code', val)
                        "
                        placeholder="23002"
                    />
                    <InputError
                        :message="props.modelValue?.errors?.postal_code"
                    />
                </div>

                <div class="field">
                    <InputLabel for="address" value="Dirección" texAdd=" *" />
                    <TextInput
                        id="address"
                        :value="local.address"
                        @input="(e) => updateField('address', e)"
                        @update:modelValue="
                            (val) => updateField('address', val)
                        "
                        placeholder="Parque central 2km al norte"
                    />
                    <InputError :message="props.modelValue?.errors?.address" />
                </div>

                <!-- Tipo de dirección: usar radio (envío vs factura). Se actualiza local.type y se emite -->
                <div class="field">
                    <InputLabel
                        class="terms"
                        value="Tipo de dirección"
                        texAdd=" *"
                    />
                    <div class="radio-group">
                        <label>
                            <input
                                type="radio"
                                class="radio"
                                name="address_type"
                                :checked="local.type === 'envio'"
                                @change="() => updateField('type', 'envio')"
                            />
                            <span>Dirección de envío</span>
                        </label>

                        <label>
                            <input
                                type="radio"
                                class="radio"
                                name="address_type"
                                :checked="local.type === 'factura'"
                                @change="() => updateField('type', 'factura')"
                            />
                            <span>Dirección de factura</span>
                        </label>
                    </div>
                </div>

                <div class="button-artist">
                    <button
                        type="button"
                        :disabled="!isValid"
                        @click="continueStep"
                        :class="[
                            'button-base',
                            { 'btn-class': isValid, gray: !isValid },
                        ]"
                    >
                        ¡Adelante! confirma esta información adicional
                    </button>
                </div>
            </div>
        </div>
        <div class="image">
            <img src="/img/img-interfaces/img-female.png" alt="" />
        </div>
    </div>
</template>
