<template>
    <b-card-code>
        <validation-observer
            ref="validateRules"
            #default="{ handleSubmit }"
        >
            <b-form
                @submit.prevent="handleSubmit(submitFormData)"
            >
                <b-row>
                    <b-col md="6">
                        <validation-provider
                            #default="validationContext"
                            name="itemCategory"
                            rules="required"
                        >
                            <b-form-group
                                label="Item Category"
                                label-for="itemCategory"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    id="itemCategory"
                                    v-model="formData.itemCategory"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="itemCategoryOptions"
                                    :clearable="false"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="itemGroup"
                            rules="required"
                        >
                            <b-form-group
                                label="Item Group"
                                label-for="itemGroup"
                            >
                                <v-select
                                    id="itemGroup"
                                    v-model="formData.itemGroup"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="itemGroupOptions"
                                    :state="getValidationState(validationContext)"
                                    @input="getPreDefineCode(formData.itemGroup)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <b-row>
                            <b-col md="7">
                                <b-form-group
                                    label="Item Code"
                                    label-for="itemCode"
                                >
                                    <validation-provider
                                        #default="validationContext"
                                        name="Item Code"
                                        rules="required"
                                    >
                                        <b-form-input
                                            id="itemCode"
                                            v-model="formData.itemCode"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </validation-provider>
                                </b-form-group>
                            </b-col>
                            <b-col md="5">
                                <b-button
                                    size="sm"
                                    variant="primary"
                                    class="mt-2"
                                    :disabled='isDisabled'
                                    @click="generateCode()"
                                >
                                    <feather-icon
                                        icon="CodesandboxIcon"
                                        size="16"
                                        class="mr-0"
                                    />
                                    Auto Generate
                                </b-button>
                            </b-col>
                        </b-row>
                        <b-form-group
                            label="Item Description"
                            label-for="itemDescription"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Item Description"
                                rules="required|max:70"
                            >
                                <b-form-input
                                    id="itemDescription"
                                    v-model="formData.itemDescription"
                                    :state="getValidationState(validationContext)"
                                    @keyup="upperCaseText()"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>

                        <b-form-group
                            label="Make"
                            label-for="make"
                        >
                            <vue-autosuggest
                                v-model="formData.make"
                                :suggestions="makeFilteredOptions"
                                :limit="10"
                                :input-props="{id:'make',class:'form-control', placeholder:'Select Make'}"
                                @input="onMakeInputChange"
                                @selected="onSelectedMake"
                            >
                                <template slot-scope="{suggestion}">
                                    <span class="my-suggestion-item">{{ suggestion.item.label }}</span>
                                </template>
                            </vue-autosuggest>
                        </b-form-group>


                        <validation-provider
                            #default="validationContext"
                            name="UOM"
                            rules="required"
                        >
                            <b-form-group
                                label="UOM"
                                label-for="uom"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    id="uom"
                                    v-model="formData.uom"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="uomOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <b-form-group
                            label="CFactor"
                            label-for="cFactor"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="CFactor"
                                rules=""
                            >
                                <b-form-input
                                    id="cFactor"
                                    v-model="formData.cFactor"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="Conv Qty"
                            label-for="convQty"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Conv Qty"
                            >
                                <b-form-input
                                    id="convQty"
                                    v-model="formData.convQty"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <validation-provider
                            #default="validationContext"
                            name="Conv. UOM"
                            rules="required"
                        >
                            <b-form-group
                                label="Conv. UOM"
                                label-for="convUom"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    id="convUom"
                                    v-model="formData.convUom"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="uomOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Batch Wise Stock"
                            label-for="batchWiseStock"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Batch Wise Stock"
                                rules=""
                            >
                                <v-select
                                    id="batchWiseStock"
                                    v-model="formData.batchWiseStock"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="batchWiseStockOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="Item Type"
                            label-for="itemType"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Item Type"
                                rules=""
                            >
                                <v-select
                                    id="itemType"
                                    v-model="formData.itemType"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="itemTypeOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="Material Process Type"
                            label-for="materialProcessType"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Material Process Type"
                                rules=""
                            >
                                <v-select
                                    id="materialProcessType"
                                    v-model="formData.materialProcessType"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="materialProcessTypeOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    :state="getValidationState(validationContext)"
                                /><!--v-on:input="getPreDefineCode(formData.itemGroup)"-->
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="Consider In Account"
                            label-for="considerInAccount"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Consider In Account"
                                rules=""
                            >
                                <v-select
                                    id="considerInAccount"
                                    v-model="formData.considerInAccount"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="batchWiseStockOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="Status"
                            label-for="status"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Status"
                                rules=""
                            >
                                <v-select
                                    id="status"
                                    v-model="formData.status"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="statusOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    :state="getValidationState(validationContext)"
                                    v-on:input="changeStatusOption(formData.status)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <div v-if="isReasonShow">
                            <b-form-group
                                label="Reason"
                                label-for="reason"
                            >
                                <validation-provider
                                    #default="validationContext"
                                    name="reason"
                                    rules=""
                                >
                                    <b-form-textarea
                                        id="reason"
                                        v-model="formData.reason"
                                        rows="2"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
                        </div>
                        <div v-if="isDateShow">
                            <b-form-group
                                label="Date"
                                label-for="date"
                            >
                                <validation-provider
                                    #default="validationContext"
                                    name="Date"
                                    rules=""
                                >
                                    <flat-pickr
                                        v-model="formData.date"
                                        class="form-control"
                                        :config="{dateFormat: 'd-m-Y'}"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
                        </div>
                        <b-form-group
                            label="Planning"
                            label-for="planning"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Planning"
                                rules=""
                            >
                                <v-select
                                    id="planning"
                                    v-model="formData.planning"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="planningOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <!--<b-form-group
                            label="Stock Allocation at WO"
                            label-for="stockAllocationAtWo"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Stock Allocation at WO"
                                rules=""
                            >
                                <v-select
                                    id="stockAllocationAtWo"
                                    v-model="formData.stockAllocationAtWo"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="batchWiseStockOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>-->
                        <b-form-group
                            label="Serial No Wise Stock"
                            label-for="serialNoWiseStock"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Serial No Wise Stock"
                                rules=""
                            >
                                <v-select
                                    id="serialNoWiseStock"
                                    v-model="formData.serialNoWiseStock"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="batchWiseStockOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>

                        <b-form-group
                            label="Is PESO Approved"
                            label-for="peso_approve"
                        >

                            <v-select
                                id="peso_approve"
                                v-model="formData.peso_approve"
                                placeholder="Select PESO Status"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="PesoOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                            />
                        </b-form-group>
                        <b-form-group
                            label="PESO Remarks"
                            label-for="peso_reason"
                            v-if="formData.peso_approve == 'NOT APPROVED'"
                        >
                            <b-form-textarea
                                id="peso_reason"
                                v-model="formData.peso_reason"
                                rows="1"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="12">
                        <hr>
                        <b-button
                            type="submit"
                            variant="primary"
                            class="float-right"
                        >
                            Save
                        </b-button>
                        <b-button
                            type="button"
                            variant="danger"
                            @click="resetForm"
                            :to="{name : 'item-master-list'}"
                            class="float-right mr-1"
                        >
                            Cancel
                        </b-button>
                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>
    </b-card-code>
</template>
<script>
    import {VueAutosuggest} from 'vue-autosuggest'
    import BCardCode from '@core/components/b-card-code'
    import flatPickr from 'vue-flatpickr-component'
    import {
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormCheckbox,
        BForm,
        BButton,
        BTab,
        BTabs,
        BFormTextarea,
        BFormInvalidFeedback,
        BInputGroup,
    } from 'bootstrap-vue'
    import {required, max} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import {ref, onUnmounted} from '@vue/composition-api'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {useToast} from 'vue-toastification/composition'
    import router from '@/router'
    import store from '@/store'
    import masterStoreModule from "../masterStoreModule"
    import axios from '@axios'
    import Swal from 'sweetalert2'

    export default {
        components: {
            BCardCode,
            ValidationProvider,
            ValidationObserver,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormCheckbox,
            BForm,
            BButton,
            BTab,
            BTabs,
            BFormTextarea,
            BFormInvalidFeedback,
            BInputGroup,
            vSelect,
            flatPickr,
            VueAutosuggest,
        },
        directives: {
            Ripple,
        },
        data() {
            return {
                itemCategoryOptions: [],
                itemGroupOptions: [],
                uomOptions: [],
                batchWiseStockOptions: [{label: 'No', value: 0}, {label: 'Yes', value: 1}],
                itemTypeOptions: [
                    {label: 'Sales', value: 1},
                    {label: 'Purchase', value: 2},
                    {label: 'General', value: 3},
                    {label: 'Service', value: 4}
                ],
                materialProcessTypeOptions: [
                    {label: 'Process-in-House', value: 1},
                    {label: 'Procured', value: 2},
                    {label: 'Sub-Contracting', value: 3},
                ],
                statusOptions: [
                    {label: 'In Use', value: 1},
                    {label: 'Hold For Despatch', value: 2},
                    {label: 'Phased Out', value: 3},
                ],
                planningOptions: [
                    {label: 'Cumlative', value: 1},
                    {label: 'Order Wise', value: 2},
                    {label: 'General', value: 3},
                ],
                PesoOptions: [
                    {label: 'UNDER APPROVAL', value: 'UNDER APPROVAL'},
                    {label: 'APPROVED', value: 'APPROVED'},
                    {label: 'NOT APPROVED', value: 'NOT APPROVED'},
                    {label: 'NOT APPLICABLE', value: 'NOT APPLICABLE'},
                ],
                makeOptions: [],
                isReasonShow: false,
                isDateShow: false,
                isDisabled: true,
                makeDataSuggest: [],
                makeFilteredOptions: [],
            }
        },
        created() {
            this.$http.get('/api/get-item-category-options').then(res => {
                this.itemCategoryOptions = res.data.data
            })
            this.$http.get('/api/get-item-group-master-options').then(res => {
                this.itemGroupOptions = res.data.data
            })
            this.$http.get('/api/get-uom-master-options').then(res => {
                this.uomOptions = res.data.data
            })

            this.$http.get('/api/get-item-make-master-options').then(res => {

                this.makeDataSuggest = res.data.data
            })
        },
        setup() {
            const toast = useToast()

            const APP_STORE_MODULE_NAME = 'master-add'
            if (!store.hasModule(APP_STORE_MODULE_NAME)) store.registerModule(APP_STORE_MODULE_NAME, masterStoreModule)
            onUnmounted(() => {
                if (store.hasModule(APP_STORE_MODULE_NAME)) store.unregisterModule(APP_STORE_MODULE_NAME)
            })

            const blankFormData = {
                make: null,
                itemCategory: [],
                itemGroup: [],
                itemCode: '',
                itemDescription: '',
                uom: '6332d8b8c6f542f108044f92',
                cFactor: '1.000000',
                convQty: '1.000000',
                convUom: '6332d8b8c6f542f108044f92',
                batchWiseStock: 0,
                itemType: 3,
                materialProcessType: 2,
                considerInAccount: 1,
                status: 1,
                reason: '',
                date: '',
                planning: 3,
                stockAllocationAtWo: [],
                serialNoWiseStock: 0,
                peso_approve: null,
                peso_reason: null,
            }

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetGroupData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const saveData = async () => {
                await store.dispatch('master-add/addItemMaster', formData.value).then(res => {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Item Master created',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: 'You have successfully Created Item Master',
                        },
                    })
                    router.push({name: 'edit-item-master', params: {id: res.data.data._id}})
                });
            }

            const submitFormData = async () => {
                await axios.post('/api/item-name-exist',
                    {
                        itemDescription: formData.value.itemDescription
                    }
                ).then(res => {
                    if (res.data.data === true) {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "Name is already exist",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, do it!',
                            cancelButtonText: 'No, Change Name!',
                            customClass: {
                                confirmButton: 'btn btn-primary',
                                cancelButton: 'btn btn-outline-danger ml-1',
                            },
                            buttonsStyling: false,
                        }).then(result => {
                            if (result.value) {
                                saveData()
                            } else {
                                formData.value.itemDescription = null
                            }
                        })
                    } else {
                        saveData()
                    }
                })
            }

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetGroupData)

            return {
                formData,
                saveData,
                submitFormData,

                refFormObserver,
                getValidationState,
                resetForm,
                resetGroupData,
            }
        },
        methods: {
            getPreDefineCode(val) {
                if (val == null) {
                    this.formData.itemCode = ''
                    this.isDisabled = true
                } else {
                    this.formData.itemCode = "I" + val.groupCode
                    this.isDisabled = false
                }
            },
            async generateCode() {
                await this.$http.post('/api/get-item-group-code', {'groupCode': this.formData.itemCode}).then(res => {
                    this.formData.itemCode = res.data.count
                })
            },
            upperCaseText() {
                this.formData.itemDescription = this.formData.itemDescription.toUpperCase()
            },
            changeStatusOption(val) {
                if (val === null) {
                    this.isReasonShow = false
                    this.isDateShow = false
                    this.formData.reason = ''
                    this.formData.date = ''
                }
                if (val === 2) {
                    this.isReasonShow = true
                } else {
                    this.isReasonShow = false
                    this.formData.reason = ''
                }
                if (val === 3) {
                    this.isDateShow = true
                } else {
                    this.isDateShow = false
                    this.formData.date = ''
                }
            },
            onMakeInputChange(text) {

                if (text === '' || text === undefined) {
                    return
                }

                const filteredData = this.makeDataSuggest.filter(item => item.label.toLowerCase().indexOf(text.toLowerCase()) > -1).slice(0, this.limit)

                this.makeFilteredOptions = [{
                    data: filteredData,
                }]
            },
            onSelectedMake(item) {
                this.formData.make = item.item.label;
            },
        }
    }
</script>
<style lang="scss">
    @import '@core/scss/vue/libs/vue-flatpicker.scss';
</style>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-autosuggest.scss';
</style>
