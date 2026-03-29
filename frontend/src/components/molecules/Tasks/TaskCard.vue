<!-- Molecule: dit bestand bevat een herbruikbare Taakkaart
     Het toont de taakgegevens van een student met bewerk en verwijder opties
-->

<template>
    <!-- Vakkaart -->
    <div class="bg-white rounded-xl shadow-sm p-6 flex flex-col gap-3 hover:shadow-xl hover:scale-105 transition-transform duration-200">
        <!-- Naam van de taak met checkbox -->
        <div class="flex items-center gap-3">
            <input type="checkbox" class="w-5 h-5 accent-soft-periwinkle cursor-pointer" />
            <h1 class="text-xl font-semibold text-ocean-twilight">
                {{ taskName }}
            </h1>
        </div>

        <!-- Naam van het vak -->
        <p class="text-lg"><span class="font-medium text-ocean-twilight">Naam van het vak:</span>
            {{ courseName }}
        </p>

        <!-- Beschrijving van de taak -->
        <p class="text-lg"><span class="font-medium text-ocean-twilight">Beschrijving van de taak:</span>
            {{ taskDescription }}
        </p>

        <!-- Studiedatum -->
        <p class="text-lg"><span class="font-medium text-ocean-twilight">Studiedatum:</span>
            {{ date }}
        </p>

        <!-- Tijdsduur van taak -->
        <p class="text-lg"><span class="font-medium text-ocean-twilight">Tijdsduur van taak:</span>
            {{ taskDuration }}
        </p>

        <!-- Knoppen -->
        <div class="flex gap-3 mt-4">
            <!-- Bewerk knop -->
            <BaseButton @click="router.push(`/student/dashboard/mijn-planning/${taskId}/taak-bewerken`)" buttonClass="flex items-center gap-2 px-4 py-2 rounded-lg font-semibold bg-soft-periwinkle text-white hover:bg-ocean-twilight hover:underline transition">
                <Pencil class="w-4 h-4" /> Bewerken
            </BaseButton>

            <!-- Verwijder knop -->
            <BaseButton @click="router.push(`/student/dashboard/mijn-planning/${taskId}/taak-verwijderen`)" buttonClass="flex items-center gap-2 px-4 py-2 rounded-lg font-semibold bg-intense-cherry text-white hover:bg-ruby-red hover:underline transition">
                <Trash2 class="w-4 h-4" /> Verwijderen
            </BaseButton>
        </div>
    </div>
</template>

<script setup>
    // Lucide iconen importeren
    import { Pencil, Trash2 } from 'lucide-vue-next'

    // Atoms (BaseButton) importeren voor verwijder en bewerkknop
    import BaseButton from '../../atoms/BaseButton.vue'

    // useRouter importeren
    import { useRouter } from 'vue-router'

    // UseRouter geeft toegang tot de router om vanuit de code te navigeren naar een andere pagina
    const router = useRouter()

    // Props zijn waardes die van buitenaf aan het component meegegeven worden
    defineProps({
        // Id van de taak om het te kunnen bewerken en verwijderen
        taskId: {
            type: Number,
            required: true
        },

        // Naam van de taak
        taskName: {
            type: String, 
            default: ''
        },

        // Naam van het vak
        courseName: {
            type: String, 
            default: ''
        },

        // Beschrijving van de taak
        taskDescription: {
            type: String,
            default: ''
        },

        // Studiedatum
        date: {
            type: String,
            default: ''
        },

        // Tijdsduur van taak
        taskDuration: {
            type: Number,
            default: ''
        },
    })
</script>