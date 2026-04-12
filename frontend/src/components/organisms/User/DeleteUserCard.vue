<!-- Organism: dit bestand bevat de gebruiker verwijderen kaart
     Het toont de gebruikersgegevens readonly en een bevestigingsmelding
-->

<template>
     <!-- Laadspinner tonen tijdens het ophalen van de gebruikersgegevens -->
     <LoadingSpinner v-if="isLoading" message="Gebruiker wordt geladen... een ogenblik geduld." />
     <div v-else class="bg-white rounded-xl shadow-md p-12 w-full max-w-4xl">
          <!-- Titel met icoon -->
          <div class="flex items-center justify-center gap-3 mb-6">
               <TriangleAlert class="w-7 h-7 text-intense-cherry" />
               <h2 class="text-2xl font-bold text-intense-cherry">Gebruiker verwijderen</h2>
          </div>

          <!-- Waarshuwing -->
          <p class="flex items-center gap-1 mb-6 text-lg font-semibold">
               Weet je zeker dat je deze gebruiker wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt.
          </p>

          <form class="space-y-5" @submit.prevent="deleteUser">
               <!-- Voornaam -->
               <div> 
                    <label class="font-medium text-intense-cherry text-lg">Voornaam</label>
                    <p class="text-lg text-dim-grey bg-white mt-3 px-4 py-2 rounded-lg border border-lavender-grey">
                         {{ user?.first_name }}
                    </p>
               </div>

               <!-- Tussenvoegsel  -->
               <div> 
                    <label class="font-medium text-intense-cherry text-lg">Tussenvoegsel</label>
                    <p class="text-lg text-dim-grey bg-white mt-3 px-4 py-2 rounded-lg border border-lavender-grey">
                         {{ user?.surname_prefix || '-'}}
                    </p>
               </div>

               <!-- Achternaam  -->
               <div> 
                    <label class="font-medium text-intense-cherry text-lg">Achternaam</label>
                    <p class="text-lg text-dim-grey bg-white mt-3 px-4 py-2 rounded-lg border border-lavender-grey">
                         {{ user?.last_name }}
                    </p>
               </div>

               <!-- Email  -->
               <div> 
                    <label class="font-medium text-intense-cherry text-lg">Email</label>
                    <p class="text-lg text-dim-grey bg-white mt-3 px-4 py-2 rounded-lg border border-lavender-grey">
                         {{ user?.email }}
                    </p>
               </div>

               <!-- Gebruikersrol  -->
               <div> 
                    <label class="font-medium text-intense-cherry text-lg">Rol</label>
                    <p class="text-lg text-dim-grey bg-white mt-3 px-4 py-2 rounded-lg border border-lavender-grey">
                         {{ user?.role }}
                    </p>
               </div>

               <!-- Toastfoutmelding -->
               <Toast :toastMessage="errorToastMessage" type="error" />

               <!-- Link terug naar gebruikersbeheer-->
               <BaseButton @click="router.push('/administrator/dashboard/gebruikersbeheer')" buttonClass="w-full mt-6 flex items-center justify-center gap-2 px-4 py-2 rounded-lg font-semibold border border-lavender-grey bg-ghost-white text-ocean-twilight hover:bg-lavender-grey hover:text-white hover:underline transition">
                    <ArrowLeft class="w-5 h-5" /> Terug naar gebruikersbeheer
               </BaseButton>

               <!-- Verwijder knop -->
               <BaseButton type="submit" :disabled="isOwnAccount" buttonClass="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-lg bg-intense-cherry text-white font-semibold hover:bg-ruby-red hover:underline transition disabled:opacity-50 disabled:cursor-not-allowed">
                    <Trash2 class="w-5 h-5" /> Ja, verwijderen
               </BaseButton>
          </form>
     </div>
</template>

<script setup>
     // Ref importeren uit Vue
     // Ref: om reactieve variabelen te maken
     import { ref, onMounted, computed } from 'vue';

     // useRouter importeren
    import { useRouter } from 'vue-router'

    // Lucide icons importeren
    import { ArrowLeft, Trash2, TriangleAlert } from 'lucide-vue-next'

    // Atoms importeren
    import BaseButton from '../../atoms/BaseButton.vue'

    import LoadingSpinner from '../../atoms/LoadingSpinner.vue'

    // Toast component importern uit de Base map
    import Toast from '../../../components/Base/Toast/Toast.vue'

    // Aangepaste axios instantie importeren met JWT token interceptor
    // Interceptor zorgt ervoor dat bij elk verzoek de JWT token automatisch wordt toegevoegd
    // Wordt gebruikt voor het vesturen van HTTP verzoeken naar de backend
    // Maakt het makkelijker om een token mee te sturen met elk verzoek in tegenstelling tot fetch()
    import apiClient from '../../../utils/axios.js'

    // AuthenticationStore importeren
    import { useAuthenticationStore } from '../../../stores/authenticationStore.js'

    // AuthenticationStore initialiseren
    const authenticationStore = useAuthenticationStore()

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
          // Id van de gebruiker om de gebruikersgegevens op te halen en te verwijderen
          userId: {
               type: Number, 
               required: true
          }
     })

     // Controleren of de administrator zijn eigen account probeert te verwijderen
     // Als dit het geval is verwijderknop uitschakelen
     const isOwnAccount = computed(() => {
          if (Number(props.userId) === authenticationStore.userId)
          {
               return true;
          }

          return false;
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

    // Functie om één speciefieke gebruiker te verwijderen
    async function deleteUser() {
          // Controleren of de administrator zijn eigen account probeert te verwijderen
          if (Number(props.userId) === authenticationStore.userId)
          {
               errorToastMessage.value = 'Je kunt je eigen account niet verwijderen.'

               // Toastmelding na 3 seconden verwijderen
               // setTimeout voert de functie uit na een opgegeven tijd in milliseconden
               // 3000 milliseconden = 3 seconden
               setTimeout(() => {
                    errorToastMessage.value = ''
               }, 3000)
                    
               return;
          }

          try{
               // DELETE verzoek sturen naar de backend om de gebruiker te verwijderen
               await apiClient.delete(`/users/${props.userId}`)

               // Succesmelding opslaan in localStorage
               const fullName = `${user.value.first_name} ${user.value.surname_prefix ? user.value.surname_prefix + ' ' : ''}${user.value.last_name}`
               localStorage.setItem('UserDeleteSuccess', fullName)

               // Na het succesvol verwijderen terug naar naar gebruikersbeheer pagina navigeren
               router.push('/administrator/dashboard/gebruikersbeheer')
          } catch (error) {
               // Foutmelding tonen als het verwijderen van de gebruiker is mislukt
               errorToastMessage.value = 'Er is iets misgegaan bij het verwijderen van de gebruiker.'

               setTimeout(() => {
                    errorToastMessage.value = ''
               }, 3000)
          }
    }
</script>