<template>
  <ul class="navbar-nav m-auto">
    <li class="nav-item">
<!--      Link i guess-->
<!--      <router-link class="nav-link" :to="{name: link.routeName}">{{link.shownName}}</router-link>-->
    </li>
    <slot></slot>
  </ul>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';

  @Component
export default class TabletLinks extends Vue {
};
</script>

<style scoped>

</style>
