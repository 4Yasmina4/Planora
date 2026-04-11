<!-- Page: dit bestand bevat de gebruikersgegevens pagina
     Het combineert de AdministratorNavbar en UserDetailsCard organisms
-->

<template>
    <!-- Administratornavbar -->
    <AdministratorNavbar />

    <div class="min-h-screen bg-ghost-white flex flex-col items-center px-4 pt-12">
        <div class="max-w-4xl w-full mx-auto">            
            <!-- UserDetailsCard organism -->
            <UserDetailsCard :userId="userId" class="mb-12" />
        </div>
    </div>
</template>

<script setup>
    // AdministratorNavbar organism importeren
    import AdministratorNavbar from '../../../components/organisms/Navbar/AdministratorNavbar.vue'

    // UserDetailsCard organism importeren
    import UserDetailsCard from '../../../components/organisms/User/UserDetailsCard.vue'

    // useRoute importeren
    import { useRoute } from 'vue-router'

    // UseRoute geeft toegang tot de huidge route informatie
    // Hiermee kun je bijvoorbeeld params ophalen
    const route = useRoute()

    // userId ophalen uit de URL parameter
    const userId = Number(route.params.id)
</script>