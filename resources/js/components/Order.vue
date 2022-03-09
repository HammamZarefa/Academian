<template>
  <div>
    <form v-on:submit.prevent>
      <div class="row">
        <div class="col-md-7">
          <div class="card">
            <div class="card-body">
              <div v-if="isActiveTab(1)">
                <ServiceSelection
                  :pricingTypes="pricingTypes"
                  :service_categories="service_categories"
                  :services="services"
                  :levels="levels"
                  :urgencies="urgencies"
                  :spacings="spacings"                 
                  :user_id="user_id"
                  :restricted_order_page_url="restricted_order_page_url"                  
                  :create_account_url="create_account_url" 
                  :additional_services_by_service_id_url="additional_services_by_service_id_url"               
                  @changeTab="changeTab($event)"
                  @dataChanged="handleServiceSelection($event)"
                ></ServiceSelection>
              </div>

              <!-- Tab 2 Starts -->
              <div v-if="isActiveTab(2)">
                <Instruction :errors="errors" :term_and_condition_url="term_and_condition_url" :privacy_policy_url="privacy_policy_url" :upload_attachment_url="upload_attachment_url" @changeTab="changeTab($event)" @submitRequest="handleSubmit($event)"></Instruction>
              </div>
              <!-- Tab 2 Ends -->
            </div>
          </div>
        </div>
        <div class="offset-md-1 col-md-4">
          <div class="sticky-top">
            <OrderSummary :form="dataForOrderSummary" @dataChanged="handleCalculatedData($event)"></OrderSummary>           
          </div>
        </div>  
      </div>
    </form>   
  </div>
</template>

<script>
import ServiceSelection from "./order/ServiceSelection.vue";
import Instruction from "./order/Instruction.vue";
import OrderSummary from "./order/OrderSummary.vue";

export default {
  components: {
    ServiceSelection,
    Instruction,
    OrderSummary
  },
  props: {
    services: {
      default: {}
    },
      service_categories: {
          default: {}
      },
    levels: {
      type: Array,
      default() {
        return {};
      }
    },
    urgencies: {
      type: Array,
      default() {
        return {};
      }
    },
    spacings: {
      type: Array,
      default() {
        return {};
      }
    },
    user_id: {
      type: [Boolean, Number],
      default() {
        return null;
      }
    },
    restricted_order_page_url: {
      type: String,
      default() {
        return null;
      }
    },
    upload_attachment_url: {
      type: String,
      default() {
        return null;
      }
    },
    create_account_url: {
      type: String,
      default() {
        return null;
      }
    },
    additional_services_by_service_id_url: {
      type: String,
      default() {
        return null;
      }
    },
    add_to_cart_url: {
      type: String,
      default() {
        return null;
      }
    },
    term_and_condition_url: {
      type: String,
      default() {
        return null;
      }
    },
    privacy_policy_url: {
      type: String,
      default() {
        return null;
      }
    }
  },

  data() {
    return {
      pricingTypes: {
        fixed: 1,
        perWord: 2,
        perPage: 3,
          later:4
      },
      activeTab: 1,      
      form: {},
      dataForOrderSummary : {},      
      errors : {}
    };
  },
  methods: {
     handleServiceSelection($data){
        this.dataForOrderSummary = $data;
     },
     handleCalculatedData($calculatedData){
       this.form = $calculatedData;
     },
     handleSubmit($data){
       var mergedRecords = {...this.form, ...$data};
       this.submitForm(mergedRecords);       
     },
    changeTab(tabNumber) {
      if (tabNumber == 2 && !this.user_id) {
        window.location = this.restricted_order_page_url;
        return false;
      }
      this.activeTab = tabNumber;
      this.$nextTick(() => {
        window.scrollTo(0, 0);
      });
    },
    isActiveTab: function(tab) {
      return this.activeTab == tab;
    },    
    submitForm(formRecords) {
         console.log(formRecords);
      this.errors = [];
      var $scope = this;

      axios
        .post(this.add_to_cart_url, formRecords)
        .then(function(response) {
          if (response.data.redirect_url) {
            window.location.href = response.data.redirect_url;
          } else if (response.data.errors) {
            $scope.errors = response.data.errors;
          } else {
            alert("Something went wrong");
          }
        })
        .catch(function(error) {
          console.log(error);
          alert(error);
        });
    }
  }
};
</script>

