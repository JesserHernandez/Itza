<script setup>
defineProps({
    image: String,
    name: String,
    description: String,
})
</script>

<template>
    <div class="city-section">

        <div class="cards-artist">
            <img :src="image" alt="" class="image">

            <div class="info">

                <div class="nombre">
                    <img src="/icons/icons-interface/city-icon.png" alt=""><h2>{{ name }}</h2> 
                </div>

                <div class="description">
                    <p>{{ description }}</p>
                </div>

                <div class="container-end">
                   
                    <div class="follow">
                        <a :href="route('sjo')" class="btn-class">
                            <span>Conocer más</span>
                            <img src="/icons/icons-interface/conocer-icon.png" alt="" class="icons add">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
