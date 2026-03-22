<!-- Organism: dit bestand bevat de vak verwijderen kaart
     Het toont de vakgegevens readonly en een bevestigingsmelding
     Wordt gebruikt op de vak verwijderen pagina van de student
-->

<template>
     <!-- Laadspinner tonen tijdens het ophalen van de vakgegevens -->
     <LoadingSpinner v-if="isLoading" message="Vak wordt geladen... een ogenblik geduld." />
     <div v-else class="bg-white rounded-xl shadow-md p-12 w-full max-w-4xl">
          <!-- Titel met icoon -->
          <div class="flex items-center justify-center gap-3 mb-6">
               <TriangleAlert class="w-7 h-7 text-intense-cherry" />
               <h2 class="text-2xl font-bold text-intense-cherry">Vak verwijderen</h2>
          </div>

          <!-- Waarshuwing -->
          <p class="flex items-center gap-1 mb-6 text-lg font-semibold">
               Weet je zeker dat je dit vak wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt.
          </p>

          <form class="space-y-5" @submit.prevent="deleteCourse">
               <!-- Naam van het vak -->
               <div> 
                    <label class="font-medium text-intense-cherry text-lg">Naam van het vak</label>
                    <p class="text-lg text-dim-grey bg-white mt-3 px-4 py-2 rounded-lg border border-lavender-grey">
                         {{ course?.course_name }}
                    </p>
               </div>

               <!-- Beschrijving van het vak  -->
               <div> 
                    <label class="font-medium text-intense-cherry text-lg">Beschrijving van het vak</label>
                    <p class="text-lg text-dim-grey bg-white mt-3 px-4 py-2 rounded-lg border border-lavender-grey">
                         {{ course?.course_description }}
                    </p>
               </div>

               <!-- EC's  -->
               <div> 
                    <label class="font-medium text-intense-cherry text-lg">Aantal EC's</label>
                    <p class="text-lg text-dim-grey bg-white mt-3 px-4 py-2 rounded-lg border border-lavender-grey">
                         {{ course?.ects }}
                    </p>
               </div>

               <!-- Examendatum  -->
               <div> 
                    <label class="font-medium text-intense-cherry text-lg">Examendatum</label>
                    <p class="text-lg text-dim-grey bg-white mt-3 px-4 py-2 rounded-lg border border-lavender-grey">
                         {{ course?.exam_date }}
                    </p>
               </div>

               <!-- Studiemateriaal  -->
               <div> 
                    <label class="font-medium text-intense-cherry text-lg">Studiemateriaal</label>
                    <p class="text-lg text-dim-grey bg-white mt-3 px-4 py-2 rounded-lg border border-lavender-grey">
                         {{ course?.study_material }}
                    </p>
               </div>

               <!-- Toastfoutmelding -->
               <Toast :toastMessage="errorToastMessage" type="error" />

               <!-- Link terug naar mijn vakken-->
               <BaseButton @click="router.push('/student/dashboard/mijn-vakken')" buttonClass="w-full mt-6 flex items-center justify-center gap-2 px-4 py-2 rounded-lg font-semibold border border-lavender-grey bg-ghost-white text-ocean-twilight hover:bg-lavender-grey hover:text-white hover:underline transition">
                    <ArrowLeft class="w-5 h-5" /> Terug naar mijn vakken
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
    // Maakt het makkelijker om een token mee te sturen met elk verzoek in tegenstelling tot fetch()
    import apiClient from '../../../utils/axios.js'

    // Reactieve variabele om bij te houden of de vakken nog geladen worden
    const isLoading = ref(true)

    // UseRouter geeft toegang tot de router om vanuit de code te navigeren naar een andere pagina
    const router = useRouter()

    // Reactieve variabele voor de vakgegevens
    const course = ref(null)

    // Error toastmelding 
    const errorToastMessage = ref('')

    // Props zijn waardes die van buitenaf aan het component meegegeven worden
    const props = defineProps({
          // Id van het vak om de vakgegevens op te halen en te verwijderen
          courseId: {
               type: Number, 
               required: true
          }
     })

     // Functie om één speciefieke vak op te halen
     // Async function zorgt ervoor dat de functie kan wachten op iets (zoals data) zonder de rest van de pagina te blokkeren
     async function fetchCourse() {
          try{
                // Laadstatus op true zetten, voordat het vak worden opgehaald
               isLoading.value = true;
               // POST verzoek sturen naar de backend
               const response = await apiClient.get(`/courses/${props.courseId}`)
               course.value = response.data
          } catch (error) {
               // Foutmelding tonen als er iets mis gaat
               console.error('Fout bij het ophalen van de vakken')
          } finally {
            // Finally wordt altijd uitgevoerd, ook al er een fout optreedt
            isLoading.value = false
        }
    }

    // onMounted wordt uitgevoerd zodra het component volledig geladen is in de browser
    onMounted(() => {
        // Vak ophalen zodra de pagina geladen is
        fetchCourse()
    })

    // Functie om één speciefieke vak te verwijderen
    async function deleteCourse() {
          try{
               // DELETE verzoek sturen naar de backend om het vak te verwijderen
               await apiClient.delete(`/courses/${props.courseId}`)

               // Succesmelding opslaan in localStorage
               localStorage.setItem('courseDeleteSuccess', course.value.course_name)

               // Na het succesvol verwijdere terug naar naar mijn vakken navigeren
               router.push('/student/dashboard/mijn-vakken')
          } catch (error) {
               // Foutmelding tonen als het verwijderen van het vak is mislukt
               errorToastMessage.value = 'Er is iets misgegaan bij het verwijderen van het vak.'
          }
    }
</script>