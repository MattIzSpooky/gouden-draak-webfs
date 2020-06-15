import {RouteConfig} from 'vue-router';
import auth from '@/router/middleware/auth';
import { UserRole } from '@/types/user';

export const newsRoutes: RouteConfig[] = [
  {
    path: 'nieuws',
    name: 'news-kassa',
    component: () => import(/* webpackChunkName: "cash-register-system" */ '@/views/cash-register-system/news/News.vue'),
    meta: {
      middleware: [auth],
      roles: [
        UserRole.ADMIN
      ]
    }
  },
  {
    path: 'nieuws/nieuw',
    name: 'new-news',
    component: () => import(/* webpackChunkName: "cash-register-system" */ '@/views/cash-register-system/news/NewNews.vue'),
    meta: {
      middleware: [auth],
      roles: [
        UserRole.ADMIN
      ]
    }
  },
  {
    path: 'nieuws/:id',
    name: 'edit-news',
    component: () => import(/* webpackChunkName: "cash-register-system" */ '@/views/cash-register-system/news/UpdateNews.vue'),
    meta: {
      middleware: [auth],
      roles: [
        UserRole.ADMIN
      ]
    },
    props: true
  }
];
