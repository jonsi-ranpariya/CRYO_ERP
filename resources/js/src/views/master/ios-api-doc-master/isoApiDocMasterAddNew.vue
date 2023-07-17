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
                    Add/Edit IOS/API Document
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
                        name="Doc Name"
                        rules="required"
                    >
                        <b-form-group>

                            <label for="docName">Doc Name <span
                                class="text-danger erp_required_star">*</span></label>

                            <b-form-input
                                id="docName"
                                v-model="userformData.docName"
                                v-uppercaseInput
                                :state="getValidationState(validationContext)"
                                trim
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <validation-provider
                        #default="validationContext"
                        name="Form No"
                        rules="required"
                    >
                        <b-form-group>

                            <label for="docFormNo">Form No <span
                                class="text-danger erp_required_star">*</span></label>

                            <b-form-input
                                id="docFormNo"
                                v-model="userformData.docFormNo"
                                v-uppercaseInput
                                :state="getValidationState(validationContext)"
                                trim
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <b-form-group
                        label="Form Name"
                        label-for="docFormName"
                    >
                        <b-form-input
                            id="docFormName"
                            v-model="userformData.docFormName"
                        />
                    </b-form-group>

                    <b-form-group
                        label="Rev. No."
                        label-for="docRevNo"
                    >
                        <b-form-input
                            id="docRevNo"
                            v-model="userformData.docRevNo"
                        />
                    </b-form-group>

                    <b-form-group
                        label="Issue Date"
                        label-for="docIssueDate"
                    >
                        <b-input-group>
                            <b-input-group-prepend>
                                <b-form-datepicker
                                    v-model="formatDates.docIssueDate"                                                      button-only
                                    @input="getIssueCompleteDate($event)"
                                    show-decade-nav
                                    size="sm"
                                    nav-button-variant="primary"
                                />
                            </b-input-group-prepend>
                            <cleave
                                id="completeDate"
                                v-model="userformData.docIssueDate"
                                class="form-control"
                                :raw="false"
                                :options="dateFormat"
                                placeholder="DD/MM/YYYY"
                                show-decade-nav
                            />
                        </b-input-group>
                    </b-form-group>

                    <b-form-group
                        label="Remark"
                        label-for="docRemark"
                    >
                        <b-form-textarea
                            id="docRemark"
                            v-model="userformData.docRemark"
                            rows="2"
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
        BFormInvalidFeedback,
        BButton,
        BFormTextarea,
        BFormDatepicker,
        BInputGroup,
        BInputGroupPrepend
    } from 'bootstrap-vue'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {ref} from '@vue/composition-api'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {required} from '@validations'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import Ripple from 'vue-ripple-directive'
    import store from '@/store'
    import axios from '@axios'
    import Swal from 'sweetalert2'
    import {uppercaseInput} from "@core/utils/utils";
    import {forMatIndianDate} from "../../../@core/utils/utils";
    import Cleave from 'vue-cleave-component'

    export default {
        components: {
            BSidebar,
            BForm,
            BFormGroup,
            BFormInput,
            BFormInvalidFeedback,
            BButton,
            BFormTextarea,
            BFormDatepicker,

            // Form Validation
            ValidationProvider,
            ValidationObserver,
            Cleave,
            BInputGroup,
            BInputGroupPrepend
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
        },
        data() {
            return {
                required,
            }
        },
        setup(props) {
            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                docIssueDate: null,
            })

            const getIssueCompleteDate = (date) => {
                props.userformData.docIssueDate = forMatIndianDate(date)
            }
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
                getIssueCompleteDate,
                formatDates,
                dateFormat
            }
        },
        methods: {

            saveMyERPData() {

                const hasIdExist = this.containsKey(this.userformData, '_id')

                if (hasIdExist) {

                    axios.post('/api/ios-api-doc-master-exist',
                        {
                            id: this.userformData._id,
                            docName: this.userformData.docName,
                            docFormNo: this.userformData.docFormNo
                        }
                    ).then(res => {
                        if (res.data.data === true) {

                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Doc Name OR Form No Already Exist!',
                            })

                        } else {

                            // save Data
                            this.userformData.id = this.userformData._id

                            delete this.userformData._id

                            store.dispatch('iso-api-doc-module/updateIsoApiDocMaster', this.userformData).then(response => {

                                if (response.status = 200) {

                                    this.$emit('refetch-data')
                                    this.$emit('update:is-add-new-user-sidebar-active', false)

                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Document Edited',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Edited Document : ${this.userformData.docName}.`,
                                        },
                                    })
                                }

                            })
                        }
                    })


                } else {

                    axios.post('/api/ios-api-doc-master-exist',
                        {
                            docName: this.userformData.docName,
                            docFormNo: this.userformData.docFormNo
                        }
                    ).then(res => {
                        if (res.data.data === true) {

                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Doc Name OR Form No Already Exist!',
                            })

                        } else {

                            // save Data
                            store.dispatch('iso-api-doc-module/addIsoApiDocMaster', this.userformData).then(response => {

                                if (response.status = 200) {

                                    this.$emit('refetch-data')
                                    this.$emit('update:is-add-new-user-sidebar-active', false)

                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Document Created',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Created New Document : ${this.userformData.docName}.`,
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
