<!-- Molecule: dit bestand bevat een herbruikbare vakkaart
     Het toont de vakgegevens van een student met bewerk en verwijder opties
     Het kan gebruikt worden in de vakkenlijst van de student
-->

<template>
    <!-- Vakkaart -->
    <div class="bg-white rounded-xl shadow-sm p-6 flex flex-col gap-3 hover:shadow-xl hover:scale-105 transition-transform duration-200">
        <!-- Naam van het vak -->
        <h1 class="text-xl font-semibold text-ocean-twilight">
            {{ courseName }}
        </h1>

        <!-- Beschrijving -->
        <p class="text-lg"><span class="font-medium text-ocean-twilight">Beschrijving van het vak:</span>
            {{ courseDescription }}
        </p>

        <!-- Aantal EC's -->
        <p class="text-lg"><span class="font-medium text-ocean-twilight">Aantal EC's:</span>
            {{ ects }}
        </p>

        <!-- Examendatum -->
        <p class="text-lg"><span class="font-medium text-ocean-twilight">Examendatum:</span>
            {{ examDate }}
        </p>

        <!-- Studiemateriaal -->
        <p class="text-lg"><span class="font-medium text-ocean-twilight">Studiemateriaal:</span>
            {{ studyMaterial }}
        </p>

        <!-- Knoppen -->
        <div class="flex gap-3 mt-4">
            <!-- Bewerk knop -->
            <BaseButton buttonClass="flex items-center gap-2 px-4 py-2 rounded-lg font-semibold bg-soft-periwinkle text-white hover:bg-ocean-twilight hover:underline transition">
                <Pencil class="w-4 h-4" /> Bewerken
            </BaseButton>

            <!-- Verwijder knop -->
            <BaseButton buttonClass="flex items-center gap-2 px-4 py-2 rounded-lg font-semibold bg-intense-cherry text-white hover:bg-ruby-red hover:underline transition">
                <Trash2 class="w-4 h-4" /> Verwijderen
            </BaseButton>
        </div>
    </div>
</template>

<script setup>
    // Lucide iconen importeren
    import { Pencil, Trash2 } from 'lucide-vue-next'

    // Atoms (BaseButton) importeren voor verwijder en bewerkknop
    import BaseButton from '../../atoms/BaseButton.vue'

    // Props zijn waardes die van buitenaf aan het component meegegeven worden
    defineProps({
        // Id van het vak om het te kunnen bewerken en verwijderen
        courseId: {
            type: Number,
            required: true
        },

        // Naam van het vak
        courseName: {
            type: String, 
            default: ''
        },

        // Beschrijving van het vak
        courseDescription: {
            type: String,
            default: ''
        },

        // Aantal ECT
        ects: {
            type: Number,
            default: ''
        },

        // Examendatum
        examDate: {
            type: String,
            default: ''
        },

        // Studiemateriaal
        studyMaterial: {
            type: String,
            default: ''
        },
    })
</script>