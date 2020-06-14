<template>
  <loader>
    <div class="row justify-content-center">
      <div v-if="summaries" class="col-md-5">
        <div class="card m-3">
          <div class="card-header">
            Samenvattingen
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item p-3" v-for="(itemObject, index) in summaries.data" :key="index">
               <button @click="download(itemObject)" class="btn btn-secondary btn-lg btn-block" :href="fileUrl + itemObject.id" target="_blank">{{ itemObject.date }}</button>
            </li>
          </ul>
          <div class="card-footer">
            <button v-if="summaries.links.prev" type="button" class="btn btn-primary" @click="previousPage">
            vorige
            </button>
            <button v-if="summaries.links.next" type="button" class="btn btn-primary" @click="nextPage">
            volgende            </button>
            <small>
            Huidige pagina: {{summaries.meta.current_page}}
            </small>
            <small>
            Laatste pagina: {{summaries.meta.last_page}}
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
import { Component, Vue } from 'vue-property-decorator';
import Loader from '@/components/cash-register-system/common/Loader.vue';
import {Paginated} from '@/types/paginated';

  @Component({
    components: {
      Loader
    },
    async beforeRouteEnter(to, _, next) {
      await store.commit('network/SET_LOADING', true);

      const response = await axios.get<Paginated<Summary>>('api/summary');
      const summaries = response.data;

      next(async (vm: DailySummary) => {
        vm.summaries = summaries;

        await vm.$store.commit('network/SET_LOADING', false);
      });
    }
  })
export default class DailySummary extends Vue {
    public summaries: Paginated<Summary> | null = null;

    get fileUrl() {
      return axios.defaults.baseURL + 'api/summary/';
    }

    async nextPage() {
      await this.$store.dispatch('network/toggleLoad');
      if (!this.summaries || !this.summaries.links.next) {
        return;
      }

      const response = await axios.get<Paginated<Summary>>(this.summaries.links.next);
      this.summaries = response.data;

      await this.$router.push({name: 'summaries', query: {page: this.summaries.meta.current_page.toString()}});
      await this.$store.dispatch('network/toggleLoad');
    }

    async previousPage() {
      await this.$store.dispatch('network/toggleLoad');
      if (!this.summaries || !this.summaries.links.prev) {
        return;
      }

      const response = await axios.get<Paginated<Summary>>(this.summaries.links.prev);
      this.summaries = response.data;

      await this.$router.push({name: 'summaries', query: {page: this.summaries.meta.current_page.toString()}});
      await this.$store.dispatch('network/toggleLoad');
    }

    async download(summary: Summary) {
      const response = await axios.get<Summary>(`api/summary/${summary.id}`, { responseType: 'arraybuffer' });
      const blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
      const url = window.URL.createObjectURL(blob);

      const a = document.createElement('a');
      a.href = url;
      a.download = summary.file;
      a.click();
      window.URL.revokeObjectURL(url);
    }
};
</script>
