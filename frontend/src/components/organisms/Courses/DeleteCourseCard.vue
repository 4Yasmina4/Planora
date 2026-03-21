<!-- Organism: dit bestand bevat de vak verwijderen kaart
     Het toont de vakgegevens readonly en een bevestigingsmelding
     Wordt gebruikt op de vak verwijderen pagina van de student
-->

<template>
     <div class="bg-white rounded-xl shadow-md p-12 w-full max-w-4xl">
          <!-- Titel met icoon -->
          <div class="flex items-center justify-center gap-3 mb-6">
               <h2 class="text-2xl font-bold text-intense-cherry">Vak verwijderen</h2>
          </div>

          <!-- Waarshuwing -->
          <p class="flex items-center gap-1">
               Weet je zeker dat je dit vak wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt.
          </p>

          <form class="space-y-5" @submit.prevent="deleteCourse">
               <!-- Naam van het vak -->
               <FormField 
                    label="Naam van het vak"
                    type="text"
                    :value="course?.course_name"
                    :disabled="true"
               />

               <!-- Beschrijving van het vak  -->
               <div>
                    <label class="flex items-center gap-1 font-medium text-intense-cherry mb-1">
                         Beschrijving van het vak
                    </label>
                    <textarea
                         :value="course?.course_description"
                         :disabled="true"
                         class="w-full px-4 py-2 rounded-lg border border-lavender-grey focus:outline-none focus:border-soft-periwinkle resize-none h-32">
                    </textarea>
               </div>

               <!-- EC's  -->
               <FormField 
                    label="EC's"
                    type="Number"
                    :value="course?.ects"
                    :disabled="true"
               />

               <!-- Examendatum  -->
               <div>
                    <FormField 
                         label="Examendatum"
                         type="date"
                         :value="course?.exam_date"
                         :disabled="true"
                    />
               </div>

               <!-- Studiemateriaal  -->
               <div>
                    <label class="flex items-center gap-1 font-medium text-intense-cherry mb-1">
                         Studiemateriaal
                    </label>
                    <textarea
                         :value="course?.study_material"
                         :required="true"
                         class="w-full px-4 py-2 rounded-lg border border-lavender-grey focus:outline-none focus:border-soft-periwinkle resize-none h-32">
                    </textarea>
               </div>

               <!-- Toastfoutmelding -->
               <Toast :toastMessage="errorToastMessage" type="error" />

               <!-- Link terug naar mijn vakken-->
               <BaseButton @click="router.push('/student/dashboard/mijn-vakken')" buttonClass="w-full mt-6 flex items-center justify-center gap-2 px-4 py-2 rounded-lg border border-lavender-grey bg-ghost-white text-ocean-twilight hover:bg-lavender-grey hover:text-white hover:underline transition">
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

    // Molecules importeren
    import FormField from '../../molecules/FormField.vue'

    // Toast component importern uit de Base map
    import Toast from '../../../components/Base/Toast/Toast.vue'

    // Aangepaste axios instantie importeren met JWT token interceptor
    // Interceptor zorgt ervoor dat bij elk verzoek de JWT token automatisch wordt toegevoegd
    // Wordt gebruikt voor het vesturen van HTTP verzoeken naar de backend
    // Maakt het makkelijker om een token mee te sturen met elk verzoek in tegenstelling tot fetch()
    import apiClient from '../../../utils/axios.js'

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
               // POST verzoek sturen naar de backend
               const response = await apiClient.get(`/courses/${props.courseId}`)
               course.value = response.data
          } catch (error) {
               // Foutmelding tonen als er iets mis gaat
               console.error('Fout bij het ophalen van de vakken')
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
               // Na het succesvol verwijdere terug naar naar mijn vakken navigeren
               router.push('/student/dashboard/mijn-vakken')
          } catch (error) {
               // Foutmelding tonen als het verwijderen van het vak is mislukt
               errorToastMessage.value = 'Er is iets misgegaan bij het verwijderen van het vak.'
          }
    }
</script>