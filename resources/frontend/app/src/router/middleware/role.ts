import {RouteMiddleware} from '@/router/types';
import store from '@/store';

export default function role({next, router, to}: RouteMiddleware) {
  const routeRoles: string[] = to.meta.roles;

  if (!Array.isArray(routeRoles)) {
    throw new Error('Route roles should be an array!');
  }

  if (!routeRoles.some(e => e === store.state.auth.user.role.name)) {
    router.push({
      name: 'cash-register-system'
    });
  }

  return next();
}
