<template>
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
    </b-card-code>
</template>

<script>
    import BCardCode from '@core/components/b-card-code'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {
        BRow, BCol, BFormGroup, BFormInput, BFormTextarea, BFormCheckbox, BFormRadio, BForm, BButton, BFormDatepicker,
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {ref, onUnmounted} from '@vue/composition-api'
    import bomStoreModule from '../bomStoreModule'
    import axios from '@axios'
    import {getUserData} from "../../../auth/utils";
    import moment from 'moment'

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
            BFormRadio,
            BFormTextarea,
            BForm,
            BButton,
            BFormDatepicker,
            vSelect
        },
        directives: {
            Ripple,
        },
        setup() {
            const DM_APP_STORE_MODULE_NAME = 'dm-module'
            // Register module
            if (!store.hasModule(DM_APP_STORE_MODULE_NAME)) store.registerModule(DM_APP_STORE_MODULE_NAME, bomStoreModule)
            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(DM_APP_STORE_MODULE_NAME)) store.unregisterModule(DM_APP_STORE_MODULE_NAME)
            })

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
                preparedBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                preparedDate: moment(new Date()).format('DD/MM/YYYY HH:mm'),
                isChecked: 'NO',
                checkedBy: null,
                checkedDate: null,
                isApproved: 'NO',
                approvedBy: null,
                approvedDate: null,
                remarkNote: null,
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

            return {
                PartyListOption,
                SoListOption,
                ItemListOption,
                drawingFormData,
                getPartyCode,
                getSoCodeData,
                getItemDetails,
                required,
            }
        },
        methods: {
            validationForm() {
                this.$refs.simpleRules.validate().then(success => {
                    if (success) {

                        store.dispatch('dm-module/addDrawingMaster', this.drawingFormData).then(response => {
                            if (response.status === 200) {
                                this.$router.push({
                                    name: 'edit-drawing-master',
                                    params: {id: response.data.data._id}
                                })
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Invoice Created',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Created New Drawing Master.`,
                                    },
                                })
                            }
                        })
                    }
                })
            },
        }
    }
</script>
