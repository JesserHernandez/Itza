<script setup>
defineProps({
    imagePerson: String,
    nameArtist: String,
    valueArtist: String,
    commentuser: String
})
</script>

<template>
    <div class="container-comments">
        <div class="header">
            <div class="name-image">
                <img :src="imagePerson">
                <span>{{ nameArtist }}</span>
            </div>
            <div class="value">
                <img src="/icons/icons-interface/star-icon.svg" alt="">
                <span>{{ valueArtist }}</span>
            </div>
        </div>
        <div class="comment">
            <span>{{ commentuser }}</span>
        </div>
    </div>
</template>
