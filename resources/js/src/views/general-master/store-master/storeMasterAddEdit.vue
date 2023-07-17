<template>
    <b-sidebar
        id="add-new-user-sidebar"
        :visible="isAddNewUserSidebarActive"
        bg-variant="white"
        sidebar-class="sidebar-lg"
        shadow
        backdrop
        no-header
        right
        @hidden="resetForm"
        @change="(val) => $emit('update:is-add-new-user-sidebar-active', val)"
    >
        <template #default="{ hide }">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center content-sidebar-header px-2 py-1">
                <h5 class="mb-0">
                    Add/Edit Store
                </h5>

                <feather-icon
                    class="ml-1 cursor-pointer"
                    icon="XIcon"
                    size="16"
                    @click="hide"
                />

            </div>

            <!-- BODY -->
            <validation-observer
                #default="{ handleSubmit }"
                ref="refFormObserver"
            >
                <!-- Form -->
                <b-form
                    class="p-2"
                    @submit.prevent="handleSubmit(saveMyERPData)"
                    @reset.prevent="resetForm"
                >

                    <validation-provider
                        #default="validationContext"
                        name="Store Name"
                        rules="required"
                    >
                        <b-form-group>

                            <label for="storeName">Store Name <span
                                class="text-danger erp_required_star">*</span></label>

                            <b-form-input
                                id="storeName"
                                v-model="userformData.storeName"
                                :state="getValidationState(validationContext)"
                                v-uppercase-input
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <b-form-group
                        label="Address"
                        label-for="storeAddress"
                    >
                        <b-form-textarea
                            id="storeAddress"
                            v-model="userformData.storeAddress"
                            rows="1"
                        />
                    </b-form-group>

                    <b-form-group
                        label="Area"
                        label-for="storeArea"
                    >
                        <b-form-input
                            id="storeArea"
                            v-model="userformData.storeArea"
                        />
                    </b-form-group>

                    <validation-provider
                        #default="validationContext"
                        name="District‌"
                        rules="required"
                    >
                        <b-form-group>

                            <label for="storeCity">District‌<span
                                class="text-danger erp_required_star">*</span></label>

                            <v-select
                                v-model="userformData.storeCity"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="cityChangeOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                id="storeCity"
                                :state="getValidationState(validationContext)"
                                @input="getCityDetails($event)"
                            />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <validation-provider
                        #default="validationContext"
                        name="State"
                        rules="required"
                    >
                        <b-form-group>

                            <label for="storeState">State<span
                                class="text-danger erp_required_star">*</span></label>

                            <v-select
                                v-model="userformData.storeState"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="stateChangeOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                id="storeState"
                                :state="getValidationState(validationContext)"
                            />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <validation-provider
                        #default="validationContext"
                        name="Country"
                        rules="required"
                    >
                        <b-form-group>

                            <label for="storeCountry">Country<span
                                class="text-danger erp_required_star">*</span></label>

                            <v-select
                                v-model="userformData.storeCountry"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="countryOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                id="storeCountry"
                                :state="getValidationState(validationContext)"
                            />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <validation-provider
                        #default="validationContext"
                        name="Pin-Code"
                        rules="required"
                    >
                        <b-form-group>
                            <label for="storePinCode">Pin-Code<span
                                class="text-danger erp_required_star">*</span></label>

                            <b-form-input
                                id="storePinCode"
                                v-model="userformData.storePinCode"
                                :state="getValidationState(validationContext)"
                                v-uppercase-input
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <b-form-group
                        label="Phone No."
                        label-for="storePhoneNo"
                    >
                        <b-input-group>
                            <b-input-group-prepend>
                                <b-form-input
                                    id="stdCode"
                                    placeholder="STD code"
                                    type="number"
                                    v-model="userformData.storeStdCode"
                                />
                            </b-input-group-prepend>
                            <b-form-input
                                id="party-phone"
                                placeholder="Party Phone"
                                v-model="userformData.storePhoneNo"
                            />
                        </b-input-group>
                    </b-form-group>

                    <b-form-group
                        label="Fax No."
                        label-for="storeFax"
                    >
                        <b-form-input
                            id="storeFax"
                            v-model="userformData.storeFax"
                        />
                    </b-form-group>

                    <b-form-group
                        label="E-mail ID."
                        label-for="storeEmail"
                    >
                        <b-form-input
                            id="storeEmail"
                            v-model="userformData.storeEmail"
                        />
                    </b-form-group>

                    <!-- Form Actions -->
                    <div class="d-flex mt-2">
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            variant="primary"
                            class="mr-2"
                            type="submit"
                        >
                            Save Data
                        </b-button>
                        <b-button
                            v-ripple.400="'rgba(186, 191, 199, 0.15)'"
                            type="button"
                            variant="outline-secondary"
                            @click="hideMySidebar()"
                        >
                            Cancel
                        </b-button>
                    </div>

                </b-form>
            </validation-observer>
        </template>
    </b-sidebar>
</template>

<script>
    import {
        BSidebar,
        BForm,
        BFormGroup,
        BFormInput,
        BFormTextarea,
        BFormInvalidFeedback,
        BButton,
        BInputGroup,
        BInputGroupPrepend
    } from 'bootstrap-vue'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {ref} from '@vue/composition-api'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {required} from '@validations'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import store from '@/store'
    import {uppercaseInput} from "../../../@core/utils/utils";
    import Swal from "sweetalert2";
    import axios from '@axios'

    export default {
        components: {
            BSidebar,
            BForm,
            BFormGroup,
            BFormInput,
            BFormTextarea,
            BFormInvalidFeedback,
            BButton,
            vSelect,
            BInputGroup,
            BInputGroupPrepend,
            // Form Validation
            ValidationProvider,
            ValidationObserver,
        },
        directives: {
            Ripple,
            uppercaseInput,
        },
        model: {
            prop: 'isAddNewUserSidebarActive',
            event: 'update:is-add-new-user-sidebar-active',
        },
        props: {
            isAddNewUserSidebarActive: {
                type: Boolean,
                required: true,
            },
            userformData: {
                type: Object,
                required: true,
            },
            countryOptions: {
                type: Array,
                required: true,
            },
        },
        data() {

            const stateChangeOptions = []
            const cityChangeOptions = []

            return {
                required,
                stateChangeOptions,
                cityChangeOptions,
            }
        },
        setup(props) {

            const blankUserData = props.userformData

            const userData = ref(JSON.parse(JSON.stringify(blankUserData)))

            const resetuserData = () => {
                userData.value = JSON.parse(JSON.stringify(blankUserData))
            }

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetuserData)

            return {
                userData,
                refFormObserver,
                getValidationState,
                resetForm,

            }
        },
        created() {

            this.$http.get('/api/get-state-options').then(res => {

                this.stateChangeOptions = res.data.data

            })

            this.$http.get('/api/get-city-options').then(res => {

                this.cityChangeOptions = res.data.data

            })
        },
        methods: {
            async getCityDetails(id) {
                await this.$http.get(`/api/city-master/${id}`).then((res) => {
                    this.userformData.storeState = res.data.data.state
                    this.userformData.storeCountry = res.data.data.country
                });
            },
            saveMyERPData() {


                const hasIdExist = this.containsKey(this.userformData, '_id')

                if (hasIdExist) {

                    axios.post('/api/new/store-master-exist',
                        {
                            id: this.userformData._id,
                            storeName: this.userformData.storeName
                        }
                    ).then(res => {
                        if (res.data.data === true) {

                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Store Name ' + this.userformData.storeName + ' Already Exist!',
                            })

                        } else {

                            this.userformData.id = this.userformData._id

                            delete this.userformData._id

                            store.dispatch('store-module/updateStoreMaster', this.userformData).then(response => {

                                if (response.status = 200) {

                                    this.$emit('refetch-data')
                                    this.$emit('update:is-add-new-user-sidebar-active', false)

                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Store Edited',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Edited Store : ${this.userformData.storeName}.`,
                                        },
                                    })
                                }

                            })
                        }
                    })
                } else {

                    axios.post('/api/new/store-master-exist',
                        {
                            storeName: this.userformData.storeName
                        }
                    ).then(res => {
                        if (res.data.data === true) {

                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Store Name ' + this.userformData.storeName + ' Already Exist!',
                            })

                        } else {

                            store.dispatch('store-module/addStoreMaster', this.userformData).then(response => {

                                if (response.status = 200) {

                                    this.$emit('refetch-data')
                                    this.$emit('update:is-add-new-user-sidebar-active', false)

                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Store Created',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Created New Store : ${this.userformData.storeName}.`,
                                        },
                                    })
                                }

                            })
                        }
                    })
                }

            },
            containsKey(obj, key) {
                return Object.keys(obj).includes(key)
            },
            hideMySidebar() {
                this.$emit('refetch-data')
                this.$emit('update:is-add-new-user-sidebar-active', false)
            },
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';

    #add-new-user-sidebar {
        .vs__dropdown-menu {
            max-height: 200px !important;
        }
    }
</style>
