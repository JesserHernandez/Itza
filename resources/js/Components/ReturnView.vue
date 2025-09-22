<script setup>
import { getCurrentInstance, computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: { type: String, default: null },
    prevent: { type: Boolean, default: true }
});
const emit = defineEmits(['back']);

const hrefComputed = computed(() => {
    if (!props.href) return null;
    try {
        // eslint-disable-next-line no-undef
        return typeof route === 'function' ? route(props.href) : props.href;
    } catch (e) {
        return props.href;
    }
});

function handleClick(e) {
    // emitir siempre para que el padre pueda reaccionar
    emit('back');

    if (props.prevent) {
        e?.preventDefault?.();

        // si nadie escucha 'back', fallback a history.back()
        const instance = getCurrentInstance();
        const hasListener = !!(
            instance?.vnode?.props &&
            (instance.vnode.props.onBack || instance.vnode.props['onBack'])
        );
        if (!hasListener) {
            window.history.back();
        }
    }
    // si prevent === false dejamos que <Link> haga la navegación por defecto
}
</script>

<template>
    <nav class="container-nav" aria-label="Navegación principal">
        <div class="nav-left">
            <div v-if="hrefComputed">
                <Link :href="hrefComputed" class="option" @click="handleClick" aria-label="Volver">
                <img src="/icons/icons-interface/back-icon.svg" alt="Volver" aria-hidden="true" />
                <p>Volver</p>
                </Link>
            </div>
                <Link v-else type="button" class="option" @click="handleClick" aria-label="Volver">
                    <img src="/icons/icons-interface/back-icon.svg" alt="Volver" aria-hidden="true" />
                    <p>Volver</p>
                </Link>
        </div>

        <div class="logo-short">
            <img src="/img/img-logo/Logo_itzat.svg" alt="Logo de Itz'at" class="logo-itzat" />
        </div>
    </nav>
</template>
