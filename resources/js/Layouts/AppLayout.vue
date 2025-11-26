<script setup>
import { ref } from "vue";
import NavLink from "@/Components/NavLink.vue";
import Dropdown from "@/Components/Dropdown.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import DropdownLink from "@/Components/DropdownLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";

defineProps({
    title: String,
    href: String,
    permissions: Array,
});

const showingNavigationDropdown = ref(false);
const isSubmenuOpen = ref(false);

const switchToTeam = (team) => {
    router.put(
        route("current-team.update"),
        {
            team_id: team.id,
        },
        {
            preserveState: false,
        }
    );
};

const logout = () => {
    router.post(route("logout"));
};

function toggleSubmenu() {
    isSubmenuOpen.value = !isSubmenuOpen.value;
}
</script>

<template>
    <Head :title="title" />

    <!-- Teams Dropdown v-if="$page.props.jetstream.hasTeamFeatures" {{ $page.props.auth.user.current_team.name }}-->
    <!-- :href="route('teams.show', $page.props.auth.user.current_team)" -->
    <!-- v-if="$page.props.auth.user.all_teams.length > 1" -->
    <!-- v-for="team in $page.props.auth.user.all_teams" :key="team.id" -->
    <!-- v-if="team.id == $page.props.auth.user.current_team_id -->
    <!-- Authentication
    <form @submit.prevent="logout">
        <NavLink as="button"> Cerrar sesión </NavLink>
    </form> -->

    <div
        class="container-admin"
        v-if="
            $page.props.auth.role.includes('Administrador') ||
            $page.props.auth.role.includes('Vendedor')
        "
    >
        <aside class="aside">
            <div class="items-aside">
                <div class="actions-aside">
                    <NavLink :href="href" class="btn-class back">
                        <img
                            src="/icons/icons-interface/double-arrow-icon.svg"
                            alt=""
                            class="icons"
                        />
                        <span class="name-link"> Volver </span>
                    </NavLink>

                    <button class="open-close btn-class">
                        <img
                            src="/icons/icons-interface/button-menu-icon.svg"
                            alt=""
                            class="icons"
                        />
                    </button>
                </div>
                <NavLink class="btn-class" :href="route('vendor')">
                    <img
                        src="/icons/icons-interface/dashboard-icon.svg"
                        alt=""
                        class="icons"
                    />
                    <span class="name-link"> Panel de control </span>
                </NavLink>

                <!-- ? VALIDACIÓN PARA ADMINISTRADORES -->
                <template
                    v-if="$page.props.auth.role.includes('Administrador')"
                >
                    <NavLink
                        class="btn-class"
                        :href="route('permissions.index')"
                    >
                        <img
                            src="/icons/icons-ceramics/vasija-4-icon.svg"
                            alt=""
                        />
                        <span class="name-link"> Permisos </span>
                    </NavLink>

                    <NavLink class="btn-class" :href="route('roles.index')">
                        <img
                            src="/icons/icons-ceramics/ceramic-mingle-icon.svg"
                            alt=""
                            class="icons"
                        />
                        <span class="name-link"> Rol </span>
                    </NavLink>

                    <NavLink
                        class="btn-class"
                        :href="route('users.index')"
                        v-if="$page.props.auth.role.includes('Administrador')"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="14"
                            height="15"
                            viewBox="0 0 14 15"
                            fill="none"
                        >
                            <path
                                d="M7.21289 0.505859C9.41453 0.617355 11.165 2.43765 11.165 4.66699L11.1602 4.88086C11.0852 6.3605 10.2378 7.63481 9.01367 8.3125C10.0226 8.6324 10.9507 9.19001 11.7129 9.95215C12.9631 11.2024 13.665 12.8989 13.665 14.667H0.332031C0.332032 12.899 1.03404 11.2024 2.28418 9.95215C3.04617 9.19016 3.9747 8.63333 4.9834 8.31348C3.7598 7.63554 2.91281 6.36026 2.83789 4.88086L2.83203 4.66699C2.83203 2.36591 4.69798 0.500164 6.99902 0.5L7.21289 0.505859ZM6.99902 10C5.76146 10.0001 4.57431 10.4921 3.69922 11.3672C3.31792 11.7485 3.00896 12.1889 2.78223 12.667H11.2148C10.9881 12.189 10.68 11.7484 10.2988 11.3672C9.42375 10.4922 8.23651 10.0001 6.99902 10ZM6.99902 2.5C5.80255 2.50016 4.83203 3.47048 4.83203 4.66699C4.83221 5.86336 5.80265 6.83284 6.99902 6.83301C8.19538 6.83283 9.16486 5.86335 9.16504 4.66699C9.16504 3.47048 8.19549 2.50018 6.99902 2.5Z"
                                fill="#F0F0F0"
                            />
                        </svg>
                        <span class="name-link"> Usuarios </span>
                    </NavLink>

                    <NavLink
                        class="btn-class"
                        :href="route('creative_cities.index')"
                    >
                        <img
                            src="/icons/icons-ceramics/cuadro-patron-icon.svg"
                            alt=""
                            class="icons"
                        />
                        <span class="name-link"> Ciudades creativas</span>
                    </NavLink>
                    <NavLink
                        class="btn-class"
                        :href="route('creative_circuits.index')"
                    >
                        <img
                            src="/icons/icons-ceramics/city-creative-icon.svg"
                            alt=""
                            class="icons"
                        />
                        <span class="name-link"> Circuitos creativos</span>
                    </NavLink>
                </template>

                <!-- ? VALIDACIÓN PARA VENDEDORES -->

                <template v-if="$page.props.auth.role.includes('Vendedor')">
                    <Dropdown>
                        <template #trigger>
                            <div class="admin-store">
                                <button class="btn-class">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="8"
                                        height="4"
                                        viewBox="0 0 10 7"
                                        fill="none"
                                        class="icons"
                                    >
                                        <path
                                            d="M5 6.83335L0 1.83335L1.16667 0.666687L5 4.50002L8.83333 0.666687L10 1.83335L5 6.83335Z"
                                            fill="#F0F0F0"
                                        />
                                    </svg>
                                    Admin/Tiendas
                                </button>
                            </div>
                        </template>
                        <template #content>
                            <div class="content">
                                <DropdownLink
                                    :href="route('teams.create')"
                                    class="btn-class"
                                >
                                    <img
                                        src="/icons/icons-interface/store-white-icon.svg"
                                        alt=""
                                        class="icons"
                                    />
                                    Tiendas
                                </DropdownLink>
                                <!-- Inicio de productos -->
                                <DropdownLink
                                    class="btn-class"
                                    :href="route('products.index')"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="20"
                                        height="20"
                                        viewBox="0 0 20 20"
                                        fill="none"
                                    >
                                        <path
                                            d="M3.77078 0C7.93668 0 12.1026 0 16.2685 0C16.1185 0.389563 15.9686 0.786475 15.8103 1.20544C16.3851 1.20544 16.9267 1.19074 17.46 1.20544C18.7597 1.24954 19.8512 2.14627 19.9845 3.26351C20.1261 4.45424 19.2846 5.54208 17.9848 5.82139C17.7182 5.88019 17.435 5.89489 17.1433 5.93164C18.3181 7.5928 18.8097 9.40096 18.6264 11.3561C18.4431 13.3039 17.6016 15.0092 16.0685 16.4939C16.5185 16.4939 16.91 16.4939 17.3183 16.4939C17.3183 17.6773 17.3183 18.8387 17.3183 20C12.4275 20 7.55342 20 2.67932 20C2.67932 18.8313 2.67932 17.67 2.67932 16.4866C3.08758 16.4866 3.48751 16.4866 3.86244 16.4866C0.829667 13.1496 0.546386 9.63616 2.82097 5.91694C2.63767 5.90224 2.43771 5.89489 2.22942 5.86549C1.03797 5.71114 0.079801 4.7703 0.00481474 3.70452C-0.0701715 2.60198 0.738004 1.5656 1.92112 1.29364C2.28772 1.21279 2.67934 1.21279 3.0626 1.19809C3.4292 1.18339 3.79578 1.19809 4.18737 1.19809C4.15404 1.09518 4.12073 1.02168 4.09573 0.948179C3.98742 0.632119 3.8791 0.31606 3.77078 0ZM9.98633 16.4866C11.2694 16.4866 12.5525 16.4866 13.8356 16.4792C13.9606 16.4792 14.1189 16.4351 14.2105 16.3616C16.3268 14.8695 17.2933 12.8997 17.3266 10.5402C17.3266 10.43 17.2683 10.3785 17.1683 10.3344C16.6018 10.0772 16.0352 9.82727 15.477 9.56266C15.3603 9.50386 15.2687 9.51121 15.152 9.56266C14.3855 9.90812 13.6107 10.2389 12.8441 10.5917C12.7025 10.6578 12.5942 10.6505 12.4609 10.5843C11.7193 10.2389 10.9611 9.90812 10.2196 9.57001C10.0946 9.51121 9.98632 9.50386 9.85301 9.56266C9.05316 9.90812 8.24496 10.2462 7.44511 10.599C7.3118 10.6578 7.22015 10.6431 7.1035 10.5917C6.34531 10.2462 5.57878 9.90077 4.81226 9.57001C4.72894 9.53326 4.59564 9.53326 4.51232 9.57001C3.93743 9.81257 3.37919 10.0698 2.81263 10.3197C2.69598 10.3712 2.64599 10.43 2.65432 10.5476C2.68765 10.9078 2.68766 11.2679 2.73765 11.6207C3.03759 13.5538 4.01242 15.1635 5.77044 16.3763C5.87875 16.4498 6.03704 16.4939 6.17035 16.4939C7.44511 16.4939 8.71989 16.4866 9.98633 16.4866ZM2.8793 8.97464C2.97095 8.93789 3.03759 8.90849 3.10425 8.88644C3.57083 8.68063 4.0374 8.47483 4.50398 8.26167C4.62896 8.20287 4.72895 8.21022 4.85393 8.26167C5.61213 8.60713 6.37864 8.94524 7.13684 9.2907C7.26181 9.34951 7.36181 9.34216 7.48678 9.2907C8.27831 8.94524 9.07815 8.61448 9.86967 8.26167C10.0113 8.20287 10.1196 8.21022 10.2613 8.26902C11.0028 8.60713 11.7443 8.93054 12.4859 9.276C12.6275 9.34215 12.7275 9.34215 12.8691 9.276C13.6273 8.93054 14.4022 8.59978 15.1604 8.26167C15.2937 8.20287 15.3937 8.20287 15.527 8.26167C16.0435 8.50423 16.5684 8.73943 17.135 8.99669C17.01 8.43072 16.8101 7.93091 16.5518 7.43844C15.8353 6.0713 14.7438 5.01286 13.2607 4.26314C13.6523 3.22675 14.0272 2.21242 14.4188 1.18339C11.4777 1.18339 8.56157 1.18339 5.62044 1.18339C5.64544 1.25689 5.66212 1.32304 5.68711 1.38919C6.01205 2.25652 6.32865 3.1312 6.67026 3.99853C6.75358 4.20434 6.71191 4.29989 6.50361 4.41014C5.21218 5.09372 4.2457 6.04925 3.57083 7.23999C3.25422 7.7839 3.02094 8.34987 2.8793 8.97464ZM15.9852 17.6773C11.9859 17.6773 8.00335 17.6773 4.01241 17.6773C4.01241 18.0669 4.01241 18.4491 4.01241 18.8313C8.01168 18.8313 11.9943 18.8313 15.9852 18.8313C15.9852 18.4418 15.9852 18.0669 15.9852 17.6773ZM14.8521 3.74127C15.252 4.05733 15.6269 4.36604 16.0102 4.67475C16.0519 4.70415 16.1102 4.7262 16.1685 4.7262C16.5851 4.7262 16.9934 4.7409 17.41 4.71885C18.1432 4.6821 18.6764 4.16024 18.6681 3.51341C18.6514 2.88864 18.0932 2.38883 17.36 2.37413C16.7517 2.36678 16.1352 2.36678 15.5186 2.37413C15.4603 2.37413 15.3603 2.41823 15.3437 2.46968C15.1604 2.90334 15.0021 3.32966 14.8521 3.74127ZM3.53749 2.37413C3.24588 2.37413 2.96262 2.36678 2.671 2.37413C1.91281 2.38883 1.32958 2.90334 1.33791 3.55016C1.33791 4.19699 1.92946 4.7115 2.68766 4.71885C3.05426 4.7262 3.42918 4.7262 3.79578 4.71885C3.87076 4.71885 3.96241 4.6821 4.02907 4.638C4.379 4.37339 4.72061 4.10878 5.05389 3.83682C5.10388 3.80007 5.13721 3.69717 5.11222 3.64572C4.97891 3.26351 4.82893 2.88129 4.68729 2.49908C4.65396 2.40353 4.60398 2.36678 4.48733 2.36678C4.17072 2.38148 3.8541 2.37413 3.53749 2.37413Z"
                                            fill="#F0F0F0"
                                        />
                                    </svg>
                                    Productos
                                </DropdownLink>
                                <!-- Fin de productos -->
                                <DropdownLink
                                    class="btn-class"
                                    :href="route('inventories.index')"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="20"
                                        height="20"
                                        viewBox="0 0 20 20"
                                        fill="none"
                                    >
                                        <path
                                            d="M18.0273 10.1919C17.8789 10.4294 17.6824 10.633 17.4503 10.7896L11.4004 14.8733C10.5552 15.4438 9.44822 15.4438 8.60303 14.8733L2.55313 10.7896C1.79214 10.276 1.49704 9.33037 1.774 8.50001L8.61496 13.0596C9.40222 13.5844 10.413 13.6172 11.2281 13.158L11.3885 13.0596L18.2288 8.49951C18.4105 9.04567 18.3562 9.66571 18.0273 10.1919ZM18.2288 11.7495C18.4105 12.2957 18.3562 12.9157 18.0273 13.4419C17.8789 13.6794 17.6824 13.883 17.4503 14.0396L11.4004 18.1233C10.5552 18.6938 9.44822 18.6938 8.60303 18.1233L2.55313 14.0396C1.79214 13.526 1.49704 12.5804 1.774 11.75L8.61496 16.3096C9.40222 16.8344 10.413 16.8672 11.2281 16.408L11.3885 16.3096L18.2288 11.7495ZM11.3885 1.42451L17.7536 5.66796C18.2132 5.97432 18.3373 6.59518 18.031 7.05471C17.9577 7.16457 17.8635 7.25883 17.7536 7.33206L11.3885 11.5755C10.5487 12.1353 9.45471 12.1353 8.61496 11.5755L2.24978 7.33206C1.79025 7.02571 1.66608 6.40484 1.97243 5.94531C2.04567 5.83546 2.13993 5.7412 2.24978 5.66796L8.61496 1.42451C9.45471 0.864681 10.5487 0.864681 11.3885 1.42451ZM9.56246 2.60624L9.44701 2.67259L3.70671 6.50001L9.44701 10.3274C9.74558 10.5265 10.1245 10.5486 10.441 10.3938L10.5564 10.3274L16.2957 6.50001L10.5564 2.67259C10.2578 2.47354 9.8789 2.45142 9.56246 2.60624Z"
                                            fill="#F0F0F0"
                                        />
                                    </svg>
                                    Inventario
                                </DropdownLink>
                                <DropdownLink class="btn-class">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="18"
                                        height="14"
                                        viewBox="0 0 18 14"
                                        fill="none"
                                    >
                                        <path
                                            d="M2.33464 13.6666C1.8763 13.6666 1.48394 13.5035 1.15755 13.1771C0.831163 12.8507 0.667969 12.4583 0.667969 12V1.99998C0.667969 1.54165 0.831163 1.14929 1.15755 0.822896C1.48394 0.496507 1.8763 0.333313 2.33464 0.333313H7.33464L9.0013 1.99998H15.668C16.1263 1.99998 16.5187 2.16317 16.8451 2.48956C17.1714 2.81595 17.3346 3.20831 17.3346 3.66665V12C17.3346 12.4583 17.1714 12.8507 16.8451 13.1771C16.5187 13.5035 16.1263 13.6666 15.668 13.6666H2.33464ZM2.33464 12H15.668V3.66665H8.3138L6.64714 1.99998H2.33464V12Z"
                                            fill="#F0F0F0"
                                        />
                                    </svg>
                                    Movimientos
                                </DropdownLink>
                                <DropdownLink class="btn-class">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="14"
                                        height="18"
                                        viewBox="0 0 14 18"
                                        fill="none"
                                    >
                                        <path
                                            d="M7.83203 8.16663H6.16536V10.6666H3.66536V12.3333H6.16536V14.8333H7.83203V12.3333H10.332V10.6666H7.83203V8.16663ZM8.66536 0.666626H1.9987C1.08203 0.666626 0.332031 1.41663 0.332031 2.33329V15.6666C0.332031 16.5833 1.0737 17.3333 1.99036 17.3333H11.9987C12.9154 17.3333 13.6654 16.5833 13.6654 15.6666V5.66663L8.66536 0.666626ZM11.9987 15.6666H1.9987V2.33329H7.83203V6.49996H11.9987V15.6666Z"
                                            fill="#F0F0F0"
                                        />
                                    </svg>
                                    Ordenes
                                </DropdownLink>
                            </div>
                        </template>
                    </Dropdown>

                    <ul class="title-list">
                        <li class="item-list">
                            <button
                                :class="{
                                    'btn-class': true,
                                    active: isSubmenuOpen,
                                }"
                                @click="toggleSubmenu"
                                aria-expanded="isSubmenuOpen"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="8"
                                    height="4"
                                    viewBox="0 0 10 7"
                                    fill="none"
                                    class="icons"
                                >
                                    <path
                                        d="M5 6.83335L0 1.83335L1.16667 0.666687L5 4.50002L8.83333 0.666687L10 1.83335L5 6.83335Z"
                                        fill="#F0F0F0"
                                    />
                                </svg>
                                <span>Administración</span>
                            </button>

                            <ul
                                class="list-admin"
                                v-show="isSubmenuOpen"
                                :class="{
                                    expanded: isSubmenuOpen,
                                    collapsed: !isSubmenuOpen,
                                }"
                                :aria-hidden="!isSubmenuOpen"
                            >
                                <li>
                                    <NavLink
                                        class="btn-class"
                                        :href="route('categories.index')"
                                    >
                                        <img
                                            src="/icons/icons-interface/task-icon.svg"
                                            alt=""
                                            class="icons"
                                        />
                                        <span class="name-link">
                                            Categorías
                                        </span>
                                    </NavLink>
                                </li>
                                <li>
                                    <NavLink
                                        class="btn-class"
                                        :href="route('tags.index')"
                                    >
                                        <img
                                            src="/icons/icons-interface/tag-icon.svg"
                                            alt=""
                                            class="icons"
                                        />
                                        <span class="name-link"> Tags </span>
                                    </NavLink>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <NavLink class="btn-class">
                        <img
                            src="/icons/icons-interface/user-artist-white-icon.svg"
                            alt=""
                            class="icons"
                        />
                        <span class="name-link"> Clientes </span>
                    </NavLink>
                    <NavLink class="btn-class">
                        <img
                            src="/icons/icons-interface/calendar-icon.svg"
                            alt=""
                            class="icons"
                        />
                        <span class="name-link"> Calendario </span>
                    </NavLink>
                </template>
            </div>
        </aside>

        <main class="content-admin">
            <slot />
        </main>
    </div>
</template>
