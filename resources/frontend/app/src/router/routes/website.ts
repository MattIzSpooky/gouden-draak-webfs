import {RouteConfig} from 'vue-router';

export const websiteRoutes: RouteConfig[] = [
  {
    path: '',
    name: 'home',
    component: () => import(/* webpackChunkName: "website" */ '@/views/website/Home.vue')
  },
  {
    path: '/menu',
    name: 'menu',
    component: () => import(/* webpackChunkName: "website" */ '@/views/website/Menu.vue')
  },
  {
    path: '/contact',
    name: 'contact',
    component: () => import(/* webpackChunkName: "website" */ '@/views/website/Contact.vue')
  },
  {
    path: '/news',
    name: 'news',
    component: () => import(/* webpackChunkName: "website" */ '@/views/website/News.vue')
  }
];
