import {RouteConfig} from 'vue-router';
import auth from '@/router/middleware/auth';
import { UserRole } from '@/types/user';
import role from '@/router/middleware/role';

export const menuItemRoutes: RouteConfig[] = [
  {
    path: 'gerechten',
    name: 'dishes',
    component: () => import(/* webpackChunkName: "cash-register-system" */ '@/views/cash-register-system/menu-items/MenuItems.vue'),
    meta: {
      middleware: [auth, role],
      roles: [
        UserRole.ADMIN
      ]
    }
  },
  {
    path: 'gerechten/nieuw',
    name: 'new-dish',
    component: () => import(/* webpackChunkName: "cash-register-system" */ '@/views/cash-register-system/menu-items/NewMenuItem.vue'),
    meta: {
      middleware: [auth, role],
      roles: [
        UserRole.ADMIN
      ]
    }
  },
  {
    path: 'gerecht/:id',
    name: 'edit-dish',
    component: () => import(/* webpackChunkName: "cash-register-system" */ '@/views/cash-register-system/menu-items/UpdateMenuItem.vue'),
    props: true,
    meta: {
      middleware: [auth, role],
      roles: [
        UserRole.ADMIN
      ]
    }
  }
];
