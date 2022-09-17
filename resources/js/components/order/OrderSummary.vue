<template>
    <div>
        <div class="summary-card">
            <div class="" v-if="!isObjectEmpty(form)">
                <h5 class="card-title pad-20">{{ $t('Order Summary') }}</h5>
                <div class="">
                    <p class="d-flex justify-content-between pad-20 mb-3">
                        <span>{{ $t('Service') }}:</span>
                        <span>  {{ form.service_model.name.en }}</span>
                        <!--<small class="form-text text-muted">{{ form.work_level_model.name }} (Work level)</small>-->
                    </p>
                    <div class="d-flex justify-content-between pad-20 mb-3"> 
                        <span>{{ $t('Urgency') }}:</span> 
                        <span> {{ form.urgency_model.name }}</span>
                    </div>

                    <div v-if="form.service_model.price_type_id == pricingTypes.fixed">
                        <div class="d-flex justify-content-between pad-20">
                            <span>{{ $t('Rate') }}:</span>
                           <span> {{ form.unit_price | formatMoney }}</span>
                        </div>
                    </div>

                    <!--<div v-if="form.service_model.price_type_id == pricingTypes.later">-->
                        <!--&lt;!&ndash;<div>&ndash;&gt;-->
                        <!--&lt;!&ndash;<b>Rate</b>&ndash;&gt;-->
                        <!--&lt;!&ndash;:&ndash;&gt;-->
                        <!--&lt;!&ndash;{{ 0 }}&ndash;&gt;-->
                        <!--&lt;!&ndash;</div>&ndash;&gt;-->
                    <!--</div>-->

                    <div v-if="form.service_model.price_type_id == pricingTypes.perWord">
                        <div class="d-flex justify-content-between pad-20 mb-3">
                            <span>{{ $t('Number of Words') }} :</span>
                           
                           <span> {{ form.number_of_words }}</span>
                        </div>
                        <div class="d-flex justify-content-between pad-20 mb-3">
                            <span>{{ $t('Rate') }}:</span>
                            
                            <span>{{ form.unit_price }}</span>
                        </div>
                    </div>

                    <div v-if="form.service_model.price_type_id == pricingTypes.perPage">
                        <div class="d-flex justify-content-between pad-20">
                            <span>{{ $t('Spacing Type') }}:</span>
                           
                            <span>{{ form.spacing_type }}</span>
                        </div>
                        <div class="d-flex justify-content-between pad-20">
                            <span>{{ $t('Pages') }}:</span>
                            
                         <span>{{ form.number_of_pages }}</span>
                        </div>
                        <div class="d-flex justify-content-between pad-20">
                            <span>{{ $t('Rate') }}:</span>
                           
                            <span>{{ form.unit_price | formatMoney }}</span>
                        </div>
                    </div>
                </div>

                <table class="table table-sm ">
                    <tbody>
                    <tr >
                        <th scope="row" style="width: 30%">{{ $t('Amount') }}</th>
                        <td style="width: 70%;text-align: end !important">{{ form.amount | formatMoney }}</td>
                    </tr>
                    <tr v-if="form.added_services.length > 0 ">
                        <td colspan="2">
                            <div>
                                <div style="font-weight: bold;">{{ $t('Additional Services') }}</div>
                                <div class="row" v-for="row in form.added_services" v-bind:key="row.id">
                                    <div class="col-md-6">
                                        <div style="padding-left: 10px;">{{ row.name }}</div>
                                    </div>
                                    <div class="col-md-6 text-right">{{ row.rate | formatMoney }}</div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="total">
                    <div>{{ $t('Total') }}</div>
                    <div>{{ calculateTotal }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        form: {
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
    data() {
        return {
            pricingTypes: {
                fixed: 1,
                perWord: 2,
                perPage: 3,
                // later: 4
            },
            spacingTypes: {
                double: "double",
                single: "single"
            }
        };
    },
    computed: {
        calculateTotal: function() {
            if (!this.isObjectEmpty(this.form)) {
                var form = this.form;
                var serviceModel = form.service_model;
                var pricingTypes = this.pricingTypes;
                var spacingTypes = this.spacingTypes;
                var workLevelModel = form.work_level_model;
                var urgencyModel = form.urgency_model;
                // When Price Type is fixed
                if (serviceModel.price_type_id == pricingTypes.fixed) {
                    var quantity = 1;
                    var base_price = parseFloat(serviceModel.price);
                }
                // When Price Type is later
                // if (serviceModel.price_type_id == pricingTypes.later) {
                //     var quantity = 1;
                //     var base_price =parseFloat(serviceModel.price);
                // }
                // When Price Type is Per Word
                if (serviceModel.price_type_id == pricingTypes.perWord) {
                    var quantity = parseFloat(form.number_of_words);
                    var base_price = parseFloat(serviceModel.price);
                }
                // When Price Type is based on Number of Pages
                if (serviceModel.price_type_id == pricingTypes.perPage) {
                    if (form.spacing_type == spacingTypes.double) {
                        // If spacing type is double
                        var base_price = parseFloat(serviceModel.double_spacing_price);
                    } else {
                        // If spacing type is single
                        var base_price = parseFloat(serviceModel.single_spacing_price);
                    }
                    var quantity = parseFloat(form.number_of_pages);
                }
                // Calculate Work Level Price
                var work_level_price = this.calculatePercentage(
                    base_price,
                    workLevelModel.percentage_to_add
                );
                // Calculate Urgency Price
                var urgency_price = this.calculatePercentage(
                    base_price,
                    urgencyModel.percentage_to_add
                );
                // Calculate Unit Price
                var unit_price = Number(parseFloat(base_price + work_level_price + urgency_price)).toFixed(2);
                // Amount before including Additional Services
                // if(serviceModel.price_type_id != pricingTypes.later)
                    var amount = (unit_price * quantity).toFixed(2);
                // else
                //     var amount = 1;
                // Calculate Total Price of Additional Services
                let additional_services_cost = _.sumBy(form.added_services, function(row) {
                    return parseFloat(row.rate);
                });
                // Calculate Sub Total  Amount + Additional Services
                var sub_total = (
                    parseFloat(amount) + parseFloat(additional_services_cost)
                ).toFixed(2);
                // Total (work here if you need to add discount option)
                var total = sub_total;
                this.$set(this.form, "service_id", serviceModel.id);
                this.$set(this.form, "urgency_id", urgencyModel.id);
                this.$set(this.form, "urgency_percentage", urgencyModel.percentage_to_add);
                this.$set(this.form, "dead_line", urgencyModel.date);
                this.$set(this.form, "work_level_id", workLevelModel.id);
                this.$set(this.form, "work_level_percentage", workLevelModel.percentage_to_add);
                this.$set(this.form, "base_price", base_price);
                // unit price = base_price + work_level_price + urgency_price
                this.$set(this.form, "unit_price", unit_price);
                this.$set(this.form, "quantity", quantity);
                // amount = unit_price * quantity
                this.$set(this.form, "amount", amount);
                this.$set(this.form, "sub_total", sub_total);
                this.$set(this.form, "total", total);
                this.$set(this.form, "work_level_price", work_level_price);
                this.$set(this.form, "urgency_price", urgency_price);
                var $scope = this;
                Vue.nextTick(function () {
                    var records = Object.assign({}, $scope.form);
                    // Delete the following records before passing
                    delete records['number_of_words'];
                    delete records['number_of_pages'];
                    delete records['service_model'];
                    delete records['urgency_model'];
                    delete records['work_level_model'];
                    $scope.$emit("dataChanged", records);
                });
                return this.formatMoneyFromNumber(total);
            }
        }
    },
    methods: {
        calculatePercentage(basePrice, percentageToAdd) {
            var number = (parseFloat(basePrice) * parseFloat(percentageToAdd)) / 100;
            return Number(parseFloat(number).toFixed(2));
        },
        isObjectEmpty(obj) {
            return Object.keys(obj).length === 0 && obj.constructor === Object;
        },
        formatMoneyFromNumber($amount) {
            return accounting.formatMoney($amount, currencyConfig.currency);
        }
    }
};
</script>
<style lang="scss" scoped>
p{
    margin: 0;
}
span{
    font-weight: 501;
    font-size: 16px;
    line-height: 22px;
    letter-spacing: 0.5px;
    color: #06243E;
}
.summary-card{
    border: 1px solid #87A2B9;
    border-radius: 16px;
    overflow: hidden;
}
.summary-card .card-title{
    font-weight: 600;
    font-size: 24px;
    line-height: 32px;
    color: #06243E;
    margin: 20px 0;
}
.pad-20{
    padding:0 20px;
}
.total{
background-color: #3667BF;
color: #fff;
padding:15px 20px;
display: flex;
justify-content: space-between;
font-weight: 600;
font-size: 24px;
line-height: 32px;
}
table{
    margin: 0;
}
tr{
    background-color: #C4DEF4;
}
tr th ,tr td{
    padding: 10px 20px;
}
</style>