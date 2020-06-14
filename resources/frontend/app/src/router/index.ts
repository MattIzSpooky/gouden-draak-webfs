import Vue from 'vue';
import VueRouter, { RouteConfig } from 'vue-router';
import auth from '@/router/middleware/auth';
import {RouteMiddlewareFunc, RouteNext, RouterContext} from '@/router/types';
import {newsRoutes} from '@/router/routes/cash-register/news';
import {orderRoutes} from '@/router/routes/cash-register/orders';
import {userRoutes} from '@/router/routes/cash-register/users';
import {menuItemRoutes} from '@/router/routes/cash-register/menu-items';
import {websiteRoutes} from '@/router/routes/website';
import {promotionalDiscountRoutes} from '@/router/routes/cash-register/promotional-discount';
import {tabletRoutes} from '@/router/routes/tablet';
import role from '@/router/middleware/role';
import {UserRole} from '@/types/user';

Vue.use(VueRouter);

const routes: Array<RouteConfig> = [
  {
    path: '/',
    component: () => import(/* webpackChunkName: "website" */ '../views/website/Index.vue'),
    children: websiteRoutes
  },
  {
    path: '/login',
    name: 'login',
    component: () => import(/* webpackChunkName: "cash-register-system" */ '../views/cash-register-system/Login.vue')
  },
  {
    path: '/kassa',
    component: () => import(/* webpackChunkName: "cash-register-system" */ '../views/cash-register-system/Index.vue'),
    meta: {
      middleware: [auth]
    },
    children: [
      {
        path: '',
        name: 'cash-register-system',
        component: () => import(/* webpackChunkName: "cash-register-system" */ '../views/cash-register-system/CashRegister.vue'),
        meta: {
          middleware: [auth, role],
          roles: [
            UserRole.ADMIN, UserRole.REGISTER, UserRole.WAITRESS
          ]
        }
      },
      {
        path: 'samenvattingen',
        name: 'summaries',
        component: () => import(/* webpackChunkName: "cash-register-system" */ '../views/cash-register-system/DailySummary.vue'),
        meta: {
          middleware: [auth, role],
          roles: [
            UserRole.ADMIN
          ]
        }
      },
      ...menuItemRoutes,
      ...userRoutes,
      ...newsRoutes,
      ...orderRoutes,
      ...promotionalDiscountRoutes,
      {
        path: '*',
        redirect: {
          name: 'cash-register-system'
        }
      }
    ]
  },
  {
    path: '/tablet',
    component: () => import(/* webpackChunkName: "tablet" */ '../views/tablet/Index.vue'),
    children: tabletRoutes
  },
  {
    path: '*',
    redirect: {
      name: 'home'
    }
  }
];

const router = new VueRouter({
  mode: 'history',
  base: '/',
  routes
});

function nextFactory(context: RouterContext, middleware: Array<RouteMiddlewareFunc>, index: number): RouteNext {
  const subsequentMiddleware = middleware[index];
  if (!subsequentMiddleware) {
    return context.next;
  }

  return (...parameters) => {
    context.next(...parameters);

    const nextMiddleware = nextFactory(context, middleware, index + 1);
    subsequentMiddleware({ ...context, next: nextMiddleware });
  };
}

router.beforeEach(async (to, from, next) => {
  if (to.meta.middleware) {
    const middleware = Array.isArray(to.meta.middleware)
      ? to.meta.middleware
      : [to.meta.middleware];

    const context: RouterContext = {
      from,
      next,
      router,
      to
    };
    const nextMiddleware = nextFactory(context, middleware, 1);

    return await middleware[0]({ ...context, next: nextMiddleware });
  }

  return next();
});

export default router;
