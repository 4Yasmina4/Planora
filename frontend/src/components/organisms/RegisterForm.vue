<!-- Dit bestand bevat het volledige registratieformulier 
     Het combineert de FormField molecules en FormButton atoms tot één geheel
     Wordt gebruikt in de register pagina
-->

<template>
    <div class="bg-white rounded-xl shadow-md p-12 w-full max-w-2xl">
        <!-- Titel met icoon -->
        <div class="flex items-center justify-center gap-3 mb-6">
            <UserRoundPlus class="w-7 h-7 text-soft-periwinkle" />
            <h2 class="text-2xl font-bold text-soft-periwinkle">Account aanmaken</h2>
        </div>

        <!-- Mededeling verplichte velden -->
        <p class="flex items-center gap-1">
            Velden met <Asterisk class="w-5 h-5 text-red-500" /> zijn verplicht.
        </p>

        <form class="space-y-5" @submit.prevent="register">
            <!-- Voornaam -->
            <!-- v-model koppelt het invoerveld aan de reactieve variabele firstName -->
            <FormField 
                label="Voornaam"
                type="text"
                placeholder="Voer uw voornaam in"
                :required="true"
                v-model="firstName"
            />

            <!-- Tussenvoegsel naam  -->
            <!-- v-model koppelt het invoerveld aan de reactieve variabele surnamePrefix -->
            <FormField 
                label="Tussenvoegsel"
                type="text"
                placeholder="Voer uw tussenvoegsel in"
                v-model="surnamePrefix"
            />

            <!-- Achternaam  -->
            <!-- v-model koppelt het invoerveld aan de reactieve variabele lastName -->
            <FormField 
                label="Achternaam"
                type="text"
                placeholder="Voer uw achternaam in"
                :required="true"
                v-model="lastName"
            />

            <!-- E-mailadres  -->
            <!-- v-model koppelt het invoerveld aan de reactieve variabele email -->
            <div>
                <FormField 
                    label="E-mailadres"
                    type="email"
                    placeholder="Voer uw e-mailadres in"
                    :required="true"
                    v-model="email"
                />
                <div class="mt-2 text-sm text-gray-500">
                    Uw e-mailadres wordt gebruikt om uw account aan te maken en om in te loggen.
                </div>
            </div>

            <!-- Wachtwoord  -->
            <!-- v-model koppelt het invoerveld aan de reactieve variabele password -->
            <FormField 
                label="Wachtwoord"
                type="password"
                placeholder="Voer uw wachtwoord in"
                :required="true"
                v-model="password"
            />
            
            <!-- Bevestig Wachtwoord  -->
            <!-- v-model koppelt het invoerveld aan de reactieve variabele password_confirm -->
            <FormField 
                label="Bevestig Wachtwoord"
                type="password"
                placeholder="Voer uw wachtwoord opnieuw in"
                :required="true"
                v-model="passwordConfirm"
            />

            <!-- Toastfoutmelding -->
            <Toast :toastMessage="errorToastMessage" type="error" />

            <!-- Registratie knop -->
            <FormButton type="submit" formButton="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-lg bg-soft-periwinkle text-white font-semibold hover:bg-ocean-twilight hover:underline transition">
                <CircleCheck class="w-5 h-5" /> Registreren
            </FormButton>
        </form>

        <!-- Link naar loginpagina-->
        <p class="text-center text-gray-500 text-base mt-6">
            Al een account?
            <router-link to="/login" class="text-soft-periwinkle hover:text-ocean-twilight font-semibold underline">Log hier in</router-link>
        </p>
    </div>
</template>

<script setup>
    // Ref importeren uit Vue
    // Ref: om reactieve variabelen te maken
    import { ref } from 'vue';

    // useRouter importeren
    import { useRouter } from 'vue-router'

    // Lucide icons importeren
    import { Asterisk, CircleCheck, UserRoundPlus } from 'lucide-vue-next'

    // Atoms importeren
    import FormButton from '../atoms/FormButton.vue'

    // Molecules importeren
    import FormField from '../molecules/FormField.vue'

    // Toast component importern uit de Base map
    import Toast from '../../components/Base/Toast/Toast.vue'

    // Aangepaste axios instantie importeren met JWT token interceptor
    // Interceptor zorgt ervoor dat bij elk verzoek de JWT token automatisch wordt toegevoegd
    // Wordt gebruikt voor het vesturen van HTTP verzoeken naar de backend
    // Maakt het makkelijker om een token mee te sturen met elk verzoek in tegenstelling tot fetch()
    import apiClient from '../../utils/axios.js'

    // UseRouter geeft toegang tot de router om vanuit de code te navigeren naar een andere pagina
    const router = useRouter()

    // Reactieve variabelen voor de invoervelden
    // Beginnen als lege string, omdat de velden leeg zijn bij het laden van de registratiepagina
    const firstName = ref('')
    const surnamePrefix = ref('')
    const lastName = ref('')
    const email = ref('')
    const password = ref('')
    const passwordConfirm = ref('')

    // Error toastmelding
    const errorToastMessage = ref('')

    // Functie om een account aan te maken (registratie)
    // Async function zorgt ervoor dat de functie kan wachten op iets (zoals data) zonder de rest van de pagina te blokkeren
    // Pagina blijft hierbij gewoon werken zonder dat het bevriest
    async function register() {
        // Controleren of de ingevoerde wachtwoorden overeenkomen
        // Dit is alleen frontend validatie, hoeft niet in de try blok
        if (password.value !== passwordConfirm.value)
        {
            errorToastMessage.value = 'De wachtwoorden komen niet overeen'
            return
        }  

        try{    
            // POST verzoek sturen naar de backend met de registratie invoervelden 
            const response = await apiClient.post('/register', {
                first_name: firstName.value,
                surname_prefix: surnamePrefix.value,
                last_name: lastName.value,
                email: email.value,
                password: password.value,
            })

            // Succesmelding opslaan in localStorage
            localStorage.setItem('registrationSuccess', 'true')

            // Na succesvolle registratie gebruiker doorsturen naar loginpagina
            router.push('/login')
        } catch (error) {
            // Foutmelding tonen als het registreren mislukt (bijvoorbeeld door een netwerkfout of een fout vanuit de backend)
            errorToastMessage.value = 'Er is iets misgegaan bij het registreren. Controleer uw gegevens en probeer het opnieuw.'
        }
    }
</script>