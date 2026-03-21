<!-- Page: dit bestand bevat de mijn vakken pagina
     Het combineert de StudentNavbar en CourseList organisms
     Wordt gebruikt als de mijn vakken pagina van de student
-->

<template>
    <!-- Studentnavbar -->
    <StudentNavbar />

    <div class="min-h-screen bg-ghost-white flex flex-col px-4 pt-16">
        <div class="max-w-4xl w-full mx-auto">
            <!-- Titel -->
            <h1 class="text-3xl font-semibold text-ocean-twilight mb-12">Mijn vakken</h1>
            <!-- CourseList organism -->
            <CourseList />
        </div>
    </div>
</template>

<script setup>
    // StudentNavbar organism importeren
    import StudentNavbar from '../../components/organisms/StudentNavbar.vue'
    // CourseList organism importeren
    import CourseList from '../../components/organisms/Courses/CourseList.vue'
</script>