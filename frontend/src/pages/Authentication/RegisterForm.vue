<template>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center px-4 py-10">
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
                <div class="mt-4">
                    <label class="flex items-center gap-1 font-medium text-soft-periwinkle mb-1">
                        Voornaam<Asterisk class="w-4 h-4 text-red-500" />
                    </label>
                    <!-- v-model koppelt het invoerveld aan de reactieve variabele firstName -->
                    <input v-model="firstName" type="text" placeholder="Voer uw voornaam in" required
                        class="w-full border border-lavender-grey rounded-lg px-3 py-3 focus:ring-2 focus:ring-soft-periwinkle focus:outline-none" />
                </div>

                <!-- Tussenvoegsel naam  -->
                <div class="mt-4">
                    <label class="flex items-center gap-1 font-medium text-soft-periwinkle mb-1">
                        Tussenvoegsel
                    </label>
                    <!-- v-model koppelt het invoerveld aan de reactieve variabele surnamePrefix -->
                    <input v-model="surnamePrefix" type="text" placeholder="Voer uw tussenvoegsel van uw naam in"
                        class="w-full border border-lavender-grey rounded-lg px-3 py-3 focus:ring-2 focus:ring-soft-periwinkle focus:outline-none" />
                </div>

                <!-- Achternaam  -->
                <div class="mt-4">
                    <label class="flex items-center gap-1 font-medium text-soft-periwinkle mb-1">
                        Achternaam<Asterisk class="w-4 h-4 text-red-500" />
                    </label>
                    <!-- v-model koppelt het invoerveld aan de reactieve variabele lastName -->
                    <input v-model="lastName" type="text" placeholder="Voer uw achternaam in" required
                        class="w-full border border-lavender-grey rounded-lg px-3 py-3 focus:ring-2 focus:ring-soft-periwinkle focus:outline-none" />
                </div>

                <!-- E-mailadres  -->
                <div class="mt-4">
                    <label class="flex items-center gap-1 font-medium text-soft-periwinkle mb-1">
                        E-mailadres<Asterisk class="w-4 h-4 text-red-500" />
                    </label>
                    <!-- v-model koppelt het invoerveld aan de reactieve variabele email -->
                    <input v-model="email" type="email" placeholder="Voer uw e-mailadres in" required
                        class="w-full border border-lavender-grey rounded-lg px-3 py-3 focus:ring-2 focus:ring-soft-periwinkle focus:outline-none" />
                    <div class="mt-2 text-sm text-gray-500">
                        Uw e-mailadres wordt gebruikt om uw account aan te maken en om in te loggen.
                    </div>
                </div>
                
                <!-- Wachtwoord  -->
                <div class="mt-4">
                    <label class="flex items-center gap-1 font-medium text-soft-periwinkle mb-1">
                        Wachtwoord<Asterisk class="w-4 h-4 text-red-500" />
                    </label>
                    <!-- v-model koppelt het invoerveld aan de reactieve variabele password -->
                    <input v-model="password" type="password" placeholder="Voer uw wachtwoord in" required
                        class="w-full border border-lavender-grey rounded-lg px-3 py-3 focus:ring-2 focus:ring-soft-periwinkle focus:outline-none" />
                </div>

                <!-- Bevestig Wachtwoord  -->
                <div class="mt-4">
                    <label class="flex items-center gap-1 font-medium text-soft-periwinkle mb-1">
                        Bevestig Wachtwoord<Asterisk class="w-4 h-4 text-red-500" />
                    </label>
                    <!-- v-model koppelt het invoerveld aan de reactieve variabele password_confirm -->
                    <input v-model="password_confirm" type="password" placeholder="Voer uw wachtwoord opnieuw in" required
                        class="w-full border border-lavender-grey rounded-lg px-3 py-3 focus:ring-2 focus:ring-soft-periwinkle focus:outline-none" />
                </div>

                <!-- Toastfoutmelding -->
                <Toast :toastMessage="errorToastMessage" type="error" />

                <!-- Registratie knop -->
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-lg bg-soft-periwinkle text-white font-semibold hover:bg-ocean-twilight hover:underline transition">
                    <CircleCheck class="w-5 h-5" /> Registreren
                </button>
            </form>

            <!-- Link naar loginpagina-->
            <p class="text-center text-gray-500 text-base mt-6">
                Al een account?
                <router-link to="/login" class="text-soft-periwinkle hover:text-ocean-twilight font-semibold underline">Log hier in</router-link>
            </p>
        </div>
    </div>

</template>

<script setup>
    // Refimporteren uit Vue
    // Ref: om reactieve variabelen te maken
    import { ref } from 'vue';

    // Lucide icons importeren
    import { Asterisk, CircleCheck, UserRoundPlus } from 'lucide-vue-next'

    // useRouter importeren
    import { useRouter } from 'vue-router'

    // Axios importeren voor het vesturen van HTTP verzoeken naar de backend
    // Axios maakt het makkelijker om een token mee te sturen met elk verzoek in tegenstelling tot fetch()
    import axios from 'axios'

    // Toast component importern uit de Base map
    import Toast from '../../components/Base/Toast/Toast.vue'

    // UseRouter geeft toegang tot de router om vanuit de code te navigeren naar een andere pagina
    const router = useRouter()

    // Reactieve variabelen voor de invoervelden
    // Beginnen als lege string, omdat de velden leeg zijn bij het laden van de registratiepagina
    const firstName = ref('')
    const surnamePrefix = ref('')
    const lastName = ref('')
    const email = ref('')
    const password = ref('')
    const password_confirm = ref('')

    // Error toastmelding
    const errorToastMessage = ref('')

    // Functie om een account aan te maken (registratie)
    // Async function zorgt ervoor dat de functie kan wachten op iets (zoals data) zonder de rest van de pagina te blokkeren
    // Pagina blijft hierbij gewoon werken zonder dat het bevriest
    async function register() {
        // Controleren of de ingevoerde wachtwoorden overeenkomen
        // Dit is alleen frontend validatie, hoeft niet in de try blok
        if (password.value !== password_confirm.value)
        {
            errorToastMessage.value = 'De wachtwoorden komen niet overeen'
            return
        }  

        try{    
            // POST verzoek sturen naar de backend met de registratie invoervelden 
            const response = await axios.post('http://localhost/register', {
                first_name: firstName.value,
                surname_prefix: surnamePrefix.value,
                last_name: lastName.value,
                email: email.value,
                password: password.value,
            })

            // Na succesvolle registratie gebruiker doorsturen naar loginpagina
            router.push('/login')
        } catch (error) {
            // Foutmelding tonen als het registreren mislukt (bijvoorbeeld door een netwerkfout of een fout vanuit de backend)
            errorToastMessage.value = 'Er is iets misgegaan bij het registreren. Controleer uw gegevens en probeer het opnieuw.'
        }
    }

</script>