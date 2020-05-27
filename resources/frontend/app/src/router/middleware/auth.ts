import store from '@/store';
import {RouteMiddleware} from '@/router/types';

export default function auth({next, router}: RouteMiddleware) {
  // FIXME: fix typing
  // eslint-disable-next-line
  if ((store.state as any).auth.bearerToken === '') {
    return router.push({name: 'login'});
  }

  return next();
}
