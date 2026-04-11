<!-- Page: dit bestand bevat de vak toevoegen pagina
     Het combineert de StudentNavbar en CourseForm organisms
-->

<template>
    <!-- Studentnavbar -->
    <StudentNavbar />

    <div class="min-h-screen bg-ghost-white flex flex-col items-center px-4 pt-12">
        <div class="max-w-4xl w-full mx-auto">            
            <!-- CourseForm organism -->
            <CourseForm class="mb-12" />
        </div>
    </div>
</template>

<script setup>
    // StudentNavbar organism importeren
    import StudentNavbar from '../../../components/organisms/Navbar/StudentNavbar.vue'

    // CourseForm organism importeren
    import CourseForm from '../../../components/organisms/Courses/CourseForm.vue'
</script>