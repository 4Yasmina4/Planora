// Dit bestand maakt een aangepaste axios instantie aan die automatisch JWT token 
// meestuurt met elk verzoek naar de backend
import axios from "axios";

// apiClient is een aangepaste axios instantie met een vaste basis URL en JWT token
// Hierdoor hoef je niet bij elk verzoek de volledige URL en token opnieuw in te stellen
const apiClient = axios.create({
    // Basis URL instellen voor alle verzoeken naar de backend
    baseURL: 'http://localhost'
})

// Interceptor wordt uigevoerd bij elk verzoek voordat het naar de backend wordt gestuurd
// Interceptor die automatisch de JWT token meestuurt met elk verzoek
apiClient.interceptors.request.use((config) => {
    // JWT token ophalen uit localStorage
    // localStorage is een opslagplek in de browser die data bewaart ook na het herladen van de pagina
    const jwtToken = localStorage.getItem('token')

    // Als er een token is, deze toevoegen aan de Authorization header
    // De Authorization header vertelt de backend wie de ingelogde gebruiker is
    if (jwtToken)
    {
        config.headers.Authorization = `Bearer ${jwtToken}`
    }

    // Verzoek met de toegevoegde Authorization header teruggeven, zodat axios het kan versturen
    return config
})

// apiClient beschikbaar maken voor andere bestanden
export default apiClient