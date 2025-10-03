<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import Dropdown from '@/Components/Dropdown.vue';
import TextInput from '@/Components/TextInput.vue';
import CardProduct from '@/Components/CardProduct.vue';
import FooterSection from '@/Components/FooterSection.vue';
import ArtistSection from '@/Components/ArtistSection.vue';
import SectionComment from '@/Components/SectionComment.vue';
import NavbarComponent from '@/Components/NavbarComponent.vue';
import CarruselSection from '@/Components/CarruselSection.vue';
import SectionCreative from '@/Components/SectionCreative.vue';
import ProductHighlight from '@/Components/ProductHighlight.vue';
import CardsPresentation from '@/Components/CardsPresentation.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});


// 👉 Aquí agregamos los ítems del carrusel


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
                        <Link :href="route('register_type')" class="btn-class">Registrarse en ITZ´AT <img
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


    <div class="main-landing" aria-label="Sección principal de la landing">
        <!--? Carrusel -->
        <CarruselSection />
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


        <FooterSection />
    </div>

</template>
