<!-- Atom: dit bestand bevat een herbruikbare aciteknop met icoon en een router-link
     Het kan gebruikt worden in de gehele applicatie
-->

<template>
    <router-link :to="to" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-base font-medium hover:text-white hover:underline">
    
        <component :is="iconComponent" class="w-4 h-4" /> {{ label }}
    </router-link>
</template>

<script setup>
    // Lucide icons importeren
    import { Eye, Pencil, Trash2, Plus } from 'lucide-vue-next'
    
    const icons = {
        eye: Eye,
        pencil: Pencil,
        trash: Trash2,
        plus: Plus
    }

    // Props zijn waardes die van buitenaf aan het component meegegeven worden
    const props = defineProps({
        // Route waar de knop naartoe navigeert
        to: {
            type: String,
            required: true
        },

        // Tekst die op de knop wordt getoond
        label: {
            type: String,
            required: true
        },

        // Naam van het Lucide-icoon dat wordt weergegeven
        icon: {
            type: String,
            required: true
        }
    })

    // Het juiste icoon component ophalen
    const iconComponent = icons[props.icon]
</script>