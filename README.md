# Planora
> Een project voor het vak Web Development 2

Planora is een webapplicatie waarmee studenten hun studie kunnen plannen en organiseren. Studenten kunnen vakken toevoegen, studietaken aanmaken en afvinken, en hun studievoortgang per vak inzien. Administrators kunnen de voortgang van alle studenten bekijken en gebruikers beheren.

## Repository
GitHub Repository: [GitHub Repository](https://github.com/4Yasmina4/Planora) of volledige url (https://github.com/4Yasmina4/Planora) 

## Testgegevens

| Rol | E-mailadres | Wachtwoord |
|-----|-------------|------------|
| Administrator | TestAdministrator@outlook.com | TestAdministrator! |
| Student | TestStudent@outlook.com | TestStudent! |
| Student | TestStudent2@outlook.com | TestStudent2 |

## Installatie en opstarten

### Vereisten
- Docker Desktop
- Node.js

### Backend opstarten
1. Navigeer naar de backend map:
```bash
cd backend
```
2. Start de Docker containers:
```bash
docker compose up -d
```

### Frontend opstarten
1. Navigeer naar de frontend map:
```bash
cd frontend
```
2. Installeer de dependencies:
```bash
npm install
```
3. Start de ontwikkelserver:
```bash
npm run dev
```
4. Open de applicatie in je browser via de link die verschijnt in de terminal na het uitvoeren van `npm run dev` (meestal **http://localhost:5173**)

> **Let op:** Als de applicatie niet werkt, controleer dan of Docker Desktop actief is en de backend containers draaien. Start daarna opnieuw `npm run dev` in de frontend map.

## Configuratie

Een `.env` bestand is vereist voor de backend. Dit bestand wordt meegeleverd in de ingeleverde zip-bestand op Moodle.

## Functionaliteiten

### Student
- Vakken toevoegen, bewerken en verwijderen
- Studietaken aanmaken, bewerken, afvinken en verwijderen
- Studievoortgang per vak inzien
- Eigen account verwijderen

### Administrator
- Gebruikers toevoegen, bewerken en verwijderen
- Voortgang van alle studenten inzien
- Gebruikersbeheer

## Technologieën

- **Backend:** PHP met FastRoute, JWT authenticatie
- **Frontend:** Vue.js met Tailwind CSS en Pinia
- **Database:** MySQL
- **Docker** – voor het lokaal draaien van de backend

## Bibliotheken

- **Firebase JWT** – voor het aanmaken en valideren van JWT tokens
- **FastRoute** – voor het afhandelen van HTTP routes in de backend
- **Pinia** – voor state management in de frontend
- **Lucide Vue** – voor iconen in de frontend
- **Axios** – voor HTTP verzoeken vanuit de frontend naar de backend

## Auteur
Yasmina Baalla
Hogeschool Inholland
Web Development 2
