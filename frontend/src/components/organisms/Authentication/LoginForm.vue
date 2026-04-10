<!-- Dit bestand bevat het volledige loginformulier 
     Het combineert de FormField molecules en BaseButton atoms tot één geheel
     Wordt gebruikt in de login pagina
-->

<template>
    <div class="bg-white rounded-xl shadow-md p-12 w-full max-w-xl">
        <!-- Titel met slot icoon -->
        <div class="flex items-center justify-center gap-3 mb-6">
            <Lock class="w-7 h-7 text-soft-periwinkle" />
            <h2 class="text-2xl font-bold text-soft-periwinkle">Inloggen</h2>
        </div>

        <!-- Formulier -->
        <!-- @submit.prevent="login": verstuurd het formulier en voorkomt dat de standaard herlaadactie in de browser wordt uitgevoerd -->
        <form class="space-y-5" @submit.prevent="login">
            <!-- E-mailadres -->
            <FormField 
                label="E-mailadres"
                type="email"
                placeholder="Voer uw e-mailadres in"
                :required="true"
                v-model="email"
            />    

            <!-- Wachtwoord -->
            <FormField 
                label="Wachtwoord"
                type="password"
                placeholder="Voer uw wachtwoord in"
                :required="true"
                v-model="password"
            /> 

            <!-- Toastfoutmelding -->
            <Toast :toastMessage="errorToastMessage" type="error" />

            <!-- Toastsuccesmelding -->
            <Toast :toastMessage="successToastMessage" type="success" />

            <!-- Knoppen -->
            <div class="flex gap-3 pt-4">
                <!-- Terug naar de homepagina -->
                <router-link to="/" class="w-full flex items-center gap-2 px-4 py-2 rounded-lg border border-lavender-grey bg-ghost-white text-gray-700 hover:bg-lavender-grey hover:text-white hover:underline transition">
                    <ArrowLeft class="w-5 h-5" /> Terug naar homepagina
                </router-link>

                <!-- Inloggen knop -->
                <BaseButton type="submit" buttonClass="w-full flex items-center gap-2 px-4 py-3 rounded-lg border border-ocean-twilight bg-soft-periwinkle text-white font-semibold hover:bg-ocean-twilight hover:underline transition">
                    <LogIn class="w-5 h-5" /> Inloggen
                </BaseButton>
            </div>
        </form>

        <!-- Link naar registratiepagina-->
        <p class="text-center text-gray-500 text-base mt-6">
            Nog geen account?
            <router-link to="/register" class="text-soft-periwinkle hover:text-ocean-twilight font-semibold underline">Account aanmaken</router-link>
        </p>
    </div>
</template>

<script setup>
    // Beveiliging:
    // - Vue beveiligt automatisch tegen XSS aanvallen door speciale tekens (zoals < en >) om te zetten
    // - JWT tokens worden via de Authorization header verstuurd, waardoor CSRF aanvallen niet mogelijk zijn
    
    // Ref importeren uit Vue
    // Ref: om reactieve variabelen te maken
    import { ref, onMounted } from 'vue';

    // useRouter importeren
    import { useRouter } from 'vue-router'

    // Lucide icons importeren
    import { ArrowLeft, LogIn, Lock } from 'lucide-vue-next'

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
    // Beginnen als lege string, omdat de velden leeg zijn bij het laden van de loginpagina
    const email = ref('')
    const password = ref('')

    // Error en succes toastmelding 
    const errorToastMessage = ref('')
    const successToastMessage = ref('')

    // onMounted wordt uitgevoerd zodra het component volledig geladen is in de browser
    onMounted(() => {
        // Controleren of er een succesmelding is na het registreren van een account
        if (localStorage.getItem('registrationSuccess') === 'true')
        {
            successToastMessage.value = 'Account succesvol aangemaakt! U kunt nu inloggen.'
            localStorage.removeItem('registrationSuccess')

            // Toastmelding na 3 seconden verwijderen
            // setTimeout voert de functie uit na een opgegeven tijd in milliseconden
            // 3000 milliseconden = 3 seconden
            setTimeout(() => {
                successToastMessage.value = ''
            }, 3000)
        }

        // Controleren of er een succesmelding is na het uitloggen
        if (localStorage.getItem('logoutSuccess') === 'true')
        {
            successToastMessage.value = 'U bent succesvol uitgelogd!'
            localStorage.removeItem('logoutSuccess')

            // Toastmelding na 3 seconden verwijderen
            // setTimeout voert de functie uit na een opgegeven tijd in milliseconden
            // 3000 milliseconden = 3 seconden
            setTimeout(() => {
                successToastMessage.value = ''
            }, 3000)
        }
    })

    // Functie om in te loggen
    // Async function zorgt ervoor dat de functie kan wachten op iets (zoals data) zonder de rest van de pagina te blokkeren
    // Pagina blijft hierbij gewoon werken zonder dat het bevriest
    async function login() {
        try{
            // POST verzoek sturen naar de backend met email en wachtwoord
            const response = await apiClient.post('/login', {
                email: email.value,
                password: password.value
            })

            // JWT token (JSON Web Token) opslaan in localStorage, zodat het beschikbaar blijft na het herladen van de pagina
            const jwtToken = response.data.token
            localStorage.setItem('token', jwtToken)

            // Gebruikersrol uitlezen uit het JWT token
            // Een JWT bestaat uit 3 delen gescheiden door punten: header.payload.signature
            // payload is het middelste deel met de gebruikersgegevens zoals user_id
            // atob decodeert base64 naar leesbare tekst (base64 is een manier om data om te zetten naar tekst)
            // split('.')[1] = pakt het middelste deel (payload) uit het JWT token
            const payload = JSON.parse(atob(jwtToken.split('.')[1]))

            // Navigeren naar de juiste dashboard pagina op basis van de gebruikersrol (administrator of student)
            if (payload.role === 'administrator')
            {
                router.push('/administrator/dashboard')
            } else if (payload.role === 'student'){
                router.push('/student/dashboard')
            } else {
                errorToastMessage.value = 'Er ging iets mis. Log opnieuw in.'
                router.push('/login')
            }
        } catch (error) {
            // Foutmelding tonen als de inloggegevens onjuist zijn
            errorToastMessage.value = 'Ongeldig e-mailadres of wachtwoord.'
        }
    }
</script>