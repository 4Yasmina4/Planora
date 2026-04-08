<!-- Organism: dit bestand bevat de takenlijst
     Het combineert de TaskCard molecules
-->

<template>
    <!-- Loading spinner -->
    <LoadingSpinner v-if="isLoading" message="Mijn taken worden geladen... een ogenblik geduld." />

    <!-- Geen taken meldinig -->
    <p v-else-if="tasks.length === 0" class="text-lavender-grey text-lg text-center py-12">
        Er zijn nog geen taken aangemaakt. Klik op "Planning maken" om een taak toe te voegen!
    </p>

    <div v-else>
        <!-- Takenlijst: nog te doen -->
        <h2 class="text-3xl font-semibold text-ocean-twilight mb-8">Nog te doen</h2>
        <div class="space-y-6">
            <TaskCard 
                @task-updated="fetchTasks"
                v-for="task in pendingTasks"
                :key="task.task_id"
                :taskId="task.task_id"
                :taskName="task.task_name"
                :courseName="getCourseName(task.course_id)"
                :taskDescription="task.task_description"
                :date="task.date"
                :taskDuration="task.task_duration"
                :isCompleted="task.is_completed"
            />
        </div>

        <!-- Takenlijst: voltooid -->
        <h2 class="text-3xl font-semibold text-ocean-twilight mt-8 mb-8">Voltooid</h2>
        <div class="space-y-6">
            <TaskCard 
                @task-updated="fetchTasks"
                v-for="task in completedTasks" 
                :key="task.task_id"
                :taskId="task.task_id"
                :taskName="task.task_name"
                :courseName="getCourseName(task.course_id)"
                :taskDescription="task.task_description"
                :date="task.date"
                :taskDuration="task.task_duration"
                :isCompleted="task.is_completed"
            />
        </div>
    </div>
</template>

<script setup>
    // Ref importeren uit Vue
    import { ref, onMounted, computed } from 'vue';

    // Atoms importeren
    import LoadingSpinner from '../../atoms/LoadingSpinner.vue'

    // Molecules importeren
    import TaskCard from '../../molecules/Tasks/TaskCard.vue'

    // Aangepaste axios instantie importeren met JWT token interceptor
    // Interceptor zorgt ervoor dat bij elk verzoek de JWT token automatisch wordt toegevoegd
    import apiClient from '../../../utils/axios.js'

    // Reactieve variabele voor de array met taken en vakken
    const tasks = ref([])
    const courses = ref([])

    // Reactieve variabele om bij te houden of de taken nog geladen worden
    const isLoading = ref(true)

    // Taken filteren op niet voltooid
    const pendingTasks = computed(() => {
        return tasks.value.filter(function(task) {
            return task.is_completed === false
        })
    })

    // Taken filteren op voltooid
    const completedTasks = computed(() => {
        return tasks.value.filter(function(task) {
            return task.is_completed === true
        })
    })

    // Vakken ophalen
    async function fetchCourses() {
        const response = await apiClient.get('/courses')
        courses.value = response.data
    }

    // Vaknaam opzoken op basis van course_id
    function getCourseName(courseId) {
        // Vak zoeken in de courses array op basis van de course_id
        const course = courses.value.find(function(c) {
            return c.course_id === courseId
        })
        
        // Als het vak gevonden is, de vaknaam teruggeven, ander onbekend vak
        if (!course)
        {
            return 'Onbekend vak'
        }

        return course.course_name
    }

    // Functie om alle taken op te halen
    async function fetchTasks() {
        try{
            // Laadstatus op true zetten, voordat de taken worden opgehaald
            isLoading.value = true;
            // GET verzoek sturen naar de backend
            const response = await apiClient.get('/tasks')

            // Backend stuurty een array met taken terug
            tasks.value = response.data
            
        } catch (error) {
            // Foutmelding tonen als er iets mis gaat
            console.error('Fout bij het ophalen van de taken')
        } finally {
            // Finally wordt altijd uitgevoerd, ook al er een fout optreedt
            isLoading.value = false
        }
    }

    // onMounted wordt uitgevoerd zodra het component volledig geladen is in de browser
    onMounted(async () => {
        // Vakken en taken ophalen zodra de pagina geladen is
        await fetchCourses()
        await fetchTasks()
    })
</script>