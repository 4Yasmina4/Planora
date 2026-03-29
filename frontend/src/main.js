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

// Administrator - User //
import UserList from './components/Administrator/User/UserList.vue'
import CreateUserForm from './components/Administrator/User/CreateUserForm.vue'
import UserDetail from './components/Administrator/User/UserDetail.vue'
import UpdateUserForm from './components/Administrator/User/UpdateUserForm.vue'
import DeleteUser from './components/Administrator/User/DeleteUser.vue'

// Student //
// Dashboard
import StudentDashboardPage from './pages/Student/DashboardPage.vue'
// Courses
import CoursesPage from './pages/Student/Courses/CoursesPage.vue'
import CreateCoursePage from './pages/Student/Courses/CreateCoursePage.vue'
import DeleteCoursePage from './pages/Student/Courses/DeleteCoursePage.vue'
import EditCoursePage from './pages/Student/Courses/EditCoursePage.vue'
// Tasks
import CreateTaskPage from './pages/Student/Tasks/CreateTaskPage.vue'

// Routes defineren
const routes = [
    // Home //
    { path: '/', component: Home },
    // Authentication //
    { path: '/login', component: LoginPage },
    { path: '/register', component: RegisterPage },
    // Users //
    { path: '/users', component: UserList },
    { path: '/users/create', component: CreateUserForm },
    { path: '/users/:id', component: UserDetail },
    { path: '/users/:id/edit', component: UpdateUserForm },
    { path: '/users/:id/delete', component: DeleteUser },
    // Student //
    // Dashboard
    { path: '/student/dashboard', component: StudentDashboardPage },
    // Courses
    { path: '/student/dashboard/mijn-vakken', component: CoursesPage},
    { path: '/student/dashboard/mijn-vakken/vak-toevoegen', component: CreateCoursePage},
    { path: '/student/dashboard/mijn-vakken/:id/vak-verwijderen', component: DeleteCoursePage},
    { path: '/student/dashboard/mijn-vakken/:id/vak-bewerken', component: EditCoursePage },
    // Tasks
    { path: '/student/dashboard/planning-maken/', component: CreateTaskPage}
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