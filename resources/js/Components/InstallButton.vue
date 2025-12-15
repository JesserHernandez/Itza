<template>
    <div v-if="deferredPrompt" class="fixed bottom-4 right-4">
        <button
            @click="installApp"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow-lg hover:bg-blue-700 transition"
        >
            Instalar App 📱
        </button>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";

const deferredPrompt = ref(null);

onMounted(() => {
    window.addEventListener("beforeinstallprompt", (e) => {
        e.preventDefault();
        deferredPrompt.value = e;
    });
});

const installApp = async () => {
    if (!deferredPrompt.value) return;

    deferredPrompt.value.prompt();
    const choiceResult = await deferredPrompt.value.userChoice;

    if (choiceResult.outcome === "accepted") {
        console.log("El usuario aceptó instalar la app 🎉");
    } else {
        console.log("El usuario canceló la instalación 😅");
    }

    deferredPrompt.value = null;
};
</script>
