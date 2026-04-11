<!-- Organism: dit bestand bevat de administratornavbar
     Het combineert de NavbarLinks molecule met een logo en uitlogknop
-->

<template>
    <nav class="flex items-center justify-between gap-4 px-16 py-6 bg-ocean-twilight shadow-sm">
        <!-- Logo linkerzijde -->
        <RouterLink to="/administrator/dashboard" class="font-bold text-white text-2xl">Planora</RouterLink>

        <!-- AdministratorNavbar linkjes -->
        <AdministratorNavbarLinks />

        <!-- Uitlogknop rechterzijde -->
        <BaseButton type="button" @click="logout" buttonClass="flex items-center gap-2 px-4 py-2 rounded-lg bg-intense-cherry text-white font-semibold hover:bg-ruby-red hover:underline transition">
            <LogOut class="w-5 h-5" /> Uitloggen
        </BaseButton>   
    </nav> 
</template>

<script setup>
    // FormButton atom importeren
    import BaseButton from '../../atoms/BaseButton.vue'

    // Molecules importeren
    import AdministratorNavbarLinks from '../../molecules/Navbar/AdministratorNavbarLinks.vue'

    // Lucide icon importeren
    import { LogOut } from 'lucide-vue-next'

    // useRouter importeren
    import { useRouter } from 'vue-router'

    // UseRouter geeft toegang tot de router om vanuit de code te navigeren naar een andere pagina
    const router = useRouter()

    // Functie om uit te loggen
    function logout(){
        // Uitlogmelding instellen voor de loginpagina
        localStorage.setItem('logoutSuccess', true)

        // JWT token verwijderen uit localStorage
        // localStorage is een opslagplek in de browser die data bewaart ook na het herladen van de pagina
        localStorage.removeItem('token')

        // Doorsturen naar login pagina
        router.push('/login')
    }
</script>