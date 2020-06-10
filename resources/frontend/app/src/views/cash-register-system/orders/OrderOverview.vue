<template>
  <Loader>
    <div class="row justify-content-center mt-1 p-3">
      <div class="card col-md-4 mr-auto">
        <div class="card-body">
          <form>
            <div class="form-group">
              <label for="from">Begin datum: </label>
              <b-form-datepicker id="from" v-model="overviewRequest.from" :date-format-options="datePickerOptions"
                                 locale="nl"/>
            </div>
            <div class="form-group">
              <label for="to">Eind datum: </label>
              <b-form-datepicker id="to"
                                 v-model="overviewRequest.to"
                                 :date-format-options="datePickerOptions"
                                 :min="overviewRequest.from"
                                 locale="nl"/>
            </div>
          </form>
          <button type="button" role="button" class="btn btn-primary" @click="fetchOverviewData"
                  :disabled="cantFetchData">
            Maak overzicht
          </button>
        </div>
      </div>
      <div class="card col-md-7 ml-5">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <h2> Omzet: €{{totalPrice}}</h2>
            </div>
            <div class="col">
              <h2> BTW: €{{totalPriceTax}}</h2>
            </div>
            <div class="col">
              <h2> excl. BTW: €{{totalPriceWithoutTax}}</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <order-item-list :items="orderedItems"/>
      </div>
    </div>
  </Loader>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import Loader from '@/components/cash-register-system/common/Loader.vue';
import {BFormDatepicker} from 'bootstrap-vue';
import {Order, OrderFilterRequest} from '@/types/order';
import axios from 'axios';
import {ApiResource} from '@/types/api';
import {OrderedMenuItem} from '@/types/menu-item';
import OrderItemList from '@/components/cash-register-system/orders/OrderItemList.vue';
import {calculateTotalPriceOfOrderedMenuItems} from '@/utils/reducers';

  @Component({components: {OrderItemList, Loader, BFormDatepicker}})
export default class OrderOverview extends Vue {
    public overviewRequest: OrderFilterRequest = {
      from: '',
      to: ''
    }

    public orderedItems: OrderedMenuItem[] = [];

    public readonly datePickerOptions = {year: 'numeric', month: 'numeric', day: 'numeric'}

    get cantFetchData() {
      return this.overviewRequest.to === '' && this.overviewRequest.from === '';
    }

    get totalPrice() {
      return (+this.totalPriceWithoutTax / 100 * 121).toFixed(2);
    }

    get totalPriceTax() {
      return (+this.totalPrice / 121 * 21).toFixed(2);
    }

    get totalPriceWithoutTax() {
      return this.orderedItems.reduce(calculateTotalPriceOfOrderedMenuItems, 0).toFixed(2);
    }

    async fetchOverviewData() {
      await this.$store.dispatch('network/toggleLoad');
      const queryOptions: OrderFilterRequest = {
        from: new Date(this.overviewRequest.from).toISOString(),
        to: new Date(this.overviewRequest.from).toISOString()
      };
      const response = await axios.get<ApiResource<Order[]>>(`/api/orders/filter?from=${queryOptions.from}&to=${queryOptions.to}`);
      const menuItems = response.data.data.map(i => i.items).flat();
      this.orderedItems.splice(0, this.orderedItems.length);
      this.orderedItems.push(...menuItems);
      await this.$store.dispatch('network/toggleLoad');
    }
};
</script>
