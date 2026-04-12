<!-- Molecule: dit bestand bevat een herbruikbaar formulierveld met een label en invoerveld
     De daadwerkelijke input wordt via <slot> meegegeven
     Het kan gebruikt worden in alle formulieren binnen de applicatie
-->

<template>
    <div>
        <!-- Label en invoerveld samen -->
        <!-- Asterisk wordt getoond als het invoerveld verplicht is -->
        <label class="flex items-center gap-1 font-medium text-soft-periwinkle mb-1"> 
            {{ label }}<Asterisk v-if="required" class="w-4 h-4 text-intense-cherry" />
        </label>

        <!-- Slot: maakt het mogelijk om elk type invoerveld in dit formulier te plaatsen -->
        <slot />
    </div>
</template>

<script setup>
    // Asterisk icoon importeren voor verplichte velden van Lucide Icons
    import { Asterisk } from 'lucide-vue-next'

    // Props zijn waardes die van buitenaf aan het component meegegeven worden
    defineProps({
        // Label tekst boven het invoerveld
        label: {
            type: String, 
            default: ''
        },

        // Controleren of het invoerveld verplicht is
        required: {
            type: Boolean,
            default: false
        },
    })
</script>