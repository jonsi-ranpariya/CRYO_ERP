<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <h6>Change Billing Term</h6>
                <hr>
            </b-col>
            <b-col md="12">

                <b-form-group
                    label="Billing Term"
                    label-for="billing-term"
                >
                    <v-select
                        placeholder="Select Billing Term To Change"
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="billingOptions"
                        :clearable="false"
                        input-id="billing-term"
                        v-model="formData.billing"
                        :reduce="val => val.value"
                        @input="getPriceValueDetails($event)"
                    />

                </b-form-group>
            </b-col>
        </b-row>
        <hr>
        <b-row>
            <b-col cols="12">
                <b-table
                    responsive="sm"
                    :bordered="true"
                    :hover="true"
                    :fields="fields"
                    :items="rows"
                    show-empty
                    class="table_scroll"
                >
                    <template #empty="scope">
                        <h5 class="text-center text-uppercase">No Billing Term Available</h5>
                    </template>
                    <template #cell(srNo)="data">
                        {{ data.index + 1 }}
                    </template>
                    <!--<template #cell(defaultValue)="data">
                        <span v-if="data.item.value">
                            {{ data.item.value }}
                        </span>
                        <span v-if="data.item.percentage">
                            {{ data.item.percentage + '%' }}
                        </span>
                    </template>-->
                    <template
                        #cell(action)="data"
                    >
                        <span>
                            <b-dropdown
                                variant="link"
                                toggle-class="text-decoration-none"
                                no-caret
                            >
                            <template v-slot:button-content>
                              <feather-icon
                                  icon="MoreVerticalIcon"
                                  size="16"
                                  class="text-body align-middle mr-25"
                              />
                            </template>
                            <b-dropdown-item @click="editBillingTermData(data.item._id)">
                              <feather-icon
                                  icon="Edit2Icon"
                                  class="mr-50"
                              />
                              <span>Edit</span>
                            </b-dropdown-item>
                            <b-dropdown-item @click="deleteBillingTermData(data.item._id)">
                              <feather-icon
                                  icon="TrashIcon"
                                  class="mr-50"
                              />
                              <span>Delete</span>
                            </b-dropdown-item>
                            </b-dropdown>
                        </span>
                    </template>
                </b-table>
            </b-col>
        </b-row>
        <hr>
        <!-- User Info: Input Fields -->
        <validation-observer
            #default="{ handleSubmit }"
            ref="refFormObserver"
        >
            <b-form @submit.prevent="handleSubmit(submitFormData)">
                <b-row>
                    <b-col md="6">
                        <b-form-group
                            label="Code"
                            label-for="calCode"
                        >
                            <b-form-input
                                id="calCode"
                                placeholder="Code"
                                v-model="formData.calCode"
                                readonly
                            />
                        </b-form-group>
                        <b-form-group
                            label="Description"
                            label-for="description"
                        >
                            <b-form-input
                                id="description"
                                placeholder="Description"
                                v-model="formData.description"
                                readonly
                            />
                        </b-form-group>
                        <b-form-group
                            label="Defination"
                            label-for="defination"
                        >
                            <b-form-input
                                id="defination"
                                placeholder="Defination"
                                v-model="formData.defination"
                                readonly
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Narration"
                            label-for="narration"
                        >
                            <b-form-input
                                id="narration"
                                placeholder="Narration"
                                v-model="formData.narration"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Percentage"
                            label-for="billing-percentage"
                        >
                            <b-form-input
                                id="billing-percentage"
                                placeholder="Percentage"
                                :disabled="formData.byValue > 0"
                                v-model="formData.percentage"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Value"
                            label-for="billing-value"
                        >
                            <b-form-input
                                id="billing-value"
                                placeholder="Value"
                                :disabled="formData.percentage > 0"
                                v-model="formData.byValue"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>

                <hr>
                <!-- Action Buttons -->
                <b-button
                    variant="primary"
                    class="mb-1 mb-sm-0 mr-0 mr-sm-1"
                    :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    type="submit"
                >
                    Update Billing Term
                </b-button>
                <b-button
                    variant="primary"
                    class="mb-1 mb-sm-0 mr-0 mr-sm-1"
                    :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    @click="clearBillingTermData"
                >
                    Clear Billing Term
                </b-button>
            </b-form>
        </validation-observer>
    </div>
</template>

<script>
    import {
        BButton,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BForm,
        BTable,
        BCard,
        BCardHeader,
        BCardTitle,
        BFormCheckbox,
        BFormTextarea,
        BFormInvalidFeedback,
        BDropdown,
        BDropdownItem,
    } from 'bootstrap-vue'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import {ref, onUnmounted} from '@vue/composition-api'
    import router from '@/router'
    import store from '@/store'
    import {useToast} from 'vue-toastification/composition'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {required, numeric, email} from '@validations'
    import {ValidationProvider, ValidationObserver, validate} from 'vee-validate'
    import partyStoreModule from '../partyStoreModule'

    export default {
        components: {
            BButton,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BForm,
            BTable,
            BCard,
            BCardHeader,
            BCardTitle,
            BFormCheckbox,
            BFormTextarea,
            BDropdown,
            BDropdownItem,
            BFormInvalidFeedback,
            vSelect,

            ValidationProvider,
            ValidationObserver
        },
        directives: {
            Ripple,
        },
        data() {
            const reFetchData = () => {
                this.$store.dispatch('partyStoreModule/fetchPartyBillingTerm', {id: router.currentRoute.params.id})
                    .then(res => {
                        this.rows = res.data.data
                    })
            }
            return {
                billingOptions: [],
                glAccountsOptions: [],
                fields: [
                    {
                        key: 'srNo',
                        label: 'No',
                    },
                    {
                        key: 'calCodeLabel',
                        label: 'Code',
                    },
                    {
                        key: 'description',
                        label: 'Name',
                    },
                    {
                        key: 'calDefination',
                        label: 'Defination',
                    },
                    {
                        key: 'percentage',
                        label: 'Percent (%)',
                    },
                    {
                        key: 'byValue',
                        label: 'Value',
                    },
                    {
                        key: 'action',
                        label: 'action',
                    },
                ],
                rows: [],
                reFetchData,
            }
        },
        created() {
            this.$http.get('/api/get-billing-template-master-options').then(res => {
                this.billingOptions = res.data.data
            })
            this.$store.dispatch('partyStoreModule/fetchPartyBillingTerm', {id: router.currentRoute.params.id}).then(res => {
                this.rows = res.data.data
            })
        },
        setup() {
            const APP_STORE_MODULE_NAME = 'master-add'
            if (!store.hasModule(APP_STORE_MODULE_NAME)) store.registerModule(APP_STORE_MODULE_NAME, partyStoreModule)
            onUnmounted(() => {
                if (store.hasModule(APP_STORE_MODULE_NAME)) store.unregisterModule(APP_STORE_MODULE_NAME)
            })

            const partyDetailFormData = {
                id: null,
                partyId: router.currentRoute.params.id,
                billing: null,
                billingTerms: [],
                calCode: null,
                description: null,
                defination: null,
                narration: null,
                percentage: null,
                byValue: null,
            }

            const formData = ref(JSON.parse(JSON.stringify(partyDetailFormData)))

            const resetGroupData = () => {
                formData.value = JSON.parse(JSON.stringify(partyDetailFormData))
            }

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetGroupData)

            return {
                formData,

                refFormObserver,
                getValidationState,
                resetForm,
                resetGroupData,
            }
        },
        methods: {
            editBillingTermData(id) {
                this.$http.get(`/api/party/billing-term/${id}`).then(res => {
                    this.formData.id = res.data.data._id
                    this.formData.billing = res.data.data.billing
                    this.formData.calCode = res.data.data.calCodeLabel
                    this.formData.description = res.data.data.description
                    this.formData.defination = res.data.data.calDefination
                    this.formData.narration = res.data.data.narration
                    this.formData.percentage = res.data.data.percentage
                    this.formData.byValue = res.data.data.byValue
                })
            },
            clearBillingTermData() {
                this.formData.id = null
                this.formData.billing = null
                this.formData.calCode = null
                this.formData.description = null
                this.formData.defination = null
                this.formData.narration = null
                this.formData.percentage = null
                this.formData.byValue = null
            },
            getPriceValueDetails(id) {
                this.$http.get(`/api/billing-template-master/${id}`).then(res => {
                    this.formData.billingTerms = res.data.data.billing_items
                    this.$store.dispatch('master-add/addPartyBillingTerm', this.formData).then(res => {
                        if (res.data.status === 200) {
                            this.reFetchData()
                        }
                    })
                })
            },
            submitFormData() {
                this.$store.dispatch('master-add/updatePartyBillingTerm', this.formData).then(() => {
                    this.resetGroupData()
                    this.reFetchData()
                    this.$toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Billing Term Updated',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: `You have successfully Updated Billing Term`,
                        },
                    })
                })
            },
            deleteBillingTermData(id) {
                this.$store.dispatch('master-add/deletePartyBillingTerm', {id}).then(() => {
                    this.reFetchData()
                    this.$toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Billing Term Deleted',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: `You have successfully Deleted Billing Term`,
                        },
                    })
                })
            }
        }
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
