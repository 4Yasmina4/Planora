<!-- Page: dit bestand bevat de taak verwijderen pagina
     Het combineert de StudentNavbar en DeleteTaskCard organisms
-->

<template>
    <!-- Studentnavbar -->
    <StudentNavbar />

    <div class="min-h-screen bg-ghost-white flex flex-col items-center px-4 pt-16">
        <div class="max-w-4xl w-full mx-auto">            
            <!-- DeleteTaskCard organism -->
            <DeleteTaskCard :taskId="taskId" />
        </div>
    </div>
</template>

<script setup>
    // StudentNavbar organism importeren
    import StudentNavbar from '../../../components/organisms/StudentNavbar.vue'

    // DeleteTaskCard organism importeren
    import DeleteTaskCard from '../../../components/organisms/Tasks/DeleteTaskCard.vue'

    // useRoute importeren
    import { useRoute } from 'vue-router'

    // UseRoute geeft toegang tot de huidge route informatie
    // Hiermee kun je bijvoorbeeld params ophalen
    const route = useRoute()

    // taskId ophalen uit de URL parameter
    const taskId = route.params.id
</script>