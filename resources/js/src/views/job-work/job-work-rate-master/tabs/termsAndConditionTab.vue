<template>
    <div>
        <!-- Table -->
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
                            <b-dropdown-item @click="editTermCondition(data.item)">
                                <feather-icon
                                    icon="Edit2Icon"
                                    class="mr-50"
                                />
                                <span>Edit</span>
                            </b-dropdown-item>
                            <b-dropdown-item @click="deleteTermCondition(data.item._id)">
                                <feather-icon
                                    icon="TrashIcon"
                                    class="mr-50"
                                />
                                <span>Delete</span>
                            </b-dropdown-item>
                        </b-dropdown>
                    </template>
                </b-table>
                <hr>
            </b-col>
        </b-row>

        <validation-observer #default="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(saveFormData)">
                <b-row>
                    <b-col md="6">
                        <validation-provider
                            #default="validationContext"
                            name="Group"
                            rules="required"
                        >
                            <b-form-group
                                label="Group"
                                label-for="group"
                            >
                                <v-select
                                    v-model="formData.groupId"
                                    placeholder="Select group"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="groupOption"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="group"
                                    @input="getGroupData($event)"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Terms & Condition"
                            label-for="termsCondition"
                        >
                            <b-form-textarea
                                id="termsCondition"
                                rows="2"
                                v-model="formData.termsCondition"
                            />
                        </b-form-group>
                    </b-col>
                    <!-- Button-->
                    <b-col md="12">
                        <hr>
                        <b-button
                            class="float-right"
                            variant="primary"
                            type="submit"
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
        BInputGroup,
        BInputGroupAppend,
        BFormInvalidFeedback,
        BButton,
        BFormTextarea,
        BTable,
        BDropdown,
        BDropdownItem,
        BSpinner,
    } from 'bootstrap-vue'
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {required} from '@validations'
    import {onUnmounted, ref} from "@vue/composition-api";
    import vSelect from 'vue-select'
    import axios from '@axios'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {useToast} from 'vue-toastification/composition'
    import Swal from 'sweetalert2'
    import router from '@/router'
    import jobWorkStoreModule from "../../jobWorkStoreModule";

    export default {
        components: {
            ValidationObserver,
            ValidationProvider,
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BInputGroup,
            BInputGroupAppend,
            BFormInvalidFeedback,
            BButton,
            BFormTextarea,
            vSelect,
            BTable,
            BDropdown,
            BDropdownItem,
            BSpinner,
        },
        setup() {
            const toast = useToast()
            const ITEMADDON_APP_STORE_MODULE_NAME = 'job-work-rate-term-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, jobWorkStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const isBusy = ref(false)
            const tableFields = ref([
                {
                    key: 'index',
                    label: 'No'
                },
                {
                    key: 'groupDescription',
                    label: 'Group Description'
                },
                {
                    key: 'termsCondition',
                    label: 'Term & Condition Description'
                },
                {
                    key: 'action',
                    label: 'Actions'
                }
            ])
            const tableData = ref([])

            const refetchData = async () => {
                isBusy.value = true
                await axios.get(`/api/new/get-job-work-rate-terms-condition/${router.currentRoute.params.id}`).then(res => {
                    tableData.value = res.data.data
                })
                isBusy.value = false
            }
            refetchData()

            //terms and condition
            const groupOption = ref([])
            axios.get('/api/get-term-condition-detail-with-group-options').then(res => {
                groupOption.value = res.data.data
            })

            const getGroupData = async (id) => {
                await axios.get(`/api/get-term-condition-detail-with-group-details/${id}`).then(res => {
                    formData.value.termsCondition = res.data.data.tcGroupDescription
                    formData.value.groupDescription = res.data.data?.tc_group_details?.groupDescription ?? null
                })
            }

            const blankFormData = {
                _id: null,
                jobRateId: router.currentRoute.params.id,
                groupId: null,
                groupDescription: null,
                termsCondition: null,
            }
            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const editTermCondition = (data) => {
                formData.value = data
            }

                const deleteTermCondition = async (id) => {
                    await Swal.fire({
                        title: 'Are you sure?',
                        text: "Delete Job Work Rate Master Term And Condition",
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
                            store.dispatch('job-work-rate-term-store-module/deleteJobWorkRateMasterTerms', {id: id}).then(res => {
                                if (res.status === 200) {
                                    toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Term And Condition Deleted',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Deleted Term And Condition.`,
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

            const saveFormData = async () => {
                if (formData.value._id === null) {
                    await store.dispatch('job-work-rate-term-store-module/addJobWorkRateMasterTerms', formData.value).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Job Work Rate Master Term And Condition Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Added Job Work Rate Master Term And Condition.`,
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
                }else {
                    await store.dispatch('job-work-rate-term-store-module/updateJobWorkRateMasterTerms', formData.value).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Job Work Rate Master Term And Condition Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Added Job Work Rate Master Term And Condition.`,
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

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)
            return {
                formData,
                refFormObserver,
                getValidationState,
                resetForm,
                resetFormData,
                required,
                saveFormData,
                groupOption,
                getGroupData,
                tableFields,
                tableData,
                refetchData,
                isBusy,
                deleteTermCondition,
                editTermCondition,
            }
        },
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
