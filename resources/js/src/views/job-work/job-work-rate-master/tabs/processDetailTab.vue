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
                        <b-dropdown-item @click="editProcessDetail(data.item)">
                            <feather-icon
                                icon="Edit2Icon"
                                class="mr-50"
                            />
                            <span>Edit</span>
                        </b-dropdown-item>
                        <b-dropdown-item @click="deleteProcessDetail(data.item._id)">
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
                        name="Item Code"
                        rules="required"
                    >
                        <b-form-group
                            label="Process"
                            label-for="itemProcess"
                        >
                            <v-select
                                v-model="formData.itemProcess"
                                placeholder="Select Process"
                                :dir="$store.state.appConfig.isRTl ? 'rtl' : 'ltr'"
                                :options="processOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="itemProcess"
                                :state="getValidationState(validationContext)"
                                @input="getProcssSheetDetail($event)"
                            />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>
                    <validation-provider
                        #default="validationContext"
                        name="Item Code"
                        rules="required"
                    >
                        <b-form-group
                            label="Process Description"
                            label-for="processDescription"
                        >
                            <b-form-input
                                id="processDescription"
                                v-model="formData.processDescription"
                                :state="getValidationState(validationContext)"
                            />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>
                </b-col>
                <b-col md=" 6">
                    <b-row>
                    <b-col md="6">
                            <b-form-group
                                label="Process Rate"
                                label-for="processRate"
                            >
                                <b-form-input
                                    id="processRate"
                                    v-model="formData.processRate"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="Rate Tolerance(+) %"
                                label-for="rateTolerance"
                            >
                                <b-form-input
                                    id="rateTolerance"
                                    v-model="formData.rateTolerance"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                        <b-form-group
                            label="Lead Time"
                            label-for="leadTime"
                        >
                            <b-form-input
                                id="leadTime"
                                v-model="formData.leadTime"
                            />
                        </b-form-group>
                </b-col>
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
        BFormGroup,
        BFormInput,
        BInputGroup,
        BFormInvalidFeedback,
        BButton,
        BTable,
        BSpinner,
        BDropdown,
        BDropdownItem,
    } from 'bootstrap-vue'
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import {onUnmounted, ref} from "@vue/composition-api";
    import formValidation from "../../../../@core/comp-functions/forms/form-validation";
    import {required} from "@validations"
    import vSelect from 'vue-select'
    import axios from '@axios'
    import {useToast} from "vue-toastification/composition";
    import jobWorkStoreModule from "../../jobWorkStoreModule";
    import ToastificationContent from "@core/components/toastification/ToastificationContent";
    import store from '@/store'
    import router from '@/router'
    import Ripple from "vue-ripple-directive";
    import Swal from "sweetalert2";
    export default {
        components:{
            ValidationObserver,
            ValidationProvider,
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BInputGroup,
            BFormInvalidFeedback,
            vSelect,
            BButton,
            BTable,
            BSpinner,
            BDropdown,
            BDropdownItem,
        },
        directives: {
            Ripple,
        },
        setup(){
            const toast = useToast()
            const ITEMADDON_APP_STORE_MODULE_NAME = 'job-work-rate-process-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, jobWorkStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const processOption = ref([])

            axios.get('/api/get-process-master-option').then(res => {
                // console.log(res.data.data)
                processOption.value = res.data.data
            })
            const getProcssSheetDetail = async (val) => {
                await axios.get(`/api/process-master/${val}`).then(res => {
                    formData.value.processDescription = res.data.data.processName
                })
            }

            const isBusy = ref(false)

            const tableFields = ref([
                {
                    key: 'index',
                    label: 'No'
                },
                {
                    key: 'processDescription',
                    label: 'Process'
                },
                // {
                //     key: 'processDescription',
                //     label: 'Description'
                // },
                {
                    key: 'processRate',
                    label: 'Process Rate'
                },
                {
                    key: 'rateTolerance',
                    label: 'Rate Tolerance'
                },
                {
                    key: 'action',
                    label: 'Actions'
                }
                ])
            const tableData = ref([])

            const refetchData = async () =>{
                isBusy.value = true
                await axios.get(`/api/new/get-job-work-rate-process/${router.currentRoute.params.id}`).then(res => {
                    tableData.value = res.data.data
                    // console.log(res.data.data)
                })
                isBusy.value = false
            }
            refetchData()

            const BlankFormData ={
                _id: null,
                RateProcessId: router.currentRoute.params.id,
                itemProcess:null,
                processDescription:null,
                processRate:null,
                rateTolerance:null,
                leadTime:null,
            }

            const formData = ref(JSON.parse(JSON.stringify(BlankFormData)))
            const resetFormData = async () => {
                formData.value = JSON.parse(JSON.stringify(BlankFormData))
            }

            const editProcessDetail = (data) => {
                formData.value = data
            }

            const deleteProcessDetail = async (id) => {
                await Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete Job Work Rate Process",
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
                        store.dispatch('job-work-rate-process-store-module/deleteJobWorkRateMasterProcess', {id: id}).then(res => {
                            if (res.status === 200) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Job Work Rate Process Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Deleted.`,
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
                    store.dispatch('job-work-rate-process-store-module/addJobWorkRateMasterProcess', formData.value).then((res) => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Job Work Item Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Added Job Work Rate Process',
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
                }   else {
                    await store.dispatch('job-work-rate-process-store-module/updateJobWorkRateMasterProcess', formData.value).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Job Work Rate Process Term And Condition Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Added Job Work Rate Process Term And Condition.`,
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
            return{
                refFormObserver,
                getValidationState,
                resetForm,
                resetFormData,
                formData,
                saveFormData,
                required,
                processOption,
                editProcessDetail,
                deleteProcessDetail,
                isBusy,
                tableFields,
                tableData,
                refetchData,
                getProcssSheetDetail

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
