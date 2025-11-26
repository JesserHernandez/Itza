<script setup>
import { useForm } from '@inertiajs/vue3';
import { watch, ref, onBeforeUnmount } from 'vue';
import HeaderAdmin from "@/Components/HeaderAdmin.vue";

// SweetAlert desde CDN
const Swal = window.Swal;

const props = defineProps({
    category: Object,
    category_attributes: Array,
});

const form = useForm({
    name: props.category?.name || "",
    description: props.category?.description || "",
    // se rellenará al submit desde attributeForms
    category_attributes: (props.category?.category_attributes ?? props.category_attributes ?? []).map(a => ({
        id: a?.id ?? null,
        category_name: a?.category_name ?? '',
        label: a?.label ?? '',
        data_type: a?.data_type ?? '',
        unit: a?.unit ?? '',
    })),

    deleted_attribute_ids: [],
});

// lista dinámica de formularios de atributo (cada uno se guarda en el array final al enviar)
const attributeForms = ref(
    (props.category?.category_attributes ?? props.category_attributes ?? []).map(a => ({
        id: a?.id ?? null,
        label: a?.label ?? '',
        category_name: a?.category_name ?? '',
        unit: a?.unit ?? '',
        data_type: a?.data_type ?? '',
        translating: false,
    }))
);

// timers y controllers por índice para debounce/abort
const translateTimeouts = {};
const translateControllers = {};

// función de traducción (Google -> MyMemory fallback)
async function translateWithApis(text, signal) {
    try {
        const gUrl = `https://translate.googleapis.com/translate_a/single?client=gtx&sl=es&tl=en&dt=t&q=${encodeURIComponent(text)}`;
        const resp = await fetch(gUrl, { method: 'GET', signal });

        if (resp.ok) {
            const data = await resp.json();
            let translated = '';
            if (Array.isArray(data) && data[0]) {
                data[0].forEach(item => {
                    if (item[0]) translated += item[0];
                });
            }
            if (translated) return translated;
        }
    } catch (err) {
        console.warn('Google translate failed:', err);
    }

    try {
        const mmUrl = `https://api.mymemory.translated.net/get?q=${encodeURIComponent(text)}&langpair=es|en`;
        const resp2 = await fetch(mmUrl, { method: 'GET', signal });
        if (resp2.ok) {
            const data2 = await resp2.json();
            if (data2 && data2.responseData && data2.responseData.translatedText) {
                return data2.responseData.translatedText;
            }
        }
    } catch (err) {
        console.warn('MyMemory failed:', err);
    }

    return text;
}

function slugify(text) {
    return (text || '')
        .toString()
        .toLowerCase()
        .normalize("NFD").replace(/[\u0300-\u036f]/g, "")
        .replace(/[^\w\s-]/g, "")
        .trim()
        .replace(/\s+/g, "_");
}

// al crear un nuevo formulario de atributo
function addAttributeForm() {
    attributeForms.value.push({
        id: null,
        label: "",
        category_name: "",
        unit: "",
        data_type: "",
        translating: false,
    });
}

function onLabelInput(idx) {
    const af = attributeForms.value[idx];
    if (!af) return;

    if (translateTimeouts[idx]) {
        clearTimeout(translateTimeouts[idx]);
        translateTimeouts[idx] = null;
    }
    if (translateControllers[idx]) {
        try { translateControllers[idx].abort(); } catch {}
        translateControllers[idx] = null;
    }

    if (!af.label || !String(af.label).trim()) {
        af.category_name = "";
        return;
    }

    translateTimeouts[idx] = setTimeout(async () => {
        af.translating = true;
        translateControllers[idx] = new AbortController();
        const signal = translateControllers[idx].signal;
        try {
            const translated = await translateWithApis(af.label, signal);
            af.category_name = slugify(translated || af.label);
        } catch (err) {
            console.warn('translate error idx', idx, err);
            af.category_name = slugify(af.label);
        } finally {
            af.translating = false;
            translateTimeouts[idx] = null;
            translateControllers[idx] = null;
        }
    }, 600);
}

function removeAttributeForm(idx) {
    // limpiar timers/controllers
    if (translateTimeouts[idx]) { clearTimeout(translateTimeouts[idx]); translateTimeouts[idx] = null; }
    if (translateControllers[idx]) { try { translateControllers[idx].abort(); } catch {} translateControllers[idx] = null; }
    // si el formulario corresponde a un atributo existente (tiene id), añadir su id a deleted_attribute_ids
    const af = attributeForms.value[idx];
    if (af && af.id) {
        form.deleted_attribute_ids = form.deleted_attribute_ids || [];
        // evitar duplicados
        if (!form.deleted_attribute_ids.includes(af.id)) form.deleted_attribute_ids.push(af.id);
        // además, si el atributo ya estaba en form.category_attributes, removerlo allí
        form.category_attributes = (form.category_attributes || []).filter(a => a.id !== af.id);
    }
    attributeForms.value.splice(idx, 1);
}

// espera a que terminen todas las traducciones pendientes
function waitForAllTranslations() {
    return new Promise((resolve) => {
        const check = () => {
            const pending = Object.values(translateTimeouts).some(v => v) || Object.values(translateControllers).some(c => !!c);
            if (!pending) return resolve();
            setTimeout(check, 100);
        };
        check();
        // timeout de seguridad
        setTimeout(resolve, 5000);
    });
}

// antes de enviar, construir category_attributes desde attributeForms
async function buildAttributesPayload() {
    await waitForAllTranslations();

    const attrs = attributeForms.value
        .map(af => {
            const label = (af.label || '').toString().trim();
            if (!label) return null; // ignorar vacíos
            return {
                id: af.id ?? null,
                category_name: af.category_name && af.category_name.trim() ? af.category_name : slugify(label),
                label: label,
                unit: af.unit || null,
                data_type: af.data_type || null,
            };
        })
        .filter(Boolean);

    form.category_attributes = attrs;
    // mantener deleted_attribute_ids (si no existe, aseguro que sea array)
    form.deleted_attribute_ids = form.deleted_attribute_ids || [];
}

// envío principal (único botón Guardar)
async function submitForm() {
    try {
        // construir payload con todas las características actuales
        await buildAttributesPayload();

        console.log('Enviando form payload:', JSON.parse(JSON.stringify(form)));

        if (props.category && props.category.id) {
            await form.put(route("categories.update", props.category.id), {
                onSuccess: () => {
                    Swal.fire({
                        title: "¡Actualizado!",
                        text: "La categoría ha sido actualizada con éxito.",
                        icon: "success",
                        confirmButtonText: "Aceptar",
                        confirmButtonColor: "#702b21"
                    });
                },
                onError: (errors) => console.warn('Errores:', errors),
            });
        } else {
            await form.post(route("categories.store"), {
                onSuccess: () => {
                    Swal.fire({
                        title: "¡Creado!",
                        text: "La categoría ha sido creada con éxito.",
                        icon: "success",
                        confirmButtonText: "Aceptar",
                        confirmButtonColor: "#702b21"
                    });
                },
                onError: (errors) => console.warn('Errores:', errors),
            });
        }
    } catch (err) {
        console.error('submitForm error:', err);
    }
}

onBeforeUnmount(() => {
    // limpiar timers/controllers
    Object.values(translateTimeouts).forEach(t => t && clearTimeout(t));
    Object.values(translateControllers).forEach(c => c && c.abort && c.abort());
});
</script>

<template>
    <div class="container-form">
        <form @submit.prevent="submitForm" class="form">
            <!-- CATEGORÍA -->
            <div class="items-form">
                <label for="name" class="form-label">Categoría</label>
                <input
                    type="text"
                    id="name"
                    v-model="form.name"
                    class="form-input"
                    placeholder="Ingrese el nombre de la categoría"
                    :class="{ errors: form.errors.name }"
                />
                <div v-if="form.errors.name" class="errors">
                    {{ form.errors.name }}
                </div>
            </div>

            <!-- DESCRIPCIÓN -->
            <div class="items-form">
                <label for="description" class="form-label">Descripción</label>
                <input
                    id="description"
                    v-model="form.description"
                    class="form-textarea"
                    placeholder="Ingrese la descripción"
                    :class="{ errors: form.errors.description }"
                />
                <div v-if="form.errors.description" class="errors">
                    {{ form.errors.description }}
                </div>
            </div>

            <!-- Botón para agregar múltiples formularios -->


            <!-- Varios formularios dinámicos; se guardan automáticamente al submit -->
            <div v-for="(af, idx) in attributeForms" :key="idx" class="attribute-form">
                <div class="items-form">
                    <label :for="'label-'+idx">Característica</label>
                    <input
                        type="text"
                        :id="'label-'+idx"
                        v-model="af.label"
                        @input="onLabelInput(idx)"
                        class="form-input"
                        placeholder="Ingrese la característica"
                    />
                </div>

                <div class="items-form" style="display: none;">
                    <label :for="'names-'+idx">Attribute Name (EN)</label>
                    <input
                        type="text"
                        :id="'names-'+idx"
                        :value="af.category_name"
                        class="form-input"
                        readonly
                        placeholder="Se llenará automáticamente"
                    />
                </div>

                <div class="items-form">
                    <label :for="'unit-'+idx">Unidad de medida</label>
                    <select :id="'unit-'+idx" v-model="af.unit">
                        <option value="" disabled>Seleccione una unidad</option>
                        <!-- opciones resumidas -->
                        <option value="kg">Kilogramo</option>
                        <option value="g">Gramo</option>
                        <option value="m">Metro</option>
                        <option value="l">Litro</option>
                    </select>
                </div>

                <div class="items-form">
                    <label :for="'data_type-'+idx">Tipo de dato</label>
                    <select :id="'data_type-'+idx" v-model="af.data_type">
                        <option value="" disabled>Seleccione un tipo de dato</option>
                        <option value="string">Texto</option>
                        <option value="integer">Número</option>
                        <option value="boolean">Booleano</option>
                        <option value="datetime">Fecha</option>
                    </select>
                </div>

                <div class="add-actions">
                    <!-- ya no hay botón "Guardar característica"; se construye al submit -->
                    <button type="button" class="btn-class btn-cancel" @click="removeAttributeForm(idx)">
                        Eliminar
                    </button>
                </div>
            </div>

            <div class="add-container">
                <button type="button" class="btn-class" @click="addAttributeForm">
                    Añadir característica
                    <img src="/icons/icons-interface/add-icon.svg" alt="" />
                </button>
            </div>

            <div class="container-button">
                <button type="submit" class="btn-class" :disabled="form.processing">
                    {{ props.category ? "Actualizar categoría" : "Crear categoría" }}
                </button>
            </div>
        </form>
    </div>
</template>
