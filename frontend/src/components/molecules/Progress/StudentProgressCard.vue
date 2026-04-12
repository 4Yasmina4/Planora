<!-- Molecule: dit bestand bevat een herbruikbare studentvoortgangskaart
     Het toont de voortgang van een student per vak met voortgangsbalken
-->

<template>
    <!-- Studentvoortgangskaart -->
    <div class="bg-white rounded-xl shadow-sm p-6 flex flex-col gap-3 hover:shadow-xl hover:scale-105 transition-transform duration-200">
        <!-- Naam van de student -->
        <h2 class="text-2xl font-semibold text-ocean-twilight">
            {{ fullName }}
        </h2>

        <!-- Geen vakken -->
        <p v-if="courses.length === 0" class="text-lg text-dim-grey">
            Geen vakken gevonden.
        </p>

        <!-- Vakken met voortgang -->
        <div v-else class="flex flex-col gap-3">
            <div v-for="course in courses" :key="course.course_id">
                <!-- Vaknaam -->
                <p class="text-xl font-medium text-ocean-twilight mb-3">
                    Vaknaam: {{ course.course_name }}
                </p>

                <!-- Totaal aantal taken  -->
                <p class="text-lg font-medium text-shadow-ocean-twilight mb-3">
                    Totaal aantal taken: {{ course.total_tasks }}
                </p>

                <!-- Aantal voltooide taken -->
                <p class="text-lg font-medium text-shadow-ocean-twilight mb-3">
                    Aantal voltooide taken: {{ course.completed_tasks }}
                </p>
                
                <!-- Percentage met voortgangsbalk -->
                <div class="flex items-center gap-4">
                    <ProgressBar :percentage="course.task_completion_percentage" />
                    <span class="text-lg font-semibold text-shadow-ocean-twilight">
                        {{ course.task_completion_percentage }}%
                    </span>
                </div>
            </div>
        </div>   
    </div>
</template>

<script setup>
    // Atoms (ProgressBar) importeren voor voortgangsbalk
    import ProgressBar from '../../atoms/ProgressBar.vue'

    // Props zijn waardes die van buitenaf aan het component meegegeven worden
    defineProps({
        // Volledige naam van de student
        fullName: {
            type: String, 
            default: ''
        },

        // Vakken met voortgang
        courses: {
            type: Array,
            default: () => []
        }
    })
</script>