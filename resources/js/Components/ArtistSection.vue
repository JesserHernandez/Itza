<script setup>
defineProps({
    image: String,
    name: String,
    description: String,
    followers: String,
    pieces: String
})
</script>

<template>
    <div class="artist-section">

        <div class="cards-artist">
            <img :src="image" alt="" class="image">

            <div class="info">

                <div class="nombre">
                    <h2>{{ name }}</h2> <img src="/icons/icons-interface/check-small-icon.svg" alt="">
                </div>

                <div class="description">
                    <p>{{ description }}</p>
                </div>

                <div class="container-end">
                    <section>
                        <div class="data">
                            <img src="/icons/icons-interface/user-artist-white-icon.svg" alt="">
                            <span>
                                {{ followers }}
                            </span>
                        </div>
                        <div class="data">
                            <img src="/icons/icons-ceramics/ceramic-8-icon.svg" alt="">
                            <span>
                                {{ pieces }}
                            </span>
                        </div>
                    </section>
                    <div class="follow">
                        <button class="btn-class">
                            <span>Seguir</span>
                            <img src="/icons/icons-interface/add-icon.svg" alt="" class="icons add">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
