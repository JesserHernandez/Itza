<script setup>
import ReturnView from '@/Components/ReturnView.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Tipo de Usuario" />

    <div class="container-type" aria-label="Registro de tipo de usuario">
        <ReturnView href="welcome" />

        <div class="section-info" aria-label="Información sobre el registro">
            <div class="title">
                <h1>¡Bienvenido a ITZ'AT! Únete a nuestra
                    comunidad de creadores!
                </h1>
            </div>
            <div class="paragrahp">
                <p>
                    Únete como artista para mostrar tu talento al mundo, o como
                    amante del arte para descubrir obras únicas y apoyar a
                    talentosos creadores.
                </p>
            </div>

            <div class="selected-container" aria-label="Opciones de registro">
                <div class="artist">
                    <p>Ceramista o Alfarero</p>
                    <!--
                        ? Se manda la props is_vendor a la vista Register.vue para validar que el tipo de usuario que se registra es un vendedor.
                    -->
                    <Link :href="route('register')" :data="{ is_vendor: true }" method="get" as="button"
                        class="btn-class" aria-label="Ingresar como artista">
                    <svg class="icons" xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25"
                        fill="none" aria-hidden="true">
                        <path
                            d="M9.99717 17.6481C9.96117 18.199 9.48321 18.603 8.93426 18.581C8.79027 18.571 8.64528 18.566 8.49929 18.566C5.41955 18.566 2.59178 20.7519 1.98083 23.7648C1.88684 24.2418 1.45888 24.5658 0.999917 24.5658C0.422965 24.5658 0.000999917 24.0228 0 23.4948C0.647946 19.455 4.42363 16.5641 8.49929 16.5661C8.68928 16.5661 8.87726 16.5731 9.06424 16.5851C9.6152 16.6211 10.0332 17.0971 9.99717 17.6481ZM1.61887 4.7156C1.37789 3.88063 1.53587 3.09467 2.02583 2.48069C2.51379 1.86972 3.25673 1.53773 4.00067 1.58073L7.50037 1.84772V1.56673C7.50037 1.01475 7.94834 0.566772 8.50029 0.566772C9.10324 0.566772 9.50021 1.01475 9.50021 1.56673V2.00071L13.7969 2.3287C14.3548 2.3597 14.8708 2.65369 15.1927 3.13267C15.5177 3.61465 15.5887 4.20462 15.3907 4.7936L14.5828 7.26149C14.6498 7.62948 14.6858 8.00346 14.6858 8.38145C14.6858 11.7923 11.911 14.5672 8.50029 14.5672C5.08958 14.5672 2.31381 11.7913 2.31381 8.38045C2.31381 7.90747 2.3858 7.44449 2.49079 6.9895C2.47879 6.96451 1.61887 4.7146 1.61887 4.7146V4.7156ZM12.6839 8.38045C12.6839 8.10446 12.6519 7.83247 12.5989 7.56648H4.39863C4.34564 7.83347 4.31364 8.10446 4.31364 8.38045C4.31364 10.6884 6.19048 12.5663 8.49929 12.5663C10.8081 12.5663 12.6839 10.6894 12.6839 8.38045ZM3.51671 4.08863L4.07766 5.56656H13.0319L13.4439 4.30662L3.86068 3.57565C3.66769 3.56365 3.42371 3.86764 3.51671 4.08863ZM23.998 18.386C23.96 19.151 23.787 19.88 23.505 20.5519C23.3741 20.8629 23.0661 21.0629 22.7291 21.0629H22.6951C22.3401 21.0629 22.0332 20.8369 21.9022 20.5069C21.6732 19.933 21.0992 19.533 20.4363 19.565C19.6294 19.603 19.0094 20.298 19.0094 21.1059V23.4778C19.0094 24.0668 18.5395 24.5668 17.9505 24.5668C14.7058 24.5668 11.976 21.8699 12.01 18.563C12.01 15.2492 14.6958 12.5633 18.0095 12.5633C21.2632 12.5633 23.906 15.1552 24 18.386H23.998ZM17.5075 20.5629C17.5075 19.735 16.8356 19.063 16.0077 19.063C15.1797 19.063 14.5078 19.735 14.5078 20.5629C14.5078 21.3909 15.1797 22.0629 16.0077 22.0629C16.8356 22.0629 17.5075 21.3909 17.5075 20.5629ZM17.5075 16.5631C17.5075 15.7351 16.8356 15.0632 16.0077 15.0632C15.1797 15.0632 14.5078 15.7351 14.5078 16.5631C14.5078 17.3911 15.1797 18.063 16.0077 18.063C16.8356 18.063 17.5075 17.3911 17.5075 16.5631ZM21.5072 16.5631C21.5072 15.7351 20.8353 15.0632 20.0073 15.0632C19.1794 15.0632 18.5075 15.7351 18.5075 16.5631C18.5075 17.3911 19.1794 18.063 20.0073 18.063C20.8353 18.063 21.5072 17.3911 21.5072 16.5631Z"
                            fill="#010101" />
                    </svg>
                    <span>Ingresar como artistas</span>
                    </Link>
                </div>

                <div class="customer">
                    <p>Amante del arte</p>
                    <Link :href="route('register')" :data="{ is_vendor: false }" method="get" as="button"
                        class="btn-class" aria-label="Ingresar como usuario">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                        <path
                            d="M9.5 4.56677C12.2614 4.56677 14.5 6.80535 14.5 9.56677C14.5 11.2025 13.7143 12.6546 12.5 13.5668H13.5C15.1569 13.5668 16.5 14.9099 16.5 16.5668V21.5668C16.5 22.1191 16.0523 22.5668 15.5 22.5668C14.9477 22.5668 14.5 22.1191 14.5 21.5668V16.5668C14.5 16.0145 14.0523 15.5668 13.5 15.5668H5.5C4.94772 15.5668 4.5 16.0145 4.5 16.5668V21.5668C4.5 22.1191 4.05228 22.5668 3.5 22.5668C2.94772 22.5668 2.5 22.1191 2.5 21.5668V16.5668C2.5 14.9099 3.84315 13.5668 5.5 13.5668H6.5C5.28565 12.6546 4.5 11.2025 4.5 9.56677C4.5 6.80535 6.73858 4.56677 9.5 4.56677ZM20 8.56677C20.5523 8.56677 21 9.01449 21 9.56677V11.0668H22.5C23.0523 11.0668 23.5 11.5145 23.5 12.0668C23.5 12.6191 23.0523 13.0668 22.5 13.0668H21V14.5668C21 15.1191 20.5523 15.5668 20 15.5668C19.4477 15.5668 19 15.1191 19 14.5668V13.0668H17.5C16.9477 13.0668 16.5 12.6191 16.5 12.0668C16.5 11.5145 16.9477 11.0668 17.5 11.0668H19V9.56677C19 9.01449 19.4477 8.56677 20 8.56677ZM9.5 6.56677C7.84315 6.56677 6.5 7.90992 6.5 9.56677C6.5 11.2236 7.84315 12.5668 9.5 12.5668C11.1569 12.5668 12.5 11.2236 12.5 9.56677C12.5 7.90992 11.1569 6.56677 9.5 6.56677Z"
                            fill="#252525" />
                    </svg>
                    <span>Ingresar como usuario</span>
                    </Link>
                </div>
            </div>

            <div class="info-end" aria-label="Separador de opciones">
                <hr>
                <span>O</span>
                <hr>
            </div>

            <div class="navigate" aria-label="Acceso para usuarios registrados">
                <span>¿Ya tienes una cuenta? </span>
                <Link :href="route('login')" class="btn-login" aria-label="Acceder a tu cuenta">Puedes acceder a ella
                </Link>
            </div>
        </div>
        <div class="section-image">
            <img src="/img/img-interfaces/img-login.png" alt="Imagen de inicio de sesión" />
        </div>
    </div>
</template>
