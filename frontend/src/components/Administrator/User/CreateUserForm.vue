<template>
    <div class="max-w-3xl mx-auto mt-10 bg-white p-12 rounded-xl shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-violet-500">
            Nieuwe gebruiker aanmaken
        </h2>

        <!-- Formulier veld -->
        <!-- Voorkomt dat de standaard herlaadactie wordt uitgevoerd bij het versturen van het formulier en roept createUser aan -->
        <form class="space-y-5" @submit.prevent="createUser">
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

            <!-- Wachtwoord -->
            <div>
                <label class="block font-medium text-gray-700 mb-1">Wachtwoord</label>
                <input v-model="password" type="password" placeholder="Voer een wachtwoord in" required
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

            <!-- v-if toon het element alleen als de voorwaarde true is (variabele niet leeg is) -->
            <!-- Foutmelding tonen als het verzoek mislukt -->
            <p v-if="errorMessage" class="text-red-500">
                {{ errorMessage}}
            </p>

            <!-- Succesbericht tonen als de gebruiker succesvol is aangemaakt -->
            <p v-if="successMessage" class="text-green-500">
                {{ successMessage}}
            </p>

            <!-- Knoppen onderaan (annuleren en opslaan) -->
            <div class="flex justify-between pt-4">
                <!-- Annuleer knop -->
                <button type="button" class="px-4 py-2 rounded-lg border bg-slate-300 text-gray-700 hover:bg-slate-400 transition">
                    Annuleren
                </button>

                <!-- Opslaan knop -->
                <button type="submit" class="px-4 py-2 rounded-lg border border-violet-950 bg-violet-400 text-white font-semibold hover:bg-violet-700 transition">Gebruiker aanmaken</button>
            </div>
        </form>
    </div>
</template>

<script setup>

    // Ref importeren uit Vue om reactieve variabelen te maken
    // Reactieve variabelen zorgen ervoor dat de pagina automatisch bijwerkt als de waarde verandert
    import { ref } from 'vue'

    // Formulier data om een gebruiker aan te maken
    const firstName = ref('')
    const surnamePrefix = ref('')
    const lastName = ref('')
    const email = ref('')
    const password = ref('')
    const role = ref('')
 
    // Foutmelding en successmelding
    const errorMessage = ref('')
    const successMessage = ref('')

    // Formulier versturen
    async function createUser() {

        // Fout- en succesberichten leegmaken bij elke nieuwe poging
        errorMessage.value = ''
        successMessage.value = ''

        try{
            // Een POST verzoek sturen naar de backend met de formlierdata
            const response = await fetch('http://localhost/users', {
                // HTTP methode instellen op POST
                method: 'POST',
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
                    password: password.value,
                    role: role.value
                })
            })

            // De JSON response van de backend omzetten naar een JavaScript object
            const data = await response.json()

            // Controlere of de HTTP statuscode tussen 200-299 (succes) valt
            // Als het verzoek niet is gelukt foutmelding tonen
            if (!response.ok)
            {
                // Foutmelding van de backend tonen
                errorMessage.value = data.error
                return
            }

            // Succesbericht tonen als de gebruiker succesvol is aangemaakt
            successMessage.value = 'Gebruiker succesvol aangemaakt!'
        } catch (error) {
            // Foutmelding tonen als er een netwerkfout of een andere fout optreedt
            errorMessage.value = 'Er is iets misgegaan, probeer het opnieuw'
        }
    }
</script>