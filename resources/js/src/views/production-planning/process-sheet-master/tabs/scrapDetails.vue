<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr></hr>
                <h4>Scrap Details</h4>
                <hr></hr>

            </b-col>
        </b-row>
        <validation-observer ref="simpleRules">
            <b-form>
                <b-row>
                    <b-col md="12">
                        <b-form-group
                            label="Select Item"
                            label-for="scrapItemId"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Item"
                                rules="required"
                            >
                                <v-select
                                    v-model="psScrapTabData.scrapItemId"
                                    placeholder="Select Item"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="psItemListData"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    v-on:input="getScrapItemDetails(psScrapTabData.scrapItemId)"
                                    input-id="itemId"
                                    :state="errors.length > 0 ? false:null"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Scrap Code"
                            label-for="scrapCode"
                        >
                            <b-form-input
                                id="scrapCode"
                                v-model="psScrapTabData.scrapCode"
                                readonly
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="8">
                        <b-form-group
                            label="Scrap Description"
                            label-for="scrapDesc"
                        >
                            <b-form-input
                                id="scrapDesc"
                                v-model="psScrapTabData.scrapDesc"
                                readonly
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="6">
                        <b-form-group
                            label="Mat. Issue Wt"
                            label-for="matIssueWt"
                        >
                            <b-form-input
                                id="matIssueWt"
                                v-model="psScrapTabData.matIssueWt"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Scrap Qty."
                            label-for="scrapQty"
                        >
                            <b-form-input
                                id="scrapQty"
                                v-model="psScrapTabData.scrapQty"
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
                            Save Scrap Detail
                        </b-button>
                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>
    </div>
</template>
<script>
    import BCardCode from '@core/components/b-card-code'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
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
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import router from '@/router'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {ref, onUnmounted} from '@vue/composition-api'
    import productionPlanningStoreModule from '../../productionPlanningStoreModule'
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
                this.$refs.simpleRules.validate().then(success => {
                    if (success) {
                        const SubmitFormData = {
                            id: this.CurrentProcessSheetId,
                            scrapDetail: this.psScrapTabData,
                        }
                        store.dispatch('srp-module/updateProcessSheetMaster', SubmitFormData).then(response => {
                            if (response.status === 200) {
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Scrap Edited',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Edited Scrap Detail`,
                                    },
                                })
                            }
                        })
                    }
                })
            },
            containsKey(obj, key) {
                return Object.keys(obj).includes(key)
            },
        },
        props: {
            psScrapTabData: {
                type: Object,
            },
            psItemListData: {
                type: Array,
            },
        },
        setup(props) {

            const SRP_APP_STORE_MODULE_NAME = 'srp-module'
            // Register module
            if (!store.hasModule(SRP_APP_STORE_MODULE_NAME)) store.registerModule(SRP_APP_STORE_MODULE_NAME, productionPlanningStoreModule)
            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(SRP_APP_STORE_MODULE_NAME)) store.unregisterModule(SRP_APP_STORE_MODULE_NAME)
            })

            const CurrentProcessSheetId = ref(router.currentRoute.params.id)

            const getScrapItemDetails = async (val) => {
                await axios.get(`/api/item-master/${val}`).then(res => {
                    props.psScrapTabData.scrapCode = res.data.data.itemCode
                    props.psScrapTabData.scrapDesc = res.data.data.itemDescription
                })
            }
            return {
                CurrentProcessSheetId,
                getScrapItemDetails,
                required,
            }
        },

    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
