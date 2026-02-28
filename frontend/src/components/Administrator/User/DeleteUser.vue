<template>
    <div class="max-w-3xl mx-auto mt-10 bg-white p-12 rounded-xl shadow-md">
        <!-- Waarschuwingstitel -->
        <h2 class="text-2xl font-bold mb-2 text-red-600">
            Weet u zeker dat u deze gebruiker wilt verwijderen?
        </h2>
        <p class="text-gray-500 mb-6">Deze actie kan niet ongedaan worden gemaakt</p>

        <!-- Toast foutmelding -->
        <Toast :toastMessage="errorToastMessage" type="error" />

        <!-- Gebruikersgegevens (alleen lezen) -->
        <div v-if="user" class="space-y-4">
            <div class="border border-gray-200 rounded-xl overflow-hidden mb-6">
                <!-- User ID -->
                <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100">
                    <IdentificationIcon class="w-5 h-5 text-red-400 shrink-0" />
                    <span class="text-gray-500 w-36 shrink-0">ID</span>
                    <span class="text-gray-800 font-medium">{{ user.user_id }}</span>
                </div>

                <!-- Voornaam -->
                <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100">
                    <UserIcon class="w-5 h-5 text-red-400 shrink-0" />
                    <span class="text-gray-500 w-36 shrink-0">Voornaam</span>
                    <span class="text-gray-800 font-medium">{{ user.first_name }}</span>
                </div>

                <!-- Tussenvoegsel naam -->
                <div v-if="user.surname_prefix" class="flex items-center gap-3 px-5 py-4 border-b border-gray-100">
                    <UserIcon class="w-5 h-5 text-red-400 shrink-0" />
                    <span class="text-gray-500 w-36 shrink-0">Tussenvoegsel</span>
                    <span class="text-gray-800 font-medium">{{ user.surname_prefix }}</span>
                </div>

                <!-- Achternaam -->
                <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100">
                    <UserIcon class="w-5 h-5 text-red-400 shrink-0" />
                    <span class="text-gray-500 w-36 shrink-0">Achternaam</span>
                    <span class="text-gray-800 font-medium">{{ user.last_name }}</span>
                </div>

                <!-- Email -->
                <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100">
                    <EnvelopeIcon class="w-5 h-5 text-red-400 shrink-0" />
                    <span class="text-gray-500 w-36 shrink-0">Email</span>
                    <span class="text-gray-800 font-medium">{{ user.email }}</span>
                </div>

                <!-- Gebruikersrol -->
                <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100">
                    <ShieldCheckIcon class="w-5 h-5 text-red-400 shrink-0" />
                    <span class="text-gray-500 w-36 shrink-0">Rol</span>
                    <span class="text-gray-800 font-medium capitalize">{{ user.role }}</span>
                </div>
            </div>

            <!-- Knoppen onderaan (annuleren en verwijderen) -->
            <div class="flex justify-between pt-4">
                <!-- Annuleer knop -->
                <router-link to="/users" class="flex items-center gap-2 px-4 py-2 rounded-lg border bg-slate-300 text-gray-700 hover:bg-slate-400 transition">
                    <ArrowLeftIcon class="w-4 h-4" /> Annuleren
                </router-link>

                <!-- Verwijder knop -->
                <button @click="deleteUser" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-red-500 text-white font-semibold hover:bg-red-700 transition">
                    <TrashIcon class="w-4 h-4" /> Ja, verwijderen
                </button>
            </div>
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
    import { useRoute, useRouter } from 'vue-router'

    // ArrowLeftIcon, UserIcon, TrashIcon, IdentificationIcon, EnvelopeIcon, ShieldCheckIcon importeren uit Heroicons
    import { ArrowLeftIcon, UserIcon, TrashIcon, IdentificationIcon, EnvelopeIcon, ShieldCheckIcon } from '@heroicons/vue/24/solid'

    // Toast component importern uit de Base map
    import Toast from '../../Base/Toast/Toast.vue'

    // UseRoute geeft toegang tot de huidige URL-informatie
    // Hiermee kan de :id uit de URL opgehaald worden (bijv. /users/5 → id = 5)
    const route = useRoute()

    // UseRouter geeft toegang tot de router om vanuit de code te navigeren naar een andere pagina
    const router = useRouter()

    // Reactieve variabele gebruiken om de gebruiker in op te slaan
    // Begint met de waarde null, omdat de gebruiker nog niet is opgehaald
    const user = ref(null)

    // Error toastmelding
    const errorToastMessage = ref('')

    // Één gebruiker ophalen van de backend om de gegevens te tonen
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
        }
    }

    // Gebruiker verwijderen via een DELETE verzoek naar de backend
    async function deleteUser() {
        try{
            const response = await fetch(`http://localhost/users/${route.params.id}`, {
                // HTTP methode instellen op DELETE
                method: 'DELETE'
            })

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

            // Na het verwijderen van de gebruiker terugnavigeren naar de gebruikerslijst met een succesmelding
            router.push({ path: '/users', 
                          state: { successToastMessage: `${user.value.first_name} ${user.value.surname_prefix ? user.value.surname_prefix + ' ': ''}${user.value.last_name} is succesvol verwijderd!` } })
        }catch (error) {
            // Foutmelding tonen als er een netwerkfout of een andere fout optreedt
            errorToastMessage.value = 'Er is iets misgegaan, probeer het opnieuw'
        }
    }

    // Gebruiker ophalen zodra het component geladen is
    onMounted(() => {
        fetchUser()
    })
</script>