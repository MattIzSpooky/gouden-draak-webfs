<template>
  <ul class="navbar-nav m-auto">
    <li class="nav-item" v-for="link in links" :key="link.routeName">
      <router-link class="nav-link" :to="{name: link.routeName}" v-if="showRoute(link)">{{link.shownName}}</router-link>
    </li>
    <slot></slot>
  </ul>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import store from '@/store';
import {UserRole} from '@/types/user';

type ShownLink = {
  routeName: string;
  shownName: string;
  roles: UserRole[];
}

  @Component
export default class CashRegisterLinks extends Vue {
    public readonly links: ShownLink[] = [
      {
        routeName: 'cash-register-system',
        shownName: 'Kassa',
        roles: [
          UserRole.ADMIN, UserRole.REGISTER, UserRole.WAITRESS
        ]
      },
      {
        routeName: 'dishes',
        shownName: 'Gerechten',
        roles: [
          UserRole.ADMIN
        ]
      },
      {
        routeName: 'users',
        shownName: 'Gebruikers',
        roles: [
          UserRole.ADMIN
        ]
      },
      {
        routeName: 'news-kassa',
        shownName: 'Nieuws',
        roles: [
          UserRole.ADMIN
        ]
      },
      {
        routeName: 'order-overview',
        shownName: 'Verkoop overzicht',
        roles: [
          UserRole.ADMIN
        ]
      },
      {
        routeName: 'summaries',
        shownName: 'Samenvattingen',
        roles: [
          UserRole.ADMIN
        ]
      },
      {
        routeName: 'orders',
        shownName: 'Bestellingen',
        roles: [
          UserRole.ADMIN, UserRole.REGISTER, UserRole.WAITRESS
        ]
      },
      {
        routeName: 'promotional-discounts',
        shownName: 'Acties',
        roles: [
          UserRole.ADMIN, UserRole.WAITRESS
        ]
      }
    ];

    showRoute(links: ShownLink) {
      return links.roles.some(e => e === store.state.auth.user.role.name);
    }
};
</script>
