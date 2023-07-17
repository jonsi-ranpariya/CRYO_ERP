<template>
    <div>
        <b-row>
            <b-col><b>Transporter Details</b></b-col>
        </b-row>
        <hr>
        <b-form @submit.prevent="saveFormData">
            <b-row>
                <b-col md="6">
                    <b-row>
                        <b-col md="6">
                            <b-form-group
                                label="Transporter"
                                label-for="transporter"
                            >
                                <b-form-input
                                    id="transporter"
                                    v-model="formData.transporter"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="Transporter Id"
                                label-for="transporterId"
                            >
                                <b-form-input
                                    id="transporterId"
                                    v-model="formData.transporterId"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="6">
                            <b-form-group
                                label="Transport Mode"
                                label-for="TransMode"
                            >
                                <v-select
                                    placeholder="Select mode"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :reduce="val => val.value"
                                    :options="transportModeOptions"
                                    :clearable="false"
                                    input-id="TransMode"
                                    v-model="formData.transportMode"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="Vehicle Type"
                                label-for="vehicleType"
                            >
                                <v-select
                                    placeholder="Select type"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :reduce="val => val.value"
                                    :options="vehicleTypeOptions"
                                    :clearable="false"
                                    input-id="vehicleType"
                                    v-model="formData.vehicleType"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="6">
                            <b-form-group
                                label="Vehical No"
                                label-for="vehicalNo"
                            >
                                <b-form-input
                                    id="vehicalNo"
                                    v-model="formData.vehicalNo"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="Distance"
                                label-for="Distance"
                            >
                                <b-form-input
                                    id="distance"
                                    v-model="formData.distance"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                </b-col>
                <b-col md="6">
                    <b-row>
                        <b-col md="6">
                            <b-form-group
                                label="L.R. Date"
                                label-for="lrDate"
                            >
                                <b-input-group>
                                    <b-input-group-prepend>
                                        <b-form-datepicker
                                            v-model="formatDates.invoiceDate"
                                            button-only
                                            @input="getLRFormatDate($event)"
                                            show-decade-nav
                                            size="sm"
                                            nav-button-variant="primary"
                                        />
                                    </b-input-group-prepend>
                                    <cleave
                                        id="lrDate"
                                        v-model="formData.lrDate"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                    />
                                </b-input-group>
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="L.R. Number"
                                label-for="lrNumber"
                            >
                                <b-form-input
                                    id="lrNumber"
                                    v-model="formData.lrNumber"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="6">
                            <b-form-group
                                label="Date of Issue of Invoice"
                                label-for="dateIssueInvoice"
                            >
                                <!--<b-form-datepicker
                                    id="dateIssueInvoice"
                                    :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                    v-model="formData.dateIssueInvoice"
                                />-->
                                <b-input-group>
                                    <b-input-group-prepend>
                                        <b-form-datepicker
                                            v-model="formatDates.dateIssueInvoice"
                                            button-only
                                            @input="getIssueInvoiceFormatDate($event)"
                                            show-decade-nav
                                            size="sm"
                                            nav-button-variant="primary"
                                        />
                                    </b-input-group-prepend>
                                    <cleave
                                        id="dateIssueInvoice"
                                        v-model="formData.dateIssueInvoice"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                    />
                                </b-input-group>
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="Time of Issue of Invoice"
                                label-for="timeIssueInvoice"
                            >
                                <b-form-timepicker
                                    id="timeIssueInvoice"
                                    locale="en"
                                    v-model="formData.timeIssueInvoice"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="6">
                            <b-form-group
                                label="Date of Removal of Goods"
                                label-for="dateRemovalGood"
                            >
                                <!--<b-form-datepicker
                                    id="dateRemovalGood"
                                    :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                    v-model="formData.dateRemovalGood"
                                />-->
                                <b-input-group>
                                    <b-input-group-prepend>
                                        <b-form-datepicker
                                            v-model="formatDates.dateRemovalGood"
                                            button-only
                                            @input="getRemovalGoodFormatDate($event)"
                                            show-decade-nav
                                            size="sm"
                                            nav-button-variant="primary"
                                        />
                                    </b-input-group-prepend>
                                    <cleave
                                        id="dateRemovalGood"
                                        v-model="formData.dateRemovalGood"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                    />
                                </b-input-group>
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="Time of Removal of Goods"
                                label-for="timeRemovalGood"
                            >
                                <b-form-timepicker
                                    id="timeRemovalGood"
                                    locale="en"
                                    v-model="formData.timeRemovalGood"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>

                </b-col>
            </b-row>
            <hr>
            <b-row>
                <b-col><b>Export Details</b></b-col>
            </b-row>
            <hr>
            <b-row>
                <b-col md="6">
                    <b-row>
                        <b-col md="6">
                            <b-form-group
                                label="Export Reference"
                                label-for="exportReference"
                            >
                                <b-form-input
                                    id="exportReference"
                                    v-model="formData.exportReference"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="Other Reference"
                                label-for="otherReference"
                            >
                                <b-form-input
                                    id="otherReference"
                                    v-model="formData.otherReference"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="6">
                            <b-form-group
                                label="Pre-Carriage By"
                                label-for="preCarriageBy"
                            >
                                <b-form-input
                                    id="preCarriageBy"
                                    v-model="formData.preCarriageBy"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="Vessel"
                                label-for="vessel"
                            >
                                <b-form-input
                                    id="vessel"
                                    v-model="formData.vessel"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="6">
                            <b-form-group
                                label="Port of Discharge"
                                label-for="portOfDischarge"
                            >
                                <b-form-input
                                    id="portOfDischarge"
                                    v-model="formData.portOfDischarge"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="Place of Receipt"
                                label-for="placeOfReceipt"
                            >
                                <b-form-input
                                    id="placeOfReceipt"
                                    v-model="formData.placeOfReceipt"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="6">
                            <b-form-group
                                label="Place of Loading"
                                label-for="placeOfLoading"
                            >
                                <b-form-input
                                    id="placeOfLoading"
                                    v-model="formData.placeOfLoading"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="Final Destination"
                                label-for="finalDestination"
                            >
                                <b-form-input
                                    id="finalDestination"
                                    v-model="formData.finalDestination"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                </b-col>
                <b-col md="6">
                    <b-row>
                        <b-col md="6">
                            <b-form-group
                                label="Export CurrentDesc"
                                label-for="exportCurrentDesc"
                            >
                                <b-form-input
                                    id="exportCurrentDesc"
                                    v-model="formData.exportCurrentDesc"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="Export Terms"
                                label-for="exportTerms"
                            >
                                <b-form-input
                                    id="exportTerms"
                                    v-model="formData.exportTerms"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="6">
                            <b-form-group
                                label="Mark & No Title"
                                label-for="markNoTitle"
                            >
                                <b-form-input
                                    id="markNoTitle"
                                    v-model="formData.markNoTitle"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="No & Pkg Title"
                                label-for="noPkgTitle"
                            >
                                <b-form-input
                                    id="noPkgTitle"
                                    v-model="formData.noPkgTitle"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-form-group
                        label="Item Desc Title"
                        label-for="itemDescTitle"
                    >
                        <b-form-input
                            id="itemDescTitle"
                            v-model="formData.itemDescTitle"
                        />
                    </b-form-group>
                    <b-row>
                        <b-col md="6">
                            <b-form-group
                                label="Narration"
                                label-for="narration"
                            >
                                <b-form-input
                                    id="narration"
                                    v-model="formData.narration"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="Notes"
                                label-for="note"
                            >
                                <b-form-textarea
                                    id="note"
                                    rows="2"
                                    v-model="formData.note"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
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
    </div>
</template>
<script>
import {
    BForm,
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BFormDatepicker,
    BFormTimepicker,
    BFormTextarea,
    BButton,
    BInputGroupAppend,
    BInputGroup,
    BInputGroupPrepend
} from 'bootstrap-vue'
import VSelect from 'vue-select'
import {computed, onMounted, onUnmounted, ref} from "@vue/composition-api"
import Cleave from 'vue-cleave-component'
import {forMatIndianDate} from "@core/utils/utils";
import {useToast} from "vue-toastification/composition";
import ToastificationContent from "@core/components/toastification/ToastificationContent";
import _ from "moment/moment";
import store from '@/store';
import router from '@/router';
import purchaseStoreModule from "../../purchaseStoreModule";

export default {
    components: {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormDatepicker,
        BFormTimepicker,
        BFormTextarea,
        BButton,
        Cleave,
        BInputGroupAppend,
        BInputGroup,
        VSelect,
        BInputGroupPrepend
    },
    props: {
        transportExportData: {
            required: true,
        }
    },
    setup(props) {
        const ITEMADDON_APP_STORE_MODULE_NAME = 'purchase-store-module'
        onMounted(() => {
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, purchaseStoreModule)
        });
        onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        });

        const toast = useToast()

        const formData = computed(() => props.transportExportData)

        const transportModeOptions = ref([
            {
                label: 'Road',
                value: '1'
            },
            {
                label: 'Rail',
                value: '2'
            },
            {
                label: 'Air',
                value: '3'
            },
            {
                label: 'Ship',
                value: '4'
            }
        ]);

        const vehicleTypeOptions = ref([
            {label: 'Regular', value: 'R'},
            {label: 'ODC', value: 'O'},
        ])

        const saveFormData = async () => {
            let submitData = {
                _id: router.currentRoute.params.id,
                transportExportData: formData.value
            }
            await store.dispatch('purchase-store-module/updatePurchaseReturn', submitData).then((res) => {
                if (res.status === 200) {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Challan & Invoice Transporter/Export Updated',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: 'You have successfully Updated Challan & Invoice Transporter/Export',
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
            });
        }

        const dateFormat = ref({
            date: true,
            delimiter: '/',
            datePattern: ['d', 'm', 'Y'],
        });

        const formatDates = ref({
            lrDate: null,
            dateIssueInvoice: null,
            dateRemovalGood: null,
        });

        const getLRFormatDate = (date) => {
            formData.value.lrDate = forMatIndianDate(date);
        }

        const getIssueInvoiceFormatDate = (date) => {
            formData.value.dateIssueInvoice = forMatIndianDate(date);
        }

        const getRemovalGoodFormatDate = (date) => {
            formData.value.dateRemovalGood = forMatIndianDate(date);
        }

        setTimeout(() => {
            if (!formData.value.timeIssueInvoice) {
                formData.value.timeIssueInvoice = _(new Date(), 'hh:mm:ss A').format('HH:mm:ss');
            }
            if (!formData.value.timeRemovalGood) {
                formData.value.timeRemovalGood = _(new Date(), 'hh:mm:ss A').format('HH:mm:ss');
            }
            if (!formData.value.lrDate) {
                formData.value.lrDate = forMatIndianDate(new Date())
            }
            if (!formData.value.dateIssueInvoice) {
                formData.value.dateIssueInvoice = forMatIndianDate(new Date())
            }
            if (!formData.value.dateRemovalGood) {
                formData.value.dateRemovalGood = forMatIndianDate(new Date())
            }
        }, 1000);

        return {
            transportModeOptions,
            vehicleTypeOptions,
            formData,
            saveFormData,
            dateFormat,
            formatDates,
            getLRFormatDate,
            getIssueInvoiceFormatDate,
            getRemovalGoodFormatDate
        }
    }
}
</script>
