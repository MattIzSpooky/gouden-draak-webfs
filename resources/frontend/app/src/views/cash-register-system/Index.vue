<template>
  <cash-register-page>
    <transition name="fade" mode="out-in">
      <router-view/>
    </transition>
  </cash-register-page>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import CashRegisterPage from '@/components/cash-register-system/CashRegisterPage.vue';

@Component({
  components: {
    CashRegisterPage
  }
})
export default class Index extends Vue {
};
</script>

<style scoped lang="scss">
  @import "~bootstrap";
  @import '~bootstrap-vue/src/index.scss';

  .fade-enter-active,
  .fade-leave-active {
    transition-duration: 0.3s;
    transition-property: opacity;
    transition-timing-function: ease;
  }

  .fade-enter,
  .fade-leave-active {
    opacity: 0
  }
</style>
