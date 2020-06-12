<template>
  <div class="card">
    <div class="card-header">
      Zoeken
    </div>
    <div class="card-body">
      <form action="#" @submit.prevent="onSubmit">
        <div class="form-group">
          <input type="text" required v-model="search" class="form-control" id="search">
          <small class="text-danger" v-if="noResults">
            Er waren geen resultaten gevonden.
          </small>
        </div>
        <button type="submit" class="btn btn-primary">Zoeken</button>
        <slot></slot>
      </form>
    </div>
  </div>
</template>

<script lang="ts">
import {Component, Emit, Vue} from 'vue-property-decorator';
import axios from 'axios';
import {ApiResource} from '@/types/api';
import {MenuItemsGroupedWithType} from '@/types/menu-item';

@Component
export default class MenuItemSearch extends Vue {
  public search = '';
  public noResults = false;

  @Emit('onSearch')
  public async onSubmit() {
    const response = await axios.get<ApiResource<MenuItemsGroupedWithType[]>>(`/api/menu/filter?query=${this.search}`);
    const data = response.data.data;

    this.noResults = data.length === 0;

    return data;
  }
}
</script>
