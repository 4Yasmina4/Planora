<!-- App.vue is het hoofdcomponent van deze Vue applicatie. Het is het eerste component dat geladen wordt tijdens
     het opstarten van deze applicatie in de browser. --> 
<template>
    <div>
        <!-- CreateUserForm component renderen op deze plek. Vue zet de code om naar iets wat de browser kan zien -->
        <CreateUserForm  />
        <UserList  />
    </div>
</template>

<script setup>
    // CreateUserForm component importeren zodat het gebruikt kan worden in de template.
    // Zonder deze import weet Vue niet wat CreateUserForm is.
    import CreateUserForm from './components/Administrator/User/CreateUserForm.vue'
    import UserList from './components/Administrator/User/UserList.vue'

</script>