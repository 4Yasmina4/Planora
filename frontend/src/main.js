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

// Componenten importeren
// Home //
import Home from './components/Home/Home.vue'

// Authentication //
import LoginPage from './pages/Authentication/LoginPage.vue'
import RegisterPage from './pages/Authentication/RegisterPage.vue'

// Administrator //
// User
import UserListPage from './pages/User/UserListPage.vue'
import CreateUserPage from './pages/User/CreateUserPage.vue'
import UserDetail from './components/Administrator/User/UserDetail.vue'
import EditUserPage from './pages/User/EditUserPage.vue'
import DeleteUser from './components/Administrator/User/DeleteUser.vue'
// Dashboard
import AdministratorDashboardPage from './pages/Administrator/Dashboard/AdministratorDashboardPage.vue'

// Student //
// Dashboard
import StudentDashboardPage from './pages/Student/Dashboard/StudentDashboardPage.vue'
// Vakken
import CoursesPage from './pages/Student/Courses/CoursesPage.vue'
import CreateCoursePage from './pages/Student/Courses/CreateCoursePage.vue'
import DeleteCoursePage from './pages/Student/Courses/DeleteCoursePage.vue'
import EditCoursePage from './pages/Student/Courses/EditCoursePage.vue'
// Taken
import MyPlanningPage from './pages/Student/Tasks/MyPlanningPage.vue'
import CreateTaskPage from './pages/Student/Tasks/CreateTaskPage.vue'
import DeleteTaskPage from './pages/Student/Tasks/DeleteTaskPage.vue'
import EditTaskPage from './pages/Student/Tasks/EditTaskPage.vue'
// Planning
import ProgressPage from './pages/Student/Progress/ProgressPage.vue'

// Routes defineren
const routes = [
    // Home //
    { path: '/', component: Home },
    // Authentication //
    { path: '/login', component: LoginPage },
    { path: '/register', component: RegisterPage },
    // Users //
    { path: '/administrator/dashboard/gebruikersbeheer', component: UserListPage },
    { path: '/administrator/dashboard/gebruikersbeheer/gebruiker/aanmaken', component: CreateUserPage },
    { path: '/users/:id', component: UserDetail },
    { path: '/administrator/dashboard/gebruikersbeheer/gebruiker/:id/bewerken', component: EditUserPage },
    { path: '/users/:id/delete', component: DeleteUser },
    // Administrator //
    // Dashboard
    { path: '/administrator/dashboard', component: AdministratorDashboardPage },
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
    { path: '/student/dashboard/voortgang/', component: ProgressPage }
]

// Router aanmaken
const router = createRouter({
    history: createWebHistory(),
    routes
})

// App aanmaken, router toevoegen en mounten (koppelen aan het HTML element met id="app")
const app = createApp(App)
app.use(router)
app.mount('#app')