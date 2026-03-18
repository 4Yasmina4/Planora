<!-- Molecule: dit bestand bevat een herbruikbaar formulierveld met een label en invoerveld
     Het combineert de Label en FormInputField atoms tot één geheel
     Het kan gebruikt worden in alle formulieren binnen de applicatie
-->

<template>
    <div>
        <!-- Label en invoerveld samen -->
        <label class="block font-medium text-soft-periwinkle mb-1"> {{ label }}</label>

        <!-- FormInputField atom -->
        <FormInputField 
            :type="type"
            :placeholder="placeholder"
            :required="required"
            :modelValue="modelValue"
            @update:modelValue="$emit('update:modelValue', $event)"
        />
    </div>
</template>

<script setup>
    // FormInputField atom importeren
    import FormInputField from '../atoms/FormInputField.vue'

    // Props zijn waardes die van buitenaf aan het component meegegeven worden
    defineProps({
        // Label tekst boven het invoerveld
        label: {
            type: String, 
            default: ''
        },

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