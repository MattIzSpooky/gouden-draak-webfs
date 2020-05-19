import Vue from 'vue';
import VueRouter, { RouteConfig } from 'vue-router';
import Home from '../views/website/Home.vue';
import Menu from '../views/website/Menu.vue';
import SignIn from '../views/website/SignIn.vue';
import Contact from '@/views/website/Contact.vue';
import News from '@/views/website/News.vue';

Vue.use(VueRouter);

const routes: Array<RouteConfig> = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/menu',
    name: 'menu',
    component: Menu
  },
  {
    path: '/contact',
    name: 'contact',
    component: Contact
  },
  {
    path: '/news',
    name: 'news',
    component: News
  },
  {
    path: '/signin',
    name: 'SignIn',
    component: SignIn
  },
  {
    path: '/about',
    name: 'About',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/website/About.vue')
  }
];

const router = new VueRouter({
  mode: 'history',
  base: '/',
  routes
});

export default router;
