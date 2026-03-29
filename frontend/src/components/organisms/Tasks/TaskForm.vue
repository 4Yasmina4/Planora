<!-- Organism: dit bestand bevat het formulier om een taak toe te voegen of te bewerken
     Het combineert de FormField molecules en BaseButton atom tot één geheel

     Let op: Het verwijderen van een taak gebeurt via DeleteTask.vue, omdat het verwijderen
     van een taak een destructieve actie is die een aparte bevestiging vereist
-->

<template>
    <!-- Laadspinner tonen tijdens het ophalen van de taakgegevens -->
    <LoadingSpinner v-if="isLoading" message="Taak wordt geladen... een ogenblik geduld." />
    <div v-else class="bg-white rounded-xl shadow-md p-12 w-full max-w-4xl">
        <!-- Titel met icoon -->
        <div class="flex items-center justify-center gap-3 mb-6">
            <h2 class="text-2xl font-bold text-soft-periwinkle">{{ formTitle }}</h2>
        </div>

        <!-- Mededeling verplichte velden -->
        <p class="flex items-center gap-1">
            Velden met <Asterisk class="w-5 h-5 text-intense-cherry" /> zijn verplicht.
        </p>

        <form class="space-y-5" @submit.prevent="submitTask">
            <!-- Dropdown met vakken -->
            <div>
                <label class="flex items-center gap-1 font-medium text-soft-periwinkle mb-1">
                    Vak <Asterisk class="w-4 h-4 text-intense-cherry" />
                </label>
                <select v-model="courseId" required class="w-full px-4 py-2 rounded-lg border border-lavender-grey focus:outline-none focus:border-soft-periwinkle">
                    <option value="" disabled>Selecteer een vak</option>
                    <option v-for="course in courses" :key="course.course_id" :value="course.course_id">
                        {{ course.course_name }}
                    </option>
                </select>
            </div>

            <!-- Naam van taak -->
            <!-- v-model koppelt het invoerveld aan de reactieve variabele taskName -->
            <FormField 
                label="Naam van de taak"
                type="text"
                placeholder="Voer de taaknaam in"
                :required="true"
                v-model="taskName"
            />

            <!-- Beschrijving van de taak  -->
            <!-- v-model koppelt het invoerveld aan de reactieve variabele taskDescription -->
            <div>
                <label class="flex items-center gap-1 font-medium text-soft-periwinkle mb-1">
                    Beschrijving van de taak <Asterisk class="w-4 h-4 text-intense-cherry" />
                </label>
                <textarea
                    v-model="taskDescription"
                    placeholder="Voer hier de beschrijving in van de taak"
                    :required="true"
                    class="w-full px-4 py-2 rounded-lg border border-lavender-grey focus:outline-none focus:border-soft-periwinkle resize-none h-32">
                </textarea>
            </div>

            <!-- Studiedatum  -->
            <!-- v-model koppelt het invoerveld aan de reactieve variabele date -->
            <FormField 
                label="Studiedatum"
                type="date"
                placeholder="Selecteer een datum"
                :required="true"
                v-model="date"
            />

            <!-- Duur van de taak  -->
            <!-- v-model koppelt het invoerveld aan de reactieve variabele taskDuration -->
            <div>
                <FormField 
                    label="Taak tijdsduur (in minuten)"
                    type="Number"
                    placeholder="Voer de tijdsduur voor de taak in"
                    :required="true"
                    v-model="taskDuration"
                />
            </div>

            <!-- Toastfoutmelding -->
            <Toast :toastMessage="errorToastMessage" type="error" />

            <!-- Link terug naar mijn planning-->
            <BaseButton @click="router.push('/student/dashboard/mijn-planning')" buttonClass="w-full mt-6 flex items-center justify-center gap-2 px-4 py-2 rounded-lg border border-lavender-grey bg-ghost-white text-ocean-twilight hover:bg-lavender-grey hover:text-white hover:underline transition">
                <ArrowLeft class="w-5 h-5" /> Terug naar mijn planning
            </BaseButton>

            <!-- Submit knop -->
            <BaseButton type="submit" buttonClass="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-lg bg-soft-periwinkle text-white font-semibold hover:bg-ocean-twilight hover:underline transition">
                <!-- Bij het bewerken van een van pencil icoon gerbuiken -->
                <Pencil v-if="props.taskId" class="w-5 h-5" />
                <!-- Bij het aanmaken van een taak listplus icoon gebruiken-->
                <ListPlus v-else class="w-5 h-5" /> 
                {{ formTitle }}
            </BaseButton>
        </form>
    </div>
</template>

<script setup>
    // Beveiliging:
    // - Vue beveiligt automatisch tegen XSS aanvallen door speciale tekens (zoals < en >) om te zetten
    // - JWT tokens worden via de Authorization header verstuurd, waardoor CSRF aanvallen niet mogelijk zijn

    // Ref importeren uit Vue
    import { ref, onMounted, computed } from 'vue';

    // useRouter importeren
    import { useRouter } from 'vue-router'

    // Lucide icons importeren
    import { Asterisk, ArrowLeft, ListPlus, Pencil  } from 'lucide-vue-next'

    // Atoms importeren
    import BaseButton from '../../atoms/BaseButton.vue'
    import LoadingSpinner from '../../atoms/LoadingSpinner.vue'

    // Molecules importeren
    import FormField from '../../molecules/FormField.vue'

    // Toast component importern uit de Base map
    import Toast from '../../../components/Base/Toast/Toast.vue'

    // Aangepaste axios instantie importeren met JWT token interceptor
    // Interceptor zorgt ervoor dat bij elk verzoek de JWT token automatisch wordt toegevoegd
    import apiClient from '../../../utils/axios.js'

    // Reactieve variabele om bij te houden of de vakken nog geladen worden
    const isLoading = ref(false)

    // UseRouter geeft toegang tot de router om vanuit de code te navigeren naar een andere pagina
    const router = useRouter()

    // Reactieve variabelen voor de invoervelden
    const taskName = ref('')
    const taskDescription = ref('')
    const date = ref('')
    const taskDuration = ref('')
    const courseId = ref(null)
    const courses = ref([])

    // Error toastmelding
    const errorToastMessage = ref('')

    // Props zijn waardes die van buitenaf aan het component meegegeven worden
    const props = defineProps({
          // Optionele taskId = als het aanwezig is, wordt het formulier gebruikt voor het bewerken van een vak
          taskId: {
               type: Number, 
               default: null
          }
     })

    // Computed property die de titel bepaalt op basis van of er een taskId aanwezig is
    // Als taskId aanwezig is = bewerken, anders taak toevoegen
    const formTitle = computed(() => {
        if (!props.taskId)
        {
            return 'Taak toevoegen'
        }

        return 'Taak bewerken'
    })

    // Functie om een taak op te slaan (aanmaken of bewerken)
    // Async function zorgt ervoor dat de functie kan wachten op iets (zoals data) zonder de rest van de pagina te blokkeren
    async function submitTask() {
        try{   
            // Controleren of het formulier gebruikt wordt voor het aanmaken of bewerken van een vak
            if (props.taskId)
            {
                // PUT verzoek versturen naar de backend voor het bewerken van een taak
                await apiClient.put(`/tasks/${props.taskId}`, {
                    task_name: taskName.value,
                    task_description: taskDescription.value,
                    date: date.value,
                    task_duration: taskDuration.value,
                })

                // Succesmelding opslaan in localStorage
                localStorage.setItem('taskEditSuccess', taskName.value)  
            } else {
                // POST verzoek sturen naar de backend voor het aanmaken van een taak 
                await apiClient.post('/tasks', {
                    course_id: courseId.value,
                    task_name: taskName.value,
                    task_description: taskDescription.value,
                    date: date.value,
                    task_duration: taskDuration.value,
                })

                // Succesmelding opslaan in localStorage
                localStorage.setItem('taskSuccess', taskName.value)
            }

            // Na het succesvol opslaan van een taak student doorsturen naar mijn planning pagina
            router.push('/student/dashboard/mijn-planning')
        } catch (error) {
            // Foutmelding tonen als er iets fout is gegaan
            errorToastMessage.value = 'Er is iets misgegaan bij het opslaan van de taak.'
        } 
    }

    // onMounted wordt uitgevoerd zodra het component volledig geladen is in de browser
    // Async gebruiken, zodat await gebruikt kan worden voor het ophalen van de vakgegevens
    onMounted(async () => {
        try{
            // Laadstatus op true zetten, voordat de taak worden opgehaald
            isLoading.value = true;
            // Vakken ophalen voor dropdown
            const courseResponse = await apiClient.get('/courses')
            courses.value = courseResponse.data

            // Als taskId aanwezig is, taakgegevens ophalen via de backend
            if (props.taskId)
            {
                const taskResponse = await apiClient.get(`/tasks/${props.taskId}`)
                // Invoervelden van het formulier vullen met de opgehaalde taakgegevens
                const task = taskResponse.data
                taskName.value = task.task_name
                taskDescription.value = task.task_description
                date.value = task.date
                taskDuration.value = task.task_duration
                courseId.value = task.course_id

                // Laadstatus van de taak op false zetten
                isLoading.value = false
            }
        } catch (error) {
            // Foutmelding tonen als er iets fout is gegaan
            errorToastMessage.value = 'Er is iets misgegaan bij het ophalen van de taak.'
        } finally {
            // Finally wordt altijd uitgevoerd, ook al er een fout optreedt
            isLoading.value = false
        }
    })
</script>