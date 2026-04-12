<!-- Page: dit bestand bevat de mijn vakken pagina
     Het combineert de StudentNavbar en CourseList organisms
     Wordt gebruikt als de mijn vakken pagina van de student
-->

<template>
    <!-- Studentnavbar -->
    <StudentNavbar />

    <div class="min-h-screen bg-ghost-white flex flex-col px-4 pt-16">
        <div class="max-w-4xl w-full mx-auto">
            <!-- Titel + vak toevoegen knop -->
            <div class="flex items-center justify-between mb-12">
                <!-- Titel -->
                <h1 class="text-3xl font-semibold text-ocean-twilight">Mijn vakken</h1>

                <!-- Vak toevoegen knop -->
                <RouterLink to="/student/dashboard/mijn-vakken/vak-toevoegen" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-mint-leaf text-white font-semibold hover:bg-hunter-green hover:underline transition">
                    <Plus class="w-5 h-5" /> Vak toevoegen
                </RouterLink>
            </div>
            
            <!-- CourseList organism -->
            <CourseList />
        </div>
    </div>

    <!-- Toastsuccesmelding -->
    <Toast :toastMessage="successToastMessage" type="success" />
</template>

<script setup>
    // Ref importeren uit Vue
    // Ref: om reactieve variabelen te maken
    import { ref, onMounted } from 'vue';

    // Lucide icons importeren
    import { Plus } from 'lucide-vue-next'

    // StudentNavbar organism importeren
    import StudentNavbar from '../../../../components/organisms/Navbar/StudentNavbar.vue'

    // CourseList organism importeren
    import CourseList from '../../../../components/organisms/Course/CourseList.vue'

    // Toast component importern uit de Base map
    import Toast from '../../../../components/Base/Toast/Toast.vue'

    // Helperfunctie importeren om toastmelding na 3 seconden te verwijderen
    import { clearToastMessage } from '../../../../utils/toast.js'

    // Succes toastmelding 
    const successToastMessage = ref('')


    // onMounted wordt uitgevoerd zodra het component volledig geladen is in de browser
    onMounted(() => {
        // Controleren of er een succesmelding is na het aanmaken van een vak
        if (localStorage.getItem('courseSuccess'))
        {
            successToastMessage.value = `${localStorage.getItem('courseSuccess')} is succesvol aangemaakt!`
            localStorage.removeItem('courseSuccess')
            clearToastMessage(successToastMessage)
        }

        // Controleren of er een succesmelding is na het verwijderen van een vak
        if (localStorage.getItem('courseDeleteSuccess'))
        {
            successToastMessage.value = `${localStorage.getItem('courseDeleteSuccess')} is succesvol verwijderd!`
            localStorage.removeItem('courseDeleteSuccess')
            clearToastMessage(successToastMessage)
        }

        // Controleren of er een succesmelding is na het bewerken van een vak
        if (localStorage.getItem('courseEditSuccess'))
        {
            successToastMessage.value = `${localStorage.getItem('courseEditSuccess')} is succesvol bewerkt!`
            localStorage.removeItem('courseEditSuccess')
            clearToastMessage(successToastMessage)
        }
    })
</script>