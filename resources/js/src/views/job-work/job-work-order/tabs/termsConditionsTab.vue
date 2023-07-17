<template>
    <div>
        <!--table-->
        <b-row>
            <b-col md="12">
                <b-table
                    responsive="sm"
                    :fields="tableFields"
                    :items="tableData"
                    :bordered="true"
                    :hover="true"
                    show-empty
                    class="table_scroll"
                    :busy="isBusy"
                >
                    <!--Loader-->
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

                    <!-- A custom formatted column -->
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
                            <b-dropdown-item @click="editTCdetails(data.item)">
                                <feather-icon
                                    icon="Edit2Icon"
                                    class="mr-50"
                                />
                                <span>Edit</span>
                            </b-dropdown-item>
                            <b-dropdown-item @click="deleteTCdetails(data.item._id)">
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
        <!-- Modal Buttons -->
        <b-row>
            <b-col md="12">

            </b-col>
        </b-row>
        <!--table Close-->
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
                                    :state="getValidationState(validationContext)"
                                    @input="getGroupData($event)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
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
                    <b-col md="6"></b-col>
                    <!--Button-->
                    <b-col md="12">
                        <hr>
                        <b-button
                            variant="primary"
                            type="submit"
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
        BTable,
        BDropdown,
        BDropdownItem,
        BSpinner,
        BFormGroup,
        BFormInvalidFeedback,
        BFormTextarea,
        BFormInput,
        BButton,
        BFormRadio
    } from 'bootstrap-vue'
    import {onUnmounted, ref} from '@vue/composition-api'
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import formValidation from "../../../../@core/comp-functions/forms/form-validation";
    import {required} from '@validations'
    import axios from '@axios'
    import vSelect from 'vue-select'
    import store from '@/store'
    import {useToast} from "vue-toastification/composition";
    import jobWorkStoreModule from "../../jobWorkStoreModule";
    import ToastificationContent from "@core/components/toastification/ToastificationContent";
    import router from '@/router'
    import Swal from "sweetalert2";


    export default {
        components: {
            ValidationProvider,
            ValidationObserver,
            BForm,
            BRow,
            BCol,
            BTable,
            BDropdown,
            BDropdownItem,
            BSpinner,
            vSelect,
            BFormGroup,
            BFormInvalidFeedback,
            BFormTextarea,
            BFormInput,
            BButton,
            BFormRadio
        },
        setup() {
            const toast = useToast()

            const ITEMADDON_APP_STORE_MODULE_NAME = 'job-work-terms-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, jobWorkStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })
            const isBusy = ref(false)
            const tableFields = ref([
                {
                    key: 'index',
                    label: 'No',
                },
                {
                    key: 'tc_group',
                    label: 'Group'
                },
                {
                    key: 'termsCondition',
                    label: 'Term & Condition'
                },
                {
                    key: 'action',
                    label: 'Actions'
                }
            ])
            const tableData = ref([])

            const groupOption = ref([])
            axios.get('/api/get-term-condition-detail-with-group-options').then(res => {
                groupOption.value = res.data.data
            })

            const getGroupData = async (id) => {
                await axios.get(`/api/get-term-condition-detail-with-group-details/${id}`).then(res => {
                    formData.value.termsCondition = res.data.data.tcGroupDescription
                })
            }
            const blankFormData = {
                _id: null,
                jobWorkId: router.currentRoute.params.id,
                groupId: null,
                termsCondition: null,
            }
            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }
            const refetchData = async () => {
                isBusy.value = true
                await axios.get(`/api/get-job-order-term-condition/${router.currentRoute.params.id}`).then(res => {
                    tableData.value = res.data.data
                })
                isBusy.value = false
            }
            refetchData()

            const editTCdetails = (data) => {
                formData.value = data
            }
            const deleteTCdetails = async (id) => {
                await Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete this item",
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
                        store.dispatch('job-work-terms-store-module/deleteJobWorkOrderTermCondition', {id: id}).then((res) => {
                            if (res.status === 200) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Job Work Item Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: 'You have successfully Deleted Job Work Item  ',
                                    },
                                })
                            } else {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Something went wrong',
                                        icon: 'AlertCircleIcon',
                                        variant: 'danger',
                                        text: 'Something went wrong',
                                    },
                                })
                            }
                        })
                     refetchData()
                    }
                })
            }

            const saveFormData = async () => {
                if (formData.value._id === null) {
               store.dispatch('job-work-terms-store-module/addJobWorkOrderTermCondition', formData.value).then((res) => {
                   if (res.status === 200) {
                       toast({
                           component: ToastificationContent,
                           position: 'top-right',
                           props: {
                               title: 'Job Work Order Item Added',
                               icon: 'CheckSquareIcon',
                               variant: 'success',
                               text: 'You have successfully Added Job Work Order',
                           },
                       })
                   } else {
                       toast({
                           component: ToastificationContent,
                           position: 'top-right',
                           props: {
                               title: 'Something went wrong',
                               icon: 'AlertCircleIcon',
                               variant: 'danger',
                               text: 'Something went wrong',
                           },
                       })
                   }
               })
                } else {
                    await store.dispatch('job-work-terms-store-module/updateJobWorkOrderTermCondition', formData.value).then((res) => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Job Work Order Term & Condition Updated',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Updated Job Work Order Term & Condition',
                                },
                            })
                        } else {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Something went wrong',
                                    icon: 'AlertCircleIcon',
                                    variant: 'danger',
                                    text: 'Something went wrong',
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
                saveFormData,
                isBusy,
                tableData,
                tableFields,
                refetchData,
                formData,
                groupOption,
                refFormObserver,
                getValidationState,
                resetFormData,
                resetForm,
                required,
                getGroupData,
                editTCdetails,
                deleteTCdetails

            }
        }
    }
</script>
