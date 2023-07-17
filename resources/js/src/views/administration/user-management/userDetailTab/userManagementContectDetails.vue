<template>
    <div><br>
        <validation-observer #default="{handleSubmit}">
            <b-form @submit.prevent="handleSubmit(saveFormData)" class="mb-2">
            <b-row>
                <b-col
                    cols="12"
                    md="6"
                    lg="3"
                >
                    <validation-provider
                        #default="validationContext"
                        name="Marital Status"
                        rules=""
                    >
                    <b-form-group
                        label="Marital Status"
                        label-for="marital_Status"
                        :state="getValidationState(validationContext)"
                    >
                        <v-select
                            v-model="userFormData.marital_Status"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="maritalStatusOptions"
                            :clearable="false"
                            input-id="marital_Status"
                            placeholder="Select Status"
                            :state="getValidationState(validationContext)"
                        />
                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                            {{ validationContext.errors[0] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    </validation-provider>
                </b-col>
                <b-col
                    cols="12"
                    md="6"
                    lg="3"
                >
                    <validation-provider
                        #default="validationContext"
                        name="Children"
                        rules=""
                    >
                    <b-form-group
                        label="Children"
                        label-for="children"
                        :state="getValidationState(validationContext)"
                    >
                        <b-form-input
                            id="children"
                            v-model="userFormData.children"
                            :state="getValidationState(validationContext)"
                        />
                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                            {{ validationContext.errors[0] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    </validation-provider>
                </b-col>
                <b-col
                    cols="12"
                    md="6"
                    lg="6"
                >
                    <validation-provider
                        #default="validationContext"
                        name="Father Name"
                        rules=""
                    >
                    <b-form-group
                        label="Father Name"
                        label-for="father_name"
                        :state="getValidationState(validationContext)"
                    >
                        <b-form-input
                            id="father_name"
                            placeholder="Father Name"
                            v-model="userFormData.father_name"
                            :state="getValidationState(validationContext)"
                        />
                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                            {{ validationContext.errors[0] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    </validation-provider>
                </b-col>
            </b-row>
            <b-row>
                <b-col
                    cols="12"
                    md="6"
                    lg="3"
                >
                </b-col>

                <b-col
                    cols="12"
                    md="6"
                    lg="3"
                >
                    <validation-provider
                        #default="validationContext"
                        name="Children in Hostel"
                        rules=""
                    >
                    <b-form-group
                        label="Children in Hostel"
                        label-for="children_in_hostel"
                        :state="getValidationState(validationContext)"
                    >
                        <b-form-input
                            id="children_in_hostel"
                            v-model="userFormData.children_in_hostel"
                            :state="getValidationState(validationContext)"
                        />
                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                            {{ validationContext.errors[0] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    </validation-provider>
                </b-col>
                <b-col
                    cols="12"
                    md="6"
                    lg="6"
                >
                    <validation-provider
                        #default="validationContext"
                        name="Spouse Name"
                        rules=""
                    >
                    <b-form-group
                        label="Spouse Name"
                        label-for="spouse_name"
                        :state="getValidationState(validationContext)"
                    >
                        <b-form-input
                            id="spouse_name"
                            placeholder="Spouse Name"
                            v-model="userFormData.spouse_name"
                            :state="getValidationState(validationContext)"
                        />
                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                            {{ validationContext.errors[0] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    </validation-provider>
                </b-col>
            </b-row>
            <hr>
            <b-row>
                <b-col md="8">
                    <validation-provider
                        #default="validationContext"
                        name="Local Address"
                        rules=""
                    >
                        <b-form-group
                            label="Local Address"
                            label-for="local_address"
                            :state="getValidationState(validationContext)"
                        >
                            <b-form-textarea
                                id="local_address"
                                v-model="userFormData.local_address"
                                :state="getValidationState(validationContext)"
                            />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>
                </b-col>
                <b-col md="4"><br>
                    <b-button
                        id="copy_permanent_address"
                        variant="primary"
                        class="mb-5 float-right"
                        @click="copyPermanentAddress"
                    >
                        Copy Permanent Address
                    </b-button>
                </b-col>
            </b-row>
            <b-row>
                <b-col
                    cols="12"
                    md="6"
                >
                    <validation-provider
                        #default="validationContext"
                        name="Local District"
                        rules=""
                    >
                    <b-form-group
                        label="District"
                        label-for="local_district"
                        :state="getValidationState(validationContext)"
                    >
                        <v-select
                            placeholder="Select District"
                            v-model="userFormData.local_district"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="cityOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="local_district"
                            @input="getCityDetails($event)"
                            :state="getValidationState(validationContext)"
                        />
                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                            {{ validationContext.errors[0] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    </validation-provider>
                    <validation-provider
                        #default="validationContext"
                        name="Local Pin-Code"
                        rules=""
                    >
                    <b-form-group
                        label="Pin-Code"
                        label-for="local_PinCode"
                        :state="getValidationState(validationContext)"
                    >
                        <b-form-input
                            id="local_PinCode"
                            placeholder="Enter Pin-Code"
                            v-model="userFormData.local_PinCode"
                            :state="getValidationState(validationContext)"
                            type="number"
                        />
                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                            {{ validationContext.errors[0] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    </validation-provider>
                </b-col>
                <b-col
                    cols="12"
                    md="6"
                >
                    <validation-provider
                        #default="validationContext"
                        name="Local State"
                        rules=""
                    >
                    <b-form-group
                        label="State"
                        label-for="local_state"
                        :state="getValidationState(validationContext)"
                    >
                        <v-select
                            placeholder="Select State"
                            v-model="userFormData.local_state"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="stateOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="local_state"
                            :state="getValidationState(validationContext)"
                        />
                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                            {{ validationContext.errors[0] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    </validation-provider>
                    <validation-provider
                        #default="validationContext"
                        name="Local Country"
                        rules=""
                    >
                    <b-form-group
                        label="Country"
                        label-for="local_country"
                        :state="getValidationState(validationContext)"
                    >
                        <v-select
                            placeholder="Select Country"
                            v-model="userFormData.local_country"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="countryOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="local_country"
                            :state="getValidationState(validationContext)"
                        />
                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                            {{ validationContext.errors[0] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    </validation-provider>
                </b-col>
            </b-row>
            <hr>
                <b-row>
                    <b-col md="8">
                        <validation-provider
                            #default="validationContext"
                            name="Permanent Address"
                            rules=""
                        >
                            <b-form-group
                                label="Permanent Address"
                                label-for="permanent_address"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-textarea
                                    id="permanent_address"
                                    v-model="userFormData.permanent_address"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="4"><br>
                        <b-button
                            id="copyAddress"
                            variant="primary"
                            class="mb-5 float-right"
                            @click="copyLocalAddress"
                        >
                            Copy Local Address
                        </b-button>
                    </b-col>
                </b-row>
                <b-row>
                <b-col
                    cols="12"
                    md="6"
                >
                    <validation-provider
                        #default="validationContext"
                        name="District"
                        rules=""
                    >
                    <b-form-group
                        label="District"
                        label-for="permanent_district"
                        :state="getValidationState(validationContext)"
                    >
                        <v-select
                            placeholder="Select District"
                            v-model="userFormData.permanent_district"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="cityOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="permanent_district"
                            @input="getPermntCityDetails($event)"
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
                        rules=""
                    >
                    <b-form-group
                        label="Pin-Code"
                        label-for="permanent_pinCode"
                        :state="getValidationState(validationContext)"
                    >
                        <b-form-input
                            id="permanent_pinCode"
                            placeholder="Enter Pin-Code"
                            v-model="userFormData.permanent_pinCode"
                            :state="getValidationState(validationContext)"
                            type="number"
                        />
                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                            {{ validationContext.errors[0] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    </validation-provider>
                </b-col>
                <b-col
                    cols="12"
                    md="6"
                >
                    <validation-provider
                        #default="validationContext"
                        name="State"
                        rules=""
                    >
                    <b-form-group
                        label="State"
                        label-for="permanent_state"
                        :state="getValidationState(validationContext)"
                    >
                        <v-select
                            placeholder="Select State"
                            v-model="userFormData.permanent_state"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="stateOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="permanent_state"
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
                        rules=""
                    >
                    <b-form-group
                        label="Country"
                        label-for="permanent_country"
                        :state="getValidationState(validationContext)"
                    >
                        <v-select
                            placeholder="Select Country"
                            v-model="userFormData.permanent_country"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="countryOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="permanent_country"
                            :state="getValidationState(validationContext)"
                        />
                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                            {{ validationContext.errors[0] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    </validation-provider>
                </b-col>
            </b-row>
            <hr>
                <div class="d-flex">
                    <feather-icon
                        icon="UsersIcon"
                        size="19"
                    />
                    <h4 class="mb-0 ml-50">
                        Contact Information
                    </h4>
                </div><br>
            <b-row>
                <b-col
                    cols="12"
                    md="6"
                    lg="6"
                >
                    <validation-provider
                        #default="validationContext"
                        name="Residence Phone No."
                        rules=""
                    >
                    <b-form-group
                        label="Residence Phone No."
                        label-for="residence_phone_no"
                        :state="getValidationState(validationContext)"
                    >
                        <b-form-input
                            id="residence_phone_no"
                            v-model="userFormData.residence_phone_no"
                            type="number"
                            placeholder="Phone No"
                            :state="getValidationState(validationContext)"
                        />
                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                            {{ validationContext.errors[0] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    </validation-provider>
                    <b-row>
                        <b-col
                            cols="12"
                            md="6"
                            lg="6"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Office Phone No."
                                rules=""
                            >
                            <b-form-group
                                label="Office Phone No."
                                label-for="office_phone_no"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="office_phone_no"
                                    v-model="userFormData.office_phone_no"
                                    type="number"
                                    placeholder="Phone No"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col
                            cols="12"
                            md="6"
                            lg="6"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Extension No."
                                rules=""
                            >
                            <b-form-group
                                label="Extension No."
                                label-for="extension_no"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="extension_no"
                                    v-model="userFormData.extension_no"
                                    type="number"
                                    placeholder="Extension No"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                            </validation-provider>
                        </b-col>
                    </b-row>
                    <validation-provider
                        #default="validationContext"
                        name="Email"
                        rules="required|email"
                    >
                    <b-form-group
                        label="Email"
                        label-for="email"
                        :state="getValidationState(validationContext)"
                    >
                        <b-form-input
                            id="email"
                            v-model="userFormData.email"
                            placeholder="john@example.com"
                            :state="getValidationState(validationContext)"
                        />
                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                            {{ validationContext.errors[0] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    </validation-provider>
                </b-col>
                <b-col
                    cols="12"
                    md="6"
                    lg="6"
                >
                    <validation-provider
                        #default="validationContext"
                        name="Permanent Phone No."
                        rules=""
                    >
                    <b-form-group
                        label="Permanent Phone No."
                        label-for="permanent_phone_no"
                        :state="getValidationState(validationContext)"
                    >
                        <b-form-input
                            id="permanent_phone_no"
                            v-model="userFormData.permanent_phone_no"
                            type="number"
                            placeholder="Phone No"
                            :state="getValidationState(validationContext)"
                        />
                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                            {{ validationContext.errors[0] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    </validation-provider>
                    <validation-provider
                        #default="validationContext"
                        name="Mobile No."
                        rules="required|max:10"
                    >
                    <b-form-group
                        label="Mobile No."
                        label-for="mobile_no"
                        :state="getValidationState(validationContext)"
                    >
                        <b-form-input
                            id="mobile_no"
                            v-model="userFormData.mobile_no"
                            type="number"
                            placeholder="Mobile No"
                            :state="getValidationState(validationContext)"
                        />
                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                            {{ validationContext.errors[0] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    </validation-provider>
                    <validation-provider
                        #default="validationContext"
                        name="At Email"
                        rules="required|email"
                    >
                    <b-form-group
                        label="At Email"
                        label-for="at_email"
                        :state="getValidationState(validationContext)"
                    >
                        <b-form-input
                            id="at_email"
                            placeholder="john@example.com"
                            v-model="userFormData.at_email"
                            :state="getValidationState(validationContext)"
                        />
                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                            {{ validationContext.errors[0] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    </validation-provider>
                </b-col>
            </b-row>
            <b-row>
                <b-col md="12">
                    <hr>
                    <b-button
                        type="submit"
                        variant="primary"
                        class="mr-1 float-right"
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
    BButton,
    BFormTextarea,
    BFormInvalidFeedback
} from 'bootstrap-vue'
import vSelect from 'vue-select'
import {computed, ref, onUnmounted} from '@vue/composition-api'
import axios from '@axios'
import {ValidationObserver, ValidationProvider} from 'vee-validate'
import {required} from '@validations'
import formValidation from '@core/comp-functions/forms/form-validation'
import userStoreModule from "../userStoreModule";
import {useToast} from "vue-toastification/composition";
import store from '@/store'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import router from '@/router'

export default {
    components:{
        BForm,
        BRow,
        BCol,
        vSelect,
        BFormGroup,
        BFormInput,
        BButton,
        BFormTextarea,
        ValidationObserver,
        ValidationProvider,
        BFormInvalidFeedback
    },
    props:{
        userContactDetails:{
            type: Object,
            required: true,
        }
    },
    setup(props){
        /*
        const toast = useToast()

        const ITEMADDON_APP_STORE_MODULE_NAME = 'users-store-module'
        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, userStoreModule)
        onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        })
        */

        const copyPermanentAddress = () => {
            userFormData.value.local_address = userFormData.value.permanent_address
            userFormData.value.local_district = userFormData.value.permanent_district
            userFormData.value.local_PinCode = userFormData.value.permanent_pinCode
            userFormData.value.local_state = userFormData.value.permanent_state
            userFormData.value.local_country = userFormData.value.permanent_country
        }

        const copyLocalAddress = () => {
            userFormData.value.permanent_address = userFormData.value.local_address
            userFormData.value.permanent_district = userFormData.value.local_district
            userFormData.value.permanent_pinCode = userFormData.value.local_PinCode
            userFormData.value.permanent_state = userFormData.value.local_state
            userFormData.value.permanent_country = userFormData.value.local_country
        }

        const maritalStatusOptions = ref([
            {label:'Married' , value: 1},
            {label:'unMarried' , value: 2},
            {label:'Divorced' , value: 3},
            {label:'Separated' , value: 4},
            {label:'Widowed' , value: 5},
        ])

        const cityOptions = ref([])
        axios.get('/api/get-city-options').then(res => {
            cityOptions.value = res.data.data
        })

        const stateOptions = ref([])
        axios.get('/api/get-state-options').then(res => {
            stateOptions.value = res.data.data
        })

        const countryOptions = ref([])
        axios.get('/api/get-country-options').then(res => {
            countryOptions.value = res.data.data
        })

        const getPermntCityDetails = async (id) => {
            await axios.get(`/api/city-master/${id}`).then((res) => {
                userFormData.value.permanent_state = res.data.data.state
                userFormData.value.permanent_country = res.data.data.country
            });
        }

        const getCityDetails = async (id) => {
            await axios.get(`/api/city-master/${id}`).then((res) => {
                userFormData.value.local_state = res.data.data.state
                userFormData.value.local_country = res.data.data.country
            });
        }

        const userFormData = computed(() => props.userContactDetails)

        const resetFormData = () => {
            userFormData.value = JSON.parse(JSON.stringify(blankFormData))
        }
        const saveFormData = async () => {
            console.log(userFormData.value)
            /* let submitData = {
                 _id: router.currentRoute.params.id,
                 userContactDetails: userFormData.value
             }*/
            /*     await store.dispatch('users-store-module/updateUserManagementDetail', submitData).then((res) => {
                     if (res.status === 200) {
                         toast({
                             component: ToastificationContent,
                             position: 'top-right',
                             props: {
                                 title: 'user Contact Detail updated',
                                 icon: 'CheckSquareIcon',
                                 variant: 'success',
                                 text: `You have successfully Updated User Contact Detail.`,
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
             */
        }
        const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)


        return{
            /*Form Data*/
            userFormData,
            saveFormData,

            /* Option */
            maritalStatusOptions,
            cityOptions,
            stateOptions,
            countryOptions,
            getPermntCityDetails,
            getCityDetails,
            copyPermanentAddress,
            copyLocalAddress,

            /* validations */
            refFormObserver,
            getValidationState,
            resetForm,
            resetFormData,
            required
        }
    }
}
</script>
