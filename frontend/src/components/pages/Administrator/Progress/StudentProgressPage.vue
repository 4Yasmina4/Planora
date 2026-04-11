<!-- Page: dit bestand bevat de voortgang pagina van een student voor de administrator
     Het combineert de AdministratorNavbar en de ProgressList organism
-->

<template>
    <!-- AdministratorNavbar -->
    <AdministratorNavbar />

    <div class="min-h-screen bg-ghost-white flex flex-col px-4 pt-16">
        <div class="max-w-4xl w-full mx-auto">
            <!-- Titel -->
            <div class="max-w-4xl w-full mx-auto">
                <h1 class="text-3xl font-semibold text-ocean-twilight mb-12">Voortgang student</h1>
            </div>

            <!-- ProgressList organism -->
            <ProgressList :userId="userId" />
        </div>
    </div>
</template>

<script setup>
    // AdministratorNavbar importeren
    import AdministratorNavbar from '../../../../components/organisms/Navbar/AdministratorNavbar.vue'

    // ProgressList organism importere
    import ProgressList from '../../../../components/organisms/Progress/ProgressList.vue'

    // useRoute importeren
    import { useRoute } from 'vue-router'

    // UseRoute geeft toegang tot de huidige route informatie
    const route = useRoute()

    // userId ophalen ui de URL parameter en omzetten naar een integer
    const userId = Number(route.params.id)
</script>
