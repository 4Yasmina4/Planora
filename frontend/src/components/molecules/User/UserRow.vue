<!-- Molecule: dit bestand bevat één tabelrij met gebruikersgegevens en actieknoppen
-->

<template>
    <tr class="border border-ocean-twilight hover:bg-ghost-white/60 transition">
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
                    :to="`/administrator/dashboard/gebruikersbeheer/gebruiker/${user.user_id}/wijzigen`"
                    label="Bewerken"
                    icon="pencil"
                    class="bg-soft-periwinkle text-white hover:bg-state-indigo transition"
                />

                <!-- Verwijderen knop -->
                <BaseActionButton
                    :to="`/administrator/dashboard/gebruikersbeheer/gebruiker/${user.user_id}/verwijderen`"
                    label="Verwijderen"
                    icon="trash"
                    class="bg-intense-cherry text-white hover:bg-ruby-red transition"
                />
            </div>
        </td>
    </tr>
</template>

<script setup>
    // Atoms importeren
    import BaseActionButton from '../../atoms/BaseActionButton.vue'

    // Props zijn waardes die van buitenaf aan het component meegegeven worden
    defineProps({
        // Gebruikersobject met alle gegevens voor deze tabelrij
        user: {
            type: Object,
            required: true
        }
    })
</script>