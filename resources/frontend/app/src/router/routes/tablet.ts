import {RouteConfig} from 'vue-router';

export const tabletRoutes: RouteConfig[] = [
  {
    path: '',
    name: 'tables',
    component: () => import(/* webpackChunkName: "tablet" */ '@/views/tablet/TableList.vue'),
    meta: {
      title: 'Tablet - Tafels'
    }
  },
  {
    path: 'tafel/:id',
    props: true,
    name: 'table',
    component: () => import(/* webpackChunkName: "tablet" */ '@/views/tablet/Table.vue'),
    meta: {
      title: 'Tablet - Tafel'
    }
  },
  {
    path: 'tafel/:id/bestellen',
    props: true,
    name: 'new-order',
    component: () => import(/* webpackChunkName: "tablet" */ '@/views/tablet/Order.vue'),
    meta: {
      title: 'Tablet - Bestellen'
    }
  },
  {
    path: '*',
    redirect: {
      name: 'tables'
    }
  }
];
