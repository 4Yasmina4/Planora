<!-- Organism: dit bestand bevat de vakkenlijst
     Het combineert de CourseCard molecules
     Wordt gebruikt op de mijn vakken pagina van de student
-->

<template>
    <div>
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
    // Refimporteren uit Vue
    // Ref: om reactieve variabelen te maken
    import { ref, onMounted } from 'vue';

    // Molecules importeren
    import CourseCard from '../../molecules/Courses/CourseCard.vue'

    // Aangepaste axios instantie importeren met JWT token interceptor
    // Interceptor zorgt ervoor dat bij elk verzoek de JWT token automatisch wordt toegevoegd
    // Wordt gebruikt voor het vesturen van HTTP verzoeken naar de backend
    // Maakt het makkelijker om een token mee te sturen met elk verzoek in tegenstelling tot fetch()
    import apiClient from '../../../utils/axios.js'

    // Reactieve variabele voor de array met vakken
    const courses = ref([])

    // Functie om alle vakken op te halen
    // Async function zorgt ervoor dat de functie kan wachten op iets (zoals data) zonder de rest van de pagina te blokkeren
    async function fetchCourses() {
        try{
            // POST verzoek sturen naar de backend
            const response = await apiClient.get('/courses')
            courses.value = response.data.data
        } catch (error) {
            // Foutmelding tonen als er iets mis gaat
            console.error('Fout bij het ophalen van de vakken')
        }
    }

    // onMounted wordt uitgevoerd zodra het component volledig geladen is in de browser
    onMounted(() => {
        // Vakken ophalen zodra de pagina geladen is
        fetchCourses()
    })

    

</script>