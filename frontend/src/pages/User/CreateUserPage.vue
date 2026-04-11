<!-- Page: dit bestand bevat het aanmaken van een gebruiker pagina
     Het combineert de AdministratorNavbar en UserForm organisms
-->

<template>
    <!-- Administratornavbar -->
    <AdministratorNavbar />

    <div class="min-h-screen bg-ghost-white flex flex-col items-center px-4 pt-16">
        <div class="max-w-4xl w-full mx-auto">            
            <!-- UserForm organism -->
            <UserForm />
        </div>
    </div>
</template>

<script setup>
    // AdministratorNavbar organism importeren
    import AdministratorNavbar from '../../components/organisms/Navbar/AdministratorNavbar.vue'

    // UserForm organism importeren
    import UserForm from '../../components/organisms/User/UserForm.vue'
</script>