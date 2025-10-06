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

    <div class="container-admin">
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
                <NavLink class="btn-class" :href="route('admin')">
                    <img
                        src="/icons/icons-interface/dashboard-icon.svg"
                        alt=""
                        class="icons"
                    />
                    <span class="name-link"> Dashboard </span>
                </NavLink>
                <NavLink class="btn-class" :href="route('teams.create')">
                    <img
                        src="/icons/icons-interface/store-white-icon.svg"
                        alt=""
                        class="icons"
                    />
                    <span class="name-link"> Tiendas </span>
                </NavLink>

                <ul class=" title-list">
                    <li class="item-list "
                    >
                        <button
                            :class="{
                                'btn-class': true,
                                'active': isSubmenuOpen,
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
                            :class="{ 'expanded': isSubmenuOpen, 'collapsed': !isSubmenuOpen }"
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
                                    <span class="name-link"> Categorías </span>
                                </NavLink>
                            </li>
                            <li>
                                <NavLink
                                    class="btn-class"
                                    :href="route('product_materials.index')"
                                >
                                    <img
                                        src="/icons/icons-ceramics/ceramic-mingle-icon.svg"
                                        alt=""
                                        class="icons"
                                    />
                                    <span class="name-link"> Materiales </span>
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
                            <li>
                                <NavLink class="btn-class">
                    <img
                        src="/icons/icons-ceramics/ceramic-7-icon.svg"
                        alt=""
                        class="icons"
                    />
                    <span class="name-link"> Productos </span>
                </NavLink>

                            </li>
                            <li>
                                <NavLink class="btn-class">
                                    <img
                                        src="/icons/icons-interface/post-white-icon.svg"
                                        alt=""
                                        class="icons"
                                    />
                                    <span class="name-link"> Publicaciones </span>
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
            </div>
        </aside>

        <main class="content-admin">
            <slot />
        </main>
    </div>
</template>
