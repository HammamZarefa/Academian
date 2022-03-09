<template>
   <div>
      <form>
         <div class="form-group row">
            <label for="colFormLabelLg" class="col-sm-3 col-form-label col-form-label-lg">Type of Service</label>
            <div class="col-sm-9">
               <multiselect
                  track-by="id" label="name" 
                  v-model="service" :options="services" @input="serviceChanged()"></multiselect>
            </div>
         </div>
      </form>
      <table class="table table-hover">
         <thead class="thead-dark">
            <tr>
               <th scope="col" class="text-center">Deadline</th>
               <th scope="col" class="text-center"  v-for="(row,index) in work_levels" :key="index">
                  {{ row.name }}
               </th>
            </tr>
         </thead>
         <tbody>
            <tr  v-for="(row, priceListIndex) in priceList" :key="priceListIndex">
               <th scope="row" class="text-center">{{ row.name }}</th>
               <td v-for="(price, priceIndex) in row.record" :key="priceIndex" class="text-center">
                  {{ currency_symbol }}{{ price }}
               </td>
            </tr>
         </tbody>
      </table>
   </div>
</template>

<script>

import Multiselect from 'vue-multiselect';

export default {
  components: {
    Multiselect,
  },
  props: {
    currency_symbol: {
      default: {},
    },
    services: {
      default: {},
    },
    work_levels: {
      type: Array,
      default() {
        return {};
      },
    },
    pricings: {
      type: Array,
      default() {
        return {};
      },
    },
  },

  data() {
    return {
      service: this.services ? this.services[0] : {},
      priceList: this.pricings ? this.pricings[1] : [],
    };
  },

  methods: {
    serviceChanged() {
      this.priceList = this.pricings[this.service.id];
    }
  }
};

</script>

<style lang="scss" scoped>
@import '~vue-multiselect/dist/vue-multiselect.min.css';

</style>
