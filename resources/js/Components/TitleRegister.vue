<script setup>
defineProps({
    title: String,
    paragraph: String
});
</script>
<template>
    <div class="title-step">
        <span class="title-pass">{{ title }}</span>
        <span class="text-pass">{{ paragraph }}</span>
    </div>
</template>
