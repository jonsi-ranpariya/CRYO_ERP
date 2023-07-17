<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <h4>Note Details</h4>
                <hr>
            </b-col>
        </b-row>
        <validation-observer ref="simpleRules">
            <b-form>
                <b-row>
                    <b-col md="12">
                        <b-form-group
                            label="Header Option"
                            label-for="headerOption"
                        >
                            <v-select
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="headerOptions"
                                :clearable="true"
                                input-id="headerOption"
                                :reduce="val => val.value"
                                v-model="noteTabData.headerId"
                                v-on:input="getHeaderData($event)"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Header"
                            label-for="noteHeader"
                        >
                            <b-form-textarea
                                id="noteHeader"
                                v-model="noteTabData.noteHeader"
                                rows="1"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Footer"
                            label-for="footer"
                        >
                            <v-select
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="footerOptions"
                                :clearable="true"
                                input-id="footer"
                                :reduce="val => val.value"
                                v-model="noteTabData.footerId"
                                v-on:input="getFooterData($event)"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Note Footer"
                            label-for="noteFooter"
                        >
                            <b-form-textarea
                                id="noteFooter"
                                v-model="noteTabData.noteFooter"
                                rows="1"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Note"
                            label-for="noteNote"
                        >
                            <b-form-textarea
                                id="noteNote"
                                v-model="noteTabData.noteNote"
                                rows="1"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Note 2"
                            label-for="noteNote2"
                        >
                            <b-form-textarea
                                id="noteNote2"
                                v-model="noteTabData.noteNote2"
                                rows="1"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Internal Note"
                            label-for="noteInternalNote"
                        >
                            <b-form-textarea
                                id="noteInternalNote"
                                v-model="noteTabData.noteInternalNote"
                                rows="1"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Item Description Title"
                            label-for="noteItemDescTitle"
                        >
                            <b-form-textarea
                                id="noteItemDescTitle"
                                v-model="noteTabData.noteItemDescTitle"
                                rows="1"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <!-- submit and reset -->
                    <b-col md="12">
                        <hr>
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            type="submit"
                            variant="primary"
                            class="mr-1 float-right"
                            @click.prevent="validationForm"
                        >
                            Add / Save Note
                        </b-button>
                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>

    </div>
</template>
<script>
import BCardCode from '@core/components/b-card-code'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import {
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BFormCheckbox,
    BFormTextarea,
    BForm,
    BDropdown,
    BDropdownItem,
    BButton,
    BFormDatepicker,
    BOverlay,
    BTable
} from 'bootstrap-vue'
import { required } from '@validations'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import router from '@/router'
import store from '@/store'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { ref, onUnmounted } from '@vue/composition-api'
import salesStoreModule from '../../salesStoreModule'
import axios from '@axios'

export default {
    components: {
        BCardCode,
        ValidationProvider,
        ValidationObserver,
        BRow,
        BCol,
        BFormGroup,
        BFormCheckbox,
        BFormInput,
        BFormTextarea,
        BForm,
        BButton,
        BDropdown,
        BDropdownItem,
        BFormDatepicker,
        vSelect,
        BOverlay,
        BTable
    },
    directives: {
        Ripple,
    },
    methods: {
        validationForm() {
            this.$refs.simpleRules.validate()
                .then(success => {
                    if (success) {
                        const SubmitFormData = {
                            id: this.CurrentSalesOrderId,
                            noteDetails: this.noteTabData,
                        }
                        store.dispatch('sales-order-module/updateSalesOrder', SubmitFormData)
                            .then(response => {
                                if (response.status === 200) {
                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Note Edited',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Edited Sales Order Note`,
                                        },
                                    })
                                }
                            })
                    }
                })
        },
        containsKey(obj, key) {
            return Object.keys(obj)
                .includes(key)
        },
    },
    props: {
        noteTabData: {
            type: Object,
            required: true,
        }
    },
    setup(props) {
        const SO_APP_STORE_MODULE_NAME = 'sales-order-module'
        // Register module
        if (!store.hasModule(SO_APP_STORE_MODULE_NAME)) store.registerModule(SO_APP_STORE_MODULE_NAME, salesStoreModule)

        const CurrentSalesOrderId = ref(router.currentRoute.params.id)

        const headerOptions = ref([])
        axios.get('/api/new/document-sales-order-header-options')
            .then(res => {
                headerOptions.value = res.data?.data
            })

        const getHeaderData = async (id) => {
            if (id == null) {
                props.noteTabData.noteHeader = null
            } else {
                await axios.get(`/api/document-header/${id}`)
                    .then(res => {
                        props.noteTabData.noteHeader = res.data.data.header
                    })
            }

        }

        const footerOptions = ref([])
        axios.get('/api/new/document-sales-order-footer-options')
            .then(res => {
                footerOptions.value = res.data.data
            })

        const getFooterData = async (id) => {
            if (id == null) {
                props.noteTabData.noteFooter = null
            } else {
                await axios.get(`/api/document-footer/${id}`)
                    .then(res => {
                        props.noteTabData.noteFooter = res.data.data.footer
                    })
            }
        }

        return {
            CurrentSalesOrderId,
            required,
            headerOptions,
            getHeaderData,
            footerOptions,
            getFooterData
        }
    },
}
</script>
<style lang="scss">
@import '~@core/scss/vue/libs/vue-select.scss';
</style>
