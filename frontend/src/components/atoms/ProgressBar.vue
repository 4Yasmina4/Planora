<!-- Atom: dit bestand bevat een voortgangsbalk
     Het kan gebruikt worden in de gehele applicatie
-->

<template>
    <!-- Voortgangsbalk -->
    <div class="w-full bg-gray-200 rounded-full h-4">
        <div class="h-4 rounded-full bg-soft-periwinkle" :style="`width: ${percentage}%`"></div>
    </div>
</template>

<script setup>
    // Props zijn waardes die van buitenaf aan het component meegegeven worden
    defineProps({
        percentage: {
            type: Number,
            default: 0
        }
    })
</script>