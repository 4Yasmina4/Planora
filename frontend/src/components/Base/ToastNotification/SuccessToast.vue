<template>
    <!-- Succesberich tonen als er een successToastMessage is -->
    <div v-if="successToastMessage" class="fixed bottom-5 right-5 bg-green-500 text-white px-6 py-5 rounded-lg shadow-lg">
        {{ successToastMessage }}
    </div>
</template>

<script setup>
    // Props definiëren zodat de componen een successToastMessage kan ontvangen van de bovenliggende component
    const props = defineProps({
        successToastMessage: {
            type: String,
            required: true
        }
    })
</script>