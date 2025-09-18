<script setup>
defineProps({
    value: String,
    texAdd: String,
});
</script>

<template>
    <label class="">
        <p>
            <span v-if="value">{{ value }}</span>
            <span v-else><slot /></span>
            <span class="asterisco">{{ texAdd }}</span>
        </p>
    </label>
</template>
