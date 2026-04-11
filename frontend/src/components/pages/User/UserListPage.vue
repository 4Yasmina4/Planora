<!-- Page: dit bestand toont de volledige gebruikerslijst binnen het administrator dashboard -->

<template>
    <!-- AdministratorNavbar -->
    <AdministratorNavbar />

    <section class="p-6 bg-ghost-white min-h-screen pt-12">
        <!-- Loading spinner -->
        <LoadingSpinner v-if="isLoading" />

        <!-- Alles tonen zodta het laden klaar is -->
        <div v-else>
            <!-- Titel + Gebruiker toevoegen knop -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-semibold text-ocean-twilight">
                    Gebruikersbeheer
                </h1>

                <BaseActionButton 
                    to="/administrator/dashboard/gebruikersbeheer/gebruiker/aanmaken"
                    label="Gebruiker aanmaken"
                    icon="plus"
                    class="bg-mint-leaf text-white hover:bg-hunter-green transition"
                />
            </div>

            <!-- Tabel -->
            <div class="overflow-x-auto bg-white rounded-lg shadow-sm border border-gray-200">
                <table class="w-full border-collapse">
                    <UserTableHeader />

                    <tbody>
                        <UserRow 
                            v-for="user in users"
                            :key="user.user_id"
                            :user="user"
                        />
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Toastsuccesmelding -->
    <Toast :toastMessage="successToastMessage" type="success" />

</template>

<script setup>
    // Ref importeren uit Vue
    // Ref: om reactieve variabelen te maken
    import { ref, onMounted } from 'vue';

    // AdministratorNavbar organism importeren
    import AdministratorNavbar from '../../../components/organisms/Navbar/AdministratorNavbar.vue'

    // Base importeren 
    import LoadingSpinner from '../../../components/atoms/LoadingSpinner.vue'

    // Atom importeren
    import BaseActionButton from '../../../components/atoms/BaseActionButton.vue'

    // Molecules importeren
    import UserTableHeader from '../../../components/molecules/User/UserTableHeader.vue'
    import UserRow from '../../../components/molecules/User/UserRow.vue'

    // Toast component importern uit de Base map
    import Toast from '../../../components/Base/Toast/Toast.vue'

    // Succes- en errortoastmelding 
    const successToastMessage = ref('')
    const errorToastMessage = ref('')

    // Loading state 
    const isLoading = ref(false)

    // State voor gebruikers
    const users = ref([])

    // Aangepaste axios instantie importeren met JWT token interceptor
    // Interceptor zorgt ervoor dat bij elk verzoek de JWT token automatisch wordt toegevoegd
    // Wordt gebruikt voor het vesturen van HTTP verzoeken naar de backend
    import apiClient from '../../../utils/axios.js'


    // onMounted wordt uitgevoerd zodra het component volledig geladen is in de browser
    onMounted(() => {
        // Controleren of er een succesmelding is na het aanmaken van een gebruiker
        if (localStorage.getItem('UserCreateSuccess'))
        {
            successToastMessage.value = `${localStorage.getItem('UserCreateSuccess')} is succesvol aangemaakt!`
            localStorage.removeItem('UserCreateSuccess')

            // Toastmelding na 3 seconden verwijderen
            // setTimeout voert de functie uit na een opgegeven tijd in milliseconden
            // 3000 milliseconden = 3 seconden
            setTimeout(() => {
                successToastMessage.value = ''
            }, 3000)
        }

        // Controleren of er een succesmelding is na het verwijderen van een gebruiker
        if (localStorage.getItem('UserDeleteSuccess'))
        {
            successToastMessage.value = `${localStorage.getItem('UserDeleteSuccess')} is succesvol verwijderd!`
            localStorage.removeItem('UserDeleteSuccess')

            // Toastmelding na 3 seconden verwijderen
            // setTimeout voert de functie uit na een opgegeven tijd in milliseconden
            // 3000 milliseconden = 3 seconden
            setTimeout(() => {
                successToastMessage.value = ''
            }, 3000)
        }

        // Controleren of er een succesmelding is na het bewerken van een gebruiker
        if (localStorage.getItem('UserEditSuccess'))
        {
            successToastMessage.value = `${localStorage.getItem('UserEditSuccess')} is succesvol bewerkt!`
            localStorage.removeItem('UserEditSuccess')

            // Toastmelding na 3 seconden verwijderen
            // setTimeout voert de functie uit na een opgegeven tijd in milliseconden
            // 3000 milliseconden = 3 seconden
            setTimeout(() => {
                successToastMessage.value = ''
            }, 3000)
        }
    })

    // Gebruikers ophalen bij het laden van de pagina
    onMounted(async() => {
        try{
            isLoading.value = true

            const userRespons = await apiClient.get('/users')
            users.value = userRespons.data
        } catch (error) {
            // Foutmelding tonen als er iets fout is gegaan
            errorToastMessage.value = 'Er is iets misgegaan bij het ophalen van de gebruikers.'
        } finally {
            // Finally wordt altijd uitgevoerd, ook al er een fout optreedt
            isLoading.value = false
        }
    })
</script>