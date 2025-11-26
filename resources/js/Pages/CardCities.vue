<script setup>
import NavbarComponent from "@/Components/NavbarComponent.vue";
import CarruselSection from "@/Components/CarruselSection.vue";
import ArtistSection from "@/Components/ArtistSection.vue";
import FooterSection from "@/Components/FooterSection.vue";
import CitySection from "@/Components/CitySection.vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/inertia-vue3";

</script>

<template>
    <Head title="Ciudades Creativas" />
    <div
        class="container-hero"
        role="contentinfo"
        aria-label="Bienvenido a Itza"
        title="" >

        <!--? Inicio de la Navbar -->
        <NavbarComponent :scrollTo="scrollTo" />
        <!--? Fin de la Navbar -->

        <!--? Inicio de 'hero information'  -->
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
                <div class="container-action">
                    <div class="button-containers">
                        <Link :href="route('register')" class="btn-class" :data="{ is_vendor: false }"
                            >Registrarse en ITZ´AT
                            <img
                                src="/icons/icons-interface/next-white-icon.svg"
                                alt="Botón para ir al formulario de Registro"
                            />
                        </Link>
                    </div>

                    <div class="button-container-two">
                        <Link :href="route('login')" class="btn-class"
                            >Ingresar a ITZ´AT
                            <img
                                src="/icons/icons-interface/next-icon.svg"
                                alt="Botón para ir al formulario de Iniciar Sesión"
                            />
                        </Link>
                    </div>
                </div>
            </div>
            <!-- * Fin del Texto de Bienvenida -->

            <!--* IMG Hero -->
            <div class="hero-image">
                <img src="/img/img-interfaces/img-travels.png" alt="" />
            </div>
        </div>
    </div>

    <div class="main-city" aria-label="Sección principal de las ciudades creativas">
        <!-- Carrusel -->
        <CarruselSection />

        <!-- Inicio del mapa de ciudades creativas -->
        <div class="title-section" id="ciudades">
            <h1>El alma de Nicaragua en sus ciudades creativas</h1>
            <p>Enfocado en el valor cultural y la identidad, Un llamado a la exploración ideal para observar a los creativos más grandes del país en pleno proceso de creación y adquirir piezas directamente de los talleres</p>

            <div class="map-cities" aria-label="Mapa de las ciudades creativas de Nicaragua">
                <img
                    src="/img/img-interfaces/img-map.png"
                    alt="Mapa de las ciudades creativas de Nicaragua"
                />
            </div>
        </div>

        <!-- Inicio de la sección de ciudades creativas -->
        <div class="ciudades-creativas">
            <CitySection
                image="/img/img-interfaces/card-sanjuan.png"
                name="San Juan de Oriente"
                description="La tradición alfarera, transmitida por generaciones, combina técnicas ancestrales con creatividad contemporánea para crear artesanía de renombre internacional."
            />

            <CitySection
                image="/img/img-interfaces/card-granada.png"
                name="Granada"
                description="Es una de las ciudades coloniales mejor conservadas de América Latina, con hermosas casas, iglesias y plazas."
            />

            <CitySection
                image="/img/img-interfaces/card-esteli.png"
                name="Estelí"
                description="Estelí es un lienzo a cielo abierto, reconocida por su vibrante movimiento de muralismo, Sus paredes cobran vida con obras de arte urbano."
            />

            <CitySection
                image="/img/img-interfaces/card-masaya.png"
                name="Masaya"
                description=" El barrio de Monimbó es un baluarte de la cultura indígena y un centro de producción artesanal, donde se mantiene viva la herencia de los ancestros."
            />

            <CitySection
                image="/img/img-interfaces/card-leon.png"
                name="León"
                description="Es una de las ciudades coloniales mejor conservadas de América Latina, con hermosas casas, iglesias y plazas."
            />

            <CitySection
                image="/img/img-interfaces/card-blufields.png"
                name="Bluefields"
                description="La herencia caribeña y afrodescendiente de la ciudad se refleja en su vida diaria, desde la música, como el reggae y el calypso, hasta la comida, tradiciones y el idioma creole."
            />
        </div>

        <!--? Fin de las Sección de Comentarios -->

        <FooterSection />
    </div>
</template>
