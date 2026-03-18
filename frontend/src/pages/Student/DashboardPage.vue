<!-- Page: dit bestand bevat de student dashboard pagina
     Het combineert het DashboardCards organism
     wordt gebruikt als startpagina nadat een student succesvol is ingelogd
-->

<template>
    <!-- Studentnavbar -->
    <StudentNavbar />

    <div class="min-h-screen bg-ghost-white flex flex-col px-4 pt-16">
        <div class="max-w-4xl w-full mx-auto">
            <!-- Welkomstbericht -->
            <h1 class="text-3xl font-semibold text-ocean-twilight mb-12"> Welkom terug!</h1>
            <!-- DashboardCards organism -->
            <DashboardCards />
        </div>
    </div>
</template>

<script setup>
    // StudentNavbar organism importeren
    import StudentNavbar from '../../components/organisms/StudentNavbar.vue'
    // DashboardCards organism importeren
    import DashboardCards from '../../components/organisms/DashboardCards.vue'
</script>