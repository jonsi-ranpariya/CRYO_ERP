<template>
    <b-overlay
        :show="showOverlayLoading"
        rounded="sm"
    >
        <div>
            <b-card-code>
                <validation-observer ref="simpleRules">
                    <b-form>
                        <b-row>

                            <b-col md="6">
                                <b-form-group
                                    label="Drawing Number"
                                    label-for="drawingNo"
                                >
                                    <validation-provider
                                        #default="{ errors }"
                                        name="Drawing Number"
                                        rules="required"
                                    >
                                        <b-form-input
                                            id="drawingNo"
                                            v-model="drawingFormData.drawingNo"
                                            placeholder="Drawing Number"
                                            :state="errors.length > 0 ? false:null"
                                        />
                                        <small class="text-danger">{{ errors[0] }}</small>
                                    </validation-provider>
                                </b-form-group>
                            </b-col>

                            <b-col md="6">
                                <b-form-group
                                    label="Drawing Title"
                                    label-for="drawingTitle"
                                >
                                    <b-form-input
                                        id="drawingTitle"
                                        v-model="drawingFormData.drawingTitle"
                                    />

                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Drawing Size"
                                    label-for="drawingSize"
                                >
                                    <b-form-input
                                        id="drawingSize"
                                        v-model="drawingFormData.drawingSize"
                                    />

                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Drawing Scale"
                                    label-for="drawingScale"
                                >
                                    <b-form-input
                                        id="drawingScale"
                                        v-model="drawingFormData.drawingScale"
                                    />

                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Drawing Location"
                                    label-for="drawingLocation"
                                >
                                    <b-form-input
                                        id="drawingLocation"
                                        v-model="drawingFormData.drawingLocation"
                                    />

                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Select Item"
                                    label-for="itemId"
                                >

                                    <v-select
                                        v-model="drawingFormData.itemId"
                                        placeholder="Select Item"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="ItemListOption"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        v-on:input="getItemDetails(drawingFormData.itemId)"
                                        input-id="itemId"
                                    />

                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Item Code"
                                    label-for="itemCode"
                                >
                                    <b-form-input
                                        id="itemCode"
                                        v-model="drawingFormData.itemCode"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Item Description"
                                    label-for="itemName"
                                >
                                    <b-form-input
                                        id="itemName"
                                        v-model="drawingFormData.itemName"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Party"
                                    label-for="partyID"
                                >
                                    <v-select
                                        v-model="drawingFormData.partyID"
                                        placeholder="Select Party"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="PartyListOption"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        v-on:input="getPartyCode(drawingFormData.partyID)"
                                        input-id="partyID"
                                    />

                                </b-form-group>
                            </b-col>

                            <b-col md="2">
                                <b-form-group
                                    label="Party Code"
                                    label-for="partyCode"
                                >
                                    <b-form-input
                                        id="partyCode"
                                        v-model="drawingFormData.partyCode"
                                        readonly
                                    />

                                </b-form-group>
                            </b-col>

                            <b-col md="6">
                                <b-form-group
                                    label="Party Name"
                                    label-for="partyName"
                                >
                                    <b-form-input
                                        id="partyName"
                                        v-model="drawingFormData.partyName"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="6">
                                <b-form-group
                                    label="SO No"
                                    label-for="salesOrderId"
                                >
                                    <v-select
                                        v-model="drawingFormData.salesOrderId"
                                        placeholder="Select So NO"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="SoListOption"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        v-on:input="getSoCodeData(drawingFormData.salesOrderId)"
                                        input-id="salesOrderId"
                                    />

                                </b-form-group>
                            </b-col>

                            <b-col md="6">
                                <b-form-group
                                    label="Sales Order No"
                                    label-for="salesOrderNo"
                                >
                                    <b-form-input
                                        id="salesOrderNo"
                                        v-model="drawingFormData.salesOrderNo"
                                        readonly
                                    />

                                </b-form-group>
                            </b-col>

                            <b-col md="12">
                                <b-form-group
                                    label="Remark / Note"
                                    label-for="remarkNote"
                                >
                                    <b-form-textarea
                                        id="remarkNote"
                                        placeholder="Remark Or Note"
                                        rows="2"
                                        v-model="drawingFormData.remarkNote"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="12">
                                <hr>
                            </b-col>

                            <b-col md="6">
                                <b-form-group
                                    label="Prepared BY"
                                    label-for="preparedBy"
                                >
                                    <b-form-input
                                        id="preparedBy"
                                        v-model="drawingFormData.preparedBy"
                                        readonly
                                    />

                                </b-form-group>
                            </b-col>

                            <b-col md="6">
                                <b-form-group
                                    label="Prepared Date"
                                    label-for="preparedDate"
                                >
                                    <b-form-input
                                        id="preparedDate"
                                        v-model="drawingFormData.preparedDate"
                                        readonly
                                    />

                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Checked BY"
                                    label-for="checkedBy"
                                >
                                    <b-form-input
                                        id="checkedBy"
                                        v-model="drawingFormData.checkedBy"
                                        readonly
                                    />

                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Checked Date"
                                    label-for="checkedDate"
                                >
                                    <b-form-input
                                        id="checkedDate"
                                        v-model="drawingFormData.checkedDate"
                                        readonly
                                    />

                                </b-form-group>
                            </b-col>

                            <b-col md="4">

                                <b-button
                                    v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                                    variant="primary"
                                    type="button"
                                    class="mt-2"
                                    @click="checkedDrawingMaster"
                                >
                                    Checked
                                </b-button>

                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Approved BY"
                                    label-for="approvedBy"
                                >
                                    <b-form-input
                                        id="approvedBy"
                                        v-model="drawingFormData.approvedBy"
                                        readonly
                                    />

                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Approve Date"
                                    label-for="approvedDate"
                                >
                                    <b-form-input
                                        id="approvedDate"
                                        v-model="drawingFormData.approvedDate"
                                        readonly
                                    />

                                </b-form-group>
                            </b-col>

                            <b-col md="4">

                                <b-button
                                    v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                                    variant="primary"
                                    type="button"
                                    class="mt-2"
                                    @click="approvedDrawingMaster"
                                >
                                    Approve
                                </b-button>

                            </b-col>

                            <b-col md="12">
                                <hr>
                            </b-col>


                        </b-row>
                        <b-row>
                            <!-- submit and reset -->
                            <b-col>
                                <b-button
                                    v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                                    type="submit"
                                    variant="primary"
                                    class="mr-1"
                                    @click.prevent="validationForm"
                                >
                                    Submit Drawing Detail
                                </b-button>

                            </b-col>
                        </b-row>
                    </b-form>
                </validation-observer>
                <b-row>
                    <b-col md="12">
                        <hr>
                    </b-col>
                    <b-col md="12">
                        <b-tabs pills>
                            <b-tab active>
                                <template #title>
                                    <feather-icon
                                        icon="PackageIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Revision</span>
                                </template>
                                <revision-tab />
                            </b-tab>
                            <b-tab>
                                <template #title>
                                    <feather-icon
                                        icon="FileTextIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Documents</span>
                                </template>
                                <upload-tab />
                            </b-tab>
                        </b-tabs>
                    </b-col>
                </b-row>
            </b-card-code>
        </div>
    </b-overlay>
</template>

<script>
    import BCardCode from '@core/components/b-card-code'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormTextarea,
        BFormCheckbox,
        BFormRadio,
        BForm,
        BButton,
        BFormDatepicker,
        BOverlay,
        BTab,
        BTabs,
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import router from '@/router'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {ref, onUnmounted} from '@vue/composition-api'
    import bomStoreModule from '../bomStoreModule'
    import axios from '@axios'
    import {getUserData} from "../../../auth/utils";
    import moment from 'moment'
    import Swal from 'sweetalert2'
    import {useToast} from 'vue-toastification/composition'
    import revisionTab from './tab/revisionTab'
    import UploadTab from "./tab/uploadTab";

    export default {
        components: {
            UploadTab,
            BCardCode,
            ValidationProvider,
            ValidationObserver,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormTextarea,
            BFormCheckbox,
            BFormRadio,
            BForm,
            BButton,
            BFormDatepicker,
            vSelect,
            BOverlay,
            BTab,
            BTabs,
            revisionTab,
        },
        directives: {
            Ripple,
        },
        methods: {
            validationForm() {
                this.$refs.simpleRules.validate().then(success => {
                    if (success) {
                        store.dispatch('dm-module/updateDrawingMaster', this.drawingFormData).then(response => {
                            if (response.status === 200) {
                                this.$router.push({name: 'drawing-master'})
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Drawing Edited',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Edited Drawing Master`,
                                    },
                                })
                            }
                        })
                    }
                })
            },
        },
        setup() {

            const DM_APP_STORE_MODULE_NAME = 'dm-module'
            // Register module
            if (!store.hasModule(DM_APP_STORE_MODULE_NAME)) store.registerModule(DM_APP_STORE_MODULE_NAME, bomStoreModule)
            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(DM_APP_STORE_MODULE_NAME)) store.unregisterModule(DM_APP_STORE_MODULE_NAME)
            })

            const toast = useToast()

            const currentId = router.currentRoute.params.id

            const showOverlayLoading = ref(false)
            const CurrentUserData = ref(getUserData())
            const PartyListOption = ref([])
            const ItemListOption = ref([])
            const SoListOption = ref([])

            axios.get('/api/party/get-master-options').then(res => {
                PartyListOption.value = res.data.data
            })

            axios.get('/api/get-item-master-options').then(res => {
                ItemListOption.value = res.data.data
            })

            axios.get('/api/get-sales-order-options').then(res => {
                SoListOption.value = res.data.data
            })

            const drawingFormData = ref({
                id: null,
                drawingNo: null,
                drawingTitle: null,
                drawingSize: null,
                drawingScale: null,
                drawingLocation: null,
                partyID: null,
                partyCode: null,
                partyName: null,
                itemId: null,
                itemCode: null,
                itemName: null,
                salesOrderId: null,
                salesOrderNo: null,
                preparedBy: null,
                preparedDate: null,
                isChecked: 'NO',
                checkedBy: null,
                checkedDate: null,
                isApproved: 'NO',
                approvedBy: null,
                approvedDate: null,
                remarkNote: null,
            })

            showOverlayLoading.value = true

            store.dispatch('dm-module/fetchDrawingMasterDetail', {id: router.currentRoute.params.id})
                .then(response => {
                    drawingFormData.value = response.data.data
                    drawingFormData.value.id = response.data.data._id
                    delete drawingFormData.value._id
                    showOverlayLoading.value = false
                })
                .catch(error => {
                    if (error.response.status === 404) {
                        drawingFormData.value = undefined
                        showOverlayLoading.value = false
                    }
                })

            const getPartyCode = async (val) => {

                await axios.get(`/api/party/edit/${val}`).then(res => {


                    drawingFormData.value.partyCode = res.data.data.partyCode
                    drawingFormData.value.partyName = res.data.data.partyName
                    drawingFormData.value.partyID = val

                })


            }

            const getItemDetails = async (val) => {

                await axios.get(`/api/item-master/${val}`).then(res => {

                    drawingFormData.value.itemCode = res.data.data.itemCode
                    drawingFormData.value.itemName = res.data.data.itemDescription
                    drawingFormData.value.drawingId = val
                })
            }

            const getSoCodeData = async (val) => {

                await axios.get(`/api/sales-order/${val}`).then(res => {

                    drawingFormData.value.salesOrderNo = res.data.data.salesOrderNo
                    drawingFormData.value.salesOrderId = val

                })

            }

            const checkedDrawingMaster = () => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to Mask AS Checked ?",
                    icon: 'warning',
                    showCancelButton: true,
                    showDenyButton: true,
                    confirmButtonText: 'Yes, Approve!',
                    denyButtonText: 'No, Decline!',
                    cancelButtonText: 'Cancel',
                    customClass: {
                        confirmButton: 'btn btn-outline-success',
                        cancelButton: 'btn btn-outline-danger ml-1',
                        denyButton: 'btn btn-outline-warning ml-1',
                    },
                    buttonsStyling: false,
                }).then(result => {
                    if (result.isConfirmed) {

                        let formData = {
                            id: currentId,
                            isChecked: 'YES',
                            checkedBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                            checkedDate: moment(new Date()).format('DD/MM/YYYY HH:mm'),
                        }

                        store.dispatch('dm-module/updateDrawingMaster', formData).then(res => {
                            if (res.data.status === 200) {

                                drawingFormData.value.isChecked = 'YES'
                                drawingFormData.value.checkedBy = CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name
                                drawingFormData.value.checkedDate = moment(new Date()).format('DD/MM/YYYY HH:mm')

                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Status Changed',
                                        icon: 'ThumbsUpIcon',
                                        variant: 'success',
                                        text: 'Drawing Master Checked Successfully!',
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
                    if (result.isDenied) {

                        let formData = {
                            id: currentId,
                            isChecked: 'NO',
                            checkedBy: null,
                            checkedDate: null,
                        }

                        store.dispatch('dm-module/updateDrawingMaster', formData).then(res => {
                            if (res.data.status === 200) {

                                drawingFormData.value.isChecked = 'NO'
                                drawingFormData.value.checkedBy = null
                                drawingFormData.value.checkedDate = null

                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Status Changed',
                                        icon: 'ThumbsUpIcon',
                                        variant: 'success',
                                        text: 'Drawing Master UnChecked Successfully!',
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
                    if (result.isDismissed) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Cancel',
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: 'You have abort the task!',
                            },
                        })
                    }
                })
            }

            const approvedDrawingMaster = () => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to Mask AS Approved ?",
                    icon: 'warning',
                    showCancelButton: true,
                    showDenyButton: true,
                    confirmButtonText: 'Yes, Approve!',
                    denyButtonText: 'No, Decline!',
                    cancelButtonText: 'Cancel',
                    customClass: {
                        confirmButton: 'btn btn-outline-success',
                        cancelButton: 'btn btn-outline-danger ml-1',
                        denyButton: 'btn btn-outline-warning ml-1',
                    },
                    buttonsStyling: false,
                }).then(result => {
                    if (result.isConfirmed) {

                        let formData = {
                            id: currentId,
                            isApproved: 'YES',
                            approvedBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                            approvedDate: moment(new Date()).format('DD/MM/YYYY HH:mm'),
                        }

                        store.dispatch('dm-module/updateDrawingMaster', formData).then(res => {
                            if (res.data.status === 200) {

                                drawingFormData.value.isApproved = 'YES'
                                drawingFormData.value.approvedBy = CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name
                                drawingFormData.value.approvedDate = moment(new Date()).format('DD/MM/YYYY HH:mm')

                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Status Changed',
                                        icon: 'ThumbsUpIcon',
                                        variant: 'success',
                                        text: 'Drawing Master Approved Successfully!',
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
                    if (result.isDenied) {

                        let formData = {
                            id: currentId,
                            isApproved: 'NO',
                            approvedBy: null,
                            approvedDate: null,
                        }

                        store.dispatch('dm-module/updateDrawingMaster', formData).then(res => {
                            if (res.data.status === 200) {

                                drawingFormData.value.isApproved = 'NO'
                                drawingFormData.value.approvedBy = null
                                drawingFormData.value.approvedDate = null

                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Status Changed',
                                        icon: 'ThumbsUpIcon',
                                        variant: 'success',
                                        text: 'Drawing Master Un-Approved Successfully!',
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
                    if (result.isDismissed) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Cancel',
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: 'You have abort the task!',
                            },
                        })
                    }
                })
            }

            return {
                PartyListOption,
                SoListOption,
                ItemListOption,
                drawingFormData,
                getPartyCode,
                getSoCodeData,
                getItemDetails,
                checkedDrawingMaster,
                approvedDrawingMaster,
                showOverlayLoading,
                CurrentUserData,
                required,
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
