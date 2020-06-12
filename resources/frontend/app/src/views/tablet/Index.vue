<template>
  <transition name="fade" mode="out-in">
    <router-view/>
  </transition>
</template>

<script>
export default {
  name: 'Index'
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
