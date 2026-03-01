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
// Administrator - User //
import UserList from './components/Administrator/User/UserList.vue'
import CreateUserForm from './components/Administrator/User/CreateUserForm.vue'
import UserDetail from './components/Administrator/User/UserDetail.vue'
import UpdateUserForm from './components/Administrator/User/UpdateUserForm.vue'
import DeleteUser from './components/Administrator/User/DeleteUser.vue'

// Routes defineren
const routes = [
    { path: '/', redirect: '/users' },
    { path: '/users', component: UserList },
    { path: '/users/create', component: CreateUserForm },
    { path: '/users/:id', component: UserDetail },
    { path: '/users/:id/edit', component: UpdateUserForm },
    { path: '/users/:id/delete', component: DeleteUser },
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