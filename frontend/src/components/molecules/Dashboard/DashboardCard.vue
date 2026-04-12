<!-- Molecule: dit bestand bevat een herbruikbare dashboard kaart
     Het combineert de BaseIcon atom met een titel, beschrijving en routerLink
     Het kan gebruikt worden op dashboarden van gebruikers (student en administrator)
-->

<template>
    <!-- Kaart met link -->
    <RouterLink :to="to"
                class="bg-white rounded-xl shadow-sm p-6 flex flex-col items-center text-center gap-3 hover:shadow-xl hover:scale-105 transition-transform duration-200 cursor-pointer no-underline">
        <!-- Lucide icoon -->
        <BaseIcon :icon="icon" :size="40" color="#494CA2" />

        <!-- Titel -->
        <h2 class="text-xl font-semibold text-ocean-twilight">
            {{ title }}
        </h2>

        <!-- Beschrijving -->
        <p class="text-lg text-lavender-grey">
            {{ description }}
        </p>
    </RouterLink>
</template>

<script setup>
    // BaseIcon atom importeren
    import BaseIcon from '../../atoms/BaseIcon.vue'

    // Props zijn waardes die van buitenaf aan het component meegegeven worden
    defineProps({
        // Titel op de kaart
        title: {
            type: String, 
            default: ''
        },

        // Het Lucide icoon
        icon: {
            type: Object, 
            required: true
        },

        // Korte beschrijving
        description: {
            type: String,
            default: ''
        },

        // De route link
        to: {
            type: String,
            default: ''
        },
    })
</script>