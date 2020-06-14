import {RouteConfig} from 'vue-router';
import auth from '@/router/middleware/auth';
import { UserRole } from '@/types/user';
import role from '@/router/middleware/role';

export const orderRoutes: RouteConfig[] = [
  {
    path: 'verkoop-overzicht',
    name: 'order-overview',
    component: () => import(/* webpackChunkName: "cash-register-system" */ '@/views/cash-register-system/orders/OrderOverview.vue'),
    meta: {
      middleware: [auth, role],
      roles: [
        UserRole.ADMIN, UserRole.REGISTER, UserRole.WAITRESS
      ]
    }
  },
  {
    path: 'bestellingen',
    name: 'orders',
    component: () => import(/* webpackChunkName: "cash-register-system" */ '@/views/cash-register-system/orders/Orders.vue'),
    meta: {
      middleware: [auth, role],
      roles: [
        UserRole.ADMIN, UserRole.REGISTER, UserRole.WAITRESS
      ]
    }
  },
  {
    path: 'bestelling/:id',
    name: 'order-detail',
    component: () => import(/* webpackChunkName: "cash-register-system" */ '@/views/cash-register-system/orders/OrderDetail.vue'),
    meta: {
      middleware: [auth, role],
      roles: [
        UserRole.ADMIN, UserRole.REGISTER, UserRole.WAITRESS
      ]
    },
    props: true
  }
];
