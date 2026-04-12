<!-- Dit bestand bevat kaarten voor de home pagina
     Het combineert de DashboardCard molecule
-->

<template>
    <!-- Grid van kaarten (2 naast elkaar) -->
    <div class="w-full max-w-4xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <DashboardCard 
                v-for="card in homeCards"
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
    import { LogIn, UserPlus } from 'lucide-vue-next'

    // Array met functiekaarten
    const homeCards = [
        {
            // Inloggen
            title: 'Inloggen',
            icon: LogIn,
            description: 'Heb je al een account? Log dan hier in.',
            to: '/login'
        },

        {
            // Registreren
            title: 'Registreren',
            icon: UserPlus,
            description: 'Nog geen account? Maak er hier een aan.',
            to: '/register'
        }
    ]
</script>