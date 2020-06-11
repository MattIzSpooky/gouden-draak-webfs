<template>
   <tr style="padding-top:50px">
     <td style="width: 50px"/>
     <td align="center" style='border:1px solid black;background:floralwhite'>
       <br/>
       <div>
         <h1>
           Acties:
         </h1>
         <div v-for="promotion in promotions" :key="promotion.id">
           <promotions :promotion="promotion"/>
           <hr/>
         </div>
       </div>
     </td>
     <td style="width: 50px"/>
   </tr>
</template>

<script lang="ts">
import axios from 'axios';
import DragonPage from '@/components/website/DragonPage.vue';
import {Component, Vue} from 'vue-property-decorator';
import {transformToDutchDate} from '@/utils/date';
import {ApiResource} from '@/types/api';
import {PromotionalDiscount} from '@/types/promotional-discount';
import Promotions from '@/components/website/Promotions.vue';

  @Component({
    components: {
      Promotions,
      DragonPage
    },
    methods: {
      transformToDutchDate
    },
    async beforeRouteEnter(to, _, next) {
      const response = await axios.get<ApiResource<PromotionalDiscount[]>>('api/promotions');

      next((vm: Home) => {
        vm.promotions = response.data.data;
        console.log(vm.promotions);
      });
    }
  })
export default class Home extends Vue {
    private promotions: PromotionalDiscount[] = [];
}
</script>
