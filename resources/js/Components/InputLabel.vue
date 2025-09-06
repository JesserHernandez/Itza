<script setup>
defineProps({
    value: String,
    texAdd: String,
});
</script>

<template>
    <label class="block font-medium text-sm text-gray-700">
        <p>
            <span v-if="value">{{ value }}</span>
            <span v-else><slot /></span>
            <span>{{ texAdd }}</span>
        </p>
    </label>
</template>
