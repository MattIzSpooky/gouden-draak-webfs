import {RouteConfig} from 'vue-router';

export const websiteRoutes: RouteConfig[] = [
  {
    path: '',
    name: 'home',
    component: () => import(/* webpackChunkName: "website" */ '@/views/website/Home.vue'),
    meta: {
      title: 'Gouden Draak'
    }
  },
  {
    path: '/menu',
    name: 'menu',
    component: () => import(/* webpackChunkName: "website" */ '@/views/website/Menu.vue'),
    meta: {
      title: 'Gouden Draak - Menu'
    }
  },
  {
    path: '/contact',
    name: 'contact',
    component: () => import(/* webpackChunkName: "website" */ '@/views/website/Contact.vue'),
    meta: {
      title: 'Gouden Draak - Contact'
    }
  },
  {
    path: '/news',
    name: 'news',
    component: () => import(/* webpackChunkName: "website" */ '@/views/website/News.vue'),
    meta: {
      title: 'Gouden Draak - Nieuws'
    }
  }
];
