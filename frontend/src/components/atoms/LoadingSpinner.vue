<!-- Atom: dit bestand bevat een herbruikbare laadspinner
     Wordt gebruikt om aan te geven dat data geladen wordt
-->

<template>
    <!-- Spinner animatie met laadtekst -->
    <div class="flex flex-col items-center justify-center py-12 gap-4">
        <div class="w-12 h-12 border-4 border-soft-periwinkle border-t-transparent rounded-full animate-spin"></div>
        <p class="text-lavender-grey font-semibold text-lg">{{ message }}</p>
    </div>
</template>

<script setup>
    // Props zijn waardes die van buitenaf aan het component meegegeven worden
    defineProps({
        // Laadtekst die getoond wordt tijden het laden (van een pagina)
        message: {
            type: String,
            default: 'Aan het laden... een ogenblik geduld'
        }
    })
</script>