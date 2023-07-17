<template>
    <div>
        <b-row>
            <b-col md="12">
                <b-table
                    :fields="routingFields"
                    :items="routingData"
                    :bordered="true"
                    :hover="true"
                    class="mb-0 table_scroll"
                    :busy="isBusy"
                    show-empty
                    responsive
                    selectable
                    select-mode="single"
                    @row-selected="onRowSelect"
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
                            <b-dropdown-item @click="deleteRouting(data.item._id)">
                                <feather-icon
                                    icon="TrashIcon"
                                    class="mr-50"
                                />
                                <span>Delete</span>
                            </b-dropdown-item>
                        </b-dropdown>
                    </template>

                    <!-- Selection Area -->
                    <template #cell(rowSelected)="{ rowSelected }">
                        <template v-if="rowSelected">
                            <span aria-hidden="true">&check;</span>
                            <span class="sr-only">Selected</span>
                        </template>
                        <template v-else>
                            <span aria-hidden="true">&nbsp;</span>
                            <span class="sr-only">Not selected</span>
                        </template>
                    </template>

                </b-table>
                <hr>
            </b-col>
        </b-row>
        <validation-observer ref="simpleRules" #default="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(submitFormData)">
                <b-row>
                    <b-col md="12">
                        <validation-provider
                            #default="validationContext"
                            name="Routing Description"
                            rules="required"
                        >
                            <b-form-group
                                label="Routing Description"
                                label-for="description"
                            >
                                <b-form-textarea
                                    id="description"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.description"
                                />
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="12">
                        <hr>
                        <b-button
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
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormTextarea,
        BFormCheckbox,
        BForm,
        BButton,
        BFormDatepicker,
        BInputGroup,
        BInputGroupAppend,
        BTable,
        BFormInvalidFeedback,
        BCard,
        BSpinner,
        BOverlay,
        BDropdown,
        BDropdownItem,
    } from 'bootstrap-vue'
    import BCardCode from '@core/components/b-card-code'
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {ref, onUnmounted} from '@vue/composition-api'
    import axios from '@axios'
    import moment from 'moment'
    import {forMatIndianDate} from '@core/utils/utils'
    import productionPlanningStoreModule from '../../productionPlanningStoreModule'
    import {useToast} from 'vue-toastification/composition'
    import router from '@/router'
    import Swal from 'sweetalert2'

    export default {
        components: {
            BCardCode,
            ValidationProvider,
            ValidationObserver,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormCheckbox,
            BFormTextarea,
            BForm,
            BButton,
            BFormDatepicker,
            BInputGroup,
            BInputGroupAppend,
            BTable,
            BFormInvalidFeedback,
            BCard,
            BOverlay,
            BSpinner,
            BDropdown,
            BDropdownItem,
            vSelect
        },
        directives: {
            Ripple,
        },
        setup() {
            const ITEMADDON_APP_STORE_MODULE_NAME = 'production-planning'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, productionPlanningStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const toast = useToast()

            const isBusy = ref(false)

            const routingFields = ref([
                {
                    key: 'rowSelected',
                    label: ''
                },
                {
                    key: 'index',
                    label: 'no'
                },
                {
                    key: 'description',
                    label: 'Description'
                },
                {
                    key: 'created_at',
                    label: 'Created Date',
                    formatter: val => forMatIndianDate(val)
                },
                {
                    key: 'action',
                    label: 'Action'
                },
            ])
            const routingData = ref([])

            const refetchData = async () => {
                isBusy.value = true
                await axios.get(`/api/get-work-order-routing-list/${router.currentRoute.params.id}`).then(res => {
                    routingData.value = res.data.data
                })
                isBusy.value = false
            }
            refetchData()

            const blankFormData = {
                id: null,
                woId: router.currentRoute.params.id,
                description: null,
            }

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const onRowSelect = (items) => {
                if (items.length > 0) {
                    formData.value.id = items[0]._id
                    formData.value.description = items[0].description ?? null
                } else {
                    resetFormData()
                }
            }

            const submitFormData = async () => {
                if (formData.value.id === null) {
                    await store.dispatch('production-planning/addWorkOrderRouting', formData.value).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Work Order Routing Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Added Work Order Routing.`,
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
                } else {
                    await store.dispatch('production-planning/updateWorkOrderRouting', formData.value).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Work Order Routing Updated',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Updated Work Order Routing.`,
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

            const deleteRouting = async (id) => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
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
                        store.dispatch('production-planning/deleteWorkOrderRouting', {id: id}).then(res => {
                            resetFormData()
                            refetchData()
                            if (res.status === 200) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Work Order Routing Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Deleted Work Order Routing.`,
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
                })
            }

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)

            return {
                isBusy,
                routingFields,
                routingData,
                refetchData,
                formData,
                resetFormData,
                submitFormData,
                deleteRouting,

                refFormObserver,
                getValidationState,
                resetForm,
                onRowSelect
            }
        }
    }
</script>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
