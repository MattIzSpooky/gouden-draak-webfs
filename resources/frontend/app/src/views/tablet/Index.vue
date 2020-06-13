<template>
  <tablet-page>
    <transition name="fade" mode="out-in">
      <router-view/>
    </transition>
  </tablet-page>
</template>

<script>
import TabletPage from '../../components/tablet/TabletPage';

export default {
  name: 'Index',
  components: {TabletPage}
};
</script>

<style lang="scss">
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
