<!-- Organism: dit bestand bevat de administratornavbar
     Het combineert de NavbarLinks molecule met een logo en uitlogknop
-->

<template>
    <nav class="bg-ocean-twilight shadow-sm">
        <!-- Bovenste balk -->
        <div class="flex items-center justify-between gap-4 px-4 md:px-16 py-6">
            <!-- Logo linkerzijde -->
            <RouterLink to="/administrator/dashboard" class="font-bold text-white text-2xl">Planora</RouterLink>

            <!-- AdministratorNavbar linkjes (alleen grote schermen) -->
            <div class="hidden md:flex">
                <AdministratorNavbarLinks />
            </div>

            <!-- Uitlogknop rechterzijde (grote schermen) + hamburger (kleine schemren) -->
            <div class="flex items-center gap-4">
                <BaseButton type="button" @click="logout" buttonClass="hidden md:flex items-center gap-2 px-4 py-2 rounded-lg bg-intense-cherry text-white font-semibold hover:bg-ruby-red hover:underline transition">
                    <LogOut class="w-5 h-5" /> Uitloggen
                </BaseButton>   

                <!-- Hamburger knop (alleen op kleine schermen) -->
                <button @click="toggleMenu" class="md:hidden text-white">
                    <Menu v-if="!menuOpen" class="w-7 h-7" />
                    <X v-else class="w-7 h-7" />
                </button>
            </div>
        </div>

        <!-- Mobiel menu -->
        <div v-if="menuOpen" class="md:hidden flex flex-col px-6 pb-6 gap-4">
            <AdministratorNavbarLinks />

            <!-- Uitlogknop -->
            <BaseButton type="button" @click="logout" buttonClass="flex items-center gap-2 px-4 py-2 rounded-lg bg-intense-cherry text-white font-semibold hover:bg-ruby-red hover:underline transition">
                <LogOut class="w-5 h-5" /> Uitloggen
            </BaseButton>
        </div>
    </nav> 
</template>

<script setup>
    // Ref importeren
    import { ref } from 'vue'

    // BaseButton atom importeren
    import BaseButton from '../../atoms/BaseButton.vue'

    // Molecules importeren
    import AdministratorNavbarLinks from '../../molecules/Navbar/AdministratorNavbarLinks.vue'

    // Lucide icon importeren
    import { LogOut, Menu, X } from 'lucide-vue-next'

    // useRouter importeren
    import { useRouter } from 'vue-router'

    // UseRouter geeft toegang tot de router om vanuit de code te navigeren naar een andere pagina
    const router = useRouter()

    // Reactieve variabele om bij te houden of het mobiele menu open is
    const menuOpen = ref(false)

    // Functie om het mobiele hamburgermenu te openen of te sluiten
    function toggleMenu() {
        menuOpen.value = !menuOpen.value
    }

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