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
    component: () => import(/* webpackChunkName: "login" */ '../views/cash-register-system/Login.vue')
  },
  {
    path: '/kassa',
    name: 'cash-register-system',
    component: () => import(/* webpackChunkName: "cash-register-system" */ '../views/cash-register-system/Index.vue'),
    meta: {
      middleware: [auth]
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
