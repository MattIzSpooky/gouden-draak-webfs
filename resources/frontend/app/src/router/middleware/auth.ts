import store from '@/store';
import {RouteMiddleware} from '@/router/types';

export default function auth({next, router}: RouteMiddleware) {
  if (store.state.auth.bearerToken === '') {
    return router.push({name: 'login'});
  }

  return next();
}
