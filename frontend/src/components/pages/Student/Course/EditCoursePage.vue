<!-- Page: dit bestand bevat de vak bewerken pagina
     Het combineert de StudentNavbar en CourseForm organisms
     Wordt gebruikt als de vak bewerken pagina van de student
-->

<template>
    <!-- Studentnavbar -->
    <StudentNavbar />

    <div class="min-h-screen bg-ghost-white flex flex-col items-center px-4 pt-12">
        <div class="max-w-4xl w-full mx-auto">            
            <!-- CourseForm organism -->
            <CourseForm :courseId="courseId" class="mb-12" />
        </div>
    </div>
</template>

<script setup>
    // StudentNavbar organism importeren
    import StudentNavbar from '../../../../components/organisms/Navbar/StudentNavbar.vue'

    // CourseForm organism importeren
    import CourseForm from '../../../../components/organisms/Courses/CourseForm.vue'

    // useRoute importeren
    import { useRoute } from 'vue-router'

    // UseRoute geeft toegang tot de huidge route informatie
    // Hiermee kun je bijvoorbeeld params ophalen
    const route = useRoute()

    // courseId ophalen uit de URL parameter
    const courseId = Number(route.params.id)
</script>