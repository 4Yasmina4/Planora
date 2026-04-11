<!-- Page: dit bestand bevat de taak bewerken pagina
     Het combineert de StudentNavbar en TaskForm organisms
-->

<template>
    <!-- Studentnavbar -->
    <StudentNavbar />

    <div class="min-h-screen bg-ghost-white flex flex-col items-center px-4 pt-12">
        <div class="max-w-4xl w-full mx-auto">            
            <!-- TaskForm organism -->
            <TaskForm :taskId="taskId" class="mb-12" />
        </div>
    </div>
</template>

<script setup>
    // StudentNavbar organism importeren
    import StudentNavbar from '../../../components/organisms/Navbar/StudentNavbar.vue'

    // TaskForm organism importeren
    import TaskForm from '../../../components/organisms/Tasks/TaskForm.vue'

    // useRoute importeren
    import { useRoute } from 'vue-router'

    // UseRoute geeft toegang tot de huidge route informatie
    // Hiermee kun je bijvoorbeeld params ophalen
    const route = useRoute()

    // taskId ophalen uit de URL parameter
    const taskId = Number(route.params.id)
</script>