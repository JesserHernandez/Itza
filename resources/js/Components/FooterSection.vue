<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<!-- Template Permite renderizar el HTML en vue -->
<template>
    <footer>
        <!-- Inicio de contenedor principal del footer -->
        <div class="container-info">
            <!-- Inicio de texto de información-->
            <div class="info">
                <h2>
                    Comienza tu aventura artistica con nosotros, intégrate a
                    ITZ´AT para mejorar tu margen de negocio con nosotros
                </h2>
            </div>
            <!-- Fin de texto de información-->

            <!-- Inicio de Botón de contáctanos -->

            <div class="btn-contact">
                <button class="btn-class">
                    <img
                        src="/icons/icons-interface/user-artist-white-icon.svg"
                        alt=""
                    />
                    <span>Contáctanos</span>
                </button>
            </div>
            <!-- Fin de Botón de contáctanos -->

            <!-- Inicio de Redes sociales -->
            <div class="redes">
                <!-- Instagram -->
                <Link href="#">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="25"
                        viewBox="0 0 24 25"
                        fill="none"
                    >
                        <g clip-path="url(#clip0_3319_1443)">
                            <path
                                d="M12 2.27031C15.2063 2.27031 15.5859 2.28437 16.8469 2.34062C18.0188 2.39219 18.6516 2.58906 19.0734 2.75313C19.6313 2.96875 20.0344 3.23125 20.4516 3.64844C20.8734 4.07031 21.1313 4.46875 21.3469 5.02656C21.5109 5.44844 21.7078 6.08594 21.7594 7.25312C21.8156 8.51875 21.8297 8.89844 21.8297 12.1C21.8297 15.3063 21.8156 15.6859 21.7594 16.9469C21.7078 18.1188 21.5109 18.7516 21.3469 19.1734C21.1313 19.7313 20.8687 20.1344 20.4516 20.5516C20.0297 20.9734 19.6313 21.2313 19.0734 21.4469C18.6516 21.6109 18.0141 21.8078 16.8469 21.8594C15.5813 21.9156 15.2016 21.9297 12 21.9297C8.79375 21.9297 8.41406 21.9156 7.15313 21.8594C5.98125 21.8078 5.34844 21.6109 4.92656 21.4469C4.36875 21.2313 3.96563 20.9688 3.54844 20.5516C3.12656 20.1297 2.86875 19.7313 2.65313 19.1734C2.48906 18.7516 2.29219 18.1141 2.24063 16.9469C2.18438 15.6813 2.17031 15.3016 2.17031 12.1C2.17031 8.89375 2.18438 8.51406 2.24063 7.25312C2.29219 6.08125 2.48906 5.44844 2.65313 5.02656C2.86875 4.46875 3.13125 4.06562 3.54844 3.64844C3.97031 3.22656 4.36875 2.96875 4.92656 2.75313C5.34844 2.58906 5.98594 2.39219 7.15313 2.34062C8.41406 2.28437 8.79375 2.27031 12 2.27031ZM12 0.109375C8.74219 0.109375 8.33438 0.123437 7.05469 0.179688C5.77969 0.235938 4.90313 0.442187 4.14375 0.7375C3.35156 1.04687 2.68125 1.45469 2.01563 2.125C1.34531 2.79063 0.9375 3.46094 0.628125 4.24844C0.332812 5.0125 0.126563 5.88437 0.0703125 7.15937C0.0140625 8.44375 0 8.85156 0 12.1094C0 15.3672 0.0140625 15.775 0.0703125 17.0547C0.126563 18.3297 0.332812 19.2063 0.628125 19.9656C0.9375 20.7578 1.34531 21.4281 2.01563 22.0938C2.68125 22.7594 3.35156 23.1719 4.13906 23.4766C4.90313 23.7719 5.775 23.9781 7.05 24.0344C8.32969 24.0906 8.7375 24.1047 11.9953 24.1047C15.2531 24.1047 15.6609 24.0906 16.9406 24.0344C18.2156 23.9781 19.0922 23.7719 19.8516 23.4766C20.6391 23.1719 21.3094 22.7594 21.975 22.0938C22.6406 21.4281 23.0531 20.7578 23.3578 19.9703C23.6531 19.2063 23.8594 18.3344 23.9156 17.0594C23.9719 15.7797 23.9859 15.3719 23.9859 12.1141C23.9859 8.85625 23.9719 8.44844 23.9156 7.16875C23.8594 5.89375 23.6531 5.01719 23.3578 4.25781C23.0625 3.46094 22.6547 2.79063 21.9844 2.125C21.3188 1.45938 20.6484 1.04688 19.8609 0.742188C19.0969 0.446875 18.225 0.240625 16.95 0.184375C15.6656 0.123438 15.2578 0.109375 12 0.109375Z"
                                fill="#6A6A6A"
                            />
                            <path
                                d="M12 5.94531C8.59688 5.94531 5.83594 8.70625 5.83594 12.1094C5.83594 15.5125 8.59688 18.2734 12 18.2734C15.4031 18.2734 18.1641 15.5125 18.1641 12.1094C18.1641 8.70625 15.4031 5.94531 12 5.94531ZM12 16.1078C9.79219 16.1078 8.00156 14.3172 8.00156 12.1094C8.00156 9.90156 9.79219 8.11094 12 8.11094C14.2078 8.11094 15.9984 9.90156 15.9984 12.1094C15.9984 14.3172 14.2078 16.1078 12 16.1078Z"
                                fill="#6A6A6A"
                            />
                            <path
                                d="M19.8469 5.70176C19.8469 6.49864 19.2 7.14083 18.4078 7.14083C17.6109 7.14083 16.9688 6.49395 16.9688 5.70176C16.9688 4.90488 17.6156 4.2627 18.4078 4.2627C19.2 4.2627 19.8469 4.90957 19.8469 5.70176Z"
                                fill="#6A6A6A"
                            />
                        </g>
                        <defs>
                            <clipPath id="clip0_3319_1443">
                                <rect
                                    width="24"
                                    height="24"
                                    fill="white"
                                    transform="translate(0 0.109375)"
                                />
                            </clipPath>
                        </defs>
                    </svg>
                    Instagram
                </Link>

                <!-- Facebook -->
                <Link href="#">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="25"
                        viewBox="0 0 24 25"
                        fill="none"
                    >
                        <g clip-path="url(#clip0_3411_5638)">
                            <path
                                d="M24 12.1094C24 5.48201 18.6274 0.109375 12 0.109375C5.37264 0.109375 0 5.48201 0 12.1094C0 17.7369 3.87456 22.4591 9.10128 23.7561V15.7766H6.62688V12.1094H9.10128V10.5292C9.10128 6.4449 10.9498 4.55177 14.9597 4.55177C15.72 4.55177 17.0318 4.70106 17.5685 4.84985V8.17385C17.2853 8.14409 16.7933 8.12922 16.1822 8.12922C14.2147 8.12922 13.4544 8.87465 13.4544 10.8124V12.1094H17.3741L16.7006 15.7766H13.4544V24.0215C19.3963 23.3039 24.0005 18.2447 24.0005 12.1094H24Z"
                                fill="#6A6A6A"
                            />
                        </g>
                        <defs>
                            <clipPath id="clip0_3411_5638">
                                <rect
                                    width="24"
                                    height="24"
                                    fill="white"
                                    transform="translate(0 0.109375)"
                                />
                            </clipPath>
                        </defs>
                    </svg>
                    Facebook
                </Link>

                <!-- TikTok -->
                <Link href="#">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="25"
                        viewBox="0 0 24 25"
                        fill="none"
                    >
                        <g clip-path="url(#clip0_3411_1960)">
                            <path
                                d="M17.0725 0.109375H13.0278V16.4572C13.0278 18.405 11.4722 20.005 9.53626 20.005C7.60034 20.005 6.04469 18.405 6.04469 16.4572C6.04469 14.5442 7.56577 12.9789 9.43257 12.9094V8.80504C5.31872 8.87458 2 12.2485 2 16.4572C2 20.7007 5.38786 24.1094 9.57085 24.1094C13.7538 24.1094 17.1416 20.6659 17.1416 16.4572V8.07457C18.6627 9.18764 20.5295 9.84851 22.5 9.88331V5.77894C19.4579 5.67459 17.0725 3.17024 17.0725 0.109375Z"
                                fill="#6A6A6A"
                            />
                        </g>
                        <defs>
                            <clipPath id="clip0_3411_1960">
                                <rect
                                    width="24"
                                    height="24"
                                    fill="white"
                                    transform="translate(0 0.109375)"
                                />
                            </clipPath>
                        </defs>
                    </svg>
                    TikTok
                </Link>

                <!-- WhatsApp -->
                <Link href="#">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="25"
                        viewBox="0 0 24 25"
                        fill="none"
                    >
                        <path
                            d="M0 24.1094L1.687 17.9464C0.645998 16.1424 0.0989998 14.0974 0.0999998 12.0004C0.103 5.44437 5.43799 0.109375 11.993 0.109375C15.174 0.110375 18.16 1.34938 20.406 3.59737C22.6509 5.84538 23.8869 8.83338 23.8859 12.0114C23.8829 18.5684 18.548 23.9034 11.993 23.9034C10.003 23.9024 8.04198 23.4034 6.30499 22.4554L0 24.1094ZM6.59698 20.3024C8.27298 21.2974 9.87298 21.8934 11.989 21.8944C17.437 21.8944 21.875 17.4604 21.878 12.0094C21.88 6.54737 17.463 2.11937 11.997 2.11737C6.54498 2.11737 2.11 6.55138 2.108 12.0014C2.107 14.2264 2.75899 15.8924 3.85399 17.6354L2.85499 21.2834L6.59698 20.3024ZM17.984 14.8384C17.91 14.7144 17.712 14.6404 17.414 14.4914C17.117 14.3424 15.656 13.6234 15.383 13.5244C15.111 13.4254 14.913 13.3754 14.714 13.6734C14.516 13.9704 13.946 14.6404 13.773 14.8384C13.6 15.0364 13.426 15.0614 13.129 14.9124C12.832 14.7634 11.874 14.4504 10.739 13.4374C9.85598 12.6494 9.25898 11.6764 9.08598 11.3784C8.91298 11.0814 9.06798 10.9204 9.21598 10.7724C9.34998 10.6394 9.51298 10.4254 9.66198 10.2514C9.81298 10.0794 9.86198 9.95538 9.96198 9.75638C10.061 9.55838 10.012 9.38438 9.93698 9.23538C9.86198 9.08738 9.26798 7.62438 9.02098 7.02938C8.77898 6.45038 8.53398 6.52837 8.35198 6.51937L7.78198 6.50938C7.58398 6.50938 7.26198 6.58337 6.98998 6.88137C6.71798 7.17937 5.94999 7.89738 5.94999 9.36038C5.94999 10.8234 7.01498 12.2364 7.16298 12.4344C7.31198 12.6324 9.25798 15.6344 12.239 16.9214C12.948 17.2274 13.502 17.4104 13.933 17.5474C14.645 17.7734 15.293 17.7414 15.805 17.6654C16.376 17.5804 17.563 16.9464 17.811 16.2524C18.059 15.5574 18.059 14.9624 17.984 14.8384Z"
                            fill="#6A6A6A"
                        />
                    </svg>
                    WhatsApp
                </Link>
            </div>
            <!-- Fin de Redes sociales -->

            <!-- Inicio de Políticas de privacidad y términos -->
            <div class="politicas">
                <!-- Políticas de privacidad -->
                <Link href="#">
                    <span>Políticas de privacidad</span>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="8"
                        height="9"
                        viewBox="0 0 8 9"
                        fill="none"
                    >
                        <path
                            d="M7 1.5L7 7.5M7 1.5L1 1.5M7 1.5L1 7.5"
                            stroke="#6A6A6A"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </Link>

                <!-- Términos y condiciones -->
                <Link href="#">
                    Términos y condiciones
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="8"
                        height="9"
                        viewBox="0 0 8 9"
                        fill="none"
                    >
                        <path
                            d="M7 1.10938L7 7.10938M7 1.10938L1 1.10938M7 1.10938L1 7.10938"
                            stroke="currentColor"
                            stroke-width="2"
                            fill="#6A6A6A"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </Link>
            </div>
            <!-- Fin de Políticas de privacidad y términos -->
        </div>
        <!-- Fin de contenedor principal del footer -->

        <!-- Inicio de contenedor secundario del menu del footer -->
        <div class="container-menu">
            <!-- Logotipo -->
            <div class="logo-menu">
                <img
                    src="/img/img-logo/Logotipo.svg"
                    alt="Logotipo de Itz'at"
                    class="logotipo"
                />
            </div>

            <!-- Menú de navegación -->
            <div class="menu">
                <!-- Enlace de Inicio -->
                <Link href="#">
                    Inicio
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="8"
                        height="9"
                        viewBox="0 0 8 9"
                        fill="none"
                    >
                        <path
                            d="M7 1.10938L7 7.10938M7 1.10938L1 1.10938M7 1.10938L1 7.10938"
                            stroke="#6A6A6A"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </Link>

                <!-- Enlace de Ciudades creativas -->
                <Link href="#">
                    Ciudades creativas
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="8"
                        height="9"
                        viewBox="0 0 8 9"
                        fill="none"
                    >
                        <path
                            d="M7 1.10938L7 7.10938M7 1.10938L1 1.10938M7 1.10938L1 7.10938"
                            stroke="#6A6A6A"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </Link>

                <!-- Enlace de Cerámicas -->
                <Link href="#">
                    Cerámicas
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="8"
                        height="9"
                        viewBox="0 0 8 9"
                        fill="none"
                    >
                        <path
                            d="M7 1.10938L7 7.10938M7 1.10938L1 1.10938M7 1.10938L1 7.10938"
                            stroke="#6A6A6A"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </Link>

                <!-- Enlace de Artistas -->
                <Link href="#">
                    Artistas
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="8"
                        height="9"
                        viewBox="0 0 8 9"
                        fill="none"
                    >
                        <path
                            d="M7 1.10938L7 7.10938M7 1.10938L1 1.10938M7 1.10938L1 7.10938"
                            stroke="#6A6A6A"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </Link>

                <!-- Enlace de ¿Quiénes somos? -->
                <Link href="#">
                    ¿Quiénes somos?
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="8"
                        height="9"
                        viewBox="0 0 8 9"
                        fill="none"
                    >
                        <path
                            d="M7 1.10938L7 7.10938M7 1.10938L1 1.10938M7 1.10938L1 7.10938"
                            stroke="#6A6A6A"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </Link>
            </div>
            <!-- Fin de menú de navegación -->
        </div>
        <!-- Fin de contenedor secundario del menu del footer -->
    </footer>
</template>
