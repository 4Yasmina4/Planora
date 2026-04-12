<!-- Page: dit bestand bevat de mijn taken pagina
     Het combineert de StudentNavbar en TaskList organisms
-->

<template>
    <!-- Studentnavbar -->
    <StudentNavbar />

    <div class="min-h-screen bg-ghost-white flex flex-col px-4 pt-16">
        <div class="max-w-4xl w-full mx-auto">
            <!-- Titel + taak toevoegen knop -->
            <div class="flex items-center justify-between mb-12">
                <!-- Titel -->
                <h1 class="text-3xl font-semibold text-ocean-twilight">Mijn taken</h1>

                <!-- Taak toevoegen knop -->
                <RouterLink to="/student/dashboard/planning-maken" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-mint-leaf text-white font-semibold hover:bg-hunter-green hover:underline transition">
                    <Plus class="w-5 h-5" /> Planning maken
                </RouterLink>
            </div>
            
            <!-- TaskList organism -->
            <TaskList class="mb-12" />
        </div>
    </div>

    <!-- Toastsuccesmelding -->
    <Toast :toastMessage="successToastMessage" type="success" />
</template>

<script setup>
    // Ref importeren uit Vue
    import { ref, onMounted } from 'vue';

    // Lucide icons importeren
    import { Plus } from 'lucide-vue-next'

    // StudentNavbar organism importeren
    import StudentNavbar from '../../../../components/organisms/Navbar/StudentNavbar.vue'

    // TaskList organism importeren
    import TaskList from '../../../../components/organisms/Task/TaskList.vue'

    // Toast component importern uit de Base map
    import Toast from '../../../../components/Base/Toast/Toast.vue'

    // Helperfunctie importeren om toastmelding na 3 seconden te verwijderen
    import { clearToastMessage } from '../../../../utils/toast.js'

    // Succes toastmelding 
    const successToastMessage = ref('')


    // onMounted wordt uitgevoerd zodra het component volledig geladen is in de browser
    onMounted(() => {
        // Controleren of er een succesmelding is na het aanmaken van een taak
        if (localStorage.getItem('taskSuccess'))
        {
            successToastMessage.value = `${localStorage.getItem('taskSuccess')} taak is succesvol aangemaakt!`
            localStorage.removeItem('taskSuccess')
            clearToastMessage(successToastMessage)
        }

        // Controleren of er een succesmelding is na het verwijderen van een taak
        if (localStorage.getItem('taskDeleteSuccess'))
        {
            successToastMessage.value = `${localStorage.getItem('taskDeleteSuccess')} taak is succesvol verwijderd!`
            localStorage.removeItem('taskDeleteSuccess')
            clearToastMessage(successToastMessage)
        }

        // Controleren of er een succesmelding is na het bewerken van een taak
        if (localStorage.getItem('taskEditSuccess'))
        {
            successToastMessage.value = `${localStorage.getItem('taskEditSuccess')} taak is succesvol bewerkt!`
            localStorage.removeItem('taskEditSuccess')
            clearToastMessage(successToastMessage)
        }
    })
</script>