<!-- Dit bestand bevat kaarten voor de gebruikersdashboards
     Het combineert de DashboardCard molecules
-->

<template>
    <!-- Grid van kaarten -->
    <div class="w-full max-w-4xl mx-auto space-y-6">
        <!-- Rij 1: 2 kaarten gecentreerd -->
        <div class="grid grid-cols-2 gap-6">
            <!-- Voor elke kaart in topCards een DashboardCard aanmaken -->
            <DashboardCard 
                v-for="card in topCards"
                :key="card.title"
                :title="card.title"
                :icon="card.icon"
                :description="card.description"
                :to="card.to"
            />
        </div>

        <!-- Rij 2: 3 kaarten -->
        <div class="grid grid-cols-3 gap-6">
            <!-- Voor elke kaart in bottomCards een DashboardCard aanmaken -->
            <DashboardCard 
                v-for="card in bottomCards"
                :key="card.title"
                :title="card.title"
                :icon="card.icon"
                :description="card.description"
                :to="card.to"
            />
        </div> 
    </div>
</template>

<script setup>
    // Molecules importeren
    import DashboardCard from '../molecules/DashboardCard.vue'

    // Lucide icons importeren
    import { BookOpen, CalendarPlus, CalendarDays, ChartBar, UserRound } from 'lucide-vue-next'

    // Array met functiekaarten
    const dashboardCards = [
        {
            // Mijn vakken - Student
            title: 'Mijn vakken',
            icon: BookOpen,
            description: 'Beheer je vakken en tentamendata',
            to: '/student/dashboard/mijn-vakken'
        },

        {
            // Planning maken - Student
            title: 'Planning maken',
            icon: CalendarPlus,
            description: 'Maak studietaken aan per vak',
            to: '/student/dashboard/planning-maken'
        },

        {
            // Mijn planning - Student
            title: 'Mijn planning',
            icon: CalendarDays,
            description: 'Bekijk en beheer al je geplande taken.',
            to: '/student/dashboard/mijn-planning'
        },

        {
            // Voortgang - Student
            title: 'Voortgang',
            icon: ChartBar,
            description: 'Bekijk je voortgang per vak.',
            to: '/student/dashboard/voortgang'
        },

        {
            // Profielinstellingen - Student
            title: 'Profielinstellingen',
            icon: UserRound,
            description: 'Bekijk en wijzig je eigen gegevens.',
            to: '/student/dashboard/profielinstellingen'
        },
    ]

    // Eerste twee kaarten voor de bovenste rij (begin bij index 0 en eindig bij index 2)
    const topCards = dashboardCards.slice(0, 2)

    // Laatste drie kaarten voor de onderste rij (begin bij index 2 en eindig bij index 5)
    const bottomCards = dashboardCards.slice(2, 5)

</script>