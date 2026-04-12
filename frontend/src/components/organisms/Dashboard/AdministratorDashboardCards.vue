<!-- Dit bestand bevat kaarten voor de administrator dashboard
     Het combineert de DashboardCard molecule
-->

<template>
    <!-- Grid van kaarten (3 naast elkaar) -->
    <div class="w-full max-w-4xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <DashboardCard 
                v-for="card in dashboardCards"
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
    import DashboardCard from '../../molecules/Dashboard/DashboardCard.vue'

    // Lucide icons importeren
    import { Users, BarChart3, Settings } from 'lucide-vue-next'

    // Array met functiekaarten
    const dashboardCards = [
        {
            // Gebruikersbeheer
            title: 'Gebruikersbeheer',
            icon: Users,
            description: 'Beheer alle bestaande gebruikers',
            to: '/administrator/dashboard/gebruikersbeheer'
        },

        {
            // Studentenvoortgang
            title: 'Studentenvoortgang',
            icon: BarChart3,
            description: 'Bekijk de voortgang per student.',
            to: '/administrator/dashboard/studenten-voortgang'
        },

        {
            // Profielinstellingen
            title: 'Profielinstellingen',
            icon: Settings,
            description: 'Bekijk en wijzig je eigen gegevens.',
            to: '/administrator/dashboard/profielinstellingen'
        },
    ]
</script>