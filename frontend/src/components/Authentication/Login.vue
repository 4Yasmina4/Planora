<template>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center px-4">
        <div class="bg-white rounded-xl shadow-md p-12 w-full max-w-xl">
            <!-- Titel met slot icoon -->
            <div class="flex items-center justify-center gap-3 mb-6">
                <LockClosedIcon class="w-7 h-7 text-soft-periwinkle" />
                <h2 class="text-2xl font-bold text-soft-periwinkle">Inloggen</h2>
            </div>

            <!-- Formulier -->
            <!-- @submit.prevent="login": verstuurd het formulier en voorkomt dat de standaar herlaadactie in de browser wordt uitgevoerd -->
            <form class="space-y-5" @submit.prevent="login">
                <!-- E-mailadres -->
                <div>
                    <label class="block font-medium text-soft-periwinkle mb-1">E-mailadres</label>
                    <!-- v-model koppelt het invoerveld aan de reactieve variabele email -->
                    <input v-model="email" type="email" placeholder="Voer uw e-mailadres in" required
                        class="w-full border border-lavender-grey rounded-lg px-3 py-3 focus:ring-2 focus:ring-soft-periwinkle focus:outline-none" />
                </div>

                <!-- Wachtwoord -->
                <div>
                    <label class="block font-medium text-soft-periwinkle mb-1">Wachtwoord</label>
                    <!-- v-model koppelt het invoerveld aan de reactieve variabele wachtwoord -->
                    <input v-model="password" type="password" placeholder="Voer uw wachtwoord in" required
                        class="w-full border border-lavender-grey rounded-lg px-3 py-3 focus:ring-2 focus:ring-soft-periwinkle focus:outline-none" />
                </div>

                <!-- Toastfoutmelding -->
                <Toast :toastMessage="errorToastMessage" type="error" />

                <!-- Knoppen -->
                <div class="flex gap-3 pt-4">
                    <!-- Terug naar de homepagina -->
                    <router-link to="/" class="w-full flex items-center gap-2 px-4 py-2 rounded-lg border border-lavender-grey bg-ghost-white text-gray-700 hover:bg-lavender-grey hover:text-white hover:underline transition">
                        <ArrowLeftIcon class="w-5 h-5" /> Terug naar homepagina
                    </router-link>

                    <!-- Inloggen knop -->
                    <button type="submit" class="w-full flex items-center gap-2 px-4 py-3 rounded-lg border border-ocean-twilight bg-soft-periwinkle text-white font-semibold hover:bg-ocean-twilight hover:underline transition">
                        <ArrowRightEndOnRectangleIcon class="w-5 h-5" /> Inloggen
                    </button>
                </div>
            </form>

            <!-- Link naar registratiepagina-->
            <p class="text-center text-gray-500 text-base mt-6">
                Nog geen account?
                <router-link to="/register" class="text-soft-periwinkle hover:text-ocean-twilight font-semibold underline">Account aanmaken</router-link>
            </p>
        </div>
    </div>
</template>

<script setup>
    // Refimporteren uit Vue
    // Ref: om reactieve variabelen te maken
    import { ref } from 'vue';

    // useRouter importeren
    import { useRouter } from 'vue-router'

    // ArrowLeftIcon, ArrowRightEndOnRectangleIcon en LockClosedIcon importeren uit Heroicons
    import { ArrowLeftIcon, ArrowRightEndOnRectangleIcon, LockClosedIcon } from '@heroicons/vue/24/solid'

    // Toast component importern uit de Base map
    import Toast from '../Base/Toast/Toast.vue'

    // Axios importeren voor het vesturen van HTTP verzoeken naar de backend
    // Axios maakt het makkelijker om een token mee te sturen met elk verzoek in tegenstelling tot fetch()
    import axios from 'axios'

    // UseRouter geeft toegang tot de router om vanuit de code te navigeren naar een andere pagina
    const router = useRouter()

    // Reactieve variabelen voor de invoervelden
    // Beginnen als lege string, omdat de velden leeg zijn bij het laden van de loginpagina
    const email = ref('')
    const password = ref('')

    // Error en succes toastmelding
    const errorToastMessage = ref('')
    const successToastMessage = ref('')

    // Functie om in te loggen
    // Async function zorgt ervoor dat de functie kan wachten op iets (zoals data) zonder de rest van de pagina te blokkeren
    // Pagina blijft hierbij gewoon werken zonder dat het bevriest
    async function login() {
        try{
            // POST verzoek sturen naar de backend met email en wachtwoord
            const response = await axios.post('http://localhost/login', {
                email: email.value,
                password: password.value
            })

            // JWT token (JSON Web Token) opslaan
            const token = response.data.token

            // Navigeren naar de juiste dashboard pagina op basis van de gebruikersrol (administrator of student)
            router.push('/users')
        } catch (error) {
            // Foutmelding tonen als de inloggegevens onjuist zijn
            errorToastMessage.value = 'Ongeldig e-mailadres of wachtwoord.'
        }
    }
</script>