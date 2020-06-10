<template>
  <div class="marquee">
    <p>
      {{text}}
    </p>
  </div>
</template>

<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';

  @Component
export default class NeoMarquee extends Vue {
    @Prop(String) public readonly text!: string;
};
</script>

<style scoped lang="scss">
  .marquee {
    height: 50px;
    overflow: hidden;
    position: relative;
    color: yellow;
    font-weight: bold;
    text-decoration: none;

    p {
      position: absolute;
      width: 100%;
      height: 100%;
      animation: scroll-left 20s linear infinite;
      text-align: center;
      white-space: nowrap;
    }

    @keyframes scroll-left {
      0% {
        transform: translateX(100%);
      }
      100% {
        transform: translateX(-100%);
      }
    }
  }
</style>
