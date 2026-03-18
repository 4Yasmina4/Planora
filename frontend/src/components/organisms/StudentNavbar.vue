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
        <FormButton type="button" formButton="flex items-center gap-2 px-4 py-2 rounded-lg bg-intense-cherry text-white font-semibold hover:bg-ruby-red hover:underline transition">
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

    

</script>