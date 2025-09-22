<script setup>
import { ref, watch, computed } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import TitleRegister from '@/Components/TitleRegister.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    modelValue: Object,
    is_vendor: [Boolean, String, Number],
    img: String
});

const isVendor = computed(() =>
    props.is_vendor === true ||
    props.is_vendor === 'true' ||
    props.is_vendor === 2 ||
    props.is_vendor === '2'
);
// emit es para
const emit = defineEmits(['update:modelValue', 'next']);

// Estado local para editar/validar antes de emitir
const local = ref({
    name: props.modelValue?.name || '',
    surname: props.modelValue?.surname || '',
    gender: props.modelValue?.gender || '',
    birth_date: props.modelValue?.birth_date || '',
    phone_number: props.modelValue?.phone_number || ''
});

// sincronizar con el padre si cambia externamente
watch(() => props.modelValue, (nv) => {
    if (!nv) return;
    if (nv.name !== undefined) local.value.name = nv.name;
    if (nv.surname !== undefined) local.value.surname = nv.surname;
    if (nv.gender !== undefined) local.value.gender = nv.gender;
    if (nv.birth_date !== undefined) local.value.birth_date = nv.birth_date;
    if (nv.phone_number !== undefined) local.value.phone_number = nv.phone_number;
}, { deep: true });

// emitir cambio al padre
function updateField(field, valueOrEvent) {
    const value = (valueOrEvent && valueOrEvent.target) ? valueOrEvent.target.value : valueOrEvent;
    local.value[field] = value;
    emit('update:modelValue', { ...(props.modelValue || {}), [field]: value });
}

// validación mínima para habilitar continuar (sin mensajes en JS)
const isValid = computed(() => {
    const name = (local.value.name || '').trim();
    const surname = (local.value.surname || '').trim();
    const gender = (local.value.gender || '').trim();
    const birth = (local.value.birth_date || '').trim();
    // teléfono opcional
    return name.length > 1 && surname.length > 1 && gender !== '' && birth !== '';
});

function handleNext(e) {
    e?.preventDefault?.();
    // solo emitir next si es válido (no mostramos mensajes aquí)
    if (!isValid.value) return;
    emit('next');
}
</script>

<template>


    <TitleRegister :title="isVendor === true ? '¡Quiero crear mi cuenta de artista!' : '¡Quiero crear mi cuenta de usuario!'" />
    <TitleRegister
        :title="isVendor === true ? 'Si eres artesano, tener un perfil completo genera confianza y credibilidad en tus clientes. Además, esta información es clave para que puedas aprovechar al máximo nuestra plataforma' : 'Tener un perfil completo es clave para acceder a rutas creativas y catálogos exclusivos. Con tu información, podemos recomendarte obras y artesanos que se ajusten a tus gustos.'" />
    <div class="field">
        <div class="formulario">
            <div class="field">
                <InputLabel for="name" value="Nombres" />
                <TextInput id="name" :value="local.name" @input="e => updateField('name', e)"
                    @update:modelValue="val => updateField('name', val)" placeholder="Nombres" required />
                <InputError :message="props.modelValue?.errors?.name" />
            </div>

            <div class="field">
                <InputLabel for="surname" value="Apellidos" />
                <TextInput id="surname" :value="local.surname" @input="e => updateField('surname', e)"
                    @update:modelValue="val => updateField('surname', val)" placeholder="Apellidos" required />
                <InputError :message="props.modelValue?.errors?.surname" />
            </div>

            <div class="field">
                <InputLabel for="gender" value="Género" />
                <select id="gender" :value="local.gender" @change="e => updateField('gender', e.target.value)" required>
                    <option value="">Seleccione</option>
                    <option value="male">Masculino</option>
                    <option value="female">Femenino</option>
                </select>
                <InputError :message="props.modelValue?.errors?.gender" />
            </div>

            <div class="field">
                <InputLabel for="birth_date" value="Fecha de nacimiento" />
                <input id="birth_date" type="date" :value="local.birth_date"
                    @input="e => updateField('birth_date', e.target.value)" required />
                <InputError :message="props.modelValue?.errors?.birth_date" />
            </div>

            <div class="field">
                <InputLabel for="phone_number" value="Número de teléfono" />
                <TextInput id="phone_number" :value="local.phone_number" @input="e => updateField('phone_number', e)"
                    @update:modelValue="val => updateField('phone_number', val)" placeholder="Teléfono (opcional)" />
                <InputError :message="props.modelValue?.errors?.phone_number" />
            </div>

            <div class="actions">
                <button type="button" @click="handleNext" :disabled="!isValid">
                    {{ isVendor === true ? '¡Adelante, continua registrandote como artista' : '¡Confirma tu perfil y continúa!' }}
                </button>
            </div>
        </div>
    </div>
    <div class="image">
        <img :src="isVendor === true ? '/img/img-interfaces/img-male.png' : '/img/img-interfaces/img-female.png'" alt="">
    </div>
</template>
