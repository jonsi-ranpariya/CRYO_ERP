<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <b-button
                    class="float-right"
                    variant="primary"
                    @click="addNewContact()"
                >
                    Add Contact
                </b-button>
            </b-col>
            <b-col cols="12">
                <hr>
                <b-table
                    responsive
                    :items="rows"
                    :bordered="bordered"
                    :fields="fields"
                    :hover="hover"
                    ref="table"
                    show-empty
                >
                    <template #empty="scope">
                        <h5 class="text-center text-uppercase">No Contact Person Available</h5>
                    </template>
                    <template #cell(phoneNo)="data">
                        <span>{{ data.item.phoneNo !== null ? data.item.phoneNoCode + data.item.phoneNo : null }}</span>
                    </template>
                    <template #cell(mobileNo)="data">
                        <span>{{ data.item.mobileNo !== null ? data.item.mobileNoCode + data.item.mobileNo : null }}</span>
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
                            <b-dropdown-item @click="selectContactPersonData(data.item)">
                              <feather-icon
                                  icon="CheckSquareIcon"
                                  class="mr-50"
                              />
                              <span>Select</span>
                            </b-dropdown-item>
                            <b-dropdown-item @click="editContactPersonData(data.item)">
                              <feather-icon
                                  icon="Edit2Icon"
                                  class="mr-50"
                              />
                              <span>Edit</span>
                            </b-dropdown-item>
                            <b-dropdown-item @click="deleteContactPersonData(data.item._id)">
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
                        <h6>Contact Person Details</h6>
                        <hr>
                    </b-col>
                    <b-col md="6">
                        <validation-provider
                            #default="{ errors }"
                            name="Contact Person"
                            rules="required"
                        >
                            <b-form-group
                                label="Contact Person"
                                label-for="contact-person"
                            >
                                <b-form-input
                                    id="contact-person"
                                    placeholder="Contact Person"
                                    v-model="formData.personName"
                                    :state="errors.length > 0 ? false:null"
                                />
                                <b-form-invalid-feedback :state="errors.length > 0 ? false:null">
                                    {{ errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>

                    <b-col md="6">
                        <validation-provider
                            #default="{ errors }"
                            name="Designation"
                            rules=""
                        >
                            <b-form-group
                                label="Designation"
                                label-for="contact-designation"
                                :state="errors.length > 0 ? false:null"
                            >
                                <v-select
                                    v-model="formData.designation"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="designationOptions"
                                    :clearable="false"
                                    input-id="contact-designation"
                                    :reduce="val => val.label"
                                    taggable
                                    @input="getDepartment($event)"
                                />
                                <b-form-invalid-feedback :state="errors.length > 0 ? false:null">
                                    {{ errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>

                    <b-col md="6">
                        <validation-provider
                            #default="{ errors }"
                            name="Department"
                            rules=""
                        >
                            <b-form-group
                                label="Department"
                                label-for="contact-department"
                                :state="errors.length > 0 ? false:null"
                            >
                                <v-select
                                    v-model="formData.department"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="departmentOptions"
                                    :clearable="false"
                                    input-id="contact-department"
                                    :reduce="val => val.label"
                                    taggable
                                />
                                <b-form-invalid-feedback :state="errors.length > 0 ? false:null">
                                    {{ errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>

                    <b-col md="6">
                        <b-form-group
                            label="Division"
                            label-for="contact-division"
                        >
                            <b-form-input
                                id="contact-division"
                                placeholder="Division"
                                v-model="formData.division"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="6">
                        <b-form-group
                            label="Phone No"
                            label-for="contact-phone"
                        >
                            <b-input-group>
                                <b-input-group-prepend>
                                    <!--<v-select
                                        placeholder="Select Country"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="countryCode"
                                        :get-option-label="option => `${option.name} (${option.dial_code}) `"
                                        :clearable="false"
                                        :reduce="val => val.dial_code"
                                        v-model="formData.phoneNoCode"
                                        input-id="phoneNoCode"
                                    />-->
                                    <b-form-input
                                        id="stdCode"
                                        placeholder="STD code"
                                        type="number"
                                        v-model="formData.phoneNoCode"
                                    />
                                </b-input-group-prepend>
                                <b-form-input
                                    id="contact-phone"
                                    placeholder="Phone No"
                                    type="number"
                                    v-model="formData.phoneNo"
                                />
                            </b-input-group>
                        </b-form-group>
                    </b-col>

                    <b-col md="6">
                        <b-form-group
                            label="Mobile No"
                            label-for="contact-mobile"
                        >
                            <b-input-group>
                                <b-input-group-prepend>
                                    <v-select
                                        placeholder="Select Country"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="countryCode"
                                        :get-option-label="option => `${option.name} (${option.dial_code}) `"
                                        :clearable="false"
                                        :reduce="val => val.dial_code"
                                        v-model="formData.mobileNoCode"
                                        input-id="mobileNoCode"
                                    />
                                </b-input-group-prepend>
                                <b-form-input
                                    id="contact-mobile"
                                    placeholder="Mobile No"
                                    type="number"
                                    v-model="formData.mobileNo"
                                />
                            </b-input-group>
                        </b-form-group>
                    </b-col>

                    <b-col md="6">
                        <b-form-group
                            label="Email Id"
                            label-for="contact-email"
                        >
                            <b-form-input
                                id="contact-email"
                                placeholder="Email id"
                                v-model="formData.email"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="6">
                        <b-form-group
                            label="Fax No"
                            label-for="contact-fax"
                        >
                            <b-form-input
                                id="contact-fax"
                                placeholder="Fax NO"
                                type="number"
                                v-model="formData.faxNo"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="EXT No."
                            label-for="extNumber"
                        >
                            <b-form-input
                                id="extNumber"
                                placeholder="EXT No"
                                v-model="formData.extNumber"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Note"
                            label-for="contact-note"
                        >
                            <b-form-textarea
                                id="contact-note"
                                placeholder="Note"
                                rows="2"
                                v-model="formData.note"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col cols="2">
                        <b-form-group>
                            <b-form-checkbox
                                id="contact-status"
                                name="contact-status"
                                value="1"
                                v-model="formData.active"
                            >
                                Active
                            </b-form-checkbox>
                        </b-form-group>
                    </b-col>

                    <b-col cols="2">
                        <b-form-group>
                            <b-form-checkbox
                                id="contact-auto-sms"
                                name="contact-auto-sms"
                                value="1"
                                v-model="formData.autoSms"
                            >
                                Auto SMS
                            </b-form-checkbox>
                        </b-form-group>
                    </b-col>

                    <b-col cols="2">
                        <b-form-group>
                            <b-form-checkbox
                                id="contact-auto-email"
                                name="contact-auto-email"
                                value="1"
                                v-model="formData.autoEmail"
                            >
                                Auto Email
                            </b-form-checkbox>
                        </b-form-group>
                    </b-col>
                </b-row>
                <!-- Action Buttons -->
                <hr>
                <b-button
                    variant="primary"
                    class="mb-1 mb-sm-0 mr-0 mr-sm-1 float-right"
                    :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    type="submit"
                    v-if="isButtonShow"
                >
                    {{ contact }} Contact
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
        BDropdown,
        BDropdownItem,
        BFormInvalidFeedback,
        BInputGroup,
        BInputGroupPrepend
    } from 'bootstrap-vue'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import router from '@/router'
    import store from '@/store'
    import {ref, onUnmounted} from '@vue/composition-api'
    import {useToast} from 'vue-toastification/composition'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {required, numeric, email} from '@validations'
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
            BDropdown,
            BDropdownItem,
            BInputGroup,
            BInputGroupPrepend,
            vSelect,

            BFormInvalidFeedback,
            ValidationProvider,
            ValidationObserver,
        },
        directives: {
            Ripple,
        },
        props: {
            partyData: {
                type: Object,
                required: true,
            },
        },
        computed: {
            countryCode: () => countryCode
        },
        data() {
            const reFetchData = () => {
                this.$store.dispatch('partyStoreModule/fetchPartyContactPersonList', {id: router.currentRoute.params.id})
                    .then(res => {
                        this.rows = res.data.data
                    })
            }
            return {
                fields: [
                    {
                        key: 'personName',
                        label: 'Person Name',
                    },
                    {
                        key: 'department',
                        label: 'Department',
                        formatter: value => typeof value === 'string' ? value : value !== null ? `${value.label}` : null,
                    },
                    {
                        key: 'designation',
                        label: 'Designation',
                        formatter: value => typeof value === 'string' ? value : value !== null ? `${value.label}` : null,
                    },
                    {
                        key: 'division',
                        label: 'Division',
                    },
                    {
                        key: 'phoneNo',
                        label: 'Phone No',
                    },
                    {
                        key: 'mobileNo',
                        label: 'Mobile No',
                    },
                    {
                        key: 'action',
                        label: 'Action',
                    },
                ],
                rows: [],
                designationOptions: [],
                departmentOptions: [],
                bordered: true,
                hover: true,
                isButtonShow: true,
                contact: 'Save',
                reFetchData,
            }
        },
        beforeCreate() {
            /*this.$http.get('/api/party/contact-person').then(res => {
                console.log(res.data.data)
                this.rows = res.data.data
            })*/
            this.$http.get('/api/get-designation-options').then(res => {
                this.designationOptions = res.data.data
            })
            this.$http.get('/api/get-department-options').then(res => {
                this.departmentOptions = res.data.data
            })
            this.$store.dispatch('partyStoreModule/fetchPartyContactPersonList', {id: router.currentRoute.params.id})
                .then(res => {
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

            const partyDetailFormData = {
                id: null,
                partyId: router.currentRoute.params.id,
                isContactPersonData: true,
                personName: null,
                designation: null,
                department: null,
                division: null,
                phoneNo: null,
                phoneNoCode: '+91',
                mobileNo: null,
                mobileNoCode: '+91',
                email: null,
                faxNo: null,
                extNumber: null,
                note: null,
                active: 1,
                autoSms: 0,
                autoEmail: 0,
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
            submitFormData() {
                if (this.formData.id === null) {
                    this.$store.dispatch('master-add/addContactPerson', this.formData).then(res => {
                        this.addNewContact()
                        this.reFetchData()
                        this.$toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Contact Person Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Updated Contact Person: ${this.formData.personName}`,
                            },
                        })
                    })
                } else {
                    this.$store.dispatch('master-add/updateContactPerson', this.formData).then(res => {
                        this.addNewContact()
                        this.reFetchData()
                        this.$toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Contact Person Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Updated Contact Person: ${this.formData.personName}`,
                            },
                        })
                    })
                }
            },
            addNewContact() {
                this.resetGroupData()
                this.isButtonShow = true
                this.contact = 'Save'
            },
            selectContactPersonData(data) {
                this.formData = data
                this.isButtonShow = false
            },
            editContactPersonData(data) {
                this.formData = data
                this.formData.id = data._id
                delete this.formData._id
                this.isButtonShow = true
                this.contact = 'Update'
            },
            deleteContactPersonData(id) {
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
                        store.dispatch(`master-add/deletePartyContactPerson`, {id}).then(response => {
                            if (response.data.status === 200) {
                                this.reFetchData()
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: 'Contact Person Delete Successfully',
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
            },
            async getDepartment(id) {
                await this.$http.get(`/api/get-designation-master-by-name/${id}`).then((res) => {
                    this.formData.department = res.data?.department_detail?.department ?? null
                });
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
