<!-- Organism: dit bestand bevat de homenavbar
     Het combineert de een logo met inloggen en registreren links
-->

<template>
    <nav class="bg-soft-periwinkle shadow-sm">
        <!-- Bovenste balk -->
        <div class="flex items-center justify-between gap-4 px-4 md:px-16 py-6">
            <!-- Logo linkerzijde -->
            <RouterLink to="/" class="font-bold text-white text-2xl">Planora</RouterLink>

            <!-- Knoppen rechterzijde (grote schermen) + hamburger (kleine schemren) -->
            <div class="flex items-center gap-4">
                <!-- Inloggen- + registratieknop (grote schermen) -->
                <div class="hidden md:flex items-center gap-4">
                    <RouterLink to="/login" class="flex items-center gap-2 px-4 py-2 rounded-lg text-white font-semibold hover:underline transition">
                        <LogIn class="w-5 h-5" /> Inloggen 
                    </RouterLink>

                    <RouterLink to="/register" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-intense-cherry text-white font-semibold hover:bg-ruby-red hover:underline transition">
                        <UserPlus class="w-5 h-5" /> Registreren 
                    </RouterLink>
                </div>
                
                <!-- Hamburger knop (alleen op kleine schermen) -->
                <button @click="toggleMenu" class="md:hidden text-white">
                    <Menu v-if="!menuOpen" class="w-7 h-7" />
                    <X v-else class="w-7 h-7" />
                </button>
            </div>   
        </div>

        <!-- Mobiel menu -->
        <div v-if="menuOpen" class="md:hidden flex flex-col px-6 pb-6 gap-4">
            <RouterLink to="/login" class="flex items-center gap-2 px-4 py-2 rounded-lg text-white font-semibold hover:underline transition">
                <LogIn class="w-5 h-5" /> Inloggen 
            </RouterLink>

            <RouterLink to="/register" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-intense-cherry text-white font-semibold hover:bg-ruby-red hover:underline transition">
                <UserPlus class="w-5 h-5" /> Registreren 
            </RouterLink>
        </div>
    </nav> 
</template>

<script setup>
    // Ref importeren
    import { ref } from 'vue'

    // Lucide icon importeren
    import { LogIn, UserPlus, Menu, X } from 'lucide-vue-next'

    // Reactieve variabele om bij te houden of het mobiele menu open is
    const menuOpen = ref(false)

    // Functie om het mobiele hamburgermenu te openen of te sluiten
    function toggleMenu() {
        menuOpen.value = !menuOpen.value
    }
</script>