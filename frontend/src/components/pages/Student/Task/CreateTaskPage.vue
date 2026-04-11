<!-- Page: dit bestand bevat de taak toevoegen pagina
     Het combineert de StudentNavbar en TaskForm organisms
-->

<template>
    <!-- Studentnavbar -->
    <StudentNavbar />

    <div class="min-h-screen bg-ghost-white flex flex-col items-center px-4 pt-12">
        <div class="max-w-4xl w-full mx-auto">            
            <!-- TaskForm organism -->
            <TaskForm class="mb-12" />
        </div>
    </div>
</template>

<script setup>
    // Organisms importeren
    import StudentNavbar from '../../../../components/organisms/Navbar/StudentNavbar.vue'
    import TaskForm from '../../../../components/organisms/Task/TaskForm.vue'
</script>