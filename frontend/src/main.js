// De globale CSS stijlen importeren voor de hele applicatie
import './assets/main.css'

// createApp importeren uit Vue om een nieuwe Vue applicatie aan te maken
import { createApp } from 'vue'

// createRouter importeren om de router aan te maken
// createWebHistory importeren om nettere URLs te gebruiken zonder # teken
// Bijvoorbeeld /users in plaats van /#/users
import { createRouter, createWebHistory } from 'vue-router'

// App.vue importeren - dit is het hoofdcomponent van de applicatie
import App from './App.vue'

// createPinia importeren om de Pinia store aan te maken
import { createPinia } from 'pinia'

// Componenten importeren
// Home //
import HomePage from './components/pages/Home/HomePage.vue'

// Authentication //
import LoginPage from './components/pages/Authentication/LoginPage.vue'
import RegisterPage from './components/pages/Authentication/RegisterPage.vue'

// Administrator //
// User
import UserListPage from './components/pages/User/UserListPage.vue'
import CreateUserPage from './components/pages/User/CreateUserPage.vue'
import UserDetailsPage from './components/pages/User/UserDetailsPage.vue'
import EditUserPage from './components/pages/User/EditUserPage.vue'
import DeleteUserPage from './components/pages/User/DeleteUserPage.vue'
// Dashboard
import AdministratorDashboardPage from './components/pages/Administrator/Dashboard/AdministratorDashboardPage.vue'
// Voortgang
import StudentProgressOverviewPage from './components/pages/Administrator/Progress/StudentProgressOverviewPage.vue'

// Student //
// Dashboard
import StudentDashboardPage from './components/pages/Student/Dashboard/StudentDashboardPage.vue'
// Vakken
import CoursesPage from './components/pages/Student/Course/CoursesPage.vue'
import CreateCoursePage from './components/pages/Student/Course/CreateCoursePage.vue'
import DeleteCoursePage from './components/pages/Student/Course/DeleteCoursePage.vue'
import EditCoursePage from './components/pages/Student/Course/EditCoursePage.vue'
// Taken
import MyPlanningPage from './components/pages/Student/Task/MyPlanningPage.vue'
import CreateTaskPage from './components/pages/Student/Task/CreateTaskPage.vue'
import DeleteTaskPage from './components/pages/Student/Task/DeleteTaskPage.vue'
import EditTaskPage from './components/pages/Student/Task/EditTaskPage.vue'
// Voortgang
import ProgressPage from './components/pages/Student/Progress/ProgressPage.vue'
// Instellingen
import SettingsPage from './components/pages/Student/Settings/SettingsPage.vue'


import { useAuthenticationStore } from './stores/authenticationStore'

// Routes defineren
const routes = [
    // Home //
    { path: '/', component: HomePage },
    // Authentication //
    { path: '/login', component: LoginPage },
    { path: '/register', component: RegisterPage },
    // Users //
    { path: '/administrator/dashboard/gebruikersbeheer', component: UserListPage },
    { path: '/administrator/dashboard/gebruikersbeheer/gebruiker/aanmaken', component: CreateUserPage },
    { path: '/administrator/dashboard/gebruikersbeheer/gebruiker/:id', component: UserDetailsPage },
    { path: '/administrator/dashboard/gebruikersbeheer/gebruiker/:id/bewerken', component: EditUserPage },
    { path: '/administrator/dashboard/gebruikersbeheer/gebruiker/:id/verwijderen', component: DeleteUserPage },
    // Administrator //
    // Dashboard
    { path: '/administrator/dashboard', component: AdministratorDashboardPage },
    // Voortgang
    { path: '/administrator/dashboard/studenten-voortgang', component: StudentProgressOverviewPage },
    // Student //
    // Dashboard
    { path: '/student/dashboard', component: StudentDashboardPage },
    // Vakken
    { path: '/student/dashboard/mijn-vakken', component: CoursesPage},
    { path: '/student/dashboard/mijn-vakken/vak-toevoegen', component: CreateCoursePage},
    { path: '/student/dashboard/mijn-vakken/:id/vak-verwijderen', component: DeleteCoursePage},
    { path: '/student/dashboard/mijn-vakken/:id/vak-bewerken', component: EditCoursePage },
    // Taken
    { path: '/student/dashboard/mijn-planning', component: MyPlanningPage},
    { path: '/student/dashboard/planning-maken', component: CreateTaskPage},
    { path: '/student/dashboard/mijn-planning/:id/taak-verwijderen', component: DeleteTaskPage },
    { path: '/student/dashboard/mijn-planning/:id/taak-bewerken', component: EditTaskPage },
    // Planning
    { path: '/student/dashboard/voortgang', component: ProgressPage },
    // ProfielInstellingen
    { path: '/student/dashboard/profielinstellingen', component: SettingsPage }
]

// Router aanmaken
const router = createRouter({
    history: createWebHistory(),
    routes
})

// App aanmaken, router toevoegen en mounten (koppelen aan het HTML element met id="app")
const app = createApp(App)
app.use(createPinia())
app.use(router)

// Authentication store initialiseren vanuit JWT token
const authenticationStore = useAuthenticationStore()
authenticationStore.initilizeAuthenticationStoreFromJwtToken()

app.mount('#app')