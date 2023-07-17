<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <b-form @submit.prevent="saveData">
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                label="Return No."
                                label-for="returnNumber"
                            >
                                <b-form-input
                                    id="returnNumber"
                                    readonly
                                    v-model="formData.returnNumber"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Job Card No."
                                label-for="jobCardNumber"
                            >
                                <b-form-input
                                    id="jobCardNumber"
                                    readonly
                                    v-model="formData.jobCardNumber"
                                />
                            </b-form-group>
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
                                            disabled
                                        />
                                    </b-input-group-prepend>
                                    <cleave
                                        id="returnDate"
                                        v-model="formData.returnDate"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-
                                        disabled
                                    />
                                </b-input-group>
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
            </b-card-code>
        </b-overlay>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <b-tabs pills>
                    <b-tab active>
                        <template #title>
                            <feather-icon
                                icon="FileTextIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Item Details</span>
                        </template>
                        <hr>
                        <item-details-tab
                            :jobCardNumber="formData.jobCardId"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="CheckSquareIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Remark</span>
                        </template>
                        <hr>
                        <remark-tab
                            :remarkData.sync="formData.remarkData"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="LogInIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Login Details</span>
                        </template>
                        <hr>
                        <login-details-tab
                            :loginDetails="formData.loginDetails"
                        />
                    </b-tab>
                </b-tabs>
            </b-card-code>
        </b-overlay>

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
    import BCardCode from "../../../@core/components/b-card-code/BCardCode";
    import vSelect from 'vue-select'
    import Ripple from 'vue-ripple-directive'
    import {onUnmounted, ref} from "@vue/composition-api";
    import store from '@/store'
    import jobCardStoreModule from "../jobCardStoreModule";
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
            BInputGroupPrepend
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

            const showOverlayLoading = ref(false)

            const CurrentUserData = ref(getUserData())

            const blankFormData = {
                id: router.currentRoute.params.id,
                jobCardNumber: null,
                jobCardId: null,
                returnDate: forMatIndianDate(getTcTodayDate()),
                returnNumber: null,
                remarkData: {
                    remark: null,
                },
                loginDetails: {
                    createdBy: null,
                    dateTime: null,
                    lastModifiedBy: null,
                    modifiedDateTime: null,
                    approvedBy: null,
                    approveDateTime: null,
                },
            }
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
            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const refetchData = async () => {
                showOverlayLoading.value = true
                await axios.get('/api/job-card-return-shop/'.concat(router.currentRoute.params.id)).then(res => {
                    formData.value.jobCardNumber = res.data.data.jobCardNumber
                    formData.value.jobCardId = res.data.data.jobCardId
                    formData.value.returnDate = res.data.data.returnDate
                    formData.value.returnNumber = res.data.data.returnNumber
                    formData.value.remarkData = res.data.data.remarkData
                    formData.value.loginDetails = res.data.data.loginDetails
                    formData.value.loginDetails.lastModifiedBy = CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name
                    formData.value.loginDetails.modifiedDateTime = moment(new Date()).format('DD/MM/YYYY HH:mm')
                })
                showOverlayLoading.value = false
            }
            refetchData()

            const saveData = async () => {
                await store.dispatch('production-planning/updateJobCardReturnShop', formData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Job Card Return Shop Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Updated Job Card Return Shop.`,
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
                await refetchData()
            }

            return {
                showOverlayLoading,
                formData,
                resetFormData,
                refetchData,
                saveData,
                dateFormat,
                formatDates,
                getReturnFormateDate
            }
        }
    }
</script>
