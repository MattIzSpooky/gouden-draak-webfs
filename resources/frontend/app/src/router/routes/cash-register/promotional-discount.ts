import {RouteConfig} from 'vue-router/types/router';
import auth from '@/router/middleware/auth';
import { UserRole } from '@/types/user';

export const promotionalDiscountRoutes: RouteConfig[] = [
  {
    path: 'acties',
    name: 'promotional-discounts',
    component: () => import(/* webpackChunkName: "cash-register-system" */ '@/views/cash-register-system/promotional-discounts/PromotionalDiscounts.vue'),
    meta: {
      middleware: [auth],
      roles: [
        UserRole.ADMIN, UserRole.WAITRESS
      ],
      title: 'Kassa - Acties'
    }
  },
  {
    path: 'actie/nieuw',
    name: 'new-promotional-discount',
    component: () => import(/* webpackChunkName: "cash-register-system" */ '@/views/cash-register-system/promotional-discounts/NewDiscount.vue'),
    meta: {
      middleware: [auth],
      roles: [
        UserRole.ADMIN, UserRole.WAITRESS
      ],
      title: 'Kassa - Nieuwe actie'
    }
  },
  {
    path: 'actie/:id',
    name: 'edit-promotional-discount',
    component: () => import(/* webpackChunkName: "cash-register-system" */ '@/views/cash-register-system/promotional-discounts/UpdateDiscount.vue'),
    meta: {
      middleware: [auth],
      roles: [
        UserRole.ADMIN, UserRole.WAITRESS
      ],
      title: 'Kassa - Actie bewerken'
    },
    props: true
  }
];
