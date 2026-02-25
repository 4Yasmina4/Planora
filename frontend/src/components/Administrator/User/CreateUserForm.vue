<template>
    <div>
        <h2>Nieuwe gebruiker aanmaken</h2>

        <!-- Formulier veld -->
        <form>
            <!-- Voornaam -->
            <label>Voornaam</label>
            <input type="text" placeholder="Voer een voornaam in" required/>

            <!-- Tussenvoegsel -->
            <label>Tussenvoegsel</label>
            <input type="text" placeholder="Voer een tussenvoegsel in" />

            <!-- Achternaam -->
            <label>Achternaam</label>
            <input type="text" placeholder="Voer een achternaam in" required/>

            <!-- Email -->
            <label>Email</label>
            <input type="email" placeholder="Voer een email in" required/>

            <!-- Wachtwoord -->
            <label>Wachtwoord</label>
            <input type="password" placeholder="Voer een wachtwoord in" required/>

            <!-- Gebruikersrol -->
            <label>- Gebruikersrol -</label>
            <select required>
                <option value="" disabled selected >Kies een gebruikersrol</option>
                <option value="student">Student</option>
                <option value="administrator">Administrator</option>
            </select>

            <!-- Opslaan knop -->
            <button type="submit">Gebruiker aanmaken</button>
        </form>
    </div>
</template>

<script setup>

</script>