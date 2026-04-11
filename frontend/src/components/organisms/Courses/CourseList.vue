<!-- Organism: dit bestand bevat de vakkenlijst
     Het combineert de CourseCard molecules
     Wordt gebruikt op de mijn vakken pagina van de student
-->

<template>
    <!-- Loading spinner -->
    <LoadingSpinner v-if="isLoading" message="Mijn vakken worden geladen... een ogenblik geduld." />

    <!-- Melding tonen als er nog geen vakken toegevoegd zijn -->
    <div v-else-if="courses.length === 0" class="text-gray-500 fw-bold text-xl mt-6 text-center">
        Je hebt nog geen vakken toegevoegd. Klik op 'Vak toevoegen' om te beginnen.
    </div>

    <!-- Vakkenlijst -->
    <div v-else class="space-y-6">
        <CourseCard 
            v-for="course in courses"
            :key="course.course_id"
            :courseId="course.course_id"
            :courseName="course.course_name"
            :courseDescription="course.course_description"
            :ects="course.ects"
            :examDate="course.exam_date"
            :studyMaterial="course.study_material"
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
    import CourseCard from '../../molecules/Courses/CourseCard.vue'

    // Aangepaste axios instantie importeren met JWT token interceptor
    // Interceptor zorgt ervoor dat bij elk verzoek de JWT token automatisch wordt toegevoegd
    // Wordt gebruikt voor het vesturen van HTTP verzoeken naar de backend
    // Maakt het makkelijker om een token mee te sturen met elk verzoek in tegenstelling tot fetch()
    import apiClient from '../../../utils/axios.js'

    // Reactieve variabele voor de array met vakken
    const courses = ref([])

    // Reactieve variabele om bij te houden of de vakken nog geladen worden
    const isLoading = ref(true)

    // Functie om alle vakken op te halen
    // Async function zorgt ervoor dat de functie kan wachten op iets (zoals data) zonder de rest van de pagina te blokkeren
    async function fetchCourses() {
        try{
            // Laadstatus op true zetten, voordat de vakken worden opgehaald
            isLoading.value = true;
            // POST verzoek sturen naar de backend
            const response = await apiClient.get('/courses')
            courses.value = response.data
        } catch (error) {
            // Foutmelding tonen als er iets mis gaat
            console.error('Fout bij het ophalen van de vakken')
        } finally {
            // Finally wordt altijd uitgevoerd, ook al er een fout optreedt
            isLoading.value = false
        }
    }

    // onMounted wordt uitgevoerd zodra het component volledig geladen is in de browser
    onMounted(() => {
        // Vakken ophalen zodra de pagina geladen is
        fetchCourses()
    })
</script>