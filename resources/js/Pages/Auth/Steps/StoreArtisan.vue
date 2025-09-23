<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import TitleRegister from "@/Components/TitleRegister.vue";
import { computed, ref, watch } from "vue";
import { municipalitiesByDept, departments } from "@/mapa";

// props y emits
const props = defineProps({ modelValue: Object });
const emit = defineEmits(["update:modelValue", "finish"]);

// Emit y local es para manejar el estado del formulario
// añado 'next' y 'finish' para que el padre pueda avanzar o finalizar si lo desea
const localTeams = ref({
    name_team: props.modelValue?.teams?.name_team || "",
    address: props.modelValue?.teams?.address || "",
    team_type: props.modelValue?.teams?.team_type || "",
    city: props.modelValue?.teams?.city || "",
    municipality: props.modelValue?.teams?.municipality || "",
    phone_number: props.modelValue?.teams?.phone_number || "",
    ruc: props.modelValue?.teams?.ruc || "",
});

// Sincronizar con el padre si cambia externamente
watch(
    () => props.modelValue?.teams,
    (nv) => {
        // nv es new value que viene del padre (modelValue) externamente y se debe reflejar en el estado local del componente
        if (!nv) return;
        Object.assign(localTeams.value, { ...(nv || {}) });
    },
    { deep: true }
);

// Emitir cambio al padre cuando el usuario edita un campo del formulario (local)
function updateTeamField(field, valueOrEvent) {
    const v =
        valueOrEvent && valueOrEvent.target
            ? valueOrEvent.target.value
            : valueOrEvent;
    localTeams.value[field] = v;
    emitTeams();
}

const isValid = computed(() => {
    // se usa trim() para evitar espacios en blanco como valor válido (que no lo es)
    const name_team = (localTeams.value.name_team || "").trim();
    const address = (localTeams.value.address || "").trim();
    const type = (localTeams.value.team_type || "").trim();
    const city = (localTeams.value.city || "").trim();
    const municipality = (localTeams.value.municipality || "").trim();
    const phone_number = (localTeams.value.phone_number || "").trim();
    const ruc = (localTeams.value.ruc || "").trim();
    return (
        name_team.length > 1 &&
        address.length > 1 &&
        type.length > 1 &&
        city.length > 1 &&
        municipality.length > 1 &&
        phone_number.length > 1 &&
        ruc.length > 1
    );
});

// opciones de departamento (strings)
const cityOptions = computed(() => departments);

// municipios según departamento seleccionado (strings)
const municipalityOptions = computed(() => {
    return municipalitiesByDept[localTeams.value.city] || [];
});

// cuando cambie el departamento (city), resetear municipio
watch(
    () => localTeams.value.city,
    (nv, ov) => {
        if (nv !== ov) {
            localTeams.value.municipality = "";
            emit("update:modelValue", {
                ...(props.modelValue || {}),
                municipality: "",
            });
        }
    }
);

// función para finalizar/emitir datos finales al padre
function continueStep() {
    emitTeams();
    emit("finish"); // evento que indica "finalizar registro"
}

function emitTeams() {
    emit("update:modelValue", {
        ...(props.modelValue || {}),
        teams: { ...(props.modelValue?.teams || {}), ...localTeams.value },
    });
}
</script>

<template>
    <!-- Mantengo tus títulos y comentarios -->
    <TitleRegister title="¡Quiero crear el perfil de mi tienda!" />
    <TitleRegister
        title="Tu perfil de tienda es clave para vender
    tus artesanías. Un perfil completo y detallado genera confianza,
    atrae a más clientes y te ayuda a aprovechar al máximo nuestra plataforma."
    />
    <div class="form">
        <div class="field">
            <InputLabel value="Nombre la tienda artística" texAdd=" *" />
            <!-- Usar local y updateField en lugar de bind directo a modelValue -->
            <TextInput
                id="name_team"
                :value="localTeams.name_team"
                @input="(e) => updateTeamField('name_team', e)"
                @update:modelValue="(val) => updateTeamField('name_team', val)"
                placeholder="Ingresa el nombre de la tienda"
            />
            <p class="input-hint" v-if="props.modelValue?.errors?.name_team">
                {{ props.modelValue.errors.name_team }}
            </p>
        </div>

        <div class="field">
            <InputLabel value="Dirección" texAdd=" *" />
            <TextInput
                id="address"
                :value="localTeams.address"
                @input="(e) => updateTeamField('address', e)"
                @update:modelValue="(val) => updateTeamField('address', val)"
                placeholder="Dirección de la tienda"
            />
            <p class="input-hint" v-if="props.modelValue?.errors?.address">
                {{ props.modelValue.errors.address }}
            </p>
        </div>

        <div class="field">
            <InputLabel value="Tipo de tienda" texAdd=" *" />
            <TextInput
                id="type"
                :value="localTeams.team_type"
                @input="(e) => updateTeamField('team_type', e)"
                @update:modelValue="(val) => updateTeamField('team_type', val)"
                placeholder="Ej. Taller, Galería, Tienda"
            />
            <p class="input-hint" v-if="props.modelValue?.errors?.type">
                {{ props.modelValue.errors.type }}
            </p>
        </div>

        <div class="grid-2">
            <div class="field">
                <InputLabel value="Departamento" texAdd=" *" />
                <select
                    id="city"
                    :value="localTeams.city"
                    @change="(e) => updateTeamField('city', e.target.value)"
                >
                    <option value="">Selecciona un departamento</option>
                    <option
                        v-for="option in cityOptions"
                        :key="option"
                        :value="option"
                    >
                        {{ option }}
                    </option>
                </select>
                <p class="input-hint" v-if="props.modelValue?.errors?.city">
                    {{ props.modelValue.errors.city }}
                </p>
            </div>

            <div class="field">
                <InputLabel value="Municipio" texAdd=" *" />
                <select
                    id="municipality"
                    :value="localTeams.municipality"
                    @change="
                        (e) => updateTeamField('municipality', e.target.value)
                    "
                >
                    <option value="">Selecciona un municipio</option>
                    <option
                        v-for="m in municipalityOptions"
                        :key="m"
                        :value="m"
                    >
                        {{ m }}
                    </option>
                </select>
                <p
                    class="input-hint"
                    v-if="props.modelValue?.errors?.municipality"
                >
                    {{ props.modelValue.errors.municipality }}
                </p>
            </div>
        </div>

        <div class="grid-2">
            <div class="field">
                <InputLabel value="Número de teléfono" />
                <TextInput
                    id="phone_number"
                    :value="localTeams.phone_number"
                    @input="(e) => updateTeamField('phone_number', e)"
                    @update:modelValue="
                        (val) => updateTeamField('phone_number', val)
                    "
                    placeholder="Teléfono de contacto"
                />
                <p
                    class="input-hint"
                    v-if="props.modelValue?.errors?.phone_number"
                >
                    {{ props.modelValue.errors.phone_number }}
                </p>
            </div>

            <div class="field">
                <InputLabel value="RUC / Identificación fiscal" />
                <TextInput
                    id="ruc"
                    :value="localTeams.ruc"
                    @input="(e) => updateTeamField('ruc', e)"
                    @update:modelValue="(val) => updateTeamField('ruc', val)"
                    placeholder="RUC o número de identificación"
                />
                <p class="input-hint" v-if="props.modelValue?.errors?.ruc">
                    {{ props.modelValue.errors.ruc }}
                </p>
            </div>
        </div>

        <!-- si quieres controlar habilitación desde aquí -->
        <div class="actions">
            <!-- botón llama continueStep y no solo next -->
            <button type="button" :disabled="!isValid" @click="continueStep">
                ¡Felicidades! continua con el perfil de tu tienda
            </button>
        </div>
    </div>
    <div class="img">
        <img src="/img/img-interfaces/artisan-female.png" alt="" />
    </div>
</template>
