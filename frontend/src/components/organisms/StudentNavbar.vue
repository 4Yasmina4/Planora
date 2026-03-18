<!-- Organism: dit bestand bevat de studentnavbar
     Het combineert de NavbarLinks molecule met een logo en uitlogknop
-->

<template>
    <nav class="flex items-center justify-start gap-20 px-28 py-6 bg-soft-periwinkle shadow-sm">
        <!-- Logo linkerzijde -->
        <RouterLink to="/student/dashboard" class="font-bold text-white text-2xl">Planora</RouterLink>

        <!-- Navbar linkjes -->
        <NavbarLinks />

        <!-- Uitlogknop rechterzijde -->
        <FormButton type="button" @click="logout" formButton="flex items-center gap-2 px-4 py-2 rounded-lg bg-intense-cherry text-white font-semibold hover:bg-ruby-red hover:underline transition">
            <LogOut class="w-5 h-5" /> Uitloggen
        </FormButton>   
    </nav> 
</template>

<script setup>
    // FormButton atom importeren
    import FormButton from '../atoms/FormButton.vue'

    // Molecules importeren
    import NavbarLinks from '../molecules/NavbarLinks.vue'

    // Lucide icon importeren
    import { LogOut } from 'lucide-vue-next'

    // useRouter importeren
    import { useRouter } from 'vue-router'

    // UseRouter geeft toegang tot de router om vanuit de code te navigeren naar een andere pagina
    const router = useRouter()

    // Functie om uit te loggen
    function logout(){
        // JWT token verwijderen uit localStorage
        // localStorage is een opslagplek in de browser die data bewaart ook na het herladen van de pagina
        localStorage.removeItem('token')

        // Doorsturen naar login pagina
        router.push('/login')
    }
</script>