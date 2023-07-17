<template>
    <b-card-code>
        <validation-observer ref="simpleRules">
            <b-form>
                <b-row>

                    <b-col md="3">
                        <b-form-group
                            label="Process Sheet No"
                            label-for="processSheetNo"
                        >
                            <b-form-input
                                id="processSheetNo"
                                readonly
                            />

                        </b-form-group>
                    </b-col>

                    <b-col md="9">
                        <b-form-group
                            label="Select Item"
                            label-for="itemId"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Item"
                                rules="required"
                            >
                                <v-select
                                    v-model="ProcessSheetFormData.itemId"
                                    placeholder="Select Item"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="ItemListOption"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    v-on:input="getItemDetails(ProcessSheetFormData.itemId)"
                                    input-id="itemId"
                                    :state="errors.length > 0 ? false:null"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Item Code"
                            label-for="itemCode"
                        >
                            <b-form-input
                                id="itemCode"
                                v-model="ProcessSheetFormData.itemCode"
                                readonly
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="8">
                        <b-form-group
                            label="Item Description"
                            label-for="itemDesc"
                        >
                            <b-form-input
                                id="itemDesc"
                                v-model="ProcessSheetFormData.itemDesc"
                                readonly
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Add. Description"
                            label-for="itemDetailDesc"
                        >
                            <b-form-textarea
                                id="itemAddDesc"
                                v-model="ProcessSheetFormData.itemAddDesc"
                                rows="1"
                                readonly
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="3">
                        <b-form-group
                            label="Drawing Number"
                            label-for="itemDrawingNo"
                        >
                            <b-form-input
                                id="itemDrawingNo"
                                v-model="ProcessSheetFormData.itemDrawingNo"
                                readonly
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Drawing Revision"
                            label-for="itemDrawingRev"
                        >
                            <b-form-input
                                id="itemDrawingRev"
                                v-model="ProcessSheetFormData.itemDrawingRev"
                                readonly
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="3">
                        <b-form-group
                            label="Item UOM"
                            label-for="itemUom"
                        >
                            <b-form-input
                                id="itemUom"
                                v-model="ProcessSheetFormData.itemUom"
                                readonly
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="12">
                        <b-form-group
                            label="Detail Description"
                            label-for="itemDetailDesc"
                        >
                            <b-form-textarea
                                id="itemDetailDesc"
                                v-model="ProcessSheetFormData.itemDetailDesc"
                                rows="1"
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
                            Submit Process Sheet
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
    import productionPlanningStoreModule from '../productionPlanningStoreModule'
    import axios from '@axios'
    import {getUserData} from "../../../auth/utils";
    import moment from 'moment'
    import Swal from "sweetalert2";

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
            const PS_APP_STORE_MODULE_NAME = 'ps-module'
            // Register module
            if (!store.hasModule(PS_APP_STORE_MODULE_NAME)) store.registerModule(PS_APP_STORE_MODULE_NAME, productionPlanningStoreModule)
            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(PS_APP_STORE_MODULE_NAME)) store.unregisterModule(PS_APP_STORE_MODULE_NAME)
            })


            const CurrentUserData = ref(getUserData())

            const ItemListOption = ref([])

            axios.get('/api/get-item-master-options').then(res => {
                ItemListOption.value = res.data.data
            })


            const ProcessSheetFormData = ref({
                id: null,
                processSheetNo: null,
                itemId: null,
                itemCode: null,
                itemDesc: null,
                itemAddDesc: null,
                itemDetailDesc: null,
                itemDrawingNo: null,
                itemDrawingRev: null,
                itemUom: null,
                scrapDetail: ref({
                    matIssueWt: null,
                    scrapItemId: null,
                    scrapCode: null,
                    scrapDesc: null,
                    scrapQty: null,
                }),
                loginDetail: ref({
                    createdBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                    createdDateTime: moment(new Date()).format('DD/MM/YYYY HH:mm'),
                    lastModifiedBy: null,
                    modifiedDateTime: null,
                }),
            })

            const getItemDetails = async (val) => {
                await axios.get(`/api/item-master/${val}`).then(res => {
                    ProcessSheetFormData.value.itemCode = res.data.data.itemCode
                    ProcessSheetFormData.value.itemDesc = res.data.data.itemDescription
                    if (res.data.data.itemDetails) {
                        ProcessSheetFormData.value.itemAddDesc = res.data.data.itemDetails.description
                        ProcessSheetFormData.value.itemDetailDesc = res.data.data.itemDetails.detailDescription
                        ProcessSheetFormData.value.itemDrawingNo = res.data.data.itemDetails.drawingNumber
                        ProcessSheetFormData.value.itemDrawingRev = res.data.data.itemDetails.revision
                    }
                    if (res.data.data.uom_details) {
                        ProcessSheetFormData.value.itemUom = res.data.data.uom_details.uom
                    }
                })
            }

            return {
                ProcessSheetFormData,
                ItemListOption,
                getItemDetails,
                required,
            }
        },
        methods: {
            validationForm() {
                this.$refs.simpleRules.validate().then(success => {
                    if (success) {

                        axios.post('/api/new/job-card-process-sheet-item-code-exist',
                            {
                                // id: this.ProcessSheetFormData._id,
                                itemCode: this.ProcessSheetFormData.itemCode
                            }
                        ).then(response => {
                            if (response.data.data === true) {

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Item Code ' + this.ProcessSheetFormData.itemCode + ' Already Exist!',
                                })

                            } else {

                                //job-card-process-sheet-item-code-exist
                                store.dispatch('ps-module/addProcessSheetMaster', this.ProcessSheetFormData).then(response => {
                                    if (response.status === 200) {
                                        this.$router.push({
                                            name: 'edit-process-sheet-master',
                                            params: {id: response.data.data._id}
                                        })
                                        this.$toast({
                                            component: ToastificationContent,
                                            position: 'top-right',
                                            props: {
                                                title: 'Process Sheet Created',
                                                icon: 'CheckSquareIcon',
                                                variant: 'success',
                                                text: `You have successfully Created New Process Sheet.`,
                                            },
                                        })
                                    }
                                })
                            }
                        })
                    }

                })
            },
        }
    }
</script>
