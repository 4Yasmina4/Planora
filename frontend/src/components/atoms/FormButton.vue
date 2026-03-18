<!-- Atom: dit bestand bevat een herbruikbare knop voor formulieren
     Het kan gebruikt worden in alle formulieren binnen de applicatie
-->

<template>
    <!-- :type="type" → type van de knop (submit, button) instellen via een prop -->
    <!-- <slot /> → de inhoud van de knop wordt van buitenaf meegegeven (tekst of icoon) -->
    <button :type="type" :class="formButton">
        <slot />
    </button>
</template>

<script setup>
    // Props zijn waardes die van buitenaf aan het component meegegeven worden
    defineProps({
        // Type van de knop (submit, button)
        type: {
            type: String,
            default: 'button'
        },

        // CSS klassen voor de knop stijl
        formButton: {
            type: String,
            default: ''
        }
    })
</script>