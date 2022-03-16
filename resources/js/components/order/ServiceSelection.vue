<template>
  <div>
    <h5 class="card-title">
      Step
      <b>1</b>/
      <span class="small">3</span> TYPE OF WORK AND DEADLINE
    </h5>
    <hr />
    <div class="form-group">
      <label>Service Category</label>
              <div class="service_category">
       <div class="base"  v-for="(item,index) in service_categories" :key="index"
        @click="setServices3(item,index,item.worklevel)" :class="[active_services == index? 'active':'']">
         <input class="option-input" :id="`d${item.id}`" type="radio" name="options" style="opacity:0" 
          :value="item" v-model="form.service_categories_model"  @change="setServices" />
          <label class="bg" :for="`d${item.id}`"
          :label="item.name" type="radio" name="service_categories" >
            {{item.name}}
          </label>
      </div>
      </div>
    </div>
    <div class="form-group" >
      <label>Service Type</label>
      <multiselect
        track-by="id"
        label="name"
        v-model="form.service_model"
        :options="filteredServices"
        @input="getAdditionalServices(form.service_model)"
      ></multiselect>
    </div>
    <div class="form-group" v-if="show_worklevel">
      <label>Work Level</label>
      <div>
        <div class="btn-group btn-group-toggle flex-wrap" data-toggle="buttons">
          <label
            class="btn btn-outline-primary"
            v-on:click="workLevelChanged(row.id, index)"
            :class="form.work_level_id === Number(row.id) ? 'active': ''"
            v-for="(row,index) in levels"
            :key="index"
          >
            <input
              type="radio"
              class="btn-group-toggle"
              :id="'workLevel_' + index"
              :value="row.id"
              autocomplete="off"
              v-model="form.work_level_id"
            />
            {{ row.name }}
          </label>
        </div>
      </div>
    </div>  

    <div class="form-row" v-if="form.service_model.price_type_id == pricingTypes.perPage">
      <div class="form-group col-md-4">
        <label>Number of pages</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <button
              type="button"
              class="btn btn-outline-secondary"
              v-on:click="changePageNumber(-1)"
            >-</button>
          </div>
          <input
            type="text"
            class="form-control text-center"
            aria-describedby="basic-addon1"
            v-model="form.number_of_pages"
            v-on:keypress="isNumber($event)"
            @change="validateNumberOfPages"
          />
          <div class="input-group-append">
            <div class="input-group-prepend">
              <button
                type="button"
                class="btn btn-outline-secondary"
                v-on:click="changePageNumber(1)"
              >+</button>
            </div>
          </div>
        </div>
        <div class="invalid-feedback d-block" v-if="errors.number_of_pages">{{ errors.number_of_pages[0] }}</div>
      </div>
      <div class="form-group col-md-8">
        <label>
          Spacing
          <span
            data-toggle="tooltip"
            title="Single-spaced - The final paper will have one line spacing between lines."
          >
            <i class="fas fa-question-circle"></i>
          </span>
        </label>
        <div>
          <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label
              v-for="row in spacings"
              class="btn btn-outline-pink"
              v-on:click="spacingTypeChanged(row.id)"
              :class="form.spacing_type == row.id ? 'active': ''"
              :key="row.id"
            >
              <input
                type="radio"
                class="btn-group-toggle"
                :id="'spacing_' + row.id"
                :value="row.id"
                autocomplete="off"
                v-model="form.spacing_type"
              />
              {{ row.name }}
            </label>
          </div>
        </div>
      </div>
    </div>
    <div class="form-row">
      <div
        class="form-group col-md-6"
        v-if="form.service_model.price_type_id == pricingTypes.perWord"
      >
        <label>Number of Words</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <button
              type="button"
              class="btn btn-outline-secondary"
              v-on:click="changeNumberOfWords(-20)"
            >-</button>
          </div>
          <input
            type="text"
            class="form-control text-center"
            aria-describedby="basic-addon1"
            v-model="form.number_of_words"
            v-on:keypress="isNumber($event)"
            @change="validateNumberOfWords"
          />
          <div class="input-group-append">
            <div class="input-group-prepend">
              <button
                type="button"
                class="btn btn-outline-secondary"
                v-on:click="changeNumberOfWords(20)"
              >+</button>
            </div>
          </div>
        </div>       
        <div class="invalid-feedback d-block" v-if="errors.number_of_words">{{ errors.number_of_words[0] }}</div>
      </div>

      <div
        class="form-group"
        v-bind:class="{ 'col-md-6': (form.service_model.price_type_id == pricingTypes.perWord), 'col-md-12': (form.service_model.price_type_id != pricingTypes.perWord) }"
      >
        <label>Urgency</label>
        <multiselect track-by="id" label="name" v-model="form.urgency_model" :options="urgencies"></multiselect>
      </div>
    </div>

    <div v-if="additional_services.length > 0">
      <h5>Additional Services</h5>
      <div class="card mb-3" v-for="row in additional_services" v-bind:key="row.id">
        <div class="row no-gutters">
          <div class="col-md-8">
            <div class="card-body">
              <h5 class="card-title">{{ row.name }}</h5>
              <p class="card-text">{{ row.description }}</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="d-flex justify-content-center" style="margin-top: 40px;">
              <a href="#" v-on:click.prevent="additionalServiceChanged(row.id, row)">
                <div class="btn btn-block" v-bind:class="getServiceContainerClass(row.id)">
                  <span v-if="addedServiceList(row.id)">
                    <i class="fas fa-check-circle"></i> Added
                  </span>
                  <span v-else>
                    <i class="fas fa-plus"></i> Add
                  </span>
                  {{ row.rate | formatMoney }}
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-if="user_id">  
      <button
        :disabled="hasError"   
        type="button"
        class="btn btn-success btn-lg btn-block"
        v-on:click.prevent="changeTab(2)"
      >
        <i class="fas fa-arrow-circle-right"></i> Next
      </button>
    </div>
    <div v-else>
      <button          
        type="button"
        class="btn btn-success btn-lg btn-block"
        v-on:click.prevent="changeTab(2)"
      >
        <i class="fas fa-sign-in-alt"></i> Sign in to place your order
      </button>

      <a :href="create_account_url" class="btn btn btn-info btn-lg btn-block">
        <i class="fas fa-user-plus"></i> Create account
      </a>
    </div>
  </div>
</template>

<script>
import Multiselect from "vue-multiselect";

export default {
  components: {
    Multiselect
  },
  props: {    
    pricingTypes: {
      default: {}
    },
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
    additional_services_by_service_id_url: {
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
    }
  },

  filters: {
    formatMoney: function(value) {
      return accounting.formatMoney(value, currencyConfig.currency);
    }
  },
  created() {
    this.triggerChange(this.form);
    this.getAdditionalServices(this.form.service_model);
  },
  watch: {
    form: {
      handler(val) {
        this.triggerChange(val);
      },
      deep: true
    },  
    errors: {
      handler(val) {
        this.checkError(val);
      },
      deep: true
    }   
  },
  data() {
    return {
      hasError:false,
      show_worklevel:true,
      active_services:0,
      errors: {},      
      additional_services: [],
      form: {
        service_model:this.services? this.services[0]: {},
        service_categories_model: this.service_categories ? this.service_categories[0] : {},
        urgency_model: this.urgencies ? this.urgencies[0] : {},
        work_level_model: this.levels ? this.levels[0] : {},
        work_level_id: this.levels ? this.levels[0].id : 1,
        number_of_words: this.services[0].minimum_order_quantity,
        number_of_pages: this.services[0].minimum_order_quantity,
        spacing_type: "double",
        added_services: []
      }
    };
  },
  computed: {
      filteredServices() {
      if (this.form.service_categories_model.length != 0) {
        return this.services.filter((el) => {
          return el.service_category_id == this.form.service_categories_model.id;
        });
      } else {
        return this.services;
      }
    },
  },
  methods: {
    setServices(){
      this.form.service_model = this.filteredServices[0];
    },
    setServices3(itm,ind,wolvl){
      this.form.service_categories_model = itm;
      this.form.service_model = this.filteredServices[0];
      this.active_services = ind;
      if(wolvl == 0){
        this.show_worklevel = false;
      }
      else{
         this.show_worklevel = true;
      }
    },
    checkError(){
      var errorList = JSON.parse(JSON.stringify(this.errors));       
      this.hasError = (Object.keys(errorList).length > 0) ? true : false ;
    },
    triggerChange(form) {
      this.$emit("dataChanged", form);
    },
    formatMoneyFromNumber($amount) {
      return accounting.formatMoney($amount, currencyConfig.currency);
    },
    workLevelChanged(work_level_id, index) {
      this.form.work_level_model = this.levels[index];

      this.form.work_level_id = work_level_id;
    },
    spacingTypeChanged(type) {
      this.form.spacing_type = type;
    },

    changePageNumber(changeByValue) {
      var changeByValue = parseInt(changeByValue);
      var number_of_pages = parseInt(this.form.number_of_pages);
      if (number_of_pages == 0 && changeByValue < 1) {
        return false;
      }
      if (!Number.isInteger(changeByValue)) {
        return false;
      }
      this.form.number_of_pages = number_of_pages + changeByValue;
      this.validateNumberOfPages();
    },
    changeNumberOfWords(changeByValue) {
      var changeByValue = parseInt(changeByValue);
      var number_of_words = parseInt(this.form.number_of_words);

      if (number_of_words == 0 && changeByValue < 1) {
        return false;
      }
      this.form.number_of_words = number_of_words + changeByValue;  
      this.validateNumberOfWords();    
    },
    validateNumberOfWords(){
      if(this.form.number_of_words < this.form.service_model.minimum_order_quantity)
      {
        var minimum_order_quantity = this.form.service_model.minimum_order_quantity;
        this.$set(this.errors, "number_of_words", ['Minium order quantity is ' + minimum_order_quantity]);         
      }
      else
      {
        this.$delete(this.errors, 'number_of_words');
      }
      this.$delete(this.errors, 'number_of_pages');
    },
    validateNumberOfPages(){
      if(this.form.number_of_pages < this.form.service_model.minimum_order_quantity)
      {
        var minimum_order_quantity = this.form.service_model.minimum_order_quantity;
        this.$set(this.errors, "number_of_pages", ['Minium order quantity is ' + minimum_order_quantity]);         
      }
      else
      {
        this.$delete(this.errors, 'number_of_pages');
      }
      this.$delete(this.errors, 'number_of_words');
    },
    getAdditionalServices(service_model) {

      // Clear the errors
      this.errors = {};     
      // Clear the added services
      this.$set(this.form,'added_services', []);

      var service_id = service_model.id;
      var minimum_order_quantity = service_model.minimum_order_quantity;

      if(service_model.price_type_id == this.pricingTypes.perPage)
      {
        this.form.number_of_pages = minimum_order_quantity;
      }
      else
      {
        this.form.number_of_pages = 1;
      }

      if(service_model.minimum_order_quantity)
      {
        this.form.number_of_words = minimum_order_quantity;
      }
      else
      {
        this.form.number_of_words = 500;
      }
      
      var $scope = this;
      axios.post(this.additional_services_by_service_id_url, {
          service_id: service_id
        })
        .then(function(response) {
          $scope.additional_services = response.data;
        })
        .catch(function(error) {
          alert("Something went wrongs");
        });
    },

    changeTab(tabNumber) {
      this.$emit("changeTab", tabNumber);
    },
    additionalServiceChanged(id, additionalService) {
      var isAlreadyInList = this.addedServiceList(id);

      if (isAlreadyInList) {
        this.form.added_services.splice(isAlreadyInList.key, 1);
      } else {
        this.form.added_services.push(additionalService);
      }
    },
    addedServiceList(id) {
      var status = false;

      $.each(this.form.added_services, function(key, row) {
        if (row.id == id) {
          return (status = { key: key });
        }
      });

      return status;
    },
    getServiceContainerClass(additionalServiceId) {
      return {
        "btn-orange": this.addedServiceList(additionalServiceId),
        "btn-outline-orange": !this.addedServiceList(additionalServiceId)
      };
    },
    isNumber: function(evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if ((charCode > 31 && (charCode < 48 || charCode > 57))) {
        evt.preventDefault();;
      } else {
        return true;
      }
    }
  }
};
</script>
<style lang="scss" scoped>

.service_category{
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
.base {
	position: relative;
	display: grid;
	grid-template-columns: repeat(30, 1fr);
  grid-template-rows: repeat(10, 1fr);
  width: 150px;
  height: 50px;
	border-radius: 0.3rem;
  margin-bottom: 15px;
	color: #fff;
	background: #a9afb0;
  cursor: pointer;
  transition: .3s;
	font: 700 18px sans-serif;
	box-shadow:
		0 1px 2px rgba(0,0,0,0.07), 
		0 2px 4px rgba(0,0,0,0.07), 
		0 4px 8px rgba(0,0,0,0.07), 
		0 8px 16px rgba(0,0,0,0.07),
		0 16px 32px rgba(0,0,0,0.07), 
		0 32px 64px rgba(0,0,0,0.07);
    &:hover{
      background: #5e72e4; 
    }
    &.active{
      background: #5e72e4;
      box-shadow:
		0 8px 16px #5e72e4;

    }
    
}
.bg {
	position: absolute;
	z-index: 10;
	left: 0;
	top: 0;
	display: grid;
	place-content: center;
  width: 100%;
  height: 100%;
	grid-column: 1 / span 30;
  grid-row: 1 / span 10;
	transition: opacity .3s;
	pointer-events: none;
	text-shadow: 0px 2px 5px rgba(0,0,0,.1);
}

}
</style>
<style lang="scss" scoped>
@import "~vue-multiselect/dist/vue-multiselect.min.css";

html {
  scroll-behavior: smooth;
}

@media (prefers-reduced-motion: reduce) {
  html {
    scroll-behavior: auto;
  }
}

input[type="number"] {
  -moz-appearance: textfield;
}

</style>
