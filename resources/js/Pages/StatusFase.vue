<script setup>
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
</script>

<template>

    <Head title="Fase 2 próximamente" />
    <!-- <NavbarComponent /> -->
    <div class="status-container">
        <section class="status-picture">
        </section>
        <section class="status-content">
            <h1>Esta sección se encuentra en construcción y estará lista en la fase 2 de ITZ´AT</h1>
            <p>¡Gracias por tu comprensión!</p>
        </section>
        <section class="status-button">
            <Link href="/" class="btn-class">
                Regresar al inicio
                <img src="/icons/icons-interface/next-white-icon.svg" alt="Botón para ir al inicio" />
            </Link>
        </section>
    </div>
</template>