<template>
    <div>
        <b-row>
            <b-col md="12">
                <b-table
                    :fields="tableFields"
                    :items="tableData"
                    responsive
                    class="mb-0"
                    bordered
                    hover
                    show-empty
                    :busy="isBusy"
                    selectable
                    select-mode="single"
                    @row-selected="onRowSelected"
                >
                    <!-- Loader -->
                    <template #table-busy>
                        <div class="text-center my-2">
                            <b-spinner class="align-middle"></b-spinner>
                            <strong>Loading...</strong>
                        </div>
                    </template>

                    <!-- A virtual column -->
                    <template #cell(index)="data">
                        {{ data.index + 1 }}
                    </template>

                    <!-- Action -->
                    <template #cell(action)="data">
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
                            <b-dropdown-item @click="deleteVendorDetails(data.item._id)">
                                <feather-icon
                                    icon="TrashIcon"
                                    class="mr-50"
                                />
                                <span>Delete</span>
                            </b-dropdown-item>
                        </b-dropdown>
                    </template>

                    <!--  select row  -->
                    <template #cell(rowSelected)="{ rowSelected }">
                        <template v-if="rowSelected">
                            <span aria-hidden="true">&check;</span>
                            <span class="sr-only">Selected</span>
                        </template>
                        <template v-else>
                            <span aria-hidden="true">&nbsp;</span>
                            <span class="sr-only">Not selected</span>
                        </template>
                    </template>

                </b-table>
                <hr>
            </b-col>
        </b-row>

        <!-- Vendor Form -->
        <validation-observer #default="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(saveFormData)">
                <b-row>
                    <b-col md="6">
                        <validation-provider
                            #default="{ errors }"
                            name="Vendor Code"
                            rules=""
                        >
                            <b-form-group
                                label="Vendor Code"
                                label-for="vendorCode"
                                :state="errors.length > 0 ? false:null"
                            >
                                <v-select
                                    placeholder="Select Vendor"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="vendorOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="vendorCode"
                                    :state="errors.length > 0 ? false:null"
                                    v-model="formData.vendorCode"
                                    @input="getVendorDetails($event)"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Vendor Name"
                            rules="required"
                        >
                            <b-form-group
                                label="Vendor Name"
                                label-for="vendorName"
                            >
                                <b-form-input
                                    id="vendorName"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.vendorName"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Address"
                            rules=""
                        >
                            <b-form-group
                                label="Address"
                                label-for="vendorAddress"
                            >
                                <b-form-textarea
                                    id="vendorAddress"
                                    rows="3"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.vendorAddress"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="{ errors }"
                            name="District"
                            rules=""
                        >
                            <b-form-group
                                label="District"
                                label-for="vendorCity"
                                :state="errors.length > 0 ? false:null"
                            >
                                <v-select
                                    placeholder="Select City"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="cityOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="vendorCity"
                                    :state="errors.length > 0 ? false:null"
                                    v-model="formData.vendorCity"
                                    @input="getCityDetails($event)"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="{ errors }"
                            name="State"
                            rules=""
                        >
                            <b-form-group
                                label="State"
                                label-for="vendorState"
                                :state="errors.length > 0 ? false:null"
                            >
                                <v-select
                                    placeholder="Select State"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="stateOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="vendorState"
                                    :state="errors.length > 0 ? false:null"
                                    v-model="formData.vendorState"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="{ errors }"
                            name="Country"
                            rules=""
                        >
                            <b-form-group
                                label="Country"
                                label-for="vendorCountry"
                                :state="errors.length > 0 ? false:null"
                            >
                                <v-select
                                    placeholder="Select Country"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="countryOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="vendorCountry"
                                    :state="errors.length > 0 ? false:null"
                                    v-model="formData.vendorCountry"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="6">
                        <validation-provider
                            #default="validationContext"
                            name="Fax No."
                            rules=""
                        >
                            <b-form-group
                                label="Fax No."
                                label-for="vendorFaxNo"
                            >
                                <b-form-input
                                    id="vendorFaxNo"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.vendorFaxNo"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Email"
                            rules=""
                        >
                            <b-form-group
                                label="Email"
                                label-for="vendorEmailId"
                            >
                                <b-form-input
                                    id="vendorEmailId"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.vendorEmailId"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Web Site"
                            rules=""
                        >
                            <b-form-group
                                label="Web Site"
                                label-for="vendorWebSite"
                            >
                                <b-form-input
                                    id="vendorWebSite"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.vendorWebSite"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="{ errors }"
                            name="Kind Attn"
                            rules=""
                        >
                            <b-form-group
                                label="Kind Attn"
                                label-for="vendorKindAttn"
                                :state="errors.length > 0 ? false:null"
                            >
                                <v-select
                                    placeholder="Select KindAttn"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="kindAttnOption"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="vendorKindAttn"
                                    :state="errors.length > 0 ? false:null"
                                    v-model="formData.vendorKindAttn"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="{ errors }"
                            name="Status"
                            rules=""
                        >
                            <b-form-group
                                label="Status"
                                label-for="vendorStatus"
                                :state="errors.length > 0 ? false:null"
                            >
                                <v-select
                                    placeholder="Select Status"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="statusOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="vendorStatus"
                                    :state="errors.length > 0 ? false:null"
                                    v-model="formData.vendorStatus"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Pin-Code"
                            rules=""
                        >
                            <b-form-group
                                label="Pin-Code"
                                label-for="vendorPinCode"
                            >
                                <b-form-input
                                    id="vendorPinCode"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.vendorPinCode"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <b-form-group
                            label="Phone No."
                            label-for="party-work-phone"
                        >
                            <b-input-group>
                                <b-input-group-prepend>
                                    <b-form-input
                                        v-model="formData.vendorPhoneCountry"
                                    />
                                </b-input-group-prepend>
                                <b-form-input
                                    id="party-work-phone"
                                    placeholder="Party Phone"
                                    v-model="formData.vendorPhoneNo"
                                />
                            </b-input-group>
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
                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>
    </div>
</template>
<script>
    import {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormTextarea,
        BFormDatepicker,
        BButton,
        BFormInvalidFeedback,
        BOverlay,
        BTable,
        BInputGroup,
        BInputGroupPrepend,
        BSpinner,
        BDropdown,
        BDropdownItem,
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import Ripple from 'vue-ripple-directive'
    import {ref, onUnmounted} from '@vue/composition-api'
    import VSelect from 'vue-select'
    import axios from '@axios'
    import {getTcTodayDate} from "@core/utils/utils";
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {required} from '@validations'
    import router from '@/router'
    import {getUserData} from "../../../../auth/utils";
    import moment from 'moment'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {useToast} from 'vue-toastification/composition'
    import purchaseStoreModule from "../../purchaseStoreModule";
    import countryCode from '@/@fake-db/data/other/country-code'
    import Swal from 'sweetalert2'

    export default {
        components: {
            BCardCode,
            VSelect,
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormTextarea,
            BFormDatepicker,
            BButton,
            BFormInvalidFeedback,
            BTable,
            BOverlay,
            BInputGroup,
            BInputGroupPrepend,
            BSpinner,
            BDropdown,
            BDropdownItem,
            ValidationProvider,
            ValidationObserver,
        },
        directives: {
            Ripple,
        },
        computed: {
            countryCode: () => countryCode
        },
        setup() {
            const ITEMADDON_APP_STORE_MODULE_NAME = 'purchase-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, purchaseStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const toast = useToast()

            const isBusy = ref(false)

            const tableFields = ref([
                {
                    key: 'rowSelected',
                    label: ''
                },
                {
                    key: 'index',
                    label: 'No'
                },
                {
                    key: 'party_code.partyCode',
                    label: 'Code'
                },
                {
                    key: 'vendorName',
                    label: 'Party Name'
                },
                //'kind_attn_name.partyName'
                {
                    key: 'kind_attn_name.personName',
                    label: 'kindAttn'
                },
                {
                    key: 'city_name.city',
                    label: 'City'
                },
                {
                    key: 'state_name.state',
                    label: 'State'
                },
                {
                    key: 'vendorStatus',
                    label: 'Status',
                    formatter: val => getStatus(val)
                },
                {
                    key: 'action',
                    label: 'Action'
                },
            ])

            const tableData = ref([])

            const refetchData = async () => {
                isBusy.value = true
                await axios.get(`/api/purchase-enquiry-vendor-details/${router.currentRoute.params.id}`).then(res => {
                    tableData.value = res.data.data
                })
                isBusy.value = false
            }
            refetchData()

            const vendorOptions = ref([])
            axios.get(`/api/party/get-master-without-customer-options`).then(res => {
                vendorOptions.value = res.data.data
            })

            const countryOptions = ref([])
            axios.get('/api/get-country-options').then(res => {
                countryOptions.value = res.data.data
            })

            const stateOptions = ref([])
            axios.get('/api/get-state-options').then(res => {
                stateOptions.value = res.data.data
            })

            const cityOptions = ref([])
            axios.get('/api/get-city-options').then(res => {
                cityOptions.value = res.data.data
            })

            const getCityDetails = async (id) => {
                await axios.get(`/api/city-master/${id}`).then(res => {
                    formData.value.vendorState = res.data.data.state
                    formData.value.vendorCountry = res.data.data.country
                });
            }

            const kindAttnOption = ref([])

            const statusOptions = ref([
                {label: 'Pending', value: 1},
                {label: 'Canceled', value: 2},
                {label: 'Completed', value: 3},
            ])

            const blankFormData = {
                _id: null,
                referenceId: router.currentRoute.params.id,
                vendorCode: null,
                vendorName: null,
                vendorAddress: null,
                vendorCountry: null,
                vendorState: null,
                vendorCity: null,
                vendorFaxNo: null,
                vendorEmailId: null,
                vendorWebSite: null,
                vendorKindAttn: null,
                vendorStatus: 1,
                vendorPinCode: null,
                vendorPhoneCountry: '+91',
                vendorPhoneNo: null,
            }

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const onRowSelected = async (items) => {
                await axios.get(`/api/party/get-party-contacts-options/${items.vendorCode}`).then(res => {
                    kindAttnOption.value = res.data.data
                })

                if (items.length > 0) {
                    formData.value._id = items[0]._id
                    formData.value.referenceId = items[0].referenceId ?? null
                    formData.value.vendorCode = items[0].vendorCode ?? null
                    formData.value.vendorName = items[0].vendorName ?? null
                    formData.value.vendorAddress = items[0].vendorAddress ?? null
                    formData.value.vendorCountry = items[0].vendorCountry ?? null
                    formData.value.vendorState = items[0].vendorState ?? null
                    formData.value.vendorCity = items[0].vendorCity ?? null
                    formData.value.vendorFaxNo = items[0].vendorFaxNo ?? null
                    formData.value.vendorEmailId = items[0].vendorEmailId ?? null
                    formData.value.vendorWebSite = items[0].vendorWebSite ?? null
                    formData.value.vendorKindAttn = items[0].vendorKindAttn ?? null
                    formData.value.vendorStatus = items[0].vendorStatus ?? null
                    formData.value.vendorPinCode = items[0].vendorPinCode ?? null
                    formData.value.vendorPhoneCountry = items[0].vendorPhoneCountry ?? null
                    formData.value.vendorPhoneNo = items[0].vendorPhoneNo ?? null
                } else {
                    resetFormData()
                }
            }


            const getVendorDetails = async (id) => {
                await axios.get(`/api/party/edit/${id}`).then(res => {
                    formData.value.vendorName = res.data.data?.partyName ?? null
                    formData.value.vendorAddress = res.data.data?.partyAddress?.partyAddress ?? null
                    formData.value.vendorCountry = res.data.data?.partyDetails?.partyCountry?.value ?? null
                    formData.value.vendorState = res.data.data?.partyDetails?.partyState?.value ?? null
                    formData.value.vendorCity = res.data.data?.partyDetails?.partyCity?.value ?? null
                    formData.value.vendorFaxNo = res.data.data?.partyDetails?.partyFaxNo ?? null
                    formData.value.vendorEmailId = res.data.data?.partyDetails?.partyEmilId ?? null
                    formData.value.vendorWebSite = res.data.data?.partyDetails?.partyWebsite ?? null
                    formData.value.vendorPinCode = res.data.data?.partyDetails?.partyPinCode ?? null
                    formData.value.vendorPhoneCountry = res.data.data?.partyDetails?.partyCountryCode ?? null
                    formData.value.vendorPhoneNo = res.data.data?.partyDetails?.partyPhoneNo ?? null
                })
                formData.value.kindAttnId = null

                await axios.get(`/api/party/get-party-contacts-options/${id}`).then(res => {
                    kindAttnOption.value = res.data.data
                })
            }

            const saveFormData = async () => {
                if (formData.value._id === null) {
                    await store.dispatch('purchase-store-module/addPurchaseEnquiryVendorDetail', formData.value)
                        .then(res => {
                            if (res.status === 200) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Vendor Details Added',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Added Vendor Details.`,
                                    },
                                })
                            } else {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Error',
                                        icon: 'AlertCircleIcon',
                                        variant: 'danger',
                                        text: 'Something went wrong!',
                                    },
                                })
                            }
                        })
                        .catch(error => {
                            let data = error.response.data
                            let statusText = error.response.statusText
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: statusText,
                                    icon: 'AlertCircleIcon',
                                    variant: 'danger',
                                    text: data.message,
                                },
                            })
                        })
                } else {
                    await store.dispatch('purchase-store-module/updatePurchaseEnquiryVendorDetail', formData.value)
                        .then(res => {
                            if (res.status === 200) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Vendor Details Updated',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Updated Vendor Details.`,
                                    },
                                })
                            } else {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Error',
                                        icon: 'AlertCircleIcon',
                                        variant: 'danger',
                                        text: 'Something went wrong!',
                                    },
                                })
                            }
                        })
                }
                resetFormData()
                await refetchData()
            }

            const getStatus = (id) => {
                let valObj = statusOptions.value.filter(function (elem) {
                    if (elem.value === id) {
                        return elem.label
                    }
                })
                if (valObj.length > 0) {
                    return valObj[0].label
                } else {
                    return ''
                }
            }

            const deleteVendorDetails = async (id) => {
                await Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete Purchase Enquiry Vendor",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, do it!',
                    cancelButtonText: 'No, keep it!',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ml-1',
                    },
                    buttonsStyling: false,
                }).then(result => {
                    if (result.value) {
                        store.dispatch('purchase-store-module/deletePurchaseEnquiryVendorDetail', {id: id}).then(res => {
                            if (res.status === 200) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Vendor Details Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Deleted Vendor Details.`,
                                    },
                                })
                            } else {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Error',
                                        icon: 'AlertCircleIcon',
                                        variant: 'danger',
                                        text: 'Something went wrong!',
                                    },
                                })
                            }
                        })
                        resetFormData()
                        refetchData()
                    }
                })
            }

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)

            return {
                isBusy,
                tableFields,
                tableData,
                refetchData,
                vendorOptions,
                kindAttnOption,
                countryOptions,
                stateOptions,
                cityOptions,
                statusOptions,
                formData,
                resetFormData,
                getVendorDetails,
                saveFormData,
                deleteVendorDetails,
                required,

                refFormObserver,
                getValidationState,
                resetForm,
                getCityDetails,
                onRowSelected
            }
        }
    }
</script>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>

<style lang="scss" scoped>
    @import '~@core/scss/base/bootstrap-extended/include';
    @import '~@core/scss/base/components/variables-dark';

    .dark-layout {
        div ::v-deep .card .card-body {
            .b-overlay {
                .bg-light {
                    background-color: $theme-dark-body-bg !important;
                }
            }
        }
    }
</style>
