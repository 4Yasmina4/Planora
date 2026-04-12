<!-- Molecule: dit bestand bevat één gegevensveld voor gebruikersdetails
-->

<template>
    <div>
        <label class="font-medium text-ocean-twilight text-lg">
            {{ label }}
        </label>

        <p class="text-lg text-dim-grey bg-white mt-3 px-4 py-2 rounded-lg border border-lavender-grey">
            {{ value }}
        </p>
    </div>
</template>

<script setup>
    // Props zijn waardes die van buitenaf aan het component meegegeven worden
    defineProps({
        // Label en waarde voor één detailveld
        label: String,
        value: [String, Number]
    })
</script>