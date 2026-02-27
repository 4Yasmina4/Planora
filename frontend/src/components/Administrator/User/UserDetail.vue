<template>
    <div class="max-w-3xl mx-auto mt-10 bg-white p-12 rounded-xl shadow-md">
        <!-- Titel -->
        <h2 class="text-2xl font-bold mb-6 text-violet-500">
            Gebruikersdetails
        </h2>

        <!-- Laadstatus mocht de pagina vertragen -->
        <div v-if="loading" class="text-gray-500">Gebruiker laden...</div>

        <!-- Toast foutmelding  -->
        <Toast :toastMessage="errorToastMessage" type="error" />

        <!-- Kaart met gebruikersgegevens -->
        <div v-if="user" class="space-y-4">

        <div class="border border-gray-200 rounded-xl overflow-hidden">
            <!-- User ID -->
            <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100">
                <IdentificationIcon class="w-5 h-5 text-violet-400 shrink-0" />
                <span class="text-gray-500 w-36 shrink-0">ID</span>
                <span class="text-gray-800 font-medium">{{ user.user_id }}</span>
            </div>

            <!-- Voornaam -->
            <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100">
                <UserIcon class="w-5 h-5 text-violet-400 shrink-0" />
                <span class="text-gray-500 w-36 shrink-0">Voornaam</span>
                <span class="text-gray-800 font-medium">{{ user.first_name }}</span>
            </div>

            <!-- Tussenvoegsel naam -->
            <div v-if="user.surname_prefix" class="flex items-center gap-3 px-5 py-4 border-b border-gray-100">
                <UserIcon class="w-5 h-5 text-violet-400 shrink-0" />
                <span class="text-gray-500 w-36 shrink-0">Tussenvoegsel</span>
                <span class="text-gray-800 font-medium">{{ user.surname_prefix }}</span>
            </div>

            <!-- Achternaam -->
            <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100">
                <UserIcon class="w-5 h-5 text-violet-400 shrink-0" />
                <span class="text-gray-500 w-36 shrink-0">Achternaam</span>
                <span class="text-gray-800 font-medium">{{ user.last_name }}</span>
            </div>

            <!-- Email -->
            <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100">
                <UserIcon class="w-5 h-5 text-violet-400 shrink-0" />
                <span class="text-gray-500 w-36 shrink-0">Email</span>
                <span class="text-gray-800 font-medium">{{ user.email }}</span>
            </div>

            <!-- Gebruikersrol -->
            <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100">
                <UserIcon class="w-5 h-5 text-violet-400 shrink-0" />
                <span class="text-gray-500 w-36 shrink-0">Rol</span>
                <span class="text-gray-800 font-medium capitalize">{{ user.role }}</span>
            </div>
        </div>

        <!-- Terug naar gebruikersoverzichtknop-->
        <router-link to="/users" class="flex items-center gap-2 px-4 py-2 rounded-lg border bg-slate-300 text-gray-700 hover:bg-slate-400 transition">
            <ArrowLeftIcon class="w-4 h-4" /> Terug naar gebruikersoverzicht
        </router-link>

        </div>
    </div>

</template>

<script setup>
    // Ref en onMounted importeren uit Vue
    // Ref: om reactieve variabelen te maken
    // onMounted: om code uit te voeren zodra het component geladen is in de browser
    // onMounted is nodig, omdat er meteen een actie gebeurt bij het laden van de pagina
    // Er wordt hierbij niet gewacht op de input van de gebruiker
    import { ref, onMounted } from 'vue'
    import { useRoute } from 'vue-router'

    // ArrowLeftIcon, UserIcon en IdentificationIcon importeren uit Heroicons
    import { ArrowLeftIcon, UserIcon, IdentificationIcon } from '@heroicons/vue/24/solid'

    // Toast component importern uit de Base map
    import Toast from '../../Base/Toast/Toast.vue'

    // UserRoute geeft toegang tot de huidige URL-informatie
    // Hiermee kan de :id uit de URL opgehaald worden (bijv. /users/5 → id = 5)
    const route = useRoute()

    // Reactieve variabele gebruiken om de gebruiker in op te slaan
    // Begint met de waarde null, omdat de gebruiker nog niet is opgehaald
    const user = ref(null)

    // Reactieve variabele gebruiken om bij te houden of de pagina nog aan het laden is
    // Begint als 'true', omdat de pagina direct begint met laden
    const loading = ref(true)

    // Error toastmelding
    const errorToastMessage = ref('')

    // Één gebruiker ophalen van de backend
    // Async function zorgt ervoor dat de functie kan wachten op iets (zoals data) zonder de rest van de pagina te blokkeren
    // Pagina blijft hierbij gewoon werken zonder dat het bevriest
    async function fetchUser() {
        try{
            // Een GET verzoek sturen naar de backend met het id uit de URL
            // Await zorgt ervoor dat de code wacht totdat de nackend een antwoord geeft
            // Route.params.id haalt het id op uit de URL 
            const response = await fetch(`http://localhost/users/${route.params.id}`)
            
            // De ruwe response van de backend omzetten naar een Javascript object
            // Await zorgt ervoor dat de code wacht totdat de omzetting klaar is
            const data = await response.json()

            // Controleren of de HTTP statuscode tussen 200-299 (succes) valt
            // Als het verzoek niet is gelukt foutmelding tonen
            if (!response.ok)
            {
                // Foutmelding van de backend tonen
                errorToastMessage.value = data.error
                return
            }
            
            // Gebruiker opslaan in de reactieve variabele
            user.value = data
        }catch (error) {
            // Foutmelding tonen als er een netwerkfout of een andere fout optreedt
            errorToastMessage.value = 'Er is iets misgegaan, probeer het opnieuw'
        } finally {
            // Finally wordt altijd uitgevoerd, of het verzoek nu gelukt is of niet
            // Loading wordt op 'false' gezet, zodat de laadstatus verdwijnt
            loading.value = false
        }
    }

    // Gebruiker ophalen zodra het component geladen is
    onMounted(() => {
        fetchUser()
    })
</script>