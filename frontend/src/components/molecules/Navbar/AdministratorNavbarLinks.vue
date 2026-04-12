<!-- Molecule: dit bestand bevat herbruikbare navigatielinks voor de administratornavbar
     Het combineert meerdere AdministratorNavbarLink atoms in een lijst
-->

<template>
    <!-- Navbar met linkjes -->
    <div class="flex flex-col md:flex-row items-start md:items-center gap-4 md:gap-6 lg:gap-14">
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
    import { LayoutDashboard, Users, BarChart3, UserPlus } from 'lucide-vue-next'

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
            to: '/administrator/dashboard/gebruikersbeheer'
        },

        {
            // Gebruiker aanmaken
            label: 'Gebruiker aanmaken',
            icon: UserPlus,
            to: '/administrator/dashboard/gebruikersbeheer/gebruiker/aanmaken'
        },
        
        {
            // Studentenvoortgang
            label: 'Studentenvoortgang',
            icon: BarChart3,
            to: '/administrator/dashboard/studenten-voortgang'
        }
    ]
</script>