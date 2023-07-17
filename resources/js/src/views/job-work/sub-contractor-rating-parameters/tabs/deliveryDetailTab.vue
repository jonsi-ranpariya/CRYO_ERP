<template>
    <div>
        <b-card-code>
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

            <!--      form Data-->
            <b-form @submit.prevent="saveFormData">
                <b-row>
                    <b-col>
                        <b-row>
                            <b-col md="12">
                                <hr>
                                <h5>Delivery Parameters</h5>
                                <hr>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="4">
                                <b-form-group
                                    label="Form Day"
                                    label-for="formDay"
                                >
                                    <b-form-input
                                        id="formDay"
                                        v-model="formData.formDay"
                                        type="number"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="To Day"
                                    label-for="toDay"
                                >
                                    <b-form-input
                                        id="toDay"
                                        v-model="formData.toDay"
                                        type="number"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Percentage(%)"
                                    label-for="percentage"
                                >
                                    <b-form-input
                                        id="percentage"
                                        v-model="formData.percentages"
                                        type="number"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
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
        </b-card-code>
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
        BButton,
        BTable,
        BSpinner,
        BDropdown,
        BDropdownItem,
    } from 'bootstrap-vue'
    import {onUnmounted, ref} from "@vue/composition-api";
    import Ripple from "vue-ripple-directive";
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import {useToast} from "vue-toastification/composition";
    import jobWorkStoreModule from "../../jobWorkStoreModule";
    import ToastificationContent from "@core/components/toastification/ToastificationContent";
    import store from '@/store'
    import router from '@/router'
    import axios from '@axios'
    import Swal from "sweetalert2";

    export default {
        components:{
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BInputGroup,
            BButton,
            BTable,
            BSpinner,
            BDropdown,
            BDropdownItem,
            BCardCode,
        },
        directives: {
            Ripple,
        },
        setup(){
            const toast = useToast()
            const ITEMADDON_APP_STORE_MODULE_NAME = 'subcontractor-rate-parameter-store-module'
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
                    key: 'formDay',
                    label: 'Form Day'
                },
                {
                    key: 'toDay',
                    label: 'To Day'
                },
                {
                    key: 'percentages',
                    label: 'Del(%)'
                },
                {
                    key: 'action',
                    label: 'Actions'
                }
            ])
            const tableData = ref([])


            const formData = ref({
                _id: null,
                formDay: null,
                toDay:null,
                percentages:null,
                flag:1
            })

            const refetchData = async () =>{
                isBusy.value = true
                await axios.get(`/api/new/sub-contractor-rate-parameter?flag=1`).then(res => {
                    tableData.value = res.data.data
                })
                isBusy.value = false
            }
            refetchData()

            const editProcessDetail = (data) => {
                formData.value = data
            }

            const deleteProcessDetail = async (id) => {
                await Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete Delivery Parameter",
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
                        store.dispatch('subcontractor-rate-parameter-store-module/deleteDeliveryParameter', {id: id}).then(res => {
                            if (res.status === 200) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Delivery Parameter',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Deleted Delivery Parameter.`,
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
                        refetchData()
                    }
                })
            }

            const saveFormData = async () => {
                if (formData.value._id === null) {
                    store.dispatch('subcontractor-rate-parameter-store-module/addSubContractorRateParameter', formData.value).then((res) => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Delivery Rate Parameter Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Added Delivery Rate Parameter',
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
                    await store.dispatch('subcontractor-rate-parameter-store-module/updateDeliveryParameter', formData.value).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Delivery Rate Parameter Update',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Update Delivery Rate Parameter.`,
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
                await refetchData()
            }
            return{
                formData,
                saveFormData,
                editProcessDetail,
                deleteProcessDetail,
                isBusy,
                tableFields,
                tableData,
                refetchData,
            }

        }
    }
</script>
