<!-- Organism: dit bestand bevat de voortgang van een student
     Het combineert de ProgressCard molecules
-->

<template>
    <!-- Loading spinner -->
    <LoadingSpinner v-if="isLoading" message="Voortgang worden geladen... een ogenblik geduld." />

    <!-- Lege staat -->
    <div v-else-if="progresses.length === 0" class="text-center py-16 bg-white rounded-lg shadow-sm border border-gray-200">
        <p class="text-lg text-dim-grey">
            Er is nog geen voortgang beschikbaar.
        </p>
    </div>

    <!-- Voortgangslijst -->
    <div v-else class="space-y-6">
        <ProgressCard 
            v-for="progress in progresses"
            :key="progress.course_id"
            :courseName="progress.course_name"
            :totalTasks="progress.total_tasks"
            :completedTasks="progress.completed_tasks"
            :taskCompletionPercentage="progress.task_completion_percentage"
        />
    </div>
</template>

<script setup>
    // Ref importeren uit Vue
    // Ref: om reactieve variabelen te maken
    import { ref, onMounted } from 'vue';

    // Atoms importeren
    import LoadingSpinner from '../../atoms/LoadingSpinner.vue'

    // Molecules importeren
    import ProgressCard from '../../molecules/Progress/ProgressCard.vue'

    // Aangepaste axios instantie importeren met JWT token interceptor
    // Interceptor zorgt ervoor dat bij elk verzoek de JWT token automatisch wordt toegevoegd
    // Maakt het makkelijker om een token mee te sturen met elk verzoek in tegenstelling tot fetch()
    import apiClient from '../../../utils/axios.js'

    // Reactieve variabele voor de array met voortgangen
    const progresses = ref([])

    // Reactieve variabele om bij te houden of de voortgangen nog geladen worden
    const isLoading = ref(true)

    // Functie om alle voortgangen op te halen
    // Async function zorgt ervoor dat de functie kan wachten op iets (zoals data) zonder de rest van de pagina te blokkeren
    async function fetchProgresses() {
        try{
            // Laadstatus op true zetten, voordat de voortgangen worden opgehaald
            isLoading.value = true;

            // GET verzoek sturen naar de backend
            const response = await apiClient.get('/progress')
            progresses.value = response.data
        } catch (error) {
            // Foutmelding tonen als er iets mis gaat
            console.error('Fout bij het ophalen van de voortgangen')
        } finally {
            // Finally wordt altijd uitgevoerd, ook al er een fout optreedt
            isLoading.value = false
        }
    }

    // onMounted wordt uitgevoerd zodra het component volledig geladen is in de browser
    onMounted(() => {
        // Voortgangen ophalen zodra de pagina geladen is
        fetchProgresses()
    })
</script>