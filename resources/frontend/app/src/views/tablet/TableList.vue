<template>
  <loader>
    <div class="row justify-content-center">
      <b-card class="col-md-3 m-3" v-for="table in tables" :key="table.id" @click="onTableClick(table)">
        <b-card-text class="my-auto">{{table.name}}</b-card-text>
      </b-card>
    </div>
  </loader>
</template>

<script lang="ts">
import axios from 'axios';
import {Component, Vue} from 'vue-property-decorator';
import store from '@/store/index';
import {ApiResource} from '@/types/api';
import Loader from '@/components/cash-register-system/common/Loader.vue';
import {Table} from '@/types/table';
import {BCard, BCardText} from 'bootstrap-vue';
import {mapActions} from 'vuex';

  @Component({
    components: {
      Loader,
      BCard,
      BCardText
    },
    methods: {
      ...mapActions({
        updateTable: 'tablet/updateTable'
      })
    },
    async beforeRouteEnter(to, _, next) {
      await store.commit('network/SET_LOADING', true);
      const response = await axios.get<ApiResource<Table[]>>('/api/table');

      const tables = response.data;

      next(async (vm: TableList) => {
        vm.tables = tables.data;

        await vm.$store.commit('network/SET_LOADING', false);
      });
    }
  })
export default class TableList extends Vue {
    public tables: Table[] = [];
    updateTable!: (table: Table) => void;
    async onTableClick(table: Table) {
      this.updateTable(table);

      await this.$router.push({
        name: 'table',
        params: {
          id: table.id.toString()
        }
      });
    }
};
</script>

<style scoped lang="scss">
  .card {
    height: 8rem;

    &-body {
      display: flex;
      justify-content: center;
    }

    &:hover {
      cursor: pointer;
    }
  }
</style>
