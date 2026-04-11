<!-- Page: dit bestand bevat de gebruiker verwijderen pagina
     Het combineert de AdministratorNavbar en DeleteUserCard organisms
-->

<template>
    <!-- AdministratorNavbar -->
    <AdministratorNavbar />

    <div class="min-h-screen bg-ghost-white flex flex-col items-center px-4 pt-12">
        <div class="max-w-4xl w-full mx-auto">            
            <!-- DeleteUserCard organism -->
            <DeleteUserCard :userId="userId" class="mb-12" />
        </div>
    </div>
</template>

<script setup>
    // AdministratorNavbar organism importeren
    import AdministratorNavbar from '../../../components/organisms/Navbar/AdministratorNavbar.vue'

    // DeleteCourseCard organism importeren
    import DeleteUserCard from '../../../components/organisms/User/DeleteUserCard.vue'

    // useRoute importeren
    import { useRoute } from 'vue-router'

    // UseRoute geeft toegang tot de huidge route informatie
    // Hiermee kun je bijvoorbeeld params ophalen
    const route = useRoute()

    // userId ophalen uit de URL parameter
    const userId = route.params.id
</script>