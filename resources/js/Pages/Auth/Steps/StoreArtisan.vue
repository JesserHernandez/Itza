<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import TitleRegister from "@/Components/TitleRegister.vue";
import { computed, ref, watch } from "vue";
import { municipalitiesByDept, departments } from "@/mapa";

// props y emits
const props = defineProps({ modelValue: Object });
const emit = defineEmits(["section-data", "finish"]);

// local para teams (mantener namespaced)
const localTeams = ref({
    name_team: props.modelValue?.teams?.name_team || "",
    address: props.modelValue?.teams?.address || "",
    type: props.modelValue?.teams?.type || "",
    city: props.modelValue?.teams?.city || "",
    municipality: props.modelValue?.teams?.municipality || "",
    phoneNumber: props.modelValue?.teams?.phoneNumber || "",
});

// sincronizar con el padre si cambia externamente
watch(
    () => props.modelValue?.teams,
    (nv) => {
        if (!nv) return;
        Object.assign(localTeams.value, { ...(nv || {}) });
    },
    { deep: true }
);

// emitir únicamente la sección teams (no reemplaza form)
function emitTeams() {
    emit("section-data", {
        teams: { ...(props.modelValue?.teams || {}), ...localTeams.value },
    });
}

// emitir cambio al padre cuando el usuario edita un campo del formulario (local)
function updateTeamField(field, valueOrEvent) {
    const v =
        valueOrEvent && valueOrEvent.target
            ? valueOrEvent.target.value
            : valueOrEvent;
    localTeams.value[field] = v;
    emitTeams();
}

const isValid = computed(() => {
    const name_team = (localTeams.value.name_team || "").trim();
    const address = (localTeams.value.address || "").trim();
    const type = (localTeams.value.type || "").trim();
    const city = (localTeams.value.city || "").trim();
    const municipality = (localTeams.value.municipality || "").trim();
    const phoneNumber = (localTeams.value.phoneNumber || "").trim();
    return (
        name_team.length > 1 &&
        address.length > 1 &&
        type.length > 1 &&
        city.length > 1 &&
        municipality.length > 1 &&
        phoneNumber.length > 1
    );
});

// opciones de departamento (strings)
const cityOptions = computed(() => departments);

// municipios según departamento seleccionado (strings)
const municipalityOptions = computed(() => {
    return municipalitiesByDept[localTeams.value.city] || [];
});

// cuando cambie el departamento (city), resetear municipio y notificar al padre
watch(
    () => localTeams.value.city,
    (nv, ov) => {
        if (nv !== ov) {
            localTeams.value.municipality = "";
            // emitir la sección teams con municipio reseteado
            emit("section-data", {
                teams: { ...(props.modelValue?.teams || {}), municipality: "" },
            });
        }
    }
);

// función para finalizar/emitir datos finales al padre (último paso vendedor)
function continueStep() {
    emitTeams();
    emit("finish"); // evento que indica "finalizar registro" (el padre debe hacer submit)
}
</script>

<template>
    <div class="step-one">
        <div class="email-pass store">
            <TitleRegister title="¡Quiero crear el perfil de mi tienda!" />
            <TitleRegister
                paragraph="Tu perfil de tienda es clave para vender
            tus artesanías. Un perfil completo y detallado genera confianza,
            atrae a más clientes y te ayuda a aprovechar al máximo nuestra plataforma."
            />

            <div class="formulario">
                <div class="field">
                    <InputLabel value="Nombre la tienda artística" texAdd=" *" />
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

                <div class="join">
                    <div class="field">
                        <InputLabel value="Departamento" texAdd=" *" />
                        <select
                            id="city"
                            :value="localTeams.city"
                            @change="(e) => updateTeamField('city', e.target.value)"
                        >
                            <option value="">Departamento</option>
                            <option v-for="option in cityOptions" :key="option" :value="option">
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
                            @change="(e) => updateTeamField('municipality', e.target.value)"
                        >
                            <option value="">Selecciona un municipio</option>
                            <option v-for="m in municipalityOptions" :key="m" :value="m">
                                {{ m }}
                            </option>
                        </select>
                        <p class="input-hint" v-if="props.modelValue?.errors?.municipality">
                            {{ props.modelValue.errors.municipality }}
                        </p>
                    </div>
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
                    <p class="example">Tus clientes deben contactar con una dirección para cualquier retiro</p>
                    <p class="input-hint" v-if="props.modelValue?.errors?.address">
                        {{ props.modelValue.errors.address }}
                    </p>
                </div>

                <div class="field">
                    <InputLabel value="Tipo de tienda" texAdd=" *" />
                    <TextInput
                        id="type"
                        :value="localTeams.type"
                        @input="(e) => updateTeamField('type', e)"
                        @update:modelValue="(val) => updateTeamField('type', val)"
                        placeholder="Tienda de cerámica precolombina"
                    />
                    <p class="input-hint" v-if="props.modelValue?.errors?.type">
                        {{ props.modelValue.errors.type }}
                    </p>
                    <p class="example">Validar su tipo de producto</p>
                </div>

                <div class="field">
                    <InputLabel value="Número de contacto" texAdd=" *" />
                    <TextInput
                        id="phoneNumber"
                        type="tel"
                        :value="localTeams.phoneNumber"
                        @input="(e) => updateTeamField('phoneNumber', e)"
                        @update:modelValue="(val) => updateTeamField('phoneNumber', val)"
                        placeholder="Número de contacto de la tienda"
                    />
                    <p class="example">Tu formato de contacto</p>
                </div>

                <div class="button-artist">
                    <button
                        type="button"
                        :disabled="!isValid"
                        @click="continueStep"
                        :class="['button-base', { 'btn-class': isValid, gray: !isValid }]"
                    >
                        ¡Perfil de tienda completado!
                    </button>
                </div>
            </div>
        </div>
        <div class="image-store">
            <img src="/img/img-interfaces/artisan-female.png" alt="" />
        </div>
    </div>
</template>
