<script setup>
const carruselItems = [
    { icon: "/icons/icons-interface/instagram-icon.svg", alt: "Icono de Instagram", text: "Instagram" },
    { icon: "/icons/icons-interface/local-offers-icon.svg", alt: "Icono de Precios Garantizados", text: "¡Precios garantizados!" },
    { icon: "/icons/icons-interface/local-shipping-icon.svg", alt: "Icono de Envíos a todo el país", text: "¡Envíos a todo el país!" },
    { icon: "/icons/icons-interface/tiktok-icon.svg", alt: "Icono de Tik Tok", text: "TikTok" },
    { icon: "/icons/icons-interface/ornament-design-icon.svg", alt: "Icono de Diseños personalizados", text: "¡Diseños personalizados!" },
    { icon: "/icons/icons-interface/whatsapp-icon.svg", alt: "Icono de WhatsApp", text: "WhatsApp" }
];
</script>

<template>
    <div class="carrusel-wrapper" role="region" aria-label="Características destacadas de la plataforma">
            <div class="carrusel-track" role="list" aria-label="Lista de características">
                <div v-for="(item, i) in carruselItems" :key="'track1-' + i" class="carrusel-item" role="listitem"
                    aria-label="Característica: {{ item.text }}">
                    <img :src="item.icon" :alt="item.alt" aria-hidden="true" />
                    <span aria-label="Texto de característica">{{ item.text }}</span>
                </div>
                <div v-for="(item, i) in carruselItems" :key="'track2-' + i" class="carrusel-item" role="listitem"
                    aria-label="Característica: {{ item.text }}">
                    <img :src="item.icon" :alt="item.alt" aria-hidden="true" />
                    <span aria-label="Texto de característica">{{ item.text }}</span>
                </div>
            </div>
        </div>
</template>
