<!-- Atom: dit bestand bevat een herbruikbaar icoon component 
     Er wordt hierbij gebruik gemaakt van Lucide icons
-->

<template>
    <component 
        :is="icon"
        :size="size"
        :color="color"
        :stroke-width="strokeWidth"
    />
</template>

<script setup>
    // Props zijn waardes die van buitenaf aan het component meegegeven worden
        defineProps({
            // Het Lucide icoon component dat weergegeven wordt
            icon: {
                type: Object,
                required: true
            },

            // Grootte van het icoon
            size: {
                type: Number,
                default: 24
            },

            // Kleur van het icoon
            color: {
                type: String,
                default: 'currentColor'
            },

            // Lijndikte van het icoon
            strokeWidth: {
                type: Number,
                default: 2
            }
        })
</script>