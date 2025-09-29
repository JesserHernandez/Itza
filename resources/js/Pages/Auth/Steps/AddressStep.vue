<script setup>
import { ref, watch, computed } from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import TitleRegister from "@/Components/TitleRegister.vue";
import { municipalitiesByDept, departments } from "@/mapa";

// Props y eventos
const props = defineProps({ modelValue: Object });
const emit = defineEmits(["section-data", "finish"]);

// Estado local para user_address
const localAddress = ref({
    address_type: props.modelValue?.user_address?.address_type || "",
    address_user: props.modelValue?.user_address?.address_user || "",
    postal_code: props.modelValue?.user_address?.postal_code || "",
    address_city: props.modelValue?.user_address?.address_city || "",
    address_municipality: props.modelValue?.user_address?.address_municipality || "",
});

// Sincronizar con el padre si cambia externamente
watch(
    () => props.modelValue?.user_address,
    (nv) => {
        if (!nv) return;
        Object.assign(localAddress.value, { ...(nv || {}) });
    },
    { deep: true }
);

// Emitir cambios al padre
function emitAddress() {
    const data = {
        user_address: { ...(props.modelValue?.user_address || {}), ...localAddress.value },
    };
    console.log("Datos emitidos desde AddressStep:", data);
    emit("section-data", data);
}

// Actualizar campo y emitir cambios
function updateAddressField(field, valueOrEvent) {
    const v =
        valueOrEvent && valueOrEvent.target
            ? valueOrEvent.target.value
            : valueOrEvent;
    localAddress.value[field] = v;
    emitAddress();
}

// Validación mínima para habilitar continuar
const isValid = computed(() => {
    const city = (localAddress.value.address_city || "").trim();
    const municipality = (localAddress.value.address_municipality || "").trim();
    const address = (localAddress.value.address_user || "").trim();
    const address_type = (localAddress.value.address_type || "").trim();
    const postal = (localAddress.value.postal_code || "").trim();

    const postalOk = postal === "" || /^[0-9A-Za-z\s-]{3,10}$/.test(postal);

    return (
        city !== "" &&
        municipality !== "" &&
        address.length > 4 &&
        address_type !== "" &&
        postalOk
    );
});

// Continuar al siguiente paso
function continueStep() {
    emitAddress();
    emit("finish");
}

// Opciones para departamentos y municipios
const departmentOptions = computed(() => departments);
const municipalityOptions = computed(
    () => municipalitiesByDept[localAddress.value.address_city] || []
);

// Cuando cambia el departamento, resetear municipio
watch(
    () => localAddress.value.address_city,
    (nv, ov) => {
        if (nv !== ov) {
            localAddress.value.address_municipality = "";
            emitAddress();
        }
    }
);
</script>

<template>
    <div class="step-one">
        <div class="email-pass address">
            <TitleRegister
                title="¡Felicidades! Ahora eres parte de nuestra comunidad"
            />
            <TitleRegister
                paragraph="Aún necesitamos datos adicionales para completar tu perfil. Es tu mejor carta de presentación."
            />

            <div class="formulario">
                <div class="join">
                    <div class="field">
                        <InputLabel
                            for="address_city"
                            value="Departamento"
                            texAdd=" *"
                        />
                        <select
                            id="address_city"
                            :value="localAddress.address_city"
                            @change="(e) => updateAddressField('address_city', e.target.value)"
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
                        <InputError :message="props.modelValue?.errors?.address_city" />
                    </div>

                    <div class="field">
                        <InputLabel
                            for="address_municipality"
                            value="Municipio"
                            texAdd=" *"
                        />
                        <select
                            id="address_municipality"
                            :value="localAddress.address_municipality"
                            @change="(e) => updateAddressField('address_municipality', e.target.value)"
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
                            :message="props.modelValue?.errors?.address_municipality"
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
                        :value="localAddress.postal_code"
                        @input="(e) => updateAddressField('postal_code', e)"
                        placeholder="23002"
                    />
                    <p class="example">
                        Identificar de forma precisa una zona geográfica
                    </p>
                    <InputError
                        :message="props.modelValue?.errors?.postal_code"
                    />
                </div>

                <div class="field">
                    <InputLabel for="address_user" value="Dirección" texAdd=" *" />
                    <TextInput
                        id="address_user"
                        :value="localAddress.address_user"
                        @input="(e) => updateAddressField('address_user', e)"
                        placeholder="Parque central 2km al norte"
                    />
                    <p class="example">
                        Es necesario en caso de que su producto deba ser enviado
                        a su hogar
                    </p>
                    <InputError :message="props.modelValue?.errors?.address_user" />
                </div>

                <div class="field">
                    <InputLabel for="address_type" value="Tipo de dirección" texAdd=" *" />
                    <TextInput
                        id="address_type"
                        max="10"
                        :value="localAddress.address_type"
                        @input="(e) => updateAddressField('address_type', e)"
                        placeholder="Casa, Apartamento, Oficina, etc."
                    />
                    <p class="example">
                        Por ejemplo: Casa, Oficina, etc.
                    </p>
                    <InputError :message="props.modelValue?.errors?.address_type" />
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
