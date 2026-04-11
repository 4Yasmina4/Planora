<!-- Organism: dit bestand bevat het formulier om een vak toe te voegen of te bewerken
     Het combineert de FormField molecules en BaseButton atom tot één geheel
     Wordt gebruikt op de vak toevoegen en bewerken pagina van de student

     Let op: Het verwijderen van een vak gebeurt via DeleteCourseCard.vue, omdat het verwijderen
     van een vak een destructieve actie is die een aparte bevestiging vereist
-->

<template>
    <!-- Laadspinner tonen tijdens het ophalen van de vakgegevens -->
    <LoadingSpinner v-if="isLoading" message="Vak wordt geladen... een ogenblik geduld." />
    <div v-else class="bg-white rounded-xl shadow-md p-12 w-full max-w-4xl">
        <!-- Titel met icoon -->
        <div class="flex items-center justify-center gap-3 mb-6">
            <h2 class="text-2xl font-bold text-soft-periwinkle">{{ formTitle }}</h2>
        </div>

        <!-- Mededeling verplichte velden -->
        <p class="flex items-center gap-1">
            Velden met <Asterisk class="w-5 h-5 text-intense-cherry" /> zijn verplicht.
        </p>

        <form class="space-y-5" @submit.prevent="submitCourse">
            <!-- Naam van het vak -->
            <!-- v-model koppelt het invoerveld aan de reactieve variabele courseName -->
            <FormField label="Naam van het vak" :required="true">
                <FormInputField
                    type="text"
                    placeholder="Voer de naam van het vak in"
                    v-model="courseName"
                />
            </FormField>

            <!-- Beschrijving van het vak  -->
            <!-- v-model koppelt het invoerveld aan de reactieve variabele courseDescription -->
            <div>
                <label class="flex items-center gap-1 font-medium text-soft-periwinkle mb-1">
                    Beschrijving van het vak <Asterisk class="w-4 h-4 text-intense-cherry" />
                </label>
                <textarea
                    v-model="courseDescription"
                    placeholder="Voer hier de beschrijving in van het vak"
                    :required="true"
                    class="w-full px-4 py-2 rounded-lg border border-lavender-grey focus:outline-none focus:border-soft-periwinkle resize-none h-32">
                </textarea>
            </div>

            <!-- EC's  -->
            <!-- v-model koppelt het invoerveld aan de reactieve variabele ects -->
            <FormField label="EC's" :required="true">
                <FormInputField
                    type="Number"
                    placeholder="Voer het aantal EC's in"
                    v-model="ects"
                />
            </FormField>

            <!-- Examendatum  -->
            <!-- v-model koppelt het invoerveld aan de reactieve variabele examDate -->
            <div>
                <FormField label="Examendatum" :required="true">
                    <FormInputField
                        type="date"
                        placeholder="Selecteer de examendatum"
                        v-model="examDate"
                    />
                </FormField>
            </div>

            <!-- Studiemateriaal  -->
            <!-- v-model koppelt het invoerveld aan de reactieve variabele studyMaterial -->
            <div>
                <label class="flex items-center gap-1 font-medium text-soft-periwinkle mb-1">
                    Studiemateriaal <Asterisk class="w-4 h-4 text-intense-cherry" />
                </label>
                <textarea
                    v-model="studyMaterial"
                    placeholder="Voer hier het studiemateriaal van het vak in"
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

            <!-- Submit knop -->
            <BaseButton type="submit" buttonClass="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-lg bg-soft-periwinkle text-white font-semibold hover:bg-ocean-twilight hover:underline transition">
                <!-- Bij het bewerken van een van pencil icoon gerbuiken -->
                <Pencil v-if="props.courseId" class="w-5 h-5" />
                <!-- Bij het aanmaken ban een vak bookplus icoon gebruiken-->
                <BookPlus v-else class="w-5 h-5" /> 
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
    // Ref: om reactieve variabelen te maken
    import { ref, onMounted, computed } from 'vue';

    // useRouter importeren
    import { useRouter } from 'vue-router'

    // Lucide icons importeren
    import { Asterisk, ArrowLeft, BookPlus, Pencil  } from 'lucide-vue-next'

    // Atoms importeren
    import BaseButton from '../../atoms/BaseButton.vue'
    import FormInputField from '../../atoms/FormInputField.vue'

    import LoadingSpinner from '../../atoms/LoadingSpinner.vue'

    // Molecules importeren
    import FormField from '../../molecules/Form/FormField.vue'

    // Toast component importern uit de Base map
    import Toast from '../../../components/Base/Toast/Toast.vue'

    // Aangepaste axios instantie importeren met JWT token interceptor
    // Interceptor zorgt ervoor dat bij elk verzoek de JWT token automatisch wordt toegevoegd
    // Wordt gebruikt voor het vesturen van HTTP verzoeken naar de backend
    import apiClient from '../../../utils/axios.js'

    // Reactieve variabele om bij te houden of de vakken nog geladen worden
    const isLoading = ref(false)

    // UseRouter geeft toegang tot de router om vanuit de code te navigeren naar een andere pagina
    const router = useRouter()

    // Reactieve variabelen voor de invoervelden
    // Beginnen als lege string, omdat de velden leeg zijn bij het laden van de pagina
    const courseName = ref('')
    const courseDescription = ref('')
    const ects = ref(null)
    const examDate = ref('')
    const studyMaterial = ref('')

    // Error toastmelding
    const errorToastMessage = ref('')

    // Props zijn waardes die van buitenaf aan het component meegegeven worden
    const props = defineProps({
          // Optionele courseId = als het aanwezig is, wordt het formulier gebruikt voor het bewerken van een vak
          courseId: {
               type: Number, 
               default: null
          }
     })

    // Computed property die de titel bepaalt op basis van of er een courseId aanwezig is
    // Als courseId aanwezig is = bewerken, anders vak toevoegen
    const formTitle = computed(() => {
        if (!props.courseId)
        {
            return 'Vak toevoegen'
        }

        return 'Vak bewerken'
    })

    // Functie om een vak op te slaan (aanmaken of bewerken)
    // Async function zorgt ervoor dat de functie kan wachten op iets (zoals data) zonder de rest van de pagina te blokkeren
    // Pagina blijft hierbij gewoon werken zonder dat het bevriest
    async function submitCourse() {
        try{   
            // Controleren of het formulier gebruikt wordt voor het aanmaken of bewerken van een vak
            if (props.courseId)
            {
                // PUT verzoek versturen naar de backend voor het bewerken van een vak
                await apiClient.put(`/courses/${props.courseId}`, {
                    course_name: courseName.value,
                    course_description: courseDescription.value,
                    ects: Number(ects.value),
                    exam_date: examDate.value,
                    study_material: studyMaterial.value
                })

                // Succesmelding opslaan in localStorage
                localStorage.setItem('courseEditSuccess', courseName.value)  
            } else {
                // POST verzoek sturen naar de backend voor het aanmaken van een vak 
                await apiClient.post('/courses', {
                    course_name: courseName.value,
                    course_description: courseDescription.value,
                    ects: Number(ects.value),
                    exam_date: examDate.value,
                    study_material: studyMaterial.value
                })

                // Succesmelding opslaan in localStorage
                localStorage.setItem('courseSuccess', courseName.value)
            }

            // Na het succesvol opslaan van een vak student doorsturen naar mijn vakken pagina
            router.push('/student/dashboard/mijn-vakken')
        } catch (error) {
            // Foutmelding tonen als er iets fout is gegaan
            errorToastMessage.value = 'Er is iets misgegaan bij het opslaan van het vak.'
        } 
    }

    // onMounted wordt uitgevoerd zodra het component volledig geladen is in de browser
    // Async gebruiken, zodat await gebruikt kan worden voor het ophalen van de vakgegevens
    onMounted(async () => {
        try{
            // Vak ophalen zodra de pagina geladen is
            if (props.courseId)
            {
                // Laadstatus op true zetten, voordat het vak worden opgehaald
                isLoading.value = true;

                // Vakgegevens ophalen via de backend
                const response = await apiClient.get(`/courses/${props.courseId}`)
                // Invoervelden van het formulier vullen met de opgehaalde vakgegevens
                const course = response.data
                courseName.value = course.course_name
                courseDescription.value = course.course_description
                ects.value = course.ects
                examDate.value = course.exam_date
                studyMaterial.value = course.study_material
            } 
        } catch (error) {
            // Foutmelding tonen als er iets fout is gegaan
            errorToastMessage.value = 'Er is iets misgegaan bij het laden van het vak.'
        } finally {
            // Finally wordt altijd uitgevoerd, ook al er een fout optreedt
            isLoading.value = false
        }
    })
</script>