<!-- Organism: dit bestand bevat het formulier om een vak toe te voegen
     Het combineert de FormField molecules en BaseButton atom tot één geheel
     Wordt gebruikt op de vak toevoegen pagina van de student
-->

<template>
    <div class="bg-white rounded-xl shadow-md p-12 w-full max-w-4xl">
        <!-- Titel met icoon -->
        <div class="flex items-center justify-center gap-3 mb-6">
            <h2 class="text-2xl font-bold text-soft-periwinkle">Vak toevoegen</h2>
        </div>

        <!-- Mededeling verplichte velden -->
        <p class="flex items-center gap-1">
            Velden met <Asterisk class="w-5 h-5 text-intense-cherry" /> zijn verplicht.
        </p>

        <form class="space-y-5" @submit.prevent="createCourse">
            <!-- Naam van het vak -->
            <!-- v-model koppelt het invoerveld aan de reactieve variabele courseName -->
            <FormField 
                label="Naam van het vak"
                type="text"
                placeholder="Voer het vaknaam in"
                :required="true"
                v-model="courseName"
            />

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
            <FormField 
                label="EC's"
                type="Number"
                placeholder="Voer het aantal EC's in"
                :required="true"
                v-model="ects"
            />

            <!-- Examendatum  -->
            <!-- v-model koppelt het invoerveld aan de reactieve variabele examDate -->
            <div>
                <FormField 
                    label="Examendatum"
                    type="date"
                    placeholder="Voer uw e-mailadres in"
                    :required="true"
                    v-model="examDate"
                />
            </div>

            <!-- Studiemateriaal  -->
            <!-- v-model koppelt het invoerveld aan de reactieve variabele studyMaterial -->
            <div>
                <label class="flex items-center gap-1 font-medium text-soft-periwinkle mb-1">
                    Studiemateriaal <Asterisk class="w-4 h-4 text-intense-cherry" />
                </label>
                <textarea
                    v-model="studyMaterial"
                    placeholder="Voer hier de studiemateriaal in van het vak"
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

            <!-- Registratie knop -->
            <BaseButton type="submit" buttonClass="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-lg bg-soft-periwinkle text-white font-semibold hover:bg-ocean-twilight hover:underline transition">
                <BookPlus class="w-5 h-5" /> Vak toevoegen
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
    import { ref } from 'vue';

    // useRouter importeren
    import { useRouter } from 'vue-router'

    // Lucide icons importeren
    import { Asterisk, ArrowLeft, BookPlus  } from 'lucide-vue-next'

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

    // Reactieve variabelen voor de invoervelden
    // Beginnen als lege string, omdat de velden leeg zijn bij het laden van de pagina
    const courseName = ref('')
    const courseDescription = ref('')
    const ects = ref('')
    const examDate = ref('')
    const studyMaterial = ref('')

    // Error toastmelding
    const errorToastMessage = ref('')

    // Functie om een een nieuw vak aan te maken
    // Async function zorgt ervoor dat de functie kan wachten op iets (zoals data) zonder de rest van de pagina te blokkeren
    // Pagina blijft hierbij gewoon werken zonder dat het bevriest
    async function createCourse() {
        try{    
            // POST verzoek sturen naar de backend met de invoervelden 
            const response = await apiClient.post('/courses', {
                course_name: courseName.value,
                course_description: courseDescription.value,
                ects: ects.value,
                exam_date: examDate.value,
                study_material: studyMaterial.value,
            })

            // Succesmelding opslaan in localStorage
            localStorage.setItem('courseSuccess', courseName.value)

            // Nadat een vak succesvol is toegevoegd student doorsturen naar mijn vakken pagina
            router.push('/student/dashboard/mijn-vakken')
        } catch (error) {
            // Foutmelding tonen als er iets is fout gegaan bij het opslaan van het vak
            errorToastMessage.value = 'Er is iets misgegaan bij het toevoegen van het vak.'
        }
    }
</script>