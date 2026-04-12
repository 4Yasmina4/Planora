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

    return { userId, userRole, setUser, clearUser }
})