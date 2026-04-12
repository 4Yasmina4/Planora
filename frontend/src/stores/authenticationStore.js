// Store voor ingelogde gebruiker
import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useAuthenticationStore = defineStore('auth', () => {
    // Ingelogde gebruiker's ID en gebruikersrol
    const userId = ref(null)
    const userRole = ref(null)

    // Gebruikersgegevens instellen na het inloggen
    function setUser(id, role) {
        userId.value = id
        userRole.value = role
    }

    // Gebruikersgegevens verwijderen na het uitloggen
    function clearUser() {
        userId.value = null
        userRole.value = null
    }

    // Store initialiseren vanuit JWT token in de localStorage
    // Wordt aangeroepen bij het laden van de applicatie
    function initilizeAuthenticationStoreFromJwtToken() {
        const jwtToken = localStorage.getItem('token')

        if (!jwtToken)
        {
            return;
        }

        // JWT token decoderen om gebruikersgegevens op te halen
        const payload = JSON.parse(atob(jwtToken.split('.')[ 1 ]))
        userId.value = payload.user_id
        userRole.value = payload.role
    }

    return { userId, userRole, setUser, clearUser, initilizeAuthenticationStoreFromJwtToken }
})