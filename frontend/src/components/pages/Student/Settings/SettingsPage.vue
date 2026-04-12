<!-- Page: dit bestand bevat de profielinstellingen pagina voor de student
     Het combineert de StudentNavbar en DeleteStudentAccountCard organism
-->

<template>
    <!-- Studentnavbar -->
    <StudentNavbar />

    <div class="min-h-screen bg-ghost-white flex flex-col px-4 pt-16">
        <div class="max-w-4xl w-full mx-auto">
            <!-- Titel + -->
            <div class="max-w-4xl w-full mx-auto">
                <h1 class="text-3xl font-semibold text-ocean-twilight mb-12">profielinstellingen</h1>
            </div>

            <!-- DeleteStudentAccountCard organism -->
            <DeleteStudentAccountCard class="mb-12" />
        </div>
    </div>
</template>

<script setup>
    // StudentNavbar organism importeren
    import StudentNavbar from '../../../../components/organisms/Navbar/StudentNavbar.vue'

    // DeleteStudentAccountCard organism importeren
    import DeleteStudentAccountCard from '../../../../components/organisms/Settings/DeleteStudentAccountCard.vue'
</script>