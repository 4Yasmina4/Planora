<!-- Molecule: dit bestand bevat een herbruikbare vakkaart
     Het toont de vakgegevens van een student met bewerk en verwijder opties
     Het kan gebruikt worden in de vakkenlijst van de student
-->

<template>
    <!-- Vakkaart -->
    <div>
        <!-- Naam van het vak -->
        <h2 class="text-xl font-semibold text-ocean-twilight"><span class="font-medium">Naam van het vak:</span>
            {{ courseName }}
        </h2>

        <!-- Beschrijving -->
        <p class="text-lg text-lavender-grey"><span class="font-medium">Beschrijving van het vak:</span>
            {{ courseDescription }}
        </p>

        <!-- Aantal ECT -->
        <p class="text-lg text-lavender-grey"><span class="font-medium">Aantal ECTS:</span>
            {{ ects }}
        </p>

        <!-- Examendatum -->
        <p class="text-lg text-lavender-grey"><span class="font-medium">Examendatum:</span>
            {{ examDate }}
        </p>

        <!-- Studiemateriaal -->
        <p class="text-lg text-lavender-grey"><span class="font-medium">Studiemateriaal:</span>
            {{ studyMaterial }}
        </p>

        <!-- Knoppen -->
        <div class="flex gap-3 mt-4">
            <!-- Bewerk knop -->
            <BaseButton buttonClass="flex items-center gap-2 px-4 py-2 rounded-lg bg-soft-periwinkle text-white hover:bg-ocean-twilight transition">
                Bewerken
            </BaseButton>

            <!-- Verwijder knop -->
            <BaseButton buttonClass="flex items-center gap-2 px-4 py-2 rounded-lg bg-intense-cherry text-white hover:bg-burgundy transition">
                Verwijderen
            </BaseButton>


        </div>
    </div>
</template>

<script setup>
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