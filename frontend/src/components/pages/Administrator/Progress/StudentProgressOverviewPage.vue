<!-- Page: dit bestand bevat de studentenvoortgang pagina voor de administrator
     Het combineert de AdministratorNavbar en de StudentProgressList organism
-->

<template>
    <!-- AdministratorNavbar -->
    <AdministratorNavbar />

    <div class="min-h-screen bg-ghost-white flex flex-col px-4 pt-16">
        <div class="max-w-4xl w-full mx-auto">
            <!-- Titel -->
            <div class="max-w-4xl w-full mx-auto">
                <h1 class="text-3xl font-semibold text-ocean-twilight mb-12">Studentenvoortgang</h1>
            </div>

            <!-- StudentProgressList organism -->
            <StudentProgressList />
        </div>
    </div>
</template>

<script setup>
    // AdministratorNavbar importeren
    import AdministratorNavbar from '../../../../components/organisms/Navbar/AdministratorNavbar.vue'

    // StudentProgressList organism importere
    import StudentProgressList from '../../../../components/organisms/Progress/StudentProgressList.vue'
</script>