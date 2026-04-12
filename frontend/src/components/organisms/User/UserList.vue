<!-- Organism: dit bestand bevat de gebruikerslijst
     Het combineert de UserRole molecule
     Alleen de administrator heeft hier toegang toe
-->

<template>
    <!-- Loading spinner -->
    <LoadingSpinner v-if="isLoading" message="Gebruikers worden geladen... een ogenblik geduld." />

    <!-- Gebruikerslijst -->
    <div v-else class="space-y-6">
        <UserRow 
            v-for="user in users"
            :key="user.user_id"
            :user="user"
        />
    </div>
</template>

<script setup>
    // Ref importeren uit Vue
    // Ref: om reactieve variabelen te maken
    import { ref, onMounted } from 'vue';

    // Atoms importeren
    import LoadingSpinner from '../../atoms/LoadingSpinner.vue'

    // Molecules importeren
    import UserRow from '../../molecules/User/UserRow.vue'

    // Aangepaste axios instantie importeren met JWT token interceptor
    // Interceptor zorgt ervoor dat bij elk verzoek de JWT token automatisch wordt toegevoegd
    // Wordt gebruikt voor het vesturen van HTTP verzoeken naar de backend
    import apiClient from '../../../utils/axios.js'

    // Reactieve variabele voor de array met gebruikers
    const users = ref([])

    // Reactieve variabele om bij te houden of de gebruikers nog geladen worden
    const isLoading = ref(true)

    // Functie om alle gebruikers op te halen
    // Async function zorgt ervoor dat de functie kan wachten op iets (zoals data) zonder de rest van de pagina te blokkeren
    async function fetchUsers() {
        try{
            // Laadstatus op true zetten, voordat de gebruikers worden opgehaald
            isLoading.value = true;
            // POST verzoek sturen naar de backend
            const response = await apiClient.get('/users')
            users.value = response.data
        } catch (error) {
            // Foutmelding tonen als er iets mis gaat
            console.error('Fout bij het ophalen van gebruikers')
        } finally {
            // Finally wordt altijd uitgevoerd, ook al er een fout optreedt
            isLoading.value = false
        }
    }

    // onMounted wordt uitgevoerd zodra het component volledig geladen is in de browser
    onMounted(() => {
        // Gebruikers ophalen zodra de pagina geladen is
        fetchUsers()
    })
</script>