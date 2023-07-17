<template>
    <div>
        <hr>
        <b-row>
            <b-col md="12">
                <b-table
                    :fields="termFields"
                    :items="termData"
                    bordered
                    hover
                    show-empty
                    responsive
                    class="mb-0 table_scroll"
                    :busy="isBusy"
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
                            <b-dropdown-item @click="deleteWoNote(data.item._id)">
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
            </b-col>
        </b-row>
        <validation-observer #default="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(submitFormData)">
                <b-row>
                    <b-col md="12">
                        <hr>
                        <validation-provider
                            #default="{ errors }"
                            name="Group"
                            rules="required"
                        >
                            <b-form-group
                                label="Group"
                                label-for="group"
                                :state="errors.length > 0 ? false:null"
                            >
                                <v-select
                                    placeholder="Select Group"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="groupOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="group"
                                    v-model="formData.groupId"
                                    @input="getGroupDetails($event)"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="{ errors }"
                            name="Description"
                            rules="required"
                        >
                            <b-form-group
                                label="description"
                                label-for="description"
                            >
                                <b-form-textarea
                                    rows="3"
                                    id="description"
                                    v-model="formData.description"
                                    :state="errors.length > 0 ? false:null"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
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
    import BCardCode from '@core/components/b-card-code'
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
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {ref, onUnmounted} from '@vue/composition-api'
    import axios from '@axios'
    import {getUserData} from "../../../../auth/utils";
    import moment from 'moment'
    import {getTcTodayDate, getSalesTypeListOption} from '@core/utils/utils'
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
            const isBusy = ref(true)

            const termFields = ref([
                {
                    key: 'rowSelected',
                    label: ''
                },
                {
                    key: 'index',
                    label: 'no'
                },
                {
                    key: 'groupName',
                    label: 'Group'
                },
                {
                    key: 'description',
                    label: 'Description'
                },
                {
                    key: 'action',
                    label: 'Action'
                }
            ])
            const termData = ref([])

            const groupOptions = ref([])
            axios.get('/api/get-term-condition-detail-with-group-options').then(res => {
                groupOptions.value = res.data.data
            })

            const reFetchData = async () => {
                isBusy.value = true
                await axios.get(`/api/get-work-order-note/${router.currentRoute.params.id}`).then(res => {
                    termData.value = res.data.data
                })
                isBusy.value = false
            }
            reFetchData()

            const blankFormData = {
                id: null,
                woId: router.currentRoute.params.id,
                groupId: null,
                groupName: null,
                description: null,
            }

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const onRowSelect = (items) => {
                if (items.length > 0) {
                    formData.value.id = items[0]._id
                    formData.value.groupName = items[0].groupName ?? null
                    formData.value.description = items[0].description ?? null
                } else {
                    resetFormData()
                }
            }

            const getGroupDetails = async (id) => {
                await axios.get(`/api/get-term-condition-detail-with-group-details/${id}`).then(res => {
                    formData.value.description = res.data.data.tcGroupDescription
                    formData.value.groupName = res.data.data.tc_group_details.groupDescription + ' - ' +  res.data.data.tcGroupCode
                })
            }

            const submitFormData = async () => {
                if (formData.value.id === null) {
                    await store.dispatch('production-planning/addWorkOrderNote', formData.value).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Work Order Note Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Added Work Order Note.`,
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
                }else{
                    await store.dispatch('production-planning/updateWorkOrderNote', formData.value).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Work Order Note Updated',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Updated Work Order Note.`,
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
                await reFetchData()
            }


            const deleteWoNote = async (id) => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete Work Order Note",
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
                        store.dispatch('production-planning/deleteWorkOrderNote', {id: id}).then(res => {
                            if (res.status === 200) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Work Order Note Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Deleted Work Order Note.`,
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
                        reFetchData()
                    }
                })
            }

            return {
                isBusy,
                termFields,
                termData,
                reFetchData,
                groupOptions,
                formData,
                resetFormData,
                getGroupDetails,
                submitFormData,
                deleteWoNote,
                onRowSelect
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
