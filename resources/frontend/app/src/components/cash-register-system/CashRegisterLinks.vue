<template>
  <ul class="navbar-nav m-auto">
    <li class="nav-item" v-for="link in links" :key="link.routeName">
      <router-link class="nav-link" :to="{name: link.routeName}">{{link.shownName}}</router-link>
    </li>
    <slot></slot>
  </ul>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';

  @Component
export default class CashRegisterLinks extends Vue {
    public readonly links = [
      {
        routeName: 'cash-register-system',
        shownName: 'Kassa'
      },
      {
        routeName: 'dishes',
        shownName: 'Gerechten'
      },
      {
        routeName: 'users',
        shownName: 'Gebruikers'
      },
      {
        routeName: 'news-kassa',
        shownName: 'Nieuws'
      },
      {
        routeName: 'order-overview',
        shownName: 'Verkoop overzicht'
      },
      {
        routeName: 'summaries',
        shownName: 'Samenvattingen'
      },
      {
        routeName: 'orders',
        shownName: 'Bestellingen'
      },
      {
        routeName: 'promotional-discounts',
        shownName: 'Acties'
      }
    ];
};
</script>
