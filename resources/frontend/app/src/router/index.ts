import Vue from 'vue';
import VueRouter, {RouteConfig} from 'vue-router';
import Home from '../views/website/Home.vue';
import Menu from '../views/website/Menu.vue';
import Contact from '@/views/website/Contact.vue';
import News from '@/views/website/News.vue';
import auth from '@/router/middleware/auth';
import {RouteMiddlewareFunc, RouteNext, RouterContext} from '@/router/types';

Vue.use(VueRouter);

const routes: Array<RouteConfig> = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/menu',
    name: 'menu',
    component: Menu
  },
  {
    path: '/contact',
    name: 'contact',
    component: Contact
  },
  {
    path: '/news',
    name: 'news',
    component: News
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
          middleware: [auth]
        }
      },
      {
        path: 'gerechten',
        name: 'dishes',
        component: () => import(/* webpackChunkName: "cash-register-system" */ '../views/cash-register-system/menu-items/MenuItems.vue'),
        meta: {
          middleware: [auth]
        }
      },
      {
        path: 'gerechten/nieuw',
        name: 'new-dish',
        component: () => import(/* webpackChunkName: "cash-register-system" */ '../views/cash-register-system/menu-items/NewMenuItem.vue'),
        meta: {
          middleware: [auth]
        }
      },
      {
        path: 'gerecht/:id',
        name: 'edit-dish',
        component: () => import(/* webpackChunkName: "cash-register-system" */ '../views/cash-register-system/menu-items/UpdateMenuItem.vue'),
        props: true,
        meta: {
          middleware: [auth]
        }
      },
      {
        path: 'gebruikers',
        name: 'users',
        component: () => import(/* webpackChunkName: "cash-register-system" */ '../views/cash-register-system/users/Users.vue'),
        meta: {
          middleware: [auth]
        }
      },
      {
        path: 'gebruiker/nieuw',
        name: 'new-user',
        component: () => import(/* webpackChunkName: "cash-register-system" */ '../views/cash-register-system/users/NewUser.vue'),
        meta: {
          middleware: [auth]
        }
      },
      {
        path: 'gebruiker/:id',
        name: 'edit-user',
        component: () => import(/* webpackChunkName: "cash-register-system" */ '../views/cash-register-system/users/UpdateUser.vue'),
        meta: {
          middleware: [auth]
        }
      },
      {
        path: 'nieuws',
        name: 'news-kassa',
        component: () => import(/* webpackChunkName: "cash-register-system" */ '../views/cash-register-system/news/News.vue'),
        meta: {
          middleware: [auth]
        }
      },
      {
        path: 'nieuws/nieuw',
        name: 'new-news',
        component: () => import(/* webpackChunkName: "cash-register-system" */ '../views/cash-register-system/news/NewNews.vue'),
        meta: {
          middleware: [auth]
        }
      }
    ]
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
    subsequentMiddleware({...context, next: nextMiddleware});
  };
}

router.beforeEach((to, from, next) => {
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

    return middleware[0]({...context, next: nextMiddleware});
  }

  return next();
});

export default router;
