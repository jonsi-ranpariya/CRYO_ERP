<template>
    <b-row>
        <b-col md="12">
            <hr>
        </b-col>
        <b-col md="6">
            <b-form-group
                label="Customer Code"
                label-for="customerCode"
            >
                <b-form-input
                    id="customerCode"
                    v-model="customerData.customerCode"
                    readonly
                />
            </b-form-group>
            <b-form-group
                label="Customer Name"
                label-for="customerName"
            >
                <b-form-input
                    id="customerName"
                    v-model="customerData.customerName"
                    readonly
                />
            </b-form-group>
            <b-form-group
                label="Reference"
                label-for="reference"
            >
                <b-form-input
                    id="reference"
                    v-model="customerData.reference"
                    readonly
                />
            </b-form-group>
            <b-form-group
                label="Address"
                label-for="address"
            >
                <b-form-textarea
                    id="address"
                    v-model="customerData.address"
                />
            </b-form-group>
            <b-form-group
                label="District"
                label-for="District"
            >
                <b-form-input
                    id="District"
                    v-model="customerData.city"
                    readonly
                />
            </b-form-group>
            <b-form-group
                label="State"
                label-for="state"
            >
                <b-form-input
                    id="state"
                    v-model="customerData.state"
                    readonly
                />
            </b-form-group>
            <b-form-group
                label="Country"
                label-for="country"
            >
                <b-form-input
                    id="country"
                    v-model="customerData.country"
                    readonly
                />
            </b-form-group>
            <b-form-group
                label="Fax No."
                label-for="faxNo"
            >
                <b-form-input
                    id="faxNo"
                    v-model="customerData.faxNo"
                    readonly
                />
            </b-form-group>
            <b-form-group
                label="Email Id"
                label-for="email"
            >
                <b-form-input
                    id="email"
                    v-model="customerData.email"
                    readonly
                />
            </b-form-group>
        </b-col>
        <b-col md="6">
            <b-form-group
                label="Project"
                label-for="project"
            >
                <b-form-input
                    id="project"
                    v-model="customerData.project"
                />
            </b-form-group>
            <b-form-group
                label="Reference Date"
                label-for="referenceDate"
            >
                <b-input-group>
                    <b-input-group-prepend>
                        <b-form-datepicker
                            v-model="formatDates.referenceDate"
                            button-only
                            @input="getRefFormateDate($event)"
                            show-decade-nav
                            size="sm"
                            nav-button-variant="primary"
                        />
                    </b-input-group-prepend>
                    <cleave
                        id="expClosureDate"
                        v-model="customerData.referenceDate"
                        class="form-control"
                        :raw="false"
                        :options="dateFormat"
                        placeholder="DD/MM/YYYY"
                        show-decade-nav
                    />
                </b-input-group>
            </b-form-group>
            <b-form-group
                label="Our Reference"
                label-for="ourReference"
            >
                <b-form-input
                    id="ourReference"
                    v-model="customerData.ourReference"
                    readonly
                />
            </b-form-group>
            <b-form-group
                label="Pincode"
                label-for="pincode"
            >
                <b-form-input
                    id="pincode"
                    v-model="customerData.pincode"
                    readonly
                />
            </b-form-group>
            <hr>
            <h5>Kind Attn. Details...</h5>
            <hr>
            <b-form-group
                label="Person Name"
                label-for="personName"
            >
                <b-form-input
                    id="personName"
                    v-model="customerData.personName"
                    readonly
                />
            </b-form-group>
            <b-form-group
                label="Mobile No."
                label-for="mobileNo"
            >
                <b-form-input
                    id="mobileNo"
                    v-model="customerData.mobileNo"
                    readonly
                />
            </b-form-group>
            <b-form-group
                label="Email Id"
                label-for="emailId"
            >
                <b-form-input
                    id="emailID"
                    v-model="customerData.emailId"
                    readonly
                />
            </b-form-group>
        </b-col>
    </b-row>
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
        BForm,
        BButton,
        BFormDatepicker,
        BTab,
        BTabs,
        BTable,
        BDropdown,
        BDropdownItem,
        BInputGroup,
        BInputGroupPrepend
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {ref, computed} from '@vue/composition-api'
    import {forMatIndianDate} from "../../../../@core/utils/utils";
    import Cleave from 'vue-cleave-component'

    export default {
        components: {
            BCardCode,
            ValidationProvider,
            ValidationObserver,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormTextarea,
            BForm,
            BButton,
            BFormDatepicker,
            BTab,
            BTabs,
            BTable,
            BDropdown,
            BDropdownItem,
            vSelect,
            BInputGroup,
            BInputGroupPrepend,
            Cleave
        },
        directives: {
            Ripple,
        },
        props: {
            customerData: {
                type: Object,
                required: true,
            }
        },
        setup(props) {
            const formData = computed(() => props.customerData)
            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                referenceDate: null,
            })

            const getRefFormateDate = (date) => {
                formData.value.referenceDate = forMatIndianDate(date)
            }
            return {
                dateFormat,
                formatDates,
                getRefFormateDate,
                formData
            }
        }
    }
</script>
