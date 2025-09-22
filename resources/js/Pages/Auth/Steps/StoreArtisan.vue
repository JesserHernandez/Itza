<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import TitleRegister from '@/Components/TitleRegister.vue';
import { computed, ref, watch } from 'vue';
import { municipalitiesByDept, departments } from '@/mapa';

// props y emits
const props = defineProps({
    modelValue: Object,
    image: String
});

// Emit y local es para manejar el estado del formulario
// añado 'next' y 'finish' para que el padre pueda avanzar o finalizar si lo desea
const emit = defineEmits(['update:modelValue', 'next', 'finish']);

const local = ref({
    name_team: props.modelValue?.name_team || '',
    address: props.modelValue?.address || '',
    type: props.modelValue?.type || '',
    // 'city' aquí representa el departamento seleccionado (mantengo el nombre por compatibilidad)
    city: props.modelValue?.city || '',
    municipality: props.modelValue?.municipality || '',
    phone_number: props.modelValue?.phone_number || '',
    ruc: props.modelValue?.ruc || '',
});

// Sincronizar con el padre si cambia externamente
watch(() => props.modelValue, (nv) => {
    // nv es new value que viene del padre (modelValue) externamente y se debe reflejar en el estado local del componente
    if (!nv) return;
    if (nv.name_team !== undefined) local.value.name_team = nv.name_team;
    if (nv.address !== undefined) local.value.address = nv.address;
    if (nv.type !== undefined) local.value.type = nv.type;
    if (nv.city !== undefined) local.value.city = nv.city;
    if (nv.municipality !== undefined) local.value.municipality = nv.municipality;
    if (nv.phone_number !== undefined) local.value.phone_number = nv.phone_number;
    if (nv.ruc !== undefined) local.value.ruc = nv.ruc;
}, { deep: true });

// Emitir cambio al padre cuando el usuario edita un campo del formulario (local)
function updateField(field, valueOrEvent) {
    const value = (valueOrEvent && valueOrEvent.target) ? valueOrEvent.target.value : valueOrEvent;
    local.value[field] = value;
    emit('update:modelValue', { ...(props.modelValue || {}), [field]: value });
}

const isValid = computed(() => {
    // se usa trim() para evitar espacios en blanco como valor válido (que no lo es)
    const name_team = (local.value.name_team || '').trim();
    const address = (local.value.address || '').trim();
    const type = (local.value.type || '').trim();
    const city = (local.value.city || '').trim();
    const municipality = (local.value.municipality || '').trim();
    const phone_number = (local.value.phone_number || '').trim();
    const ruc = (local.value.ruc || '').trim();
    return name_team.length > 1 && address.length > 1 && type.length > 1 && city.length > 1 && municipality.length > 1 && phone_number.length > 1 && ruc.length > 1;
});

// opciones de departamento (strings)
const cityOptions = computed(() => departments);

// municipios según departamento seleccionado (strings)
const municipalityOptions = computed(() => {
    return municipalitiesByDept[local.value.city] || [];
});

// cuando cambie el departamento (city), resetear municipio
watch(() => local.value.city, (nv, ov) => {
    if (nv !== ov) {
        local.value.municipality = '';
        emit('update:modelValue', { ...(props.modelValue || {}), municipality: '' });
    }
});

// función para finalizar/emitir datos finales al padre
function continueStep() {
    // emitir datos finales al padre
    emit('update:modelValue', { ...(props.modelValue || {}), ...local.value });
    emit('finish'); // evento que indica "finalizar registro"
}
</script>

<template>
    <!-- Mantengo tus títulos y comentarios -->
    <TitleRegister title="¡Quiero crear el perfil de mi tienda!" />
    <TitleRegister title="Tu perfil de tienda es clave para vender
    tus artesanías. Un perfil completo y detallado genera confianza,
    atrae a más clientes y te ayuda a aprovechar al máximo nuestra plataforma." />
    <div class="form">

        <div class="field">
            <InputLabel value="Nombre la tienda artística" texAdd=" *" />
            <!-- Usar local y updateField en lugar de bind directo a modelValue -->
            <TextInput id="name_team" :value="local.name_team" @input="e => updateField('name_team', e)"
                @update:modelValue="val => updateField('name_team', val)"
                placeholder="Ingresa el nombre de la tienda" />
            <p class="input-hint" v-if="props.modelValue?.errors?.name_team">{{ props.modelValue.errors.name_team }}</p>
        </div>

        <div class="field">
            <InputLabel value="Dirección" texAdd=" *" />
            <TextInput id="address" :value="local.address" @input="e => updateField('address', e)"
                @update:modelValue="val => updateField('address', val)" placeholder="Dirección de la tienda" />
            <p class="input-hint" v-if="props.modelValue?.errors?.address">{{ props.modelValue.errors.address }}</p>
        </div>

        <div class="field">
            <InputLabel value="Tipo de tienda" texAdd=" *" />
            <TextInput id="type" :value="local.type" @input="e => updateField('type', e)"
                @update:modelValue="val => updateField('type', val)" placeholder="Ej. Taller, Galería, Tienda" />
            <p class="input-hint" v-if="props.modelValue?.errors?.type">{{ props.modelValue.errors.type }}</p>
        </div>

        <div class="grid-2">
            <div class="field">
                <InputLabel value="Departamento" texAdd=" *" />
                <select id="city" :value="local.city" @change="e => updateField('city', e.target.value)">
                    <option value="">Selecciona un departamento</option>
                    <option v-for="option in cityOptions" :key="option" :value="option">
                        {{ option }}
                    </option>
                </select>
                <p class="input-hint" v-if="props.modelValue?.errors?.city">{{ props.modelValue.errors.city }}</p>
            </div>

            <div class="field">
                <InputLabel value="Municipio" texAdd=" *" />
                <select id="municipality" :value="local.municipality"
                    @change="e => updateField('municipality', e.target.value)">
                    <option value="">Selecciona un municipio</option>
                    <option v-for="m in municipalityOptions" :key="m" :value="m">
                        {{ m }}
                    </option>
                </select>
                <p class="input-hint" v-if="props.modelValue?.errors?.municipality">{{
                    props.modelValue.errors.municipality }}</p>
            </div>
        </div>

        <div class="grid-2">
            <div class="field">
                <InputLabel value="Número de teléfono" />
                <TextInput id="phone_number" :value="local.phone_number" @input="e => updateField('phone_number', e)"
                    @update:modelValue="val => updateField('phone_number', val)" placeholder="Teléfono de contacto" />
                <p class="input-hint" v-if="props.modelValue?.errors?.phone_number">{{
                    props.modelValue.errors.phone_number }}</p>
            </div>

            <div class="field">
                <InputLabel value="RUC / Identificación fiscal" />
                <TextInput id="ruc" :value="local.ruc" @input="e => updateField('ruc', e)"
                    @update:modelValue="val => updateField('ruc', val)" placeholder="RUC o número de identificación" />
                <p class="input-hint" v-if="props.modelValue?.errors?.ruc">{{ props.modelValue.errors.ruc }}</p>
            </div>
        </div>

        <!-- si quieres controlar habilitación desde aquí -->
        <div class="actions">
            <!-- botón llama continueStep y no solo next -->
            <button type="button" :disabled="!isValid" @click="continueStep">¡Felicidades! continua con el perfil de tu
                tienda</button>
        </div>
    </div>
    <div class="img">
        <img src="/img/img-interfaces/artisan-female.png" alt="">
    </div>
</template>
