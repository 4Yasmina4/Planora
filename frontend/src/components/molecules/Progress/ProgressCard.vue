<!-- Molecule: dit bestand bevat een herbruikbare voortgangskaart
     Het toont de voortgang van een student met een voortgangsbalk
-->

<template>
    <!-- Vakkaart -->
    <div class="bg-white rounded-xl shadow-sm p-6 flex flex-col gap-3 hover:shadow-xl hover:scale-105 transition-transform duration-200">
        <!-- Naam van het vak -->
        <h1 class="text-xl font-semibold text-ocean-twilight">
            {{ courseName }}
        </h1>

        <!-- Totaal aantal taken -->
        <p class="text-lg"><span class="font-medium text-ocean-twilight">Totaal aantal taken:</span>
            {{ totalTasks }}
        </p>

        <!-- Aantal voltooide taken -->
        <p class="text-lg"><span class="font-medium text-ocean-twilight">Aantal voltooide taken:</span>
            {{ completedTasks }}
        </p>

        <!-- Percentage voor de voortgangsbalk -->
        <ProgressBar :percentage="taskCompletionPercentage" />
    </div>
</template>

<script setup>
    // Atoms (ProgressBar) importeren voor voortgangsbalk
    import ProgressBar from '../../atoms/ProgressBar.vue'

    // Props zijn waardes die van buitenaf aan het component meegegeven worden
    defineProps({
        // Naam van het vak
        courseName: {
            type: String, 
            default: ''
        },

        // Totaal aantal taken
        totalTasks: {
            type: Number,
            default: 0
        },

        // Aantal voltooide taken
        completedTasks: {
            type: Number,
            default: 0
        },

        // Percentage voor de voortgangsbalk
        taskCompletionPercentage: {
            type: Number,
            default: 0
        }
    })
</script>