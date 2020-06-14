import VueRouter, {Route} from 'vue-router';
import {RawLocation} from 'vue-router/types/router';
import Vue, {Component} from 'vue';

export type RouterContext = {
  from: Route;
  next: RouteNext;
  router: VueRouter;
  to: Route;
}

export type RouteNext = (to?: RawLocation | false | ((vm: Vue) => Component) | void) => void;

export type RouteMiddleware = {
  to: Route;
  next: RouteNext;
  router: VueRouter;
}

export type RouteMiddlewareFunc = (objects: RouteMiddleware) => void;
