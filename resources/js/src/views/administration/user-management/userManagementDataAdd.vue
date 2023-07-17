<template>
    <div>
        <b-card-code>
            <validation-observer #default="{handleSubmit}">
                <b-form @submit.prevent="handleSubmit(saveFormData)">
                    <b-row>
                        <b-col md="6">
                            <validation-provider
                                #default="validationContext"
                                name="Company"
                                rules="required"
                            >
                                <b-form-group
                                    label="Company"
                                    label-for="company"
                                    :state="getValidationState(validationContext)"
                                >
                                    <v-select
                                        v-model="userFormData.companyId"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="companyDetailOptions"
                                        :clearable="false"
                                        input-id="company"
                                        placeholder="Select Company"
                                        :state="getValidationState(validationContext)"
                                        :reduce="val => val.value"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="6">
                            <validation-provider
                                #default="validationContext"
                                name="Role"
                                rules="required"
                            >
                                <b-form-group
                                    label="Role"
                                    label-for="role"
                                    :state="getValidationState(validationContext)"
                                >
                                    <v-select
                                        v-model="userFormData.role"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="roleOptions"
                                        :clearable="false"
                                        input-id="role"
                                        placeholder="Select Role"
                                        :state="getValidationState(validationContext)"
                                        :reduce="val => val.value"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                    </b-row>
                    <b-row>
                        <!-- Field: Mobile -->
                        <b-col md="4">
                            <validation-provider
                                #default="validationContext"
                                name="First name"
                                rules="required"
                            >
                                <b-form-group
                                    label="First name"
                                    label-for="first_name"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-input
                                        id="first_name"
                                        v-model="userFormData.first_name"
                                        placeholder="First name"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="4">
                            <validation-provider
                                #default="validationContext"
                                name="Last name"
                                rules="required"
                            >
                                <b-form-group
                                    label="Last name"
                                    label-for="last_name"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-input
                                        id="last_name"
                                        v-model="userFormData.last_name"
                                        placeholder="Last Name"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>

                        <!-- Field: Website -->
                        <b-col md="4">
                            <validation-provider
                                #default="validationContext"
                                name="Code"
                                rules="required"
                            >
                                <b-form-group
                                    label="Code"
                                    label-for="code"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-input
                                        id="website"
                                        v-model="userFormData.code"
                                        placeholder="Code"
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
                        <b-col md="4">
                            <validation-provider
                                #default="validationContext"
                                name="User Name"
                                rules="required"
                            >
                                <b-form-group
                                    label="User Name"
                                    label-for="user_name"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-input
                                        id="user_name"
                                        v-model="userFormData.username"
                                        placeholder="User Name"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="4">
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
                        <b-col md="4">
                            <b-form-group>
                                <div class="d-flex justify-content-between">
                                    <label for="password">Password</label>
                                </div>
                                <validation-provider
                                    #default="{ errors }"
                                    name="Password"
                                    rules="required"
                                >
                                    <b-input-group
                                        class="input-group-merge"
                                        :class="errors.length > 0 ? 'is-invalid':null"
                                    >
                                        <b-form-input
                                            id="password"
                                            v-model="userFormData.password"
                                            :state="errors.length > 0 ? false:null"
                                            class="form-control-merge"
                                            :type="passwordFieldType"
                                            name="password"
                                            placeholder="Password"
                                        />
                                        <b-input-group-append is-text>
                                            <feather-icon
                                                class="cursor-pointer"
                                                :icon="passwordToggleIcon"
                                                @click="togglePasswordVisibility"
                                            />
                                        </b-input-group-append>
                                    </b-input-group>
                                    <small class="text-danger">{{ errors[0] }}</small>
                                </validation-provider>
                            </b-form-group>
                        </b-col>
                    </b-row>
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

                </b-form>
            </validation-observer>
        </b-card-code>
    </div>
</template>
<script>
import {
    BButton,
    BCol,
    BForm,
    BFormGroup,
    BFormInput,
    BFormInvalidFeedback,
    BInputGroup,
    BInputGroupAppend,
    BRow,
} from 'bootstrap-vue'
import { onUnmounted, ref } from '@vue/composition-api'
import vSelect from 'vue-select'
import BCardCode from '@core/components/b-card-code/BCardCode'
import { togglePasswordVisibility } from '@core/mixins/ui/forms'
import { ValidationObserver, ValidationProvider } from 'vee-validate'
import { required } from '@validations'
import formValidation from '@core/comp-functions/forms/form-validation'
import router from '@/router'
import { forMatIndianDate, getTcTodayDate } from '@core/utils/utils'
import userStoreModule from './userStoreModule'
import { useToast } from 'vue-toastification/composition'
import store from '@/store'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import axios from '@axios'

export default {
    components: {
        BCardCode,
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        vSelect,
        BFormInvalidFeedback,
        ValidationProvider,
        ValidationObserver,
        BInputGroup,
        BInputGroupAppend,
        BButton,
    },
    computed: {
        passwordToggleIcon() {
            return this.passwordFieldType === 'password' ? 'EyeIcon' : 'EyeOffIcon'
        },
    },
    mixins: [togglePasswordVisibility],
    setup() {
        const toast = useToast()

        const ITEM_ADDON_APP_STORE_MODULE_NAME = 'users-store-module'
        if (!store.hasModule(ITEM_ADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEM_ADDON_APP_STORE_MODULE_NAME, userStoreModule)

        const companyDetailOptions = ref([])
        axios.get('/api/administration/get-company-options').then((res) => {
            companyDetailOptions.value = res.data.data
        })

        const blankFormData = {
            companyId: null,
            first_name: null,
            last_name: null,
            code: null,
            username: null,
            email: null,
            password: null,
            role: null,
            userGeneralDetails: {
                userImages: null,
                ticketNo: null,
                employee_code: null,
                title: null,
                gender: null,
                birth_date: forMatIndianDate(),
                age: null,
                grade: null,
                branch: null,
                department: null,
                designation: null,
                division: null,
                unit: null,
                category: null,
                group: null,
                joining_date: forMatIndianDate(),
                confirm_date: forMatIndianDate(),
                probation_date: forMatIndianDate(),
                last_increment_date: forMatIndianDate(),
                employee_status: null,
                resign_offer_date: forMatIndianDate(),
                last_work_date: forMatIndianDate(),
                f_and_F_date: forMatIndianDate(),
                old_employee_code: null,
                payment_mode: null,
                service_years_month: null,
                freeze_payment: null,
                freeze_date: forMatIndianDate(),
                freeze_reason: null,
            },
            userContactDetails: {
                marital_Status: null,
                children: null,
                father_name: null,
                children_in_hostel: null,
                spouse_name: null,
                local_address: null,
                local_district: null,
                local_PinCode: null,
                local_state: null,
                local_country: null,
                permanent_address: null,
                permanent_district: null,
                permanent_pinCode: null,
                permanent_state: null,
                permanent_country: null,
                residence_phone_no: null,
                office_phone_no: null,
                extension_no: null,
                email: null,
                permanent_phone_no: null,
                mobile_no: null,
                at_email: null,
            },
            userStatutoryDetails: {
                beneficiary_name: null,
                bank_name: null,
                bank_account_no: null,
                branch_name: null,
                branch_code: null,
                ifs_code: null,
                micr_code: null,
                swift_code: null,
                i_ban_number: null,
                employee_type: null,
                employee_remarks: null,
                pan_number: null,
                uan_number: null,
                pran_number: null,
                aadhar_number: null,
                group_join_Date: null,
                surcharge: null,
                gratuity_Code: null,
                provident_fund: null,
                provident_fund_number: null,
                family_pension_fund_number: null,
                voluntary_provident_fund_persent: null,
                provident_fund_join_Date: null,
                provident_fund_remarks: null,
                emp_state_insurance_scheme: null,
                emp_state_insurance_scheme_no: null,
                emp_state_insurance_scheme_imp_code: null,
                emp_state_insurance_scheme_imp_name: null,
                emp_state_insurance_scheme_remarks: null,
                pc_t: null,
                pt_number: null,
            },
            userCheckListDetails: {
                document_name: null,
                documentItem: null,
            }
        }
        const userFormData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            userFormData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const saveFormData = async () => {
            await store.dispatch('users-store-module/addUserManagementDetail', userFormData.value)
                .then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'User Created',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully created user ${userFormData.value.name}.`,
                            },
                        })
                    } else {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Warning',
                                icon: 'AlertCircleIcon',
                                variant: 'warning',
                                text: 'Something went wrong!',
                            },
                        })
                    }
                    router.push({name:'edit-user-details', params: { id: res.data.data._id } })
                })
                .catch((error) => {
                    let response = error.response
                    if (response) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Error',
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: 'Internal Server Error',
                            },
                        })
                    }
                })
        }

        const roleOptions = ref([])
        axios.get('/api/get-role-all-options').then(res => {
            roleOptions.value = res.data.data
        })

        const {
            refFormObserver,
            getValidationState,
            resetForm
        } = formValidation(resetFormData)

        return {
            companyDetailOptions,

            /*Form Data*/
            saveFormData,
            userFormData,
            roleOptions,

            /*validations*/
            resetFormData,
            refFormObserver,
            getValidationState,
            resetForm,
            required,

        }
    }
}
</script>
