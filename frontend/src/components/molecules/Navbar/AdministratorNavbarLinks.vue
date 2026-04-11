<!-- Molecule: dit bestand bevat herbruikbare navigatielinks voor de administratornavbar
     Het combineert meerdere AdministratorNavbarLink atoms in een lijst
-->

<template>
    <!-- Navbar met linkjes -->
    <div class="flex items-center gap-14">
        <NavbarLink
            v-for="link in navbarLinks"
            :key="link.label"
            :label="link.label"
            :icon="link.icon"
            :to="link.to"
        />
    </div>
</template>

<script setup>
    // NavbarLink atom importeren
    import NavbarLink from '../../atoms/NavbarLink.vue'

    // Lucide icons importeren
    import { LayoutDashboard, Users, BarChart3, Settings } from 'lucide-vue-next'

    // Array met administrator navbarlinkjes
    const navbarLinks = [
        {
            // Dashboard
            label: 'Dashboard',
            icon: LayoutDashboard,
            to: '/administrator/dashboard'
        },

        {
            // Gebruikersbeheer
            label: 'Gebruikersbeheer',
            icon: Users,
            to: '/administrator/dashboard/gebruikersbeheer/gebruiker/aanmaken'
        },
        
        {
            // Studentenvoortgang
            label: 'Studentenvoortgang',
            icon: BarChart3,
            to: '/administrator/dashboard/studenten-voortgang'
        },

        {
            // Profielinstellingen
            label: 'Profielinstellingen',
            icon: Settings,
            to: '/administrator/dashboard/profielinstellingen'
        }
    ]
</script>