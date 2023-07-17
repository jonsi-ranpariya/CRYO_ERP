<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <b-button
                    variant="primary"
                    class="float-right"
                    @click="addDeliveryAddress"
                    type="button"
                >
                    Add Delivery Address
                </b-button>
            </b-col>
            <b-col cols="12">
                <hr>
                <b-table
                    responsive="sm"
                    :fields="fields"
                    :items="rows"
                    :bordered="true"
                    :hover="true"
                    show-empty
                >
                    <template #empty="scope">
                        <h5 class="text-center text-uppercase">No Delivery Address Available</h5>
                    </template>
                    <template #cell(srNo)="data">
                        {{ data.index + 1 }}
                    </template>
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
                            <b-dropdown-item @click="selectDeliveryAddress(data.item)">
                              <feather-icon
                                  icon="CheckSquareIcon"
                                  class="mr-50"
                              />
                              <span>Select</span>
                            </b-dropdown-item>
                            <b-dropdown-item @click="editDeliveryAddress(data.item)">
                              <feather-icon
                                  icon="Edit2Icon"
                                  class="mr-50"
                              />
                              <span>Edit</span>
                            </b-dropdown-item>
                            <b-dropdown-item @click="deleteDeliveryAddress(data.item._id)">
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
        <!-- User Info: Input Fields -->
        <validation-observer
            ref="validateRules"
            #default="{ handleSubmit }"
        >
            <b-form @submit.prevent="handleSubmit(submitFormData)">
            <b-row>
                <b-col md="12">
                    <hr>
                    <h6>Delivery Address Details</h6>
                    <hr>
                </b-col>
                <b-col md="3">
                    <validation-provider
                        #default="validationContext"
                        name="District‌"
                        rules="required"
                    >
                        <b-form-group
                            label="District‌"
                            label-for="delivery-address-city"
                            :state="getValidationState(validationContext)"
                        >
                            <v-select
                                placeholder="Select District‌"
                                v-model="formData.city"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="cityOptions"
                                :clearable="false"
                                input-id="delivery-address-city"
                                @input="getCityDetails($event)"
                            />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>
                </b-col>
                <b-col md="3">
                    <validation-provider
                        #default="validationContext"
                        name="State"
                        rules="required"
                    >
                        <b-form-group
                            label="State"
                            label-for="delivery-address-state"
                            :state="getValidationState(validationContext)"
                        >
                            <v-select
                                placeholder="Select State"
                                v-model="formData.state"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="stateOptions"
                                :clearable="false"
                                input-id="delivery-address-state"
                            />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>
                </b-col>
                <b-col md="3">
                    <validation-provider
                        #default="validationContext"
                        name="Country"
                        rules="required"
                    >
                        <b-form-group
                            label="Country"
                            label-for="delivery-address-country"
                            :state="getValidationState(validationContext)"
                        >
                            <v-select
                                placeholder="Select Country"
                                v-model="formData.country"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="countryOptions"
                                :clearable="false"
                                input-id="delivery-address-country"
                            />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Pin-Code"
                        label-for="delivery-address-pincode"
                    >
                        <b-form-input
                            id="delivery-address-pincode"
                            placeholder="Pin Code"
                            v-model="formData.pinCode"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="12">
                    <b-form-group
                        label="Address"
                        label-for="delivery-address-address"
                    >
                        <b-form-textarea
                            id="delivery-address-address"
                            placeholder="Address"
                            v-model="formData.address"
                            rows="2"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="12">
                    <b-form-group
                        label="Phone No."
                        label-for="delivery-address-phone"
                    >
                        <b-input-group>
                            <b-input-group-prepend>
                                <b-form-input
                                    id="stdCode"
                                    placeholder="STD code"
                                    type="number"
                                    v-model="formData.phoneNoCode"
                                />
                            </b-input-group-prepend>
                            <b-form-input
                                type="number"
                                id="delivery-address-phone"
                                placeholder="Party Phone"
                                v-model="formData.phoneNo"
                                rows="2"
                            />
                        </b-input-group>
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Fax No."
                        label-for="delivery-address-fax"
                    >
                        <b-form-input
                            id="delivery-address-fax"
                            placeholder="Party Fax"
                            v-model="formData.faxNo"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Email ID"
                        label-for="delivery-address-email"
                    >
                        <b-form-input
                            id="delivery-address-email"
                            placeholder="Party Email"
                            type="email"
                            v-model="formData.emailId"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Website"
                        label-for="delivery-address-website"
                    >
                        <b-form-input
                            id="delivery-address-website"
                            placeholder="Party Website"
                            v-model="formData.website"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Vat No"
                        label-for="delivery-address-vat-no"
                    >
                        <b-form-input
                            id="delivery-address-vat-no"
                            placeholder="Vat No"
                            v-model="formData.vatNo"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="C.S.T No"
                        label-for="delivery-address-cst"
                    >
                        <b-form-input
                            id="delivery-address-cst"
                            placeholder="C.S.T No"
                            v-model="formData.cstNo"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="GSTIN"
                        label-for="delivery-address-gstin"
                    >
                        <b-form-input
                            id="delivery-address-gstin"
                            placeholder="GSTIN"
                            v-model="formData.gstin"
                        />
                    </b-form-group>
                </b-col>
            </b-row>

            <hr>
            <!-- Action Buttons -->
            <b-button
                variant="primary"
                class="mb-1 mb-sm-0 mr-0 mr-sm-1 float-right"
                :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                type="submit"
                v-if="isButtonShow"
            >
                {{ buttonDetails }} Detail
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
        BInputGroup,
        BInputGroupPrepend
    } from 'bootstrap-vue'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import router from '@/router'
    import store from '@/store'
    import { useToast } from 'vue-toastification/composition'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {required, numeric, email} from '@validations'
    import {ref, onUnmounted} from '@vue/composition-api'
    import {ValidationProvider, ValidationObserver, validate} from 'vee-validate'
    import partyStoreModule from '../partyStoreModule'
    import countryCode from '@/@fake-db/data/other/country-code'

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
            BFormInvalidFeedback,
            BDropdown,
            BDropdownItem,
            BInputGroup,
            BInputGroupPrepend,
            vSelect,

            ValidationProvider,
            ValidationObserver
        },
        directives: {
            Ripple,
        },
        computed: {
            countryCode: () => countryCode
        },
        data() {
            const reFetchData = () => {
                this.$store.dispatch('partyStoreModule/fetchPartyDeliveryAddress', {id: router.currentRoute.params.id}).then(res => {
                    this.rows = res.data.data
                })
            }
            return {
                buttonDetails: 'Add',
                countryOptions: [],
                stateOptions: [],
                cityOptions: [],
                fields: [
                    {
                        key: 'srNo',
                        label: 'No'
                    },
                    {
                        key: 'address',
                        label: 'Address'
                    },
                    {
                        key: 'city.label',
                        label: 'city'
                    },
                    {
                        key: 'state.label',
                        label: 'State'
                    },
                    {
                        key: 'country.label',
                        label: 'country'
                    },
                    {
                        key: 'pinCode',
                        label: 'Pincode'
                    },
                    {
                        key: 'action',
                        label: 'Actions'
                    },
                ],
                rows: [],
                isButtonShow : true,
                reFetchData,
            }
        },
        created() {
            this.$http.get('/api/get-country-options').then(res => {
                this.countryOptions = res.data.data
            })

            this.$http.get('/api/get-state-options').then(res => {
                this.stateOptions = res.data.data
            })

            this.$http.get('/api/get-city-options').then(res => {
                this.cityOptions = res.data.data
            })

            this.$store.dispatch('partyStoreModule/fetchPartyDeliveryAddress', {id: router.currentRoute.params.id}).then(res => {
                this.rows = res.data.data
            })
        },
        setup() {
            const toast = useToast()

            const APP_STORE_MODULE_NAME = 'master-add'
            if (!store.hasModule(APP_STORE_MODULE_NAME)) store.registerModule(APP_STORE_MODULE_NAME, partyStoreModule)
            onUnmounted(() => {
                if (store.hasModule(APP_STORE_MODULE_NAME)) store.unregisterModule(APP_STORE_MODULE_NAME)
            })

            const deliveryFormData = {
                id: null,
                partyId: router.currentRoute.params.id,
                country: null,
                state: null,
                city: null,
                pinCode: null,
                address: null,
                phoneNo: null,
                phoneNoCode: '+91',
                faxNo: null,
                emailId: null,
                website: null,
                vatNo: null,
                cstNo: null,
                gstin: null,
            }

            const formData = ref(JSON.parse(JSON.stringify(deliveryFormData)))

            const resetGroupData = () => {
                formData.value = JSON.parse(JSON.stringify(deliveryFormData))
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
            async getCityDetails(city) {
                await this.$http.get(`/api/city-master/${city.value}`).then((res) => {
                    this.formData.state = res.data.data.state_detail
                    this.formData.country = res.data.data.country_detail
                });
            },

            selectDeliveryAddress(val){
                this.formData = val
                this.formData.id = val._id
                delete this.formData._id
                this.isButtonShow = false
            },
            addDeliveryAddress(){
                this.resetGroupData();
                this.isButtonShow = true
            },
            editDeliveryAddress(val){
                this.formData = val
                this.formData.id = val._id
                delete this.formData._id
                this.isButtonShow = true
                this.buttonDetails = 'Update'
            },
            submitFormData(){
                if (this.formData.id === null) {
                    this.$store.dispatch('master-add/addDeliveryAddress', this.formData).then(res => {
                        this.resetGroupData()
                        this.reFetchData()
                        this.$toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Delivery Address Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Added Delivery Address`,
                            },
                        })
                    })
                } else {
                    this.$store.dispatch('master-add/updateDeliveryAddress', this.formData).then(res => {
                        this.resetGroupData()
                        this.reFetchData()
                        this.buttonDetails = 'Add'
                        this.$toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Delivery Address Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Updated Delivery Address`,
                            },
                        })
                    })
                }
            },
            deleteDeliveryAddress(id){
                this.$swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ml-1',
                    },
                    buttonsStyling: false,
                }).then(result => {
                    if (result.value) {
                        store.dispatch('master-add/deleteDeliveryAddress', {id}).then(response => {
                            if (response.data.status === 200) {
                                this.reFetchData()
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: 'Term & Condition Delete Successfully',
                                    },
                                })
                            } else {
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: `Error`,
                                        icon: 'AlertCircleIcon',
                                        variant: 'danger',
                                        text: `something went wrong`,
                                    },
                                })
                            }
                        })
                    }
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
