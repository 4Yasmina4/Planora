<!-- Page: dit bestand bevat de student dashboard pagina
     Het combineert het DashboardCards organism
     wordt gebruikt als startpagina nadat een student succesvol is ingelogd
-->

<template>
    <div class="min-h-screen bg-ghost-white flex items-center justify-center flex-col px-4">
        <!-- Welkomstbericht -->
        <h1 class="text-3xl font-semibold text-ocean-twilight mb-8"> Welkom terug!</h1>
        <!-- DashboardCards organism -->
        <DashboardCards />
    </div>
</template>

<script setup>
    // DashboardCards organism importeren
    import DashboardCards from '../../components/organisms/DashboardCards.vue'
</script>