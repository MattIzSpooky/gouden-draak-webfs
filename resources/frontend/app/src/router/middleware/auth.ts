import store from '@/store';
import {RouteMiddleware} from '@/router/types';

export default function auth({next, to, router}: RouteMiddleware) {
  if (store.state.auth.bearerToken === '') {
    return router.push({name: 'login'});
  }

  const routeRoles: string[] = to.meta.roles;

  if (!Array.isArray(routeRoles)) {
    throw new Error('Route roles should be an array!');
  }

  if (!routeRoles.some(e => e === store.state.auth.user.role.name)) {
    return next(false);
  }

  return next();
}
