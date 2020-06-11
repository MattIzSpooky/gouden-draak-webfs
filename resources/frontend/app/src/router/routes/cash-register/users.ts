import {RouteConfig} from 'vue-router';
import auth from '@/router/middleware/auth';

export const userRoutes: RouteConfig[] = [{
  path: 'gebruikers',
  name: 'users',
  component: () => import(/* webpackChunkName: "cash-register-system" */ '@/views/cash-register-system/users/Users.vue'),
  meta: {
    middleware: [auth]
  }
},
{
  path: 'gebruiker/nieuw',
  name: 'new-user',
  component: () => import(/* webpackChunkName: "cash-register-system" */ '@/views/cash-register-system/users/NewUser.vue'),
  meta: {
    middleware: [auth]
  }
},
{
  path: 'gebruiker/:id',
  name: 'edit-user',
  component: () => import(/* webpackChunkName: "cash-register-system" */ '@/views/cash-register-system/users/UpdateUser.vue'),
  meta: {
    middleware: [auth]
  },
  props: true
}
];