<template>
  <div>
    <h5 class="card-title">
    {{ $t('step') }}
      <b>1</b>/
      <span class="small">3</span> {{ $t('TYPE OF WORK AND DEADLINE') }}
    </h5>
    <hr />
    <div>
      
    </div>
    <div class="form-group">
      <label>{{ $t('Service Category') }}</label>
              <div class="service_category">
       <div class="base"  v-for="item in service_categories" :key="item"
        @click="setServices3(item,item.id,item.worklevel)" :class="[active_services == item.id? 'active':'']">
         <input class="option-input" :id="`d${item.id}`" type="radio" name="options" style="opacity:0" 
          :value="item" v-model="form.service_categories_model"  @change="setServices" />
          <label class="bg" :for="`d${item.id}`"
          :label="item.name" type="radio" name="service_categories" >
           {{item.name[locale] }} 

          </label>
      </div>
      </div>
    </div>
    <div class="form-group" >
      <label>{{ $t('Service Type') }}</label>
      <!-- <multiselect
        track-by="id"
        label="name"
        v-model="form.service_model"
        :options="filteredServices"
        @input="getAdditionalServices(form.service_model)"
      ></multiselect> -->
      <details class="dropdown">
    <summary role="button">
      <a class="button">{{form.service_model.name[locale]}}</a>
      <i class="fas fa-caret-down"></i> 
    </summary>
    <ul>
      <li @click="getAdditionalServices(form.service_model);setServicesType(item)"
      v-for="item in filteredServices" :key="item"
      >
          <a href="#" :class="[form.service_model.id == item.id? 'active':'']">{{item.name[locale]}}</a>
          </li>
  </ul>
</details>
    </div>
    <div class="form-group" v-if="show_worklevel">
      <label>{{ $t('Work Level') }}</label>
      <div>
        <div class="btn-group btn-group-toggle flex-wrap" data-toggle="buttons">
          <label
            class="btn btn-outline-primary"
            v-on:click="workLevelChanged(row.id, index)"
            :class="form.work_level_id === Number(row.id) ? 'active': ''"
            v-for="(row,index) in filteredlevels"
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
            {{ row.name[locale] }}
          </label>
        </div>
        
      </div>
    </div>
        <hr />
        <div>

        </div>

        <div class="form-row" v-if="form.service_model.price_type_id == pricingTypes.perPage">
            <div class="form-group col-md-4">
                <label>{{ $t('Number of pages') }}</label>
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
                  {{ $t('Spacing') }} 
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
                <label>{{ $t('Number of Words') }}</label>
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
                <label>{{ $t('Urgency') }}</label>
                <multiselect track-by="id" label="name" v-model="form.urgency_model" :options="filteredurgency"></multiselect>
            </div>
        </div>

        <div v-if="additional_services.length > 0">
            <h5>{{ $t('Additional Services') }}</h5>
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
                    <i class="fas fa-check-circle"></i>{{ $t('Added') }} 
                  </span>
                                    <span v-else>
                    <i class="fas fa-plus"></i> {{ $t('Add') }} 
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
                v-on:click.prevent="changeTab(2)">
                <i class="fas fa-arrow-circle-right"></i>{{ $t('Next') }} 
            </button>
        </div>
       
        <div v-else>
            <button
                type="button"
                class="btn btn-success btn-lg btn-block"
                v-on:click.prevent="changeTab(2)"
            >
                <i class="fas fa-sign-in-alt"></i>{{ $t('Sign in to place your order') }}  
            </button>

            <a :href="create_account_url" class="btn btn btn-info btn-lg btn-block">
                <i class="fas fa-user-plus"></i> {{ $t('Create account') }}  
            </a>
            <a :href="quest_order_url" class="btn btn  btn-lg btn-block" style="background:#3969c6;color:#fff">
                <i class="fas fa-user-plus"></i> {{ $t('Continue as Quest') }}  
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
                return 5;
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
        },
        quest_order_url: {
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
          const locale = localStorage.getItem('locale') || 'ar';
        return {
            locale:locale,
            lev:false,
            urgen:false,
            passParam:false,
            params : {},
            hasError:false,
            show_worklevel:true,
            active_services: this.passParam == true ?  this.filteredServices_categories[0].id : this.service_categories[0].id,
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
        filteredServices_categories() {
            if (this.passParam == true) {
                return this.service_categories.filter((el) => {
                    return el.id == this.params.Service_Category;
                });
            }
        },
        filteredlevels() {
            if (this.lev == true) {
                return this.levels.filter((el) => {
                    return el.id == this.params.work_level;
                });
            }
            else {
                return this.levels;
            }
        },
        filteredurgency() {
            if (this.urgen == true) {
                return this.urgencies.filter((el) => {
                    return el.id == this.params.urgency;
                });
            }
            else {
                return this.urgencies;
            }
        },
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
    mounted(){
        window.location.search.slice(1).split('&').forEach(elm => {
            if (elm === '') return;
            let spl = elm.split('=');
            const d = decodeURIComponent;
            this.params[d(spl[0])] = (spl.length >= 2 ? d(spl[1]) : true);
        });

        if(this.params == {}){
            this.passParam = false;
            this.active_services = this.service_categories[0].id;
            
        }
        if(typeof(this.params.work_level) == 'string'){
               this.lev = true;
               this.form.work_level_model = this.filteredlevels[0];
               this.form.work_level_id = this.filteredlevels[0].id;
        }
        if(typeof(this.params.urgency) == 'string'){
               this.urgen = true;
               this.form.urgency_model = this.filteredurgency[0];
        }
        if(typeof(this.params.pages) == 'string'){
          
               this.form.number_of_pages = this.params.pages;
        }
        if(typeof(this.params.spacing_type) == 'string'){
               this.form.spacing_type = this.params.spacing_type;
        }
        if(typeof(this.params.words) == 'string'){
               this.form.number_of_words = this.params.words;
        }
        else{
            this.passParam = true;
            this.form.service_categories_model =  this.filteredServices_categories[0];
            this.active_services = this.filteredServices_categories[0].id;
        }
        console.log('params:',this.params);
        console.log('spacing_type:',this.form.spacing_type);
        // console.log('filteredlevels:',this.filteredlevels);
        // console.log('passParam:',this.passParam);
        // console.log('service_categories:',this.service_categories);
        // console.log('services:',this.services);
        // console.log('service_categories_model:',this.form.service_categories_model);
        // console.log('service_model:',this.form.service_model);
        // console.log('filteredServices_categories:',this.filteredServices_categories);
        // console.log('filteredServices:',this.filteredServices);
    },
    methods: {
        setServicesType(t){
            this.form.service_model = t;
        },
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
        font: 700 16px sans-serif;
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
/* Follow me for more pens like this! */

/* Tweak to change the look and feel */


/* Boring button styles */
a.button {
  /* Frame */
  display: inline-block;
  padding: 3px 15px;
  border-radius: 5px;
  box-sizing: border-box;
  
  /* Style */
  border: none;
  background: #fff;
  color: #5e6e7e;
  font-size: 18px;
  cursor: pointer;
}

a.button:active {
  filter: brightness(75%);
}

/* Dropdown styles */
.dropdown {
  position: relative;
  padding: 0;
  height: 40px;
  border: 1px solid rgb(236, 236, 236);
  border-radius: 5px;
}
/* Dropdown triangle */

.dropdown summary {
  list-style: none;
  list-style-type: none;
  position: relative;
}
.dropdown summary i {
    position: absolute;
    right: 14px;
    top: 10px;
    color: #999999;
}
.dropdown > summary::-webkit-details-marker {
  display: none;
}

.dropdown summary:focus {
  outline: none;
}

.dropdown summary:focus a.button {
  border: 2px solid white;
}

.dropdown summary:focus {
  outline: none;
}

.dropdown ul {
  position: absolute;
  margin: 20px 0 0 0;
  padding:  0;
  width: 100%;
  height: 215px;
  overflow-y: scroll;
  left: 0;
  top: 42px;
  margin: 0;
  box-sizing: border-box;
  z-index: 3;
  border: 1px solid rgb(236, 236, 236);
  background: #fff;
  border-radius: 5px;
  list-style: none;
}

.dropdown ul li {
  padding: 0;
  margin: 0;
}

.dropdown ul li a:link, .dropdown ul li a:visited {
  display: inline-block;
  padding: 6px 0.8rem;
  width: 100%;
  box-sizing: border-box;
  
  color: black;
  text-decoration: none;
}

.dropdown ul li a:hover {
  background-color: #2caf72;
  color: #fff;
}
.dropdown ul li a.active:hover {
  background-color: #fa4f61;
  color: #fff;
}
/* Close the dropdown with outside clicks */
.dropdown > summary::before {
  display: none;
}

.dropdown[open] > summary::before {
    content: ' ';
    display: block;
    position: fixed;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    z-index: 1;
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
