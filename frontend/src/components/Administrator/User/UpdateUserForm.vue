<template>
    <div class="max-w-3xl mx-auto mt-10 bg-white p-12 rounded-xl shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-violet-500">
            Gebruiker bewerken
        </h2>

        <!-- Formulier veld -->
        <!-- Voorkomt dat de standaard herlaadactie wordt uitgevoerd bij het versturen van het formulier en roept updateUser aan -->
        <form class="space-y-5" @submit.prevent="updateUser">
            <!-- User ID (alleen lezen) -->
            <div>
                <label class="block font-medium text-gray-700 mb-1">ID</label>
                <input :value="user?.user_id" type="text" disabled 
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 bg-gray-100 text-gray-500 cursor-not-allowed" 
                />
            </div>

            <!-- v-model koppelt het invoerveld aan de reactieve variabele -->
            <!-- Voornaam -->
            <div>
                <label class="block font-medium text-gray-700 mb-1">Voornaam</label>
                <input v-model="firstName" type="text" placeholder="Voer een voornaam in" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                />
            </div>

            <!-- Tussenvoegsel -->
            <div>
                <label class="block font-medium text-gray-700 mb-1">Tussenvoegsel</label>
                <input v-model="surnamePrefix" type="text" placeholder="Voer een tussenvoegsel in" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                />
            </div>

            <!-- Achternaam -->
            <div>
                <label class="block font-medium text-gray-700 mb-1">Achternaam</label>
                <input v-model="lastName" type="text" placeholder="Voer een achternaam in" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                />
            </div>

            <!-- Email -->
            <div>
                <label class="block font-medium text-gray-700 mb-1">Email</label>
                <input v-model="email" type="email" placeholder="Voer een email in" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                />
            </div>

            <!-- Wachtwoord (optioneel) -->
            <div>
                <label class="block font-medium text-gray-700 mb-1">Wachtwoord</label>
                <input v-model="password" type="password" placeholder="Laat leeg om wachtwoord niet te wijzigen"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                />
            </div>

            <!-- Gebruikersrol -->
            <div>
                <label class="block font-medium text-gray-700 mb-1">Gebruikersrol</label>
                <select v-model="role" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="" disabled selected >- Selecteer een gebruikersrol -</option>
                    <option value="student">Student</option>
                    <option value="administrator">Administrator</option>
                </select>
            </div>

            <!-- Errortoastmelding tonen als het verzoek mislukt -->
            <Toast :toastMessage="errorToastMessage" type="error" />

            <!-- Knoppen onderaan (annuleren en opslaan) -->
            <div class="flex justify-between pt-4">
                <!-- Annuleer knop -->
                <router-link to="/users" class="flex items-center gap-2 px-4 py-2 rounded-lg border bg-slate-300 text-gray-700 hover:bg-slate-400 transition">
                    <ArrowLeftIcon class="w-4 h-4" /> Annuleren
                </router-link>

                <!-- Wijzigingen opslaan knop -->
                <button type="submit" class="px-4 py-2 rounded-lg border border-violet-950 bg-violet-400 text-white font-semibold hover:bg-violet-700 transition">Wijzigingen opslaan</button>
            </div>
        </form>
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

    // ArrowLeftIcon importeren uit Heroicons
    import { ArrowLeftIcon } from '@heroicons/vue/24/solid'

    // Toast component importern uit de Base map
    import Toast from '../../Base/Toast/Toast.vue'

    // UseRoute geeft toegang tot de huidige URL-informatie
    // Hiermee kan de :id uit de URL opgehaald worden (bijv. /users/5 → id = 5)
    const route = useRoute()

    // UseRouter geeft toegang tot de router om vanuit de code te navigeren naar een andere pagina
    const router = useRouter()

    // Reactieve variabele gebruiken om de gebruiker in op te slaan om het ID te tonen
    // Begint met de waarde null, omdat de gebruiker nog niet is opgehaald
    const user = ref(null)

        // Formulier data om een gebruiker aan te maken
    const firstName = ref('')
    const surnamePrefix = ref('')
    const lastName = ref('')
    const email = ref('')
    const password = ref('')
    const role = ref('')
 
    // Error toastmelding
    const errorToastMessage = ref('')

    // Bestaande gebruikersgegevens ophalen en het formulier voorvullen
    async function fetchUser() {
        try{
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
            
            // Formulier voorvullen met bestaand gebruikersgegevens
            firstName.value = data.first_name
            surnamePrefix.value = data.surname_prefix ?? ''
            lastName.value = data.last_name
            email.value = data.email
            role.value = data.role
        }catch (error) {
            // Foutmelding tonen als er een netwerkfout of een andere fout optreedt
            errorToastMessage.value = 'Er is iets misgegaan, probeer het opnieuw'
        }
    }

    // Gebruikersgegevens bijwerken via een PUT verzoek naar de backend
    async function updateUser() {
        try{
            // Een PUT verzoek sturen naar de backend met de formlierdata
            const response = await fetch(`http://localhost/users/${route.params.id}`, {
                // HTTP methode instellen op PUT
                method: 'PUT',
                // Aangeven dat de data in JSON formaat wordt meegestuurd
                headers:{
                    'Content-Type': 'application/json'
                },
                // Formulierdata omzetten naar JSON formaat en meesturen in het verzoek
                body: JSON.stringify({
                    first_name: firstName.value,
                    surname_prefix: surnamePrefix.value || null, // null als tussenvoegsel leeg is
                    last_name: lastName.value,
                    email: email.value,
                    password: password.value || null, // null als wachtwoord niet gewijzigd is
                    role: role.value
                })
            })

            // De JSON response van de backend omzetten naar een JavaScript object
            const data = await response.json()

            // Controleren of de HTTP statuscode tussen 200-299 (succes) valt
            // Als het verzoek niet is gelukt foutmelding tonen
            if (!response.ok)
            {
                // Foutmelding van de backend tonen
                errorToastMessage.value = data.error
                return
            }

            // Redirecten naar de gebruikerslijst en een succesbericht tonen
            router.push({ path: '/users', 
                          state: { successToastMessage: `${user.value.first_name} ${user.value.surname_prefix ? user.value.surname_prefix + ' ': ''}${user.value.last_name} is succesvol bijgewerkt!` } })

        } catch (error) {
            // Foutmelding tonen als er een netwerkfout of een andere fout optreedt
            errorToastMessage.value = 'Er is iets misgegaan, probeer het opnieuw'
        }
    }

    // Gebruiker ophalen zodra het component geladen is
    onMounted(() => {
        fetchUser()
    })
</script>