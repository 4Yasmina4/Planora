<!-- Page: dit bestand bevat de administrator dashboard pagina
     Het combineert het AdministratorDashboardCards organism
-->

<template>
    <!-- AdministratorNavbar -->
    <!-- <StudentNavbar /> -->

    <div class="min-h-screen bg-ghost-white flex flex-col px-4 pt-16">
        <div class="max-w-4xl w-full mx-auto">
            <!-- Welkomstbericht -->
            <h1 class="text-3xl font-semibold text-ocean-twilight mb-12"> Welkom terug, {{ fullName }}!</h1>
            <!-- AdministratorDashboardCards organism -->
            <AdministratorDashboardCards />
        </div>
    </div>
</template>

<script setup>
    // // Organisms importeren
    // import AdministratorNavbar from '../../../components/organisms/StudentNavbar.vue'
    
    import AdministratorDashboardCards from '../../../components/organisms/Dashboard/AdministratorDashboardCards.vue'

    // Computed importeren uit Vue om reactieve berekeningen te maken
    import { computed } from 'vue'

    // JWT token (JSON Web Token) ophalen uit de localStorage
    const jwtToken = localStorage.getItem('token')

    // Gebruikersrol uitlezen uit het JWT token
    // Een JWT bestaat uit 3 delen gescheiden door punten: header.payload.signature
    // payload is het middelste deel met de gebruikersgegevens zoals user_id
    // atob decodeert base64 naar leesbare tekst (base64 is een manier om data om te zetten naar tekst)
    // split('.')[1] = pakt het middelste deel (payload) uit het JWT token
    const payload = JSON.parse(atob(jwtToken.split('.')[1]))

    // Volledige naam samenstellen van gebruiker op basis van de payload
    // Tussenvoegsel van naam alleen toevoegen als het aanwezig is
    const fullName = computed(() => {
        // Controleren of er een tussenvoegsel aanwezig is
        if (payload.surname_prefix)
        {
            return `${payload.first_name} ${payload.surname_prefix} ${payload.last_name}`
        }

        // Naam zonder tussenvoegsel 
        return `${payload.first_name} ${payload.last_name}`

    })
</script>