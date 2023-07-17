<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <validation-observer #default="{ handleSubmit }">
                    <b-form @submit.prevent="handleSubmit(saveFormData)">
                        <b-row>
                            <b-col md="4">
                                <b-form-group
                                    label="Return No."
                                    label-for="returnNumber"
                                >
                                    <b-form-input
                                        id="returnNumber"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <validation-provider
                                    #default="validationContext"
                                    name="Job Card No."
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Job Card No."
                                        label-for="jobCardNumber"
                                    >
                                        <b-input-group class="d-flex">
                                            <b-form-input
                                                id="jobCardNumber"
                                                readonly
                                                v-model="formData.jobCardNumber"
                                                :state="getValidationState(validationContext)"
                                            />
                                            <b-input-group-append>
                                                <b-button variant="primary" @click="openModal">...</b-button>
                                            </b-input-group-append>
                                        </b-input-group>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Return Date"
                                    label-for="returnDate"
                                >
                                    <b-input-group>
                                        <b-input-group-prepend>
                                            <b-form-datepicker
                                                v-model="formatDates.returnDate"
                                                button-only
                                                @input="getReturnFormateDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                            />
                                        </b-input-group-prepend>
                                        <cleave
                                            id="returnDate"
                                            v-model="formData.returnDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                        />
                                    </b-input-group>
                                </b-form-group>
                            </b-col>
                            <!-- Button-->
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
            </b-card-code>
        </b-overlay>
        <!-- Job Card Modal -->
        <b-modal
            id="jobCardModal"
            title="Find"
            size="lg"
            no-close-on-backdrop
            ref="jobCardModal"
            scrollable
            ok-only
            ok-variant="danger"
            ok-title="Cancel"
        >
            <b-table
                responsive="sm"
                :fields="modalTable.fields"
                :items="modalTable.data"
                :bordered="true"
                :hover="true"
                show-empty
                class="table_scroll"
            >
                <template #cell(selectButton)="data">
                    <b-button
                        variant="primary"
                        size="sm"
                        type="button"
                        @click="selectJobCard(data.item)"
                    >
                        Select
                    </b-button>
                </template>
            </b-table>
        </b-modal>
    </div>
</template>
<script>
    import {
        BForm,
        BCol,
        BRow,
        BFormGroup,
        BFormInput,
        BFormDatepicker,
        BFormTextarea,
        BButton,
        BFormValidFeedback,
        BInputGroupAppend,
        BInputGroup,
        BFormInvalidFeedback,
        BFormRadio,
        BTable,
        BFormCheckbox,
        BCard,
        BTabs,
        BTab,
        BOverlay,
        BInputGroupPrepend
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import vSelect from 'vue-select'
    import Ripple from 'vue-ripple-directive'
    import {onUnmounted, ref} from "@vue/composition-api";
    import store from '@/store'
    import {required} from '@validations'
    import {useToast} from 'vue-toastification/composition'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import router from '@/router'
    import axios from '@axios'
    import moment from 'moment'
    import {getUserData} from "../../../auth/utils";
    import ItemDetailsTab from "./tabs/itemDetailsTab";
    import {forMatIndianDate, getTcTodayDate} from '@core/utils/utils'
    import remarkTab from "./tabs/remarkTab";
    import loginDetailsTab from "./tabs/loginDetailsTab"
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import productionPlanningStoreModule from '../productionPlanningStoreModule'
    import Cleave from 'vue-cleave-component'

    export default {
        components: {
            ItemDetailsTab,
            remarkTab,
            loginDetailsTab,
            BCardCode,
            BFormValidFeedback,
            BInputGroupAppend,
            BInputGroup,
            BFormInvalidFeedback,
            BFormRadio,
            BForm,
            BCol,
            BRow,
            BFormGroup,
            BFormInput,
            BFormTextarea,
            BFormDatepicker,
            BButton,
            BTable,
            BFormCheckbox,
            BCard,
            BTabs,
            BTab,
            BOverlay,
            vSelect,
            Cleave,
            ValidationProvider,
            ValidationObserver,
            BInputGroupPrepend
        },
        directives: {
            Ripple,
        },
        setup(jobCardModal) {

            const ITEMADDON_APP_STORE_MODULE_NAME = 'production-planning'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, productionPlanningStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const showOverlayLoading = ref(false)

            const toast = useToast()

            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                returnDate: null,
            })

            const getReturnFormateDate = (date) => {
                formData.value.returnDate = forMatIndianDate(date)
            }

            const CurrentUserData = ref(getUserData())

            const blankFormData = {
                jobCardNumber: null,
                jobCardId: null,
                returnDate: forMatIndianDate(getTcTodayDate()),
                returnNumber: null,
                remarkData: {
                    remark: null,
                },
                loginDetails: {
                    createdBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                    dateTime: moment(new Date()).format('DD/MM/YYYY HH:mm'),
                    lastModifiedBy: null,
                    modifiedDateTime: null,
                    approvedBy: null,
                    approveDateTime: null,
                },
            }

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            jobCardModal = ref()

            const modalTable = ref({
                fields: [
                    {
                        key: 'selectButton',
                        label: ''
                    },
                    {
                        key: 'jobCardNumber',
                        label: 'Job Card Number'
                    },
                    {
                        key: 'itemDescription',
                        label: 'Item Description'
                    },
                    {
                        key: 'itemCode',
                        label: 'J. Item Code'
                    },
                    {
                        key: 'drawingNumber',
                        label: 'Drawing Number'
                    },
                    {
                        key: 'refNo',
                        label: 'Ref No'
                    },
                    {
                        key: 'jobCardDate',
                        label: 'JobCard Date',
                        formatter: val => forMatIndianDate(val)
                    },
                ],
                data: [],
            })

            const openModal = async () => {
                await axios.get('/api/job-cards').then(res => {
                    modalTable.value.data = res.data.data
                })
                jobCardModal.value.show()
            }

            const selectJobCard = (data) => {
                formData.value.jobCardNumber = data.jobCardNumber
                formData.value.jobCardId = data._id
                jobCardModal.value.hide()
            }

            const saveFormData = async () => {
                await store.dispatch('production-planning/addJobCardReturnShop', formData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Job Card Return Shop Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Added Job Card Return Shop.`,
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
                    router.push({name: 'edit-job-card-material-return', params: {id: res.data.data._id}})
                })
            }

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)

            return {
                showOverlayLoading,
                formData,
                resetFormData,
                jobCardModal,
                modalTable,
                openModal,
                selectJobCard,
                saveFormData,

                refFormObserver,
                getValidationState,
                resetForm,
                getReturnFormateDate,
                dateFormat,
                formatDates
            }
        }
    }
</script>
