<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },

    description: {
        type: String,
        default: '',
    },
});
</script>

<template>
    <button :type="type" class="btn-class">
        {{  }}
    </button>
</template>
