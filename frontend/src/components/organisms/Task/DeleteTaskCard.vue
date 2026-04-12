<!-- Organism: dit bestand bevat de taak verwijderen kaart
     Het toont de taakgegevens readonly en een bevestigingsmelding
-->

<template>
     <!-- Laadspinner tonen tijdens het ophalen van de Taakgegevens -->
     <LoadingSpinner v-if="isLoading" message="Taak wordt geladen... een ogenblik geduld." />
     <div v-else class="bg-white rounded-xl shadow-md p-12 w-full max-w-4xl">
          <!-- Titel met icoon -->
          <div class="flex items-center justify-center gap-3 mb-6">
               <TriangleAlert class="w-7 h-7 text-intense-cherry" />
               <h2 class="text-2xl font-bold text-intense-cherry">Taak verwijderen</h2>
          </div>

          <!-- Waarshuwing -->
          <p class="flex items-center gap-1 mb-6 text-lg font-semibold">
               Weet je zeker dat je deze taak wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt.
          </p>

          <form class="space-y-5" @submit.prevent="deleteTask">
               <!-- Naam van de taak -->
               <div> 
                    <label class="font-medium text-intense-cherry text-lg">Naam van de taak</label>
                    <p class="text-lg text-dim-grey bg-white mt-3 px-4 py-2 rounded-lg border border-lavender-grey">
                         {{ task?.task_name }}
                    </p>
               </div>

               <!-- Naam van het vak -->
               <div> 
                    <label class="font-medium text-intense-cherry text-lg">Naam van het vak</label>
                    <p class="text-lg text-dim-grey bg-white mt-3 px-4 py-2 rounded-lg border border-lavender-grey">
                         {{ task?.course_name }}
                    </p>
               </div>

               <!-- Beschrijving van de taak  -->
               <div> 
                    <label class="font-medium text-intense-cherry text-lg">Beschrijving van de taak</label>
                    <p class="text-lg text-dim-grey bg-white mt-3 px-4 py-2 rounded-lg border border-lavender-grey">
                         {{ task?.task_description }}
                    </p>
               </div>

               <!-- Studiedatum  -->
               <div> 
                    <label class="font-medium text-intense-cherry text-lg">Studiedatum</label>
                    <p class="text-lg text-dim-grey bg-white mt-3 px-4 py-2 rounded-lg border border-lavender-grey">
                         {{ task?.date }}
                    </p>
               </div>

               <!-- Tijdsduur van taak  -->
               <div> 
                    <label class="font-medium text-intense-cherry text-lg">Tijdsduur van taak</label>
                    <p class="text-lg text-dim-grey bg-white mt-3 px-4 py-2 rounded-lg border border-lavender-grey">
                         {{ task?.task_duration }}
                    </p>
               </div>

               <!-- Toastfoutmelding -->
               <Toast :toastMessage="errorToastMessage" type="error" />

               <!-- Link terug naar mijn planning-->
               <BaseButton @click="router.push('/student/dashboard/mijn-planning')" buttonClass="w-full mt-6 flex items-center justify-center gap-2 px-4 py-2 rounded-lg font-semibold border border-lavender-grey bg-ghost-white text-ocean-twilight hover:bg-lavender-grey hover:text-white hover:underline transition">
                    <ArrowLeft class="w-5 h-5" /> Terug naar mijn planning
               </BaseButton>

               <!-- Verwijder knop -->
               <BaseButton type="submit" buttonClass="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-lg bg-intense-cherry text-white font-semibold hover:bg-ruby-red hover:underline transition">
                    <Trash2 class="w-5 h-5" /> Ja, verwijderen
               </BaseButton>
          </form>
     </div>
</template>

<script setup>
    // Ref importeren uit Vue
    // Ref: om reactieve variabelen te maken
    import { ref, onMounted } from 'vue';

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
    import apiClient from '../../../utils/axios.js'

    // Helperfunctie importeren om toastmelding na 3 seconden te verwijderen
    import { clearToastMessage } from '../../../utils/toast.js'

    // Reactieve variabele om bij te houden of de taken nog geladen worden
    const isLoading = ref(true)

    // UseRouter geeft toegang tot de router om vanuit de code te navigeren naar een andere pagina
    const router = useRouter()

    // Reactieve variabele voor de taakgegevens
    const task = ref(null)

    // Error toastmelding 
    const errorToastMessage = ref('')

    // Props zijn waardes die van buitenaf aan het component meegegeven worden
    const props = defineProps({
          // Id van de taak om de vakgegevens op te halen en te verwijderen
          taskId: {
               type: Number, 
               required: true
          }
     })

    // Functie om één speciefieke taak op te halen
    // Async function zorgt ervoor dat de functie kan wachten op iets (zoals data) zonder de rest van de pagina te blokkeren
    async function fetchTask() {
        try{
            // Laadstatus op true zetten, voordat de taak wordt opgehaald
            isLoading.value = true;

            // POST verzoek sturen naar de backend om taak op te halen
            const taskResponse = await apiClient.get(`/tasks/${props.taskId}`);
            task.value = taskResponse.data;

            // Vak ophalen op basis van course_id
            const courseResponse = await apiClient.get(`/courses/${task.value.course_id}`);
            task.value.course_name = courseResponse.data.course_name;
        } catch (error) {
            // Foutmelding tonen als er iets mis gaat
            console.error('Fout bij het ophalen van de taken');
            errorToastMessage.value = 'Er is iets misgegaan bij het ophalen van de taak.';
            clearToastMessage(errorToastMessage);
        } finally {
            // Finally wordt altijd uitgevoerd, ook al er een fout optreedt
            isLoading.value = false;
        }
    }

    // onMounted wordt uitgevoerd zodra het component volledig geladen is in de browser
    onMounted(() => {
        // taak ophalen zodra de pagina geladen is
        fetchTask()
    })

    // Functie om één speciefieke taak te verwijderen
    async function deleteTask() {
        try{
            // DELETE verzoek sturen naar de backend om de taak te verwijderen
            await apiClient.delete(`/tasks/${props.taskId}`);

            // Succesmelding opslaan in localStorage
            localStorage.setItem('taskDeleteSuccess', task.value.task_name);

            // Na het succesvol verwijderen terug naar naar mijn planning navigeren
            router.push('/student/dashboard/mijn-planning');
        } catch (error) {
            // Foutmelding tonen als het verwijderen van de taak is mislukt
            errorToastMessage.value = 'Er is iets misgegaan bij het verwijderen van de taak.';
            clearToastMessage(errorToastMessage);
        }
    }
</script>