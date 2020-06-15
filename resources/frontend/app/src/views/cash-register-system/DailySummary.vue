<template>
  <loader>
    <div class="row justify-content-center">
      <div v-if="paginatedData" class="col-md-5">
        <div class="card m-3">
          <div class="card-header">
            Samenvattingen
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item p-3" v-for="(itemObject, index) in paginatedData.data" :key="index">
               <button @click="download(itemObject)" class="btn btn-secondary btn-lg btn-block" :href="fileUrl + itemObject.id" target="_blank">{{ itemObject.date }}</button>
            </li>
          </ul>
          <div class="card-footer">
            <button v-if="paginatedData.links.prev" type="button" class="btn btn-primary" @click="previousPage">
            vorige
            </button>
            <button v-if="paginatedData.links.next" type="button" class="btn btn-primary" @click="nextPage">
            volgende            </button>
            <small>
            Huidige pagina: {{paginatedData.meta.current_page}}
            </small>
            <small>
            Laatste pagina: {{paginatedData.meta.last_page}}
            </small>
          </div>
        </div>
      </div>
    </div>
  </loader>
</template>

<script lang="ts">
import axios from 'axios';
import store from '@/store/index';
import { Summary } from '@/types/summary';
import { Component } from 'vue-property-decorator';
import Loader from '@/components/cash-register-system/common/Loader.vue';
import {Paginated} from '@/types/paginated';
import {mixins} from 'vue-class-component';
import {PaginationMixin} from '@/mixins/Pagination';

  @Component({
    components: {
      Loader
    },
    async beforeRouteEnter(to, _, next) {
      await store.commit('network/SET_LOADING', true);

      const response = await axios.get<Paginated<Summary>>('api/summary');
      const summaries = response.data;

      next(async (vm: DailySummary) => {
        vm.paginatedData = summaries;

        await vm.$store.commit('network/SET_LOADING', false);
      });
    }
  })
export default class DailySummary extends mixins<PaginationMixin<Summary>>(PaginationMixin) {
    public readonly routeName = 'summaries';

    get fileUrl() {
      return axios.defaults.baseURL + 'api/summary/';
    }

    async download(summary: Summary) {
      await this.$store.commit('network/SET_LOADING', true);

      const response = await axios.get<Summary>(`api/summary/${summary.id}`, { responseType: 'arraybuffer' });
      const blob = new Blob([response.data as unknown as BlobPart], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
      const url = window.URL.createObjectURL(blob);

      const a = document.createElement('a');
      a.href = url;
      a.download = summary.file;
      a.click();
      window.URL.revokeObjectURL(url);

      this.$store.commit('network/SET_LOADING', false);
    }
};
</script>
