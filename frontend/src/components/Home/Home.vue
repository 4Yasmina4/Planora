<template>
    <div class="min-h-screen">
        <!-- Hero afbeelding bovenaan -->
        <img :src="heroImage" class="w-full h-96 object-cover" 
             alt="Hero afbeelding van een gele bureau met een groene plant, schrijfgerei, grijzen toetsenbord en muis. Een open lijntjes schrift" />

        <!-- Inhoud onder de hero afbeelding -->
        <div class="text-center px-6 max-w-3xl mx-auto py-16">
            <!-- Titel -->
            <h1 class="text-5xl font-bold text-gray-800 mb-6 leading-tight">
                Studeer slimmer, niet harder.
            </h1>

            <!-- Subtitel -->
            <p class="text-xl text-gray-500 mb-10">
                Plan je vakken, bijhoud je voortgang en werk samen met je studiecoach — alles op één plek. 
            </p>

            <!-- Knoppen -->
            <div class="flex justify-center gap-4">
                <!-- Inlog knop -->
                <router-link to="/login" class="flex items-center gap-2 px-6 py-3 rounded-lg bg-violet-500 text-white font-semibold hover:bg-violet-700 transition">
                    <ArrowRightEndOnRectangleIcon class="w-5 h-5" /> Inloggen
                </router-link>

                <!-- Account aanmaken knop -->
                <router-link to="/register" class="flex items-center gap-2 px-6 py-3 rounded-lg bg-violet-500 text-white font-semibold hover:bg-violet-700 transition">
                    <UserPlusIcon class="w-5 h-5" /> Account aanmaken
                </router-link>

            </div>

        </div>

    </div>

</template>

<script setup>
    // ArrowRightEndOnRectangleIcon en UserPlusIcon importeren uit Heroicons
    import { ArrowRightEndOnRectangleIcon, UserPlusIcon } from '@heroicons/vue/24/solid'

    // Hero afbeeldingen importeren uit de assets map
    import heroImage from '../../assets/images/hero_image.jpg'
</script>