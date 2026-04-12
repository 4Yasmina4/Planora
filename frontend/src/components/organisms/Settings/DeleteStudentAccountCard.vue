<!-- Organism: dit bestand bevat de account verwijderen kaart voor student
-->

<template>
    <div class="bg-white rounded-xl shadow-md p-12 w-full max-w-4xl">
        <!-- Titel met icoon -->
        <div class="flex items-center justify-center gap-3 mb-6">
            <TriangleAlert class="w-7 h-7 text-intense-cherry" />
            <h2 class="text-2xl font-bold text-intense-cherry">Account verwijderen</h2>
        </div>

        <!-- Waarshuwing -->
        <p class="flex items-center gap-1 mb-6 text-lg font-semibold">
            Weet je zeker dat je je acoount wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt.
        </p>

        <form class="space-y-5" @submit.prevent="deleteOwnAccount">
            <!-- Toastfoutmelding -->
            <Toast :toastMessage="errorToastMessage" type="error" />

            <!-- Verwijder knop -->
            <BaseButton type="submit" buttonClass="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-lg bg-intense-cherry text-white font-semibold hover:bg-ruby-red hover:underline transition disabled:opacity-50 disabled:cursor-not-allowed">
                <Trash2 class="w-5 h-5" /> Ja, mijn account verwijderen
            </BaseButton>
        </form>
    </div>
</template>

<script setup>
     // Ref importeren uit Vue
     // Ref: om reactieve variabelen te maken
     import { ref } from 'vue';

     // useRouter importeren
    import { useRouter } from 'vue-router'

    // Lucide icons importeren
    import { Trash2, TriangleAlert } from 'lucide-vue-next'

    // Atoms importeren
    import BaseButton from '../../atoms/BaseButton.vue'

    // Toast component importern uit de Base map
    import Toast from '../../../components/Base/Toast/Toast.vue'

    // Aangepaste axios instantie importeren met JWT token interceptor
    // Interceptor zorgt ervoor dat bij elk verzoek de JWT token automatisch wordt toegevoegd
    // Wordt gebruikt voor het vesturen van HTTP verzoeken naar de backend
    import apiClient from '../../../utils/axios.js'

    // UseRouter geeft toegang tot de router om vanuit de code te navigeren naar een andere pagina
    const router = useRouter()

    // Error toastmelding 
    const errorToastMessage = ref('')

    // Functie om eigen account te verwijderen
    // Async function zorgt ervoor dat de functie kan wachten op iets (zoals data) zonder de rest van de pagina te blokkeren
    async function deleteOwnAccount() {
        try{
            // DELETE verzoek sturen naar de backend
            const response = await apiClient.delete('/settings/account')
               
            // JWT token verwijderen uit localStorage
            localStorage.removeItem('token')

            // Succesmelding opslaan in localStorage
            localStorage.setItem('AccountDeleteSuccess', 'Je account is succesvol verwijderd!')

            // Na het succesvol verwijderen naar de loginpagina navigeren
            router.push('/login')

        } catch (error) {
            // Foutmelding tonen als er iets mis gaat
            errorToastMessage.value = 'Er is iets misgegaan bij het verwijderen van je account.'

            // Toastmelding na 3 seconden verwijderen
            setTimeout(() => {
                errorToastMessage.value = ''
            }, 3000)
        } 
    }
</script>