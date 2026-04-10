<!-- Page: dit bestand bevat de voortgang pagina
     Het combineert de StudentNavbar en ProgressList organism
-->

<template>
    <!-- Studentnavbar -->
    <StudentNavbar />

    <div class="min-h-screen bg-ghost-white flex flex-col px-4 pt-16">
        <div class="max-w-4xl w-full mx-auto">
            <!-- Titel + -->
            <div class="max-w-4xl w-full mx-auto">
                <h1 class="text-3xl font-semibold text-ocean-twilight mb-12">Mijn voortgang</h1>
            </div>

            <!-- ProgressList organism -->
            <ProgressList />
        </div>
    </div>
</template>

<script setup>
    // StudentNavbar organism importeren
    import StudentNavbar from '../../../components/organisms/StudentNavbar.vue'

    // ProgressList organism importeren
    import ProgressList from '../../../components/organisms/Progress/ProgressList.vue'
</script>