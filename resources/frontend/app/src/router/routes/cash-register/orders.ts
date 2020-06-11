import {RouteConfig} from 'vue-router';
import auth from '@/router/middleware/auth';

export const orderRoutes: RouteConfig[] = [
  {
    path: 'verkoop-overzicht',
    name: 'order-overview',
    component: () => import(/* webpackChunkName: "cash-register-system" */ '@/views/cash-register-system/orders/OrderOverview.vue'),
    meta: {
      middleware: [auth]
    }
  },
  {
    path: 'bestellingen',
    name: 'orders',
    component: () => import(/* webpackChunkName: "cash-register-system" */ '@/views/cash-register-system/orders/Orders.vue'),
    meta: {
      middleware: [auth]
    }
  },
  {
    path: 'bestelling/:id',
    name: 'order-detail',
    component: () => import(/* webpackChunkName: "cash-register-system" */ '@/views/cash-register-system/orders/OrderDetail.vue'),
    meta: {
      middleware: [auth]
    },
    props: true
  }
];
