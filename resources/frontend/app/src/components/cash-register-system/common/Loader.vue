<template>
  <div>
    <div v-show="isLoading">
      <div class="full-height container h-100 d-flex justify-content-center">
        <div class="my-auto loader"/>
      </div>
    </div>
    <div v-show="!isLoading">
      <slot/>
    </div>
  </div>
</template>

<script>
import {Component, Vue} from 'vue-property-decorator';
import {mapGetters} from 'vuex';

@Component({
  computed: {
    ...mapGetters({
      isLoading: 'network/isLoading'
    })
  }
})
export default class Loader extends Vue {
};
</script>

<style scoped lang="scss">
  .loader {
    border: 8px solid #f3f3f3;
    border-top: 8px solid #3498db;
    border-radius: 50%;
    width: 120px;
    height: 120px;
    animation: spin 1.3s linear infinite;
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }

  .full-height {
    min-height: 82vh;
  }
</style>
