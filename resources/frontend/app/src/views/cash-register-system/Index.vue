<template>
  <cash-register-page>
    <router-view></router-view>
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
