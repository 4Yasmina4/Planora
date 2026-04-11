<!-- Organism: dit bestand bevat de gebruikersgegevens kaart
     Het toont de gebruikersgegevens readonly
-->

<template>
    <!-- Laadspinner tonen tijdens het ophalen van de gebruikersgegevens -->
    <LoadingSpinner v-if="isLoading" message="Gebruiker wordt geladen... een ogenblik geduld." />
    <div v-else class="bg-white rounded-xl shadow-md p-12 w-full max-w-4xl">
        <!-- Titel met icoon -->
        <div class="flex items-center justify-center gap-3 mb-6">
            <User class="w-7 h-7 text-ocean-twilight" />
            <h2 class="text-2xl font-bold text-ocean-twilight">Gebruikersdetails</h2>
        </div>

        <!-- Foutmelding -->
        <Toast :toastMessage="errorToastMessage" type="error" />

        <!-- Gegevens -->
        <div class="space-y-5">
            <!-- ID -->
            <UserDetailField label="ID" :value="user.user_id" />
            <!-- Voornaam -->
            <UserDetailField label="Voornaam" :value="user.first_name" />
            <!-- Tussenvoegsel -->
            <UserDetailField label="Tussenvoegsel" :value="user.surname_prefix || '-'" />
            <!-- Achternaam -->
            <UserDetailField label="Achternaam" :value="user.last_name" />
            <!-- Email -->
            <UserDetailField label="Email" :value="user.email" />
            <!-- Gebruikersrol -->
            <UserDetailField label="Rol" :value="user.role" />
        </div>

        <!-- Link terug naar gebruikersbeheer-->
        <BaseButton @click="router.push('/administrator/dashboard/gebruikersbeheer')" buttonClass="w-full mt-6 flex items-center justify-center gap-2 px-4 py-2 rounded-lg font-semibold border border-lavender-grey bg-ghost-white text-ocean-twilight hover:bg-lavender-grey hover:text-white hover:underline transition">
            <ArrowLeft class="w-5 h-5" /> Terug naar gebruikersbeheer
        </BaseButton>
    </div>
</template>

<script setup>
     // Ref importeren uit Vue
     // Ref: om reactieve variabelen te maken
     import { ref, onMounted } from 'vue';

     // useRouter importeren
    import { useRouter } from 'vue-router'

    // Lucide icons importeren
    import { ArrowLeft, User } from 'lucide-vue-next'

    // Atoms importeren
    import BaseButton from '../../atoms/BaseButton.vue'
    import LoadingSpinner from '../../atoms/LoadingSpinner.vue'

    // Molecule importeren
    import UserDetailField from '../../molecules/User/UserDetailField.vue'

    // Toast component importern uit de Base map
    import Toast from '../../../components/Base/Toast/Toast.vue'

    // Aangepaste axios instantie importeren met JWT token interceptor
    // Interceptor zorgt ervoor dat bij elk verzoek de JWT token automatisch wordt toegevoegd
    // Wordt gebruikt voor het vesturen van HTTP verzoeken naar de backend
    // Maakt het makkelijker om een token mee te sturen met elk verzoek in tegenstelling tot fetch()
    import apiClient from '../../../utils/axios.js'

    // Reactieve variabele om bij te houden of de vakken nog geladen worden
    const isLoading = ref(true)

    // UseRouter geeft toegang tot de router om vanuit de code te navigeren naar een andere pagina
    const router = useRouter()

    // Reactieve variabele voor de vakgegevens
    const user = ref(null)

    // Error toastmelding 
    const errorToastMessage = ref('')

    // Props zijn waardes die van buitenaf aan het component meegegeven worden
    const props = defineProps({
          // Id van de gebruiker om de gebruikersgegevens op te halen
          userId: {
               type: Number, 
               required: true
          }
     })

     // Functie om één speciefieke gebruiker op te halen
     // Async function zorgt ervoor dat de functie kan wachten op iets (zoals data) zonder de rest van de pagina te blokkeren
     async function fetchUser() {
          try{
               // Laadstatus op true zetten, voordat de gebruiker wordt opgehaald
               isLoading.value = true;
               // POST verzoek sturen naar de backend
               const response = await apiClient.get(`/users/${props.userId}`)
               user.value = response.data
          } catch (error) {
               // Foutmelding tonen als er iets mis gaat
               console.error('Fout bij het ophalen van de gebruiker')
          } finally {
            // Finally wordt altijd uitgevoerd, ook al er een fout optreedt
            isLoading.value = false
          }
    }

    // onMounted wordt uitgevoerd zodra het component volledig geladen is in de browser
    onMounted(() => {
        // Gebruiker ophalen zodra de pagina geladen is
        fetchUser()
    })
</script>