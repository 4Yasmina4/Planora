// Hulpfunctie om de ingelogde gebruiker's ID op te halen uit de JWT token
export function getLoggedInUserId() {
    // JWT token ophalen uit localStorage
    const jwtToken = localStorage.getItem('token')

    if (!jwtToken)
    {
        return null;
    }

    // JWT token bestaat uit 3 delen gescheiden door punten
    // Het tweede deel (payload) bevat de gebruikersgegevens
    const payload = JSON.parse(atob(jwtToken.split('.')[ 1 ]))
    return payload.user_id
}