<template>
    <div>
        <!--table -->
        <b-row>
            <b-col md="12">
                <b-table
                    :fields="table.fields"
                    :items="table.data"
                    responsive
                    class="mb-0 table_scroll"
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
                            <b-dropdown-item @click="editSlabDetails(data.item)">
                                <feather-icon
                                    icon="Edit2Icon"
                                    class="mr-50"
                                />
                                <span>Edit</span>
                            </b-dropdown-item>
                            <b-dropdown-item @click="deleteSlabDetails(data.item._id)">
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
        <!--table Close-->
        <validation-observer #default="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(saveFormData)">
                <b-row>
                    <b-col md="4">
                        <validation-provider
                            #default="validationContext"
                            name="Type"
                            rules="required"
                        >
                            <b-form-group
                                :state="getValidationState(validationContext)" l
                            >
                                <label for="type">Type <span
                                    class="text-danger erp_required_star"
                                >*</span></label>

                                <v-select
                                    v-model="formData.type"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="typeOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    placeholder="Select Type"
                                    id="type"
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
                            name="Time From"
                            rules="required"
                        >
                            <b-form-group
                                :state="getValidationState(validationContext)"
                            >
                                <label for="time_from">Time From <span
                                    class="text-danger erp_required_star"
                                >*</span></label>

                                <b-form-input
                                    v-model="formData.time_from"
                                    id="time_from"
                                    type="number"
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
                            name="Time To"
                            rules="required"
                        >
                            <b-form-group
                                :state="getValidationState(validationContext)"
                            >
                                <label for="time_to">Time To <span
                                    class="text-danger erp_required_star"
                                >*</span></label>

                                <b-form-input
                                    v-model="formData.time_to"
                                    id="time_to"
                                    type="number"
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
                            name="Late Mark"
                            rules="required"
                        >
                            <b-form-group
                                :state="getValidationState(validationContext)"
                            >
                                <label for="time_from">Late Mark <span
                                    class="text-danger erp_required_star"
                                >*</span></label>

                                <b-form-input
                                    v-model="formData.late_mark"
                                    id="late_mark"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                </b-row>
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
        BFormInput,
        BFormInvalidFeedback,
        BButton
    } from 'bootstrap-vue'
    import {onUnmounted, ref} from '@vue/composition-api'
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import formValidation from "@core/comp-functions/forms/form-validation";
    import vSelect from 'vue-select'
    import Swal from "sweetalert2";
    import {useToast} from "vue-toastification/composition";
    import hrmsStoreModule from "../../../hrmsStoreModule";
    import store from '@/store'
    import ToastificationContent from "@core/components/toastification/ToastificationContent";
    import axios from '@axios'

    export default {
        components: {
            BForm,
            BRow,
            BCol,
            BTable,
            BDropdown,
            BDropdownItem,
            BSpinner,
            ValidationProvider,
            ValidationObserver,
            BFormGroup,
            BFormInput,
            BFormInvalidFeedback,
            vSelect,
            BButton
        },
        setup(){
              /*  const toast = useToast()

                const ITEMADDON_APP_STORE_MODULE_NAME = 'hr-store-module'
                if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, hrmsStoreModule)
                onUnmounted(() => {
                    if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
                })*/

            const typeOptions = ref([
                {label:'Coming Time - Late Mark', value: 1},
                {label:'Going Time -Late Mark', value: 2},
                {label:'Compensation Hours', value: 3},
                {label:'RoundOff OT Hours', value: 4},
            ])
            const isBusy = ref(false)
            const table = ref({
                fields: [
                    {
                        key: 'index',
                        label: 'No',
                    },
                    {
                        key: 'time_from',
                        label: 'Time From',
                    },
                    {
                        key: 'time_to',
                        label: 'Time To',
                    },
                    {
                        key: 'late_mark',
                        label: 'Late Mark',
                    },
                    {
                        key: 'action',
                        label: 'Action',
                    }
                ],
                data: [],
            })
            const blankFormData = {
                type:null,
                time_from:null,
                time_to:null,
                late_mark:null,
            }
            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const refetchData = async () => {
                isBusy.value = true
                /*  await axios.get(`/api/get-job-work-order-item/${router.currentRoute.params.id}`).then(res => {
                      // console.log(res.data.data)
                      table.value.data = res.data.data
                })*/
                table.value.data = [
                    {
                        time_from: '11',
                        time_to: '25',
                        late_mark: '1.00',
                    }
                ]
                isBusy.value = false
            }
            refetchData()

            const editSlabDetails = (data) => {
                formData.value = data
            }
            const deleteSlabDetails = async (id) => {
            /*
                await Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete Slab",
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
                        store.dispatch('hr-store-module/deleteSlabShiftDefinition', {id: id}).then((res) => {
                            if (res.status === 200) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Slab Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: 'You have successfully Deleted Slab',
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
            */
            }

            const saveFormData = async () => {
                console.log(formData.value)
                // if (formData.value._id === null) {
                //     store.dispatch('hr-store-module/addSlabShiftDefinition', formData.value).then((res) => {
                //         if (res.status === 200) {
                //             toast({
                //                 component: ToastificationContent,
                //                 position: 'top-right',
                //                 props: {
                //                     title: 'Slab Added',
                //                     icon: 'CheckSquareIcon',
                //                     variant: 'success',
                //                     text: 'You have successfully Added Slab',
                //                 },
                //             })
                //         } else {
                //             toast({
                //                 component: ToastificationContent,
                //                 position: 'top-right',
                //                 props: {
                //                     title: 'Something went wrong',
                //                     icon: 'AlertCircleIcon',
                //                     variant: 'danger',
                //                     text: 'Something went wrong',
                //                 },
                //             })
                //         }
                //     })
                // } else {
                //     store.dispatch('hr-store-module/updateSlabShiftDefinition', formData.value).then((res) => {
                //         if (res.status === 200) {
                //             toast({
                //                 component: ToastificationContent,
                //                 position: 'top-right',
                //                 props: {
                //                     title: 'Slab Updated',
                //                     icon: 'CheckSquareIcon',
                //                     variant: 'success',
                //                     text: 'You have successfully Updated Slab',
                //                 },
                //             })
                //         } else {
                //             toast({
                //                 component: ToastificationContent,
                //                 position: 'top-right',
                //                 props: {
                //                     title: 'Something went wrong',
                //                     icon: 'AlertCircleIcon',
                //                     variant: 'danger',
                //                     text: 'Something went wrong',
                //                 },
                //             })
                //         }
                //     })
                // }
                // resetFormData();
                // await refetchData()
            }
            const {
                refFormObserver,
                getValidationState,
                resetForm
            } = formValidation(resetFormData)

            return {
                formData,
                isBusy,
                table,
                refetchData,
                editSlabDetails,
                deleteSlabDetails,
                saveFormData,
                refFormObserver,
                getValidationState,
                resetForm,
                resetFormData,
                typeOptions
            }
        }
    }
</script>
