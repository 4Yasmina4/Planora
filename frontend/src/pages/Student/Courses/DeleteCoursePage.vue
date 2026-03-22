<!-- Page: dit bestand bevat de vak verwijderen pagina
     Het combineert de StudentNavbar en DeleteCourseCard organisms
     Wordt gebruikt als de vak verwijderen pagina van de student
-->

<template>
    <!-- Studentnavbar -->
    <StudentNavbar />

    <div class="min-h-screen bg-ghost-white flex flex-col items-center px-4 pt-16">
        <div class="max-w-4xl w-full mx-auto">            
            <!-- DeleteCourseCard organism -->
            <DeleteCourseCard :courseId="courseId" />
        </div>
    </div>
</template>

<script setup>
    // StudentNavbar organism importeren
    import StudentNavbar from '../../../components/organisms/StudentNavbar.vue'

    // DeleteCourseCard organism importeren
    import DeleteCourseCard from '../../../components/organisms/Courses/DeleteCourseCard.vue'

    // useRoute importeren
    import { useRoute } from 'vue-router'

    // UseRoute geeft toegang tot de huidge route informatie
    // Hiermee kun je bijvoorbeeld params ophalen
    const route = useRoute()

    // courseId ophalen uit de URL parameter
    const courseId = route.params.id
</script>