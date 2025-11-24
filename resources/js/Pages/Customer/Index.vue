<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ProductHighlight from "@/Components/ProductHighlight.vue";

import NavbarComponent from "@/Components/NavbarComponent.vue";

const carruselItems = [
    {
        icon: "/icons/icons-interface/instagram-icon.svg",
        alt: "Icono de Instagram",
        text: "Instagram",
    },
    {
        icon: "/icons/icons-interface/local-offers-icon.svg",
        alt: "Icono de Precios Garantizados",
        text: "¡Precios garantizados!",
    },
    {
        icon: "/icons/icons-interface/local-shipping-icon.svg",
        alt: "Icono de Envíos a todo el país",
        text: "¡Envíos a todo el país!",
    },
    {
        icon: "/icons/icons-interface/tiktok-icon.svg",
        alt: "Icono de Tik Tok",
        text: "TikTok",
    },
    {
        icon: "/icons/icons-interface/ornament-design-icon.svg",
        alt: "Icono de Diseños personalizados",
        text: "¡Diseños personalizados!",
    },
    {
        icon: "/icons/icons-interface/whatsapp-icon.svg",
        alt: "Icono de WhatsApp",
        text: "WhatsApp",
    },
];
</script>

<template>
    <NavbarComponent />
    <div
        class="container-hero heroOne"
        role="contentinfo"
        aria-label="Bienvenido a Itza"
        title=""
    >
        <div
            class="hero-information"
            aria-label="Información sobre la aplicación"
        >
            <div class="hero-text">
                <!--* Inicio de los Artistas destacados -->
                <div
                    class="artist-outstanding"
                    role="list"
                    aria-label="Artistas destacados"
                >
                    <div
                        class="container-image"
                        role="listitem"
                        aria-label="Artista destacado: 4.5 estrellas"
                    >
                        <div class="text-value">
                            <span aria-label="Valoración del artista">4.5</span>
                            <img
                                src="/icons/icons-interface/star-icon.svg"
                                alt="Estrella"
                                class="icons-star"
                                aria-hidden="true"
                            />
                        </div>
                        <section class="img-circle">
                            <img
                                src="/img/img-interfaces/artist-one.png"
                                alt="Artista principal uno"
                                class="one"
                            />
                        </section>
                    </div>

                    <div
                        class="container-image"
                        role="listitem"
                        aria-label="Artista destacado: 3.5 estrellas"
                    >
                        <div class="text-value value-two">
                            <span aria-label="Valoración del artista">3.5</span>
                            <img
                                src="/icons/icons-interface/star-icon.svg"
                                alt="Estrella"
                                class="icons-star"
                                aria-hidden="true"
                            />
                        </div>
                        <section class="img-circle">
                            <img
                                src="/img/img-interfaces/artist-two.png"
                                alt="Artista principal dos"
                                class="two"
                            />
                        </section>
                    </div>

                    <div
                        class="container-image"
                        role="listitem"
                        aria-label="Artista destacado: 4.8 estrellas"
                    >
                        <div class="text-value value-three">
                            <span aria-label="Valoración del artista">4.8</span>
                            <img
                                src="/icons/icons-interface/star-icon.svg"
                                alt="Estrella"
                                class="icons-star"
                                aria-hidden="true"
                            />
                        </div>
                        <section class="img-circle">
                            <img
                                src="/img/img-interfaces/artist-three.png"
                                alt="Artista principal tres"
                                class="three"
                            />
                        </section>
                    </div>

                    <div
                        class="container-image"
                        role="listitem"
                        aria-label="Artista destacado: 4.2 estrellas"
                    >
                        <div class="text-value value-four">
                            <span aria-label="Valoración del artista">4.2</span>
                            <img
                                src="/icons/icons-interface/star-icon.svg"
                                alt="Estrella"
                                class="icons-star"
                                aria-hidden="true"
                            />
                        </div>
                        <section class="img-circle">
                            <img
                                src="/img/img-interfaces/artist-four.png"
                                alt="Artista principal cuatro"
                                class="four"
                            />
                        </section>
                    </div>

                    <div
                        class="container-image"
                        role="listitem"
                        aria-label="Artista destacado: 3.8 estrellas"
                    >
                        <div class="text-value value-five">
                            <span aria-label="Valoración del artista">3.8</span>
                            <img
                                src="/icons/icons-interface/star-icon.svg"
                                alt="Estrella"
                                class="icons-star"
                                aria-hidden="true"
                            />
                        </div>
                        <section class="img-circle">
                            <img
                                src="/img/img-interfaces/artist-five.png"
                                alt="Artista principal cinco"
                                class="five"
                            />
                        </section>
                    </div>
                </div>
                <!--* Fin de los Artistas destacados -->

                <!--*  Inicio del Texto de Bienvenida-->
                <div class="text-welcome">
                    <h1>
                        Tierra Viva, <span>¡Cerámica nicaragüense</span> directo
                        de las manos del <span>artesano!</span>
                    </h1>
                </div>
                <div class="paragraph-welcome">
                    <p>
                        Explora la auténtica cerámica nicaragüense a través de
                        nuestro marketplace, una ventana cultural donde puedes
                        adquirir piezas únicas y conocer las historias detrás de
                        ellas.
                    </p>
                </div>
            </div>
            <!-- * Fin del Texto de Bienvenida -->

            <!--* IMG Hero -->
            <div class="hero-image">
                <img src="/img/img-interfaces/img-hero.png" alt="" />
            </div>
        </div>
    </div>

    <div class="main-landing" aria-label="Sección principal de la landing">
        <div
            class="carrusel-wrapper"
            role="region"
            aria-label="Características destacadas de la plataforma"
        >
            <div
                class="carrusel-track"
                role="list"
                aria-label="Lista de características"
            >
                <div
                    v-for="(item, i) in carruselItems"
                    :key="'track1-' + i"
                    class="carrusel-item"
                    role="listitem"
                    aria-label="Característica: {{ item.text }}"
                >
                    <img :src="item.icon" :alt="item.alt" aria-hidden="true" />
                    <span aria-label="Texto de característica">{{
                        item.text
                    }}</span>
                </div>
                <div
                    v-for="(item, i) in carruselItems"
                    :key="'track2-' + i"
                    class="carrusel-item"
                    role="listitem"
                    aria-label="Característica: {{ item.text }}"
                >
                    <img :src="item.icon" :alt="item.alt" aria-hidden="true" />
                    <span aria-label="Texto de característica">{{
                        item.text
                    }}</span>
                </div>
            </div>
        </div>

        <div class="container-card" aria-label="Tarjetas informativas principales">
        <div class="cards" aria-label="Tarjeta Marketplace">
            <div class="icon">
                <img src="/icons/icons-interface/bag-icon.svg" alt="Icono de Marketplace" aria-hidden="true">
            </div>
            <div class="title">
                <h2>Marketplace</h2>
            </div>
            <div class="text">
                <p><span>ITZ'AT</span> es una sistema de
                    Marketplace que apoya el
                    arte y la cerámica
                    nicaragüense para fomentar
                    el desarrollo cultural y
                    económico del país.</p>
            </div>
        </div>
        <div class="cards" aria-label="Tarjeta Travel App">
            <div class="icon">
                <img src="/icons/icons-interface/world-icon.svg" alt="Icono de Travel App" aria-hidden="true">
            </div>
            <div class="title">
                <h2>Travel App</h2>
            </div>
            <div class="text">
                <p><span>ITZ'AT</span> es una app de viajes
                    que te guía por los
                    circuitos creativos de Nicaragua,
                    permitiéndote comprar arte
                    y cerámica local mientras
                    exploras el país.</p>
            </div>
        </div>
        <div class="cards" aria-label="Tarjeta Comunidad">
            <div class="icon">
                <img src="/icons/icons-interface/trending-icon.svg" alt="Icono de Comunidad" aria-hidden="true">
            </div>
            <div class="title">
                <h2>Comunidad</h2>
            </div>
            <div class="text">
                <p>Además <span>ITZ'AT</span> cuenta con
                    una comunidad donde los
                    artistas pueden subir y
                    compartir su trabajo,
                    creando un espacio de
                    conexión local.</p>
            </div>
        </div>
    </div>
    </div>
</template>
