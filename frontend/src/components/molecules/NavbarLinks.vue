<!-- Molecule: dit bestand bevat herbruikbare navigatielinks voor de navbar
     Het combineert meerdere NavbarLink atoms in een lijst
-->

<template>
    <!-- Navbar met linkjes -->
    <div class="flex items-center gap-10">
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
    import NavbarLink from '../atoms/NavbarLink.vue'

    // Lucide icons importeren
    import { BookOpen, CalendarPlus, CalendarDays, ChartBar, UserRound } from 'lucide-vue-next'

    // Array met navbarlinkjes
    const navbarLinks = [
        {
            // Mijn vakken - Student
            label: 'Mijn vakken',
            icon: BookOpen,
            to: '/student/dashboard/mijn-vakken'
        },

        {
            // Planning maken - Student
            label: 'Planning maken',
            icon: CalendarPlus,
            to: '/student/dashboard/planning-maken'
        },

        {
            // Mijn planning - Student
            label: 'Mijn planning',
            icon: CalendarDays,
            to: '/student/dashboard/mijn-planning'
        },

        {
            // Voortgang - Student
            label: 'Voortgang',
            icon: ChartBar,
            to: '/student/dashboard/voortgang'
        },

        {
            // Profielinstellingen - Student
            label: 'Profielinstellingen',
            icon: UserRound,
            to: '/student/dashboard/profielinstellingen'
        },
    ]
</script>