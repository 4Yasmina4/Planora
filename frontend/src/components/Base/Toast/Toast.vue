<!--
    Dit component toont een toastmelding rechtsboven in beeld.
    De kleur en stijl worden bepaald op basis van het type melding (success, error)
    Het component is herbruikbaar binnen de gehele applicatie
 --> 
<template>
    <!-- Kleur van de toastbericht komt uit de mapping hieronder bij het script -->
    <div v-if="toastMessage" :class="['fixed top-5 right-5 text-white px-6 py-5 rounded-lg shadow-lg',
        toastColors[type]
        ]"
    >
        {{ toastMessage }}
    </div>
</template>

<script setup>
    // Props definiëren voor de tekst van de toastmelding en het type toastmelding dat getoond moet worden
    const props = defineProps({
        toastMessage: {
            type: String,
            required: true
        },
        type: {
            type: String,
            default: 'success'
        }
    })

    // Mapping van de toast-types naar Tailwind classes
    const toastColors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
    }
</script>