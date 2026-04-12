<!-- Molecule: dit bestand bevat herbruikbare navigatielinks voor de studentnavbar
     Het combineert meerdere NavbarLink atoms in een lijst
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
    import { LayoutDashboard, BookOpen, CalendarPlus, CalendarDays, ChartBar, UserRound } from 'lucide-vue-next'

    // Array met navbarlinkjes
    const navbarLinks = [
        {
            // Dashboard
            label: 'Dashboard',
            icon: LayoutDashboard,
            to: '/student/dashboard'
        },
        
        {
            // Mijn vakken
            label: 'Mijn vakken',
            icon: BookOpen,
            to: '/student/dashboard/mijn-vakken'
        },

        {
            // Planning maken
            label: 'Planning maken',
            icon: CalendarPlus,
            to: '/student/dashboard/planning-maken'
        },

        {
            // Mijn planning
            label: 'Mijn planning',
            icon: CalendarDays,
            to: '/student/dashboard/mijn-planning'
        },

        {
            // Voortgang
            label: 'Voortgang',
            icon: ChartBar,
            to: '/student/dashboard/voortgang'
        },

        {
            // Profielinstellingen
            label: 'Profielinstellingen',
            icon: UserRound,
            to: '/student/dashboard/profielinstellingen'
        }
    ]
</script>