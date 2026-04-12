<!-- Page: dit bestand bevat de homepagina 
     Het combineert de HomeNavbar, de hero afbeelding en HomeDashboardCards
-->

<template>
    <!-- HomeNavbar -->
    <HomeNavbar />

    <div class="min-h-screen bg-ghost-white">
        <!-- Hero afbeelding -->
        <img :src="heroImage" class="w-full h-96 object-cover" alt="Hero afbeelding van een bureau met schrijfgerei" />

        <!-- Inhoud -->
        <div class="text-center px-6 max-w-3xl mx-auto py-16">
            <!-- Titel -->
            <h1 class="text-5xl font-bold text-ocean-twilight mb-6 leading-tight">
                Studeer slimmer, niet harder
            </h1>

            <!-- Subtitel -->
            <p class="text-2xl text-shadow-dim-grey mb-10">
                Plan je vakken en houdt je studievoortang bij op één plek met Planora
            </p>

            <!-- Kaarten -->
            <HomeDashboardCards />
        </div>
    </div>

    <!-- Footer -->
    <Footer />
</template>

<script setup>
    // Organisms importeren
    import HomeNavbar from '../../../components/organisms/Navbar/HomeNavbar.vue'
    import HomeDashboardCards from '../../../components/organisms/Dashboard/HomeDashboardCards.vue'
    import Footer from '../../../components/organisms/Footer/Footer.vue'

    // Hero afbeelding importeren
    import heroImage from '../../../assets/images/hero_image.jpg'
</script>