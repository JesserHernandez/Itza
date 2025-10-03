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
                        <img src="/icons/icons-interface/double-arrow-icon.svg" alt="" class="icons">
                        <span class="name-link"> Volver </span>
                    </NavLink>

                    <button class="open-close btn-class">
                        <img src="/icons/icons-interface/button-menu-icon.svg" alt="" class="icons">
                    </button>
                </div>
                <NavLink class="btn-class" :href="route('admin')">
                    <img src="/icons/icons-interface/dashboard-icon.svg" alt="" class="icons">
                    <span class="name-link"> Dashboard </span>
                </NavLink>
                <NavLink class="btn-class" :href="route('teams.create')">
                    <img src="/icons/icons-interface/store-white-icon.svg" alt="" class="icons">
                    <span class="name-link"> Tiendas </span>
                </NavLink>
                <NavLink class="btn-class" :href="route('categories.index')">
                    <img src="/icons/icons-interface/task-icon.svg" alt="" class="icons">
                    <span class="name-link"> Categorías </span>
                </NavLink>
                <NavLink class="btn-class" :href="route('product_materials.index')">
                    <img src="/icons/icons-ceramics/ceramic-mingle-icon.svg" alt="" class="icons">
                    <span class="name-link"> Materiales </span>
                </NavLink>
                <NavLink class="btn-class" :href="route('tags.index')">
                    <img src="/icons/icons-interface/tag-icon.svg" alt="" class="icons">
                    <span class="name-link"> Tags </span>
                </NavLink>
                <NavLink class="btn-class">
                    <img src="/icons/icons-ceramics/ceramic-7-icon.svg" alt="" class="icons">
                    <span class="name-link"> Productos </span>
                </NavLink>
                <NavLink class="btn-class">
                    <img src="/icons/icons-interface/user-artist-white-icon.svg" alt="" class="icons">
                    <span class="name-link"> Clientes </span>
                </NavLink>
                <NavLink class="btn-class">
                    <img src="/icons/icons-interface/calendar-icon.svg" alt="" class="icons">
                    <span class="name-link"> Calendario </span>
                </NavLink>
            </div>
        </aside>

        <main class="content-admin">
            <slot />
        </main>
    </div>
</template>
