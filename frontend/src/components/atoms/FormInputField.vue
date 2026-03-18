<!-- Atom: dit bestand bevat herbruikbaar invoerveld voor formulieren
     Het kan gebruikt worden in alle formulieren binnen de applicatie
     Ondersteunt v-model, zodat de ingevulde waarde automatisch wordt bijgehouden
-->

<template>
    <!-- Props zijn waardes die van buitenaf aan het component meegegeven worden, zoals type en placeholder-->
    <!-- :type="type" → type van het invoerveld (text, email, password) instellen via een prop -->
    <!-- :placeholder="placeholder" → placeholder tekst instellen via een prop -->
    <!-- :required="required" → maakt het invoerveld verplicht of niet via een prop -->
    <!-- :value="modelValue" → toont huidige waarden van het invoerveld -->
    <!--  @input="$emit('update:modelValue', $event.target.value)" → stuurt de nieuwe waarde terug naar de parent component als de gebruiker iets typt -->
    <input 
        :type="type"
        :placeholder="placeholder"
        :required="required"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        class="w-full border border-lavender-grey rounded-lg px-3 py-3 focus:ring-2 focus:ring-soft-periwinkle focus:outline-none"
    />
</template>

<script setup>
    // Props definiëren voor het invoerveld
    // defineProps defineert welke waardes van buiten het component meegegeven kunnen worden
    defineProps({
        // Type van het invoerveld (text, email, password)
        type: {
            type: String,
            default: 'text'
        }, 

        // Placeholder tekst van het invoerveld
        placeholder: {
            type: String,
            default: ''
        },

        // Controleren of het invoerveld verplicht is
        required: {
            type: Boolean,
            default: false
        },

        // De huidige waarde van het invoerveld wordt meegegeven via v-model
        modelValue: {
            type: String,
            default: ''
        }
    })

    // Emit definiëren, zodat v-model werkt in de parent component
    defineEmits(['update:modelValue'])
</script>