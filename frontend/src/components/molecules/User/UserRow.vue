<!-- Molecule: dit bestand bevat één tabelrij (desktop) met gebruikersgegevens en actieknoppen
     of kaart (op kleine schermen)
-->

<template>
    <!-- Grote scherm (desktop) tabelrij -->
    <tr class="hidden md:table-row border border-ocean-twilight hover:bg-ghost-white/60 transition">
        <!-- Gebruikersgegevens -->
        <td class="py-3 px-4 text-base font-medium text-ocean-twilight">
            {{ user.user_id }}
        </td>

        <!-- Volledige naam gebruiker -->
        <td class="py-3 px-4 text-base font-medium text-ocean-twilight">
            {{ user.first_name }}
            <span v-if="user.surname_prefix"> {{ user.surname_prefix }}</span>
            {{ user.last_name }}
        </td>

        <!-- Email -->
        <td class="py-3 px-4 text-base font-medium text-ocean-twilight">
            {{ user.email }}
        </td>

        <!-- Gebruikersrol -->
        <td class="py-3 px-4 text-base font-medium text-ocean-twilight">
            {{ user.role }}
        </td>

        <!-- Actieknoppen -->
        <td class="py-3 px-4">
            <div class="flex flex-wrap gap-2">
                <!-- Bekijken knop -->
                <BaseActionButton
                    :to="`/administrator/dashboard/gebruikersbeheer/gebruiker/${user.user_id}`"
                    label="Bekijken"
                    icon="eye"
                    class="bg-ocean-twilight text-white hover:bg-french-blue transition"
                />

                <!-- Bewerken knop -->
                <BaseActionButton
                    :to="`/administrator/dashboard/gebruikersbeheer/gebruiker/${user.user_id}/bewerken`"
                    label="Bewerken"
                    icon="pencil"
                    class="bg-soft-periwinkle text-white hover:bg-state-indigo transition"
                />

                <!-- Verwijderen knop -->
                <BaseActionButton
                    v-if="!isOwnAccount"
                    :to="`/administrator/dashboard/gebruikersbeheer/gebruiker/${user.user_id}/verwijderen`"
                    label="Verwijderen"
                    icon="trash"
                    class="bg-intense-cherry text-white hover:bg-ruby-red transition"
                />
            </div>
        </td>
    </tr>

    <!-- Kleine scherm (mobiel) kaartweergave -->
    <div class="block md:hidden bg-white rounded-lg shadow-sm border border-gray-200 px-4 pt-5 pb-12 mb-12">
        <!-- Naam groot -->
        <p class="font-semibold text-ocean-twilight text-xl leading-tight mb-3">
            {{ user.first_name }}
            <span v-if="user.surname_prefix"> {{ user.surname_prefix }}</span>
            {{ user.last_name }}
        </p>

        <!-- ID -->
        <p class="text-lg text-dim-grey font-semibold mt-1">
            ID: {{ user.user_id }}
        </p>

        <!-- Email -->
        <p class="text-lg text-ocean-twilight font-semibold mt-2">
            {{ user.email }}
        </p>

        <!-- Gebruikersrol -->
        <p class="text-lg text-ocean-twilight font-semibold mt-3">
            Rol: {{ user.role }}
        </p>

        <!-- Actieknoppen onder elkaar -->
        <div class="mt-5 space-y-3">
            <!-- Bekijken knop -->
                <BaseActionButton
                    :to="`/administrator/dashboard/gebruikersbeheer/gebruiker/${user.user_id}`"
                    label="Bekijken"
                    icon="eye"
                    class="bg-ocean-twilight text-white font-semibold hover:bg-french-blue transition w-full py-2"
                />

                <!-- Bewerken knop -->
                <BaseActionButton
                    :to="`/administrator/dashboard/gebruikersbeheer/gebruiker/${user.user_id}/bewerken`"
                    label="Bewerken"
                    icon="pencil"
                    class="bg-soft-periwinkle text-white font-semibold hover:bg-state-indigo transition w-full py-2"
                />

                <!-- Verwijderen knop -->
                <BaseActionButton
                    v-if="!isOwnAccount"
                    :to="`/administrator/dashboard/gebruikersbeheer/gebruiker/${user.user_id}/verwijderen`"
                    label="Verwijderen"
                    icon="trash"
                    class="bg-intense-cherry text-white font-semibold hover:bg-ruby-red transition w-full py-2"
                />  
        </div>
    </div>
</template>

<script setup>
    // Atoms importeren
    import BaseActionButton from '../../atoms/BaseActionButton.vue'

    // Computed importeren om reactieve berekeningen te maken
    import { computed } from 'vue'

    // AuthenticationStore importeren
    import { useAuthenticationStore } from '../../../stores/authenticationStore.js'

    // AuthenticationStore initialiseren
    const authenticationStore = useAuthenticationStore()

    // Props zijn waardes die van buitenaf aan het component meegegeven worden
    const props = defineProps({
        // Gebruikersobject met alle gegevens voor deze tabelrij
        user: {
            type: Object,
            required: true
        }
    })

    // Controleren of deze rij van de ingelogde administrator is
    const isOwnAccount = computed(() => {
        if (props.user.user_id === authenticationStore.userId)
        {
            return true;
        }

        return false;
    })
</script>