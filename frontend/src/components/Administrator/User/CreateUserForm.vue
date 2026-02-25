<template>
    <div class="max-w-3xl mx-auto mt-10 bg-white p-12 rounded-xl shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-violet-500">
            Nieuwe gebruiker aanmaken
        </h2>

        <!-- Formulier veld -->
        <form class="space-y-5">
            <!-- Voornaam -->
            <div>
                <label class="block font-medium text-gray-700 mb-1">Voornaam</label>
                <input type="text" placeholder="Voer een voornaam in" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                />
            </div>

            <!-- Tussenvoegsel -->
            <div>
                <label class="block font-medium text-gray-700 mb-1">Tussenvoegsel</label>
                <input type="text" placeholder="Voer een tussenvoegsel in" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                />
            </div>

            <!-- Achternaam -->
            <div>
                <label class="block font-medium text-gray-700 mb-1">Achternaam</label>
                <input type="text" placeholder="Voer een achternaam in" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                />
            </div>

            <!-- Email -->
            <div>
                <label class="block font-medium text-gray-700 mb-1">Email</label>
                <input type="email" placeholder="Voer een email in" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                />
            </div>

            <!-- Wachtwoord -->
            <div>
                <label class="block font-medium text-gray-700 mb-1">Wachtwoord</label>
                <input type="password" placeholder="Voer een wachtwoord in" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                />
            </div>

            <!-- Gebruikersrol -->
            <div>
                <label class="block font-medium text-gray-700 mb-1">Gebruikersrol</label>
                <select required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="" disabled selected >- Selecteer een gebruikersrol -</option>
                    <option value="student">Student</option>
                    <option value="administrator">Administrator</option>
                </select>
            </div>

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

</script>