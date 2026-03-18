<!-- Atom: dit bestand bevat een navbar link component 
     Het toont een Lucide icoon met een tekst label en navigeert naar een route
-->

<template>
    <RouterLink :to="to" class="flex items-center gap-2 text-lg text-white font-semibold hover:underline transistion"> 
        <BaseIcon :icon="icon" />
        {{ label }}
    </RouterLink>
</template>

<script setup>
    // BaseIcon atom importeren
    import BaseIcon from '../atoms/BaseIcon.vue'

    // Props zijn waardes die van buitenaf aan het component meegegeven worden
        defineProps({
            // Tekst van de link
            label: {
                type: String,
                default: ''
            },

            // Het Lucide icoon
            icon: {
                type: Object, 
                required: true
            },

            // De route link
            to: {
                type: String,
                default: ''
            },
        })
</script>