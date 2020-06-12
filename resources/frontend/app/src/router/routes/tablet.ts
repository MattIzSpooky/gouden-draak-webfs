import {RouteConfig} from 'vue-router';

export const tabletRoutes: RouteConfig[] = [
  {
    path: '',
    name: 'tables',
    component: () => import(/* webpackChunkName: "tablet" */ '@/views/tablet/TableList.vue')
  },
  {
    path: 'tafel/:id',
    props: true,
    name: 'table',
    component: () => import(/* webpackChunkName: "tablet" */ '@/views/tablet/Table.vue')
  },
  {
    path: 'tafel/:id/bestellen',
    props: true,
    name: 'new-order',
    component: () => import(/* webpackChunkName: "tablet" */ '@/views/tablet/Order.vue')
  },
  {
    path: '*',
    redirect: {
      name: 'tables'
    }
  }
];
