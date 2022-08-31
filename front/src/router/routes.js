import IndexPage from "pages/IndexPage";
import Login from "pages/Login";
import User from "pages/User";
import Producer from "pages/Producer";
import Consultas from "pages/Consultas";
import ProducerSearch from "pages/ProducerSearch";
import ProducerShow from "pages/ProducerShow";
const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: 'login', component: Login },
      { path: '', component: IndexPage,meta: {requiresAuth: true} },
      { path: 'user', component: User,meta: {requiresAuth: true} },
      { path: 'producer', component: Producer,meta: {requiresAuth: true} },
      { path: 'consultas', component: Consultas,meta: {requiresAuth: true} },
      { path: 'producerSearch', component: ProducerSearch,meta: {requiresAuth: true} },

    ]
  },
  { path: '/producerShow/:id', component: ProducerShow },
  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]

export default routes
