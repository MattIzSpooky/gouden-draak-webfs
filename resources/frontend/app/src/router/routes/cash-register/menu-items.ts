import {RouteConfig} from 'vue-router';
import auth from '@/router/middleware/auth';

export const menuItemRoutes: RouteConfig[] = [
  {
    path: 'gerechten',
    name: 'dishes',
    component: () => import(/* webpackChunkName: "cash-register-system" */ '@/views/cash-register-system/menu-items/MenuItems.vue'),
    meta: {
      middleware: [auth]
    }
  },
  {
    path: 'gerechten/nieuw',
    name: 'new-dish',
    component: () => import(/* webpackChunkName: "cash-register-system" */ '@/views/cash-register-system/menu-items/NewMenuItem.vue'),
    meta: {
      middleware: [auth]
    }
  },
  {
    path: 'gerecht/:id',
    name: 'edit-dish',
    component: () => import(/* webpackChunkName: "cash-register-system" */ '@/views/cash-register-system/menu-items/UpdateMenuItem.vue'),
    props: true,
    meta: {
      middleware: [auth]
    }
  }
];
