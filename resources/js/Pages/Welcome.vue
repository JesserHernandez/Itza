<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import Dropdown from '@/Components/Dropdown.vue';
import TextInput from '@/Components/TextInput.vue';
import CardProduct from '@/Components/CardProduct.vue';
import ArtistSection from '@/Components/ArtistSection.vue';
import NavbarComponent from '@/Components/NavbarComponent.vue';
import SectionCreative from '@/Components/SectionCreative.vue';
import ProductHighlight from '@/Components/ProductHighlight.vue';
import CardsPresentation from '@/Components/CardsPresentation.vue';
import SectionComment from '@/Components/SectionComment.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});


// 👉 Aquí agregamos los ítems del carrusel
const carruselItems = [
    { icon: "/icons/icons-interface/instagram-icon.svg", alt: "Icono de Instagram", text: "Instagram" },
    { icon: "/icons/icons-interface/local-offers-icon.svg", alt: "Icono de Precios Garantizados", text: "¡Precios garantizados!" },
    { icon: "/icons/icons-interface/local-shipping-icon.svg", alt: "Icono de Envíos a todo el país", text: "¡Envíos a todo el país!" },
    { icon: "/icons/icons-interface/tiktok-icon.svg", alt: "Icono de Tik Tok", text: "TikTok" },
    { icon: "/icons/icons-interface/ornament-design-icon.svg", alt: "Icono de Diseños personalizados", text: "¡Diseños personalizados!" },
    { icon: "/icons/icons-interface/whatsapp-icon.svg", alt: "Icono de WhatsApp", text: "WhatsApp" }
];

function scrollTo(id) {
    const element = document.getElementById(id);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}
</script>



<template>

    <Head title="Welcome" />

    <div class="container-hero" role="contentinfo" aria-label="Bienvenido a Itza" title="">
        <!--? Inicio de la Navbar -->
        <NavbarComponent :scrollTo="scrollTo" />
        <!--? Fin de la Navbar -->

        <!--? Inicio de 'hero information'  -->
        <div class="hero-information" aria-label="Información sobre la aplicación">
            <div class="hero-text">
                <!--* Inicio de los Artistas destacados -->
                <div class="artist-outstanding" role="list" aria-label="Artistas destacados">
                    <div class="container-image" role="listitem" aria-label="Artista destacado: 4.5 estrellas">
                        <div class="text-value">
                            <span aria-label="Valoración del artista">4.5</span>
                            <img src="/icons/icons-interface/star-icon.svg" alt="Estrella" class="icons-star"
                                aria-hidden="true">
                        </div>
                        <section class="img-circle">
                            <img src="/img/img-interfaces/artist-one.png" alt="Artista principal uno" class="one">
                        </section>
                    </div>

                    <div class="container-image" role="listitem" aria-label="Artista destacado: 3.5 estrellas">
                        <div class="text-value value-two">
                            <span aria-label="Valoración del artista">3.5</span>
                            <img src="/icons/icons-interface/star-icon.svg" alt="Estrella" class="icons-star"
                                aria-hidden="true">
                        </div>
                        <section class="img-circle">
                            <img src="/img/img-interfaces/artist-two.png" alt="Artista principal dos" class="two">
                        </section>
                    </div>

                    <div class="container-image" role="listitem" aria-label="Artista destacado: 4.8 estrellas">
                        <div class="text-value value-three">
                            <span aria-label="Valoración del artista">4.8</span>
                            <img src="/icons/icons-interface/star-icon.svg" alt="Estrella" class="icons-star"
                                aria-hidden="true">
                        </div>
                        <section class="img-circle">
                            <img src="/img/img-interfaces/artist-three.png" alt="Artista principal tres" class="three">
                        </section>
                    </div>

                    <div class="container-image" role="listitem" aria-label="Artista destacado: 4.2 estrellas">
                        <div class="text-value value-four">
                            <span aria-label="Valoración del artista">4.2</span>
                            <img src="/icons/icons-interface/star-icon.svg" alt="Estrella" class="icons-star"
                                aria-hidden="true">
                        </div>
                        <section class="img-circle">
                            <img src="/img/img-interfaces/artist-four.png" alt="Artista principal cuatro" class="four">
                        </section>
                    </div>

                    <div class="container-image" role="listitem" aria-label="Artista destacado: 3.8 estrellas">
                        <div class="text-value value-five">
                            <span aria-label="Valoración del artista">3.8</span>
                            <img src="/icons/icons-interface/star-icon.svg" alt="Estrella" class="icons-star"
                                aria-hidden="true">
                        </div>
                        <section class="img-circle">
                            <img src="/img/img-interfaces/artist-five.png" alt="Artista principal cinco" class="five">
                        </section>
                    </div>
                </div>
                <!--* Fin de los Artistas destacados -->

                <!--*  Inicio del Texto de Bienvenida-->
                <div class="text-welcome">
                    <h1>Tradición Viva, <span>¡Cerámica
                            nicaragüense</span>
                        directo de las
                        manos del <span>artesano!</span>
                    </h1>
                </div>
                <div class="paragraph-welcome">
                    <p>
                        Explora la auténtica cerámica nicaragüense a través de nuestro
                        marketplace, una ventana cultural donde puedes adquirir piezas
                        únicas y conocer las historias detrás de ellas.
                    </p>
                </div>
                <div class="container-action">
                    <div class="button-containers">
                        <Link :href="route('register-type')" class="btn-class">Registrarse en ITZ´AT <img
                            src="/icons/icons-interface/next-white-icon.svg"
                            alt="Botón para ir al formulario de Registro">
                        </Link>
                    </div>

                    <div class="button-container-two">
                        <Link :href="route('login')" class="btn-class">Ingresar a ITZ´AT <img
                            src="/icons/icons-interface/next-icon.svg"
                            alt="Botón para ir al formulario de Iniciar Sesión">
                        </Link>
                    </div>
                </div>
            </div>
            <!-- * Fin del Texto de Bienvenida -->

            <!--* IMG Hero -->
            <div class="hero-image">
                <img src="/img/img-interfaces/img-hero.png" alt="">
            </div>
        </div>
    </div>


    <!--? Carrusel -->
    <div class="main-landing" aria-label="Sección principal de la landing">
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
        <!--? Inicio de las CardsPresentation -->
        <CardsPresentation />
        <!--? Fin de las CardsPresentation  -->

        <!--? Inicio de las product cards -->
        <div class="title-section" id="producto">
            <h1>
                Descubre la cerámica nicaragüense. ¡Vive la ruta creativa!
            </h1>
        </div>

        <div class="container-products-cards" role="region" aria-label="Productos destacados y ruta creativa">

            <!--? Productos destacados  -->

            <ProductHighlight name="Productos destacados" slogan="Diseño para tu hogar, distinción en cada pieza."
                store="Artesanías González" imageHigh="/img/img-interfaces/jaguar-vessel.png" action="Comprar" />

            <ProductHighlight name="Ofertas de temporada" slogan="¡Ahorra hasta un 30%! de descuento"
                store="Artesanías González" imageHigh="/img/img-interfaces/jarron-vessel.png" action="Comprar" />


            <!--? Fin de los productos destacados -->

            <!--? Inicio de los productos en general -->
            <CardProduct name="Ovos" price="350" description="Cerámica artesanal nicaragüense." location="Masaya"
                store="Artesanías González" value="4.5" image="/img/img-interfaces/ovos.jpg" />

            <CardProduct name="Terrarios" price="5, 840"
                description="Cuencos coloridos: tres piezas apiladas con texturas vibrantes, ideales para dar un toque de alegría."
                location="San Juan De Oriente" store="Artesanía Doña Daysi" value="4.1"
                image="/img/img-interfaces/terrarios.jpg" />

            <CardProduct name="Jarrón de la Luna Nueva" price="2, 920"
                description="Esta vasija ovalada, con su forma lunar y sus intrincados diseños figurativos."
                location="San Juan De Oriente" store="Artesanía Doña Daysi" value="4.94"
                image="/img/img-interfaces/luna-nueva.jpg" />

            <CardProduct name="El Guardián Mítico de las Antiguas Historias" price="620"
                description="Vasija de silueta distintiva y boca esculpida con grabados míticos en blanco sobre azul."
                location="San Juan De Oriente" store="Artesanía Doña Daysi" value="4.9"
                image="/img/img-interfaces/guardian-mitico.jpg" />

            <div class="btn-show-products">
                <Link class="btn-class" :href="route('login')">
                <span>Ver más productos</span>
                <img src="/icons/icons-interface/next-white-icon.svg" alt="">
                </Link>
            </div>
        </div>

        <!--? Fin de los productos en general -->
        <div class="title-section">
            <h1>El legado de Nicaragua vive en sus artistas más destacados</h1>
        </div>

        <div class="carrusel">
            <ArtistSection image="/img/img-interfaces/artist-card.png" name="Helio Gutiérrez" description="Su trabajo ha trascendido fronteras y ha sido reconocido internacionalmente,
            incluyendo premios de la UNESCO y la orden Ruben Darío" followers="312" pieces="48" />

            <ArtistSection image="/img/img-interfaces/artist-card.png" name="Helio Gutiérrez" description="Su trabajo ha trascendido fronteras y ha sido reconocido internacionalmente,
            incluyendo premios de la UNESCO y la orden Ruben Darío" followers="312" pieces="48" />

            <ArtistSection image="/img/img-interfaces/artist-card.png" name="Helio Gutiérrez" description="Su trabajo ha trascendido fronteras y ha sido reconocido internacionalmente,
            incluyendo premios de la UNESCO y la orden Ruben Darío" followers="312" pieces="48" />

            <ArtistSection image="/img/img-interfaces/artist-card.png" name="Helio Gutiérrez" description="Su trabajo ha trascendido fronteras y ha sido reconocido internacionalmente,
            incluyendo premios de la UNESCO y la orden Ruben Darío" followers="312" pieces="48" />

            <ArtistSection image="/img/img-interfaces/artist-card.png" name="Helio Gutiérrez" description="Su trabajo ha trascendido fronteras y ha sido reconocido internacionalmente,
            incluyendo premios de la UNESCO y la orden Ruben Darío" followers="312" pieces="48" />
        </div>

        <!--? Inicio sobre las Ciudades Creativas -->
        <div class="creative">

            <SectionCreative />

            <div class="btn-city">
                <button class="btn-class" :href="route('login')">
                    <span>Explora las Ciudades Creativas</span>
                    <img src="/icons/icons-interface/next-icon.svg" alt="">
                </button>
            </div>
        </div>
        <!--? Fin de las Ciudades Creativas -->

        <!--? Inicio de la Sección de Comentarios -->
        <div class="section-coments">

            <SectionComment imagePerson="/img/avatars/avatar-sixteen.png" nameArtist="María" valueArtist="4.0"
                commentuser="Las tazas son bellas y de gran calidad.
            Es increíble cómo se siente la dedicación del artesano en cada detalle." />

            <SectionComment imagePerson="/img/avatars/avatar-twentythree.png" nameArtist="Juan" valueArtist="3.8"
                commentuser="¡El envío fue increíblemente rápido y estoy muy,
            muy satisfecho con mi compra! El paquete llegó en perfectas condiciones " />

            <SectionComment imagePerson="/img/avatars/avatar-twentyfive.png" nameArtist="Carla" valueArtist="5.0"
                commentuser="Las cerámicas de esta tienda tienen un encanto
            verdaderamente único. Es increíble cómo cada pieza parece contar una historia por sí misma." />

            <SectionComment imagePerson="/img/avatars/avatar-twentyfour.png" nameArtist="Miguel" valueArtist="3.0"
                commentuser="Las cerámicas de esta tienda tienen un
            encanto verdaderamente único. Es increíble cómo cada pieza parece contar una historia por sí misma." />

        </div>

        <!--? Fin de las Sección de Comentarios -->
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
            <g clip-path="url(#clip0_3319_1443)">
                <path
                    d="M12 2.27031C15.2063 2.27031 15.5859 2.28437 16.8469 2.34062C18.0188 2.39219 18.6516 2.58906 19.0734 2.75313C19.6313 2.96875 20.0344 3.23125 20.4516 3.64844C20.8734 4.07031 21.1313 4.46875 21.3469 5.02656C21.5109 5.44844 21.7078 6.08594 21.7594 7.25312C21.8156 8.51875 21.8297 8.89844 21.8297 12.1C21.8297 15.3063 21.8156 15.6859 21.7594 16.9469C21.7078 18.1188 21.5109 18.7516 21.3469 19.1734C21.1313 19.7313 20.8687 20.1344 20.4516 20.5516C20.0297 20.9734 19.6313 21.2313 19.0734 21.4469C18.6516 21.6109 18.0141 21.8078 16.8469 21.8594C15.5813 21.9156 15.2016 21.9297 12 21.9297C8.79375 21.9297 8.41406 21.9156 7.15313 21.8594C5.98125 21.8078 5.34844 21.6109 4.92656 21.4469C4.36875 21.2313 3.96563 20.9688 3.54844 20.5516C3.12656 20.1297 2.86875 19.7313 2.65313 19.1734C2.48906 18.7516 2.29219 18.1141 2.24063 16.9469C2.18438 15.6813 2.17031 15.3016 2.17031 12.1C2.17031 8.89375 2.18438 8.51406 2.24063 7.25312C2.29219 6.08125 2.48906 5.44844 2.65313 5.02656C2.86875 4.46875 3.13125 4.06562 3.54844 3.64844C3.97031 3.22656 4.36875 2.96875 4.92656 2.75313C5.34844 2.58906 5.98594 2.39219 7.15313 2.34062C8.41406 2.28437 8.79375 2.27031 12 2.27031ZM12 0.109375C8.74219 0.109375 8.33438 0.123437 7.05469 0.179688C5.77969 0.235938 4.90313 0.442187 4.14375 0.7375C3.35156 1.04687 2.68125 1.45469 2.01563 2.125C1.34531 2.79063 0.9375 3.46094 0.628125 4.24844C0.332812 5.0125 0.126563 5.88437 0.0703125 7.15937C0.0140625 8.44375 0 8.85156 0 12.1094C0 15.3672 0.0140625 15.775 0.0703125 17.0547C0.126563 18.3297 0.332812 19.2063 0.628125 19.9656C0.9375 20.7578 1.34531 21.4281 2.01563 22.0938C2.68125 22.7594 3.35156 23.1719 4.13906 23.4766C4.90313 23.7719 5.775 23.9781 7.05 24.0344C8.32969 24.0906 8.7375 24.1047 11.9953 24.1047C15.2531 24.1047 15.6609 24.0906 16.9406 24.0344C18.2156 23.9781 19.0922 23.7719 19.8516 23.4766C20.6391 23.1719 21.3094 22.7594 21.975 22.0938C22.6406 21.4281 23.0531 20.7578 23.3578 19.9703C23.6531 19.2063 23.8594 18.3344 23.9156 17.0594C23.9719 15.7797 23.9859 15.3719 23.9859 12.1141C23.9859 8.85625 23.9719 8.44844 23.9156 7.16875C23.8594 5.89375 23.6531 5.01719 23.3578 4.25781C23.0625 3.46094 22.6547 2.79063 21.9844 2.125C21.3188 1.45938 20.6484 1.04688 19.8609 0.742188C19.0969 0.446875 18.225 0.240625 16.95 0.184375C15.6656 0.123438 15.2578 0.109375 12 0.109375Z"
                    fill="#6A6A6A" />
                <path
                    d="M12 5.94531C8.59688 5.94531 5.83594 8.70625 5.83594 12.1094C5.83594 15.5125 8.59688 18.2734 12 18.2734C15.4031 18.2734 18.1641 15.5125 18.1641 12.1094C18.1641 8.70625 15.4031 5.94531 12 5.94531ZM12 16.1078C9.79219 16.1078 8.00156 14.3172 8.00156 12.1094C8.00156 9.90156 9.79219 8.11094 12 8.11094C14.2078 8.11094 15.9984 9.90156 15.9984 12.1094C15.9984 14.3172 14.2078 16.1078 12 16.1078Z"
                    fill="#6A6A6A" />
                <path
                    d="M19.8469 5.70176C19.8469 6.49864 19.2 7.14083 18.4078 7.14083C17.6109 7.14083 16.9688 6.49395 16.9688 5.70176C16.9688 4.90488 17.6156 4.2627 18.4078 4.2627C19.2 4.2627 19.8469 4.90957 19.8469 5.70176Z"
                    fill="#6A6A6A" />
            </g>
            <defs>
                <clipPath id="clip0_3319_1443">
                    <rect width="24" height="24" fill="white" transform="translate(0 0.109375)" />
                </clipPath>
            </defs>
        </svg>
    </div>

</template>
