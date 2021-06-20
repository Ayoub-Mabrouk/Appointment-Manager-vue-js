import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import Reserve from '../views/Reserve.vue'
import SignIn from '../views/SignIn.vue'
import Myappointments from '../views/Myappointments.vue'
import Edit from '../views/Edit.vue'
import SignUp from '../views/SignUp.vue'
import SignInbyReference from '../views/SignInbyReference.vue'
import Logout from '../views/Logout.vue'
const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
 
  {
    path: '/reserve',
    name: 'Reserve',
    component: Reserve
  },
  {
    path: '/signin',
    name: 'SignIn',
    component: SignIn
  },
  {
    path: '/SignUp',
    name: 'SignUp',
    component: SignUp
  },
  {
    path: '/Logout',
    name: 'Logout',
    component: Logout
  },
  {
    path: '/SignInbyReference',
    name: 'SignInbyReference',
    component: SignInbyReference
  },
  {
    path: '/Edit',
    name: 'Edit',
    component: Edit
  },
  {
    path: '/Myappointments',
    name: 'Myappointments',
    component: Myappointments
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
