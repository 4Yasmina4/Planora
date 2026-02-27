<template>
    <div class="max-w-5xl mx-auto mt-10 bg-white p-12 rounded-xl shadow-md">
        <!-- SuccessToastMessage component tonen met het succesbericht -->
        <!-- met : wordt een reactieve variabele doorgegeven aan de prop -->
        <SuccessToast :successToastMessage="successToastMessage" />

        <!-- Titel en gebruiker aanmaken knop naast elkaar plaatsen -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold mb-6 text-violet-500">
                Gebruikersbeheer
            </h2>

            <!-- Knop om naar de gebruiker aanmaken pagina te navigeren -->
            <router-link to="/users/create" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-green-500 text-white font-semibold hover:bg-green-700 transition">
                <!-- Icoon toevoegen van Heroicons-->
                <UserPlusIcon class="w-5 h-5" />
                Gebruiker aanmaken
            </router-link>
        </div>

        <!-- v-if toon het element alleen als de voorwaarde true is (variabele niet leeg is) -->
        <!-- Foutmelding tonen als het verzoek mislukt -->
        <p v-if="errorMessage" class="text-red-500">
            {{ errorMessage}}
        </p> 

        <!-- Tabel met alle gebruikers -->
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="py-3 px-4 text-gray-700">Naam</th>
                    <th class="py-3 px-4 text-gray-700">Email</th>
                    <th class="py-3 px-4 text-gray-700">Rol</th>
                    <th class="py-3 px-4 text-gray-700">Acties</th>
                </tr>
            </thead>

            <tbody>
                <!-- v-for is een Vue directive die een element herhaalt voor elk item in een lijst -->
                <!-- v-for maakt een rij aan voor elke gebruiker in de lijst -->
                <!-- Hierbij is :key="user.user_id" verplicht bij v-for - het geeft elke rij een uniek ID
                     zodat Vue weet welke rij bijgewerkt moet worden om data te veranderen. -->
                <tr v-for="user in users" :key="user.user_id" class="border-b border-gray-100 hover:bg-gray-50">
                    <td class="py-3 px-4">{{ user.first_name }} {{ user.surname_prefix }} {{ user.last_name }}</td>
                    <td class="py-3 px-4">{{ user.email }}</td>
                    <td class="py-3 px-4">{{ user.role }}</td>
                    <td class="py-3 px-4">
                        <div class="flex gap-2">
                            <!-- Bewerken knop -->
                            <button class="flex items-center gap-2 px-3 py-1 rounded-lg bg-violet-400 text-white hover:bg-violet-700 transition">
                                <PencilIcon class="w-4 h-4" /> Bewerken
                            </button>

                            <!-- Verwijder knop -->
                            <button class="flex items-center gap-2 px-3 py-1 rounded-lg bg-red-400 text-white hover:bg-red-700 transition">
                                <TrashIcon class="w-4 h-4" /> Verwijderen
                            </button>
                        </div>
                    </td>

                </tr>
            </tbody>

        </table>
        
    </div>
</template>

<script setup>
    // Ref en onMounted importeren uit Vue
    // Ref: om reactieve variabelen te maken
    // onMounted: om code uit te voeren zodra het component geladen is in de browser
    // onMounted is nodig, omdat er meteen een actie gebeurt bij het laden van de pagina
    // Er wordt hierbij niet gewacht op de input van de gebruiker
    import { ref, onMounted } from "vue";

    // UserPlusIcon, PencilIcon en TrashIcon importeren uit Heroicons
    import { UserPlusIcon, PencilIcon, TrashIcon } from '@heroicons/vue/24/solid'

    // SuccessToast component importern uit de Base map
    import SuccessToast from '../../Base/ToastNotification/SuccessToast.vue'
    
    // Reactieve variabelen
    // Lege array aanmaken om de gebruikers in op te slaan
    const users = ref([])

    // Foutmelding
    const errorMessage = ref('')

    // SuccessToastMessage ophalen uit de router state
    // Router state is een manier om data mee te sturen bij een navigatie naar een andere pagina, zonder het in de URL te zetten
    // Het werkt via de browser's ingebouwde history API. Als er naar /users wordt genavigeerd wordt er een berichte meegestuurd
    const successToastMessage = ref(history.state.successToastMessage || '')

    // SuccesToastMessage na 3 seconden laten verdwijnen
    if (successToastMessage.value)
    {
        setTimeout(() => {
            successToastMessage.value = ''
        }, 3000)
    }
    

    // Alle gebruikers ophalen van de backend
    // Async function zorgt ervoor dat de functie kan wachten op iets (zoals data) zonder de rest van de pagina te blokkeren
    // Pagina blijft hierbij gewoon werken zonder dat het bevriest
    async function getAllUsers() {
        try{
            // GET verzoek sturen naar de backend
            const response = await fetch('http://localhost/users')

            // De JSON response van de backend omzetten naar een JavaScript object
            const data = await response.json()

            // Controleren of de HTTP statuscode tussen 200-299 (succes) valt
            // Als het verzoek niet is gelukt foutmelding tonen
            if (!response.ok)
            {
                // Foutmelding van de backend tonen
                errorMessage.value = data.error
                return
            }

            // Gebruikers opslaan in de reactieve variabele
            users.value = data
        }catch (error) {
            // Foutmelding tonen als er een netwerkfout of een andere fout optreedt
            errorMessage.value = 'Er is iets misgegaan, probeer het opnieuw'
        }       
    }

    // Gebruikers ophalen zodra het component geladen is
    onMounted(() => {
        getAllUsers()
    }) 
</script>