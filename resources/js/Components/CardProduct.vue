<script setup>
import { Value } from 'sass';


defineProps({
    name: String,
    price: String,
    description: String,
    location: String,
    store: String,
    value: String,
    image: String

})

</script>

<template>
    <div class="products">
        <div class="img-product">
            <img :src="image" alt="">
        </div>
        <section class="data-products">
            <div class="numbers">
                <p>C$ {{ price }}</p>

                <p><img src="/icons/icons-interface/star-icon.svg" alt="">
                    <span>{{ value }}</span></p>
            </div>

            <div class="first-data">
                <div class="name">
                    <h4>{{ name }}</h4>
                </div>
                <div class="action-card">
                    <section class="section">
                        <img src="/icons/icons-interface/mark-icon.svg" alt="">
                    </section>
                    <Link :href="route('login')" aria-label="Comprar producto destacado: Ofertas de temporada"
                        class="btn-class">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 25" fill="none">
                        <path
                            d="M17.1417 13.7757C18.0167 13.7757 18.7867 13.2974 19.1833 12.574L23.36 5.00238C23.7917 4.23238 23.2317 3.27572 22.345 3.27572H5.07834L3.98167 0.942383H0.166672V3.27572H2.50001L6.70001 12.1307L5.12501 14.9774C4.27334 16.5407 5.39334 18.4424 7.16667 18.4424H21.1667V16.109H7.16667L8.45001 13.7757H17.1417ZM6.18667 5.60905H20.3617L17.1417 11.4424H8.95167L6.18667 5.60905ZM7.16667 19.609C5.88334 19.609 4.84501 20.659 4.84501 21.9424C4.84501 23.2257 5.88334 24.2757 7.16667 24.2757C8.45001 24.2757 9.50001 23.2257 9.50001 21.9424C9.50001 20.659 8.45001 19.609 7.16667 19.609ZM18.8333 19.609C17.55 19.609 16.5117 20.659 16.5117 21.9424C16.5117 23.2257 17.55 24.2757 18.8333 24.2757C20.1167 24.2757 21.1667 23.2257 21.1667 21.9424C21.1667 20.659 20.1167 19.609 18.8333 19.609Z" />
                    </svg>
                    <span>Comprar</span>
                    </Link>
                </div>
            </div>
            <div class="description">
                <p>
                    {{ description }}
                </p>
            </div>
            <div class="end-data">
                <section class="location">
                    <img src="/icons/icons-interface/pin-location-icon.svg" alt="">
                    <span>{{ location }}</span>
                </section>
                <section class="store">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 28 29" fill="none">
                        <path
                            d="M21.42 11.3455L22.12 14.8455H5.88L6.58 11.3455H21.42ZM23.3333 5.51221H4.66667V7.84554H23.3333V5.51221ZM23.3333 9.01221H4.66667L3.5 14.8455V17.1789H4.66667V24.1789H16.3333V17.1789H21V24.1789H23.3333V17.1789H24.5V14.8455L23.3333 9.01221ZM7 21.8455V17.1789H14V21.8455H7Z"
                            fill="#303030" />
                    </svg>
                    <span>{{ store }}</span>
                </section>
            </div>
        </section>
    </div>
</template>
