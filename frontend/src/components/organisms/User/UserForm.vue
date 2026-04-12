<!-- Organism: dit bestand bevat het formulier om een gebruiker toe te voegen of te bewerken
     Het combineert de FormField molecules en BaseButton atom tot één geheel

     Let op: Het verwijderen van een gebruiker gebeurt via DeleteUserCard.vue, omdat het verwijderen
     van een gebruiker een destructieve actie is een aparte bevestiging vereist
-->

<template>
    <!-- Laadspinner tonen tijdens het ophalen van de gebruikers -->
    <LoadingSpinner v-if="isLoading" message="Gebruiker wordt geladen... een ogenblik geduld." />
    <div v-else class="bg-white rounded-xl shadow-md p-12 w-full max-w-4xl">
        <!-- Titel met icoon -->
        <div class="flex items-center justify-center gap-3 mb-6">
            <h2 class="text-2xl font-bold text-soft-periwinkle">{{ formTitle }}</h2>
        </div>

        <!-- Mededeling verplichte velden -->
        <p class="flex items-center gap-1">
            Velden met <Asterisk class="w-5 h-5 text-intense-cherry" /> zijn verplicht.
        </p>

        <form class="space-y-5" @submit.prevent="submitUser">
            <!-- Voornaam -->
            <!-- v-model koppelt het invoerveld aan de reactieve variabele firstName -->
            <FormField label="Voornaam" :required="true">
                <FormInputField
                    v-model="firstName"
                    type="text"
                    placeholder="Voer een voornaam in"
                />
            </FormField>

            <!-- Tussenvoegsel -->
            <FormField label="Tussenvoegsel" :required="false">
                <FormInputField
                    v-model="surnamePrefix"
                    type="text"
                    placeholder="Voer een tussenvoegsel in"
                />
            </FormField>

            <!-- Achternaam -->
            <FormField label="Achternaam" :required="true">
                <FormInputField
                    v-model="lastName"
                    type="text"
                    placeholder="Voer een achternaam in"
                />
            </FormField>

            <!-- Email -->
            <FormField label="Email" :required="true">
                <FormInputField
                    v-model="email"
                    type="text"
                    placeholder="Voer een email in"
                />
            </FormField>

            <!-- Wachtwoord (alleen verplicht bij het aanmaken van een gebruiker) -->
            <FormField label="Wachtwoord" :required="!props.userId">
                <FormInputField
                    v-model="password"
                    type="password"
                    placeholder="Voer een wachtwoord in"
                />
            </FormField>

            <!-- Bevestig wachtwoord (alleen verplicht bij het aanmaken van een gebruiker) -->
            <FormField label="Wachtwoord bevestigen" :required="!props.userId">
                <FormInputField
                    v-model="passwordConfirm"
                    type="password"
                    placeholder="Voer het wachtwoord opnieuw in"
                />
            </FormField>

            <!-- Gebruikersrol -->
            <FormField label="Gebruikersrol" :required="true">
                <select
                    v-model="role"
                    class="w-full border border-lavender-grey rounded-lg px-3 py-3 focus:ring-2 focus:ring-soft-periwinkle focus:outline-none">
                    <option disabled value="">- Selecteer een gebruikersrol -</option>
                    <option value="student">Student</option>
                    <option value="administrator">Administrator</option>
                </select>
            </FormField>

            <!-- Toastfoutmelding -->
            <Toast :toastMessage="errorToastMessage" type="error" />

            <!-- Link terug naar gebruikersbeheer vakken-->
            <BaseButton @click="router.push('/administrator/dashboard/gebruikersbeheer')" buttonClass="w-full mt-6 flex items-center justify-center gap-2 px-4 py-2 rounded-lg border border-lavender-grey bg-ghost-white text-ocean-twilight hover:bg-lavender-grey hover:text-white hover:underline transition">
                <ArrowLeft class="w-5 h-5" /> Terug naar gebruikersbeheer
            </BaseButton>

            <!-- Submit knop -->
            <BaseButton type="submit" buttonClass="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-lg bg-soft-periwinkle text-white font-semibold hover:bg-ocean-twilight hover:underline transition">
                <!-- Bij het bewerken van een gebruiker pencil icoon gebruiken -->
                <Pencil v-if="props.userId" class="w-5 h-5" />
                <!-- Bij het aanmaken van een gebruiker bookplus icoon gebruiken-->
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
    import LoadingSpinner from '../../atoms/LoadingSpinner.vue'
    import FormInputField from '../../atoms/FormInputField.vue'

    // Molecules importeren
    import FormField from '../../molecules/Form/FormField.vue'

    // Toast component importern uit de Base map
    import Toast from '../../../components/Base/Toast/Toast.vue'

    // Aangepaste axios instantie importeren met JWT token interceptor
    // Interceptor zorgt ervoor dat bij elk verzoek de JWT token automatisch wordt toegevoegd
    // Wordt gebruikt voor het vesturen van HTTP verzoeken naar de backend
    import apiClient from '../../../utils/axios.js'

    // Helperfunctie importeren om toastmelding na 3 seconden te verwijderen
    import { clearToastMessage } from '../../../utils/toast.js'

    // Reactieve variabele om bij te houden of de gebruiker nog geladen wordt
    const isLoading = ref(false)

    // UseRouter geeft toegang tot de router om vanuit de code te navigeren naar een andere pagina
    const router = useRouter()

    // Reactieve variabelen voor de invoervelden
    // Beginnen als lege string, omdat de velden leeg zijn bij het laden van de pagina
    const firstName = ref('')
    const surnamePrefix = ref('')
    const lastName = ref('')
    const email = ref('')
    const password = ref('')
    const passwordConfirm = ref('')
    const role = ref('')

    // Error toastmelding
    const errorToastMessage = ref('')

    // Props zijn waardes die van buitenaf aan het component meegegeven worden
    const props = defineProps({
          // Optionele userId = als het aanwezig is, wordt het formulier gebruikt voor het bewerken van een gebruiker
          userId: {
               type: Number, 
               default: null
          }
     })

    // Computed property die de titel bepaalt op basis van of er een userId aanwezig is
    // Als userId aanwezig is = bewerken, anders gebruiker toevoegen
    const formTitle = computed(() => {
        if (!props.userId)
        {
            return 'Gebruiker aanmaken'
        }

        return 'Gebruiker bewerken'
    })

    // Functie om een gebruiker op te slaan (aanmaken of bewerken)
    // Async function zorgt ervoor dat de functie kan wachten op iets (zoals data) zonder de rest van de pagina te blokkeren
    // Pagina blijft hierbij gewoon werken zonder dat het bevriest
    async function submitUser() {
        try{   
            // Volledige naam samenstellen
            const fullName = `${firstName.value} ${surnamePrefix.value ? surnamePrefix.value + ' ': ''}${lastName.value}`

            // Ingevoerde wachtwoorden valideren bij het aanmaken van een gebruiker
            if (!props.userId && password.value !== passwordConfirm.value)
            {
                errorToastMessage.value = 'Wachtwoorden komen niet overeen.'
                clearToastMessage(errorToastMessage)
                return;
            }

            // Controleren of het formulier gebruikt wordt voor het aanmaken of bewerken van een gebruiker
            // Payload bevat alle gebruikersgegevens die meegestuurd worden in het HTTP-verzoek
            if (props.userId)
            {
                // Payload object bouwen voor het bewerken van een gebruiker
                const payload = {
                    first_name: firstName.value,
                    surname_prefix: surnamePrefix.value || null,
                    last_name: lastName.value,
                    email: email.value,
                    role: role.value
                }

                // Wachtwoord alleen toevoegen aan de payload als de administrator een nieuw wachtwoord heeft ingevuld
                if (password.value)
                {
                    payload.password = password.value
                }

                // PUT verzoek versturen naar de backend voor het bewerken van een gebruiker
                await apiClient.put(`/users/${props.userId}`, payload)

                // Succesmelding opslaan in localStorage
                localStorage.setItem('UserEditSuccess', fullName)  
            } else {
                // POST verzoek sturen naar de backend voor het aanmaken van een gebruiker 
                await apiClient.post('/users', {
                    first_name: firstName.value,
                    surname_prefix: surnamePrefix.value || null,
                    last_name: lastName.value,
                    email: email.value,
                    role: role.value,
                    password: password.value
                })

                // Succesmelding opslaan in localStorage
                localStorage.setItem('UserCreateSuccess', fullName)
            }

            // Na het succesvol opslaan van een gebruiker, administrator doorsturen naar gebruikersbeheer pagina
            router.push('/administrator/dashboard/gebruikersbeheer')
        } catch (error) {
            // Foutmelding tonen als er iets fout is gegaan
            errorToastMessage.value = 'Er is iets misgegaan bij het opslaan van de gebruiker.'
            clearToastMessage(errorToastMessage)
        } 
    }

    // onMounted wordt uitgevoerd zodra het component volledig geladen is in de browser
    // Async gebruiken, zodat await gebruikt kan worden voor het ophalen van de gebruikersgegevens
    onMounted(async () => {
        try{
            // gebruiker ophalen zodra de pagina geladen is
            if (props.userId)
            {
                // Laadstatus op true zetten, voordat de gebruiker wordt opgehaald
                isLoading.value = true;

                // Gebruikersgegevens ophalen via de backend
                const userResponse = await apiClient.get(`/users/${props.userId}`)
                // Invoervelden van het formulier vullen met de opgehaalde gebruikersgegevens
                const user = userResponse.data

                firstName.value = user.first_name
                surnamePrefix.value = user.surname_prefix
                lastName.value = user.last_name
                email.value = user.email
                role.value = user.role
                // Wachtwoord wordt om veiligheidsredenen niet teruggestuurd door de backend, dus dit veld blijft leeg.
            } else {
                return;
            }
        } catch (error) {
            // Foutmelding tonen als er iets fout is gegaan
            errorToastMessage.value = 'Er is iets misgegaan bij het ophalen van de gebruiker.'
            clearToastMessage(errorToastMessage)
        } finally {
            // Finally wordt altijd uitgevoerd, ook al er een fout optreedt
            isLoading.value = false
        }
    })
</script>