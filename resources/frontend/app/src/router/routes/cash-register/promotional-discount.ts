import {RouteConfig} from 'vue-router/types/router';
import auth from '@/router/middleware/auth';
import { UserRole } from '@/types/user';
import role from '@/router/middleware/role';

export const promotionalDiscountRoutes: RouteConfig[] = [
  {
    path: 'acties',
    name: 'promotional-discounts',
    component: () => import(/* webpackChunkName: "cash-register-system" */ '@/views/cash-register-system/promotional-discounts/PromotionalDiscounts.vue'),
    meta: {
      middleware: [auth, role],
      roles: [
        UserRole.ADMIN, UserRole.WAITRESS
      ]
    }
  },
  {
    path: 'actie/nieuw',
    name: 'new-promotional-discount',
    component: () => import(/* webpackChunkName: "cash-register-system" */ '@/views/cash-register-system/promotional-discounts/NewDiscount.vue'),
    meta: {
      middleware: [auth, role],
      roles: [
        UserRole.ADMIN, UserRole.WAITRESS
      ]
    }
  },
  {
    path: 'actie/:id',
    name: 'edit-promotional-discount',
    component: () => import(/* webpackChunkName: "cash-register-system" */ '@/views/cash-register-system/promotional-discounts/UpdateDiscount.vue'),
    meta: {
      middleware: [auth, role],
      roles: [
        UserRole.ADMIN, UserRole.WAITRESS
      ]
    },
    props: true
  }
];
