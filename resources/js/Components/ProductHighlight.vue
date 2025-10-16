<script setup>
import NavLink from '@/Components/NavLink.vue'

defineProps({
    slogan: String,
    store: String,
    imageHigh: String,
    name: String

})
</script>

<template>
    <div class="cards-product" role="list" aria-label="Lista de productos destacados">
        <div class="text-section" role="listitem" :aria-label="slogan">
            <div class="name">
                <img src="/icons/icons-interface/star-white-icon.svg" alt="Icono de producto destacado"
                    aria-hidden="true">
                <span>{{ name }}</span>
            </div>

            <div class="slogan">
                <h2>
                    {{ slogan }}
                </h2>
            </div>

            <div class="name-store">
                <img src="/icons/icons-interface/store-white-icon.svg" alt="Icono de tienda" aria-hidden="true">
                <span>{{ store }}</span>
            </div>

            <div class="button-link">
                <NavLink :href="route('login')" aria-label="Comprar producto destacado">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                    <path
                        d="M17.1417 13.7757C18.0167 13.7757 18.7867 13.2974 19.1833 12.574L23.36 5.00238C23.7917 4.23238 23.2317 3.27572 22.345 3.27572H5.07834L3.98167 0.942383H0.166672V3.27572H2.50001L6.70001 12.1307L5.12501 14.9774C4.27334 16.5407 5.39334 18.4424 7.16667 18.4424H21.1667V16.109H7.16667L8.45001 13.7757H17.1417ZM6.18667 5.60905H20.3617L17.1417 11.4424H8.95167L6.18667 5.60905ZM7.16667 19.609C5.88334 19.609 4.84501 20.659 4.84501 21.9424C4.84501 23.2257 5.88334 24.2757 7.16667 24.2757C8.45001 24.2757 9.50001 23.2257 9.50001 21.9424C9.50001 20.659 8.45001 19.609 7.16667 19.609ZM18.8333 19.609C17.55 19.609 16.5117 20.659 16.5117 21.9424C16.5117 23.2257 17.55 24.2757 18.8333 24.2757C20.1167 24.2757 21.1667 23.2257 21.1667 21.9424C21.1667 20.659 20.1167 19.609 18.8333 19.609Z" />
                </svg>
                <span>Comprar</span>
                </NavLink>
            </div>
        </div>
        <div class="image" role="img" aria-label="Imagen de producto destacado: Jaguar Vessel">
            <img :src="imageHigh" alt="Jaguar Vessel">
        </div>
    </div>
</template>
