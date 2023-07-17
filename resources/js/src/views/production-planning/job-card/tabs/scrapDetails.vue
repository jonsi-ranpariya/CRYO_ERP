<template>
    <div>
        <validation-observer ref="simpleRules" #default="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(saveScrapData)">
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
                                    v-model="jcScrapTabData.scrapItemId"
                                    placeholder="Select Item"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="ItemListOption"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    v-on:input="getScrapItemDetails($event)"
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
                                v-model="jcScrapTabData.scrapCode"
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
                                v-model="jcScrapTabData.scrapDesc"
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
                                v-model="jcScrapTabData.matIssueWt"
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
                                v-model="jcScrapTabData.scrapQty"
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
    import BCardCode from "../../../../@core/components/b-card-code/BCardCode";
    import {
        BForm, BRow, BCol, BFormGroup, BInputGroup, BFormInput, BInputGroupAppend, BFormInvalidFeedback,
        BButton, BFormTextarea,
    } from 'bootstrap-vue'
    import vSelect from 'vue-select'
    import jobCardStoreModule from "../../jobCardStoreModule";
    import {onUnmounted, ref, computed} from "@vue/composition-api";
    import store from '@/store'
    import {useToast} from 'vue-toastification/composition'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import router from '@/router'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import axios from '@axios'

    export default {
        components: {
            BCardCode,
            BForm,
            BRow,
            BCol,
            BInputGroup,
            BInputGroupAppend,
            BFormInvalidFeedback,
            BFormInput,
            BButton,
            BFormGroup,
            BFormTextarea,
            vSelect,
            ValidationProvider,
            ValidationObserver
        },
        directives: {
            Ripple,
        },
        props: {
            scrapDetails: {
                type: Object,
                required: true
            },
            ItemListOption: {
                type: Array,
            }
        },
        setup(props) {

            //toast alert
            const toast = useToast()

            //store module
            const SE_APP_STORE_MODULE_NAME = 'scrap-module'

            if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, jobCardStoreModule)

            onUnmounted(() => {
                if (store.hasModule(SE_APP_STORE_MODULE_NAME)) store.unregisterModule(SE_APP_STORE_MODULE_NAME)
            })

            //import computes
            const jcScrapTabData = computed(() => props.scrapDetails)

            const getScrapItemDetails = async (val) => {
                await axios.get(`/api/item-master/${val}`).then(res => {
                    props.scrapDetails.scrapCode = res.data.data.itemCode
                    props.scrapDetails.scrapDesc = res.data.data.itemDescription
                })
            }

            const saveScrapData = async () => {
                const SubmitFormData = {
                    id: router.currentRoute.params.id,
                    scrapDetails: jcScrapTabData.value,
                }
                await store.dispatch('scrap-module/updateJobCard', SubmitFormData).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Scrap Details Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Added Scrap Details.`,
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

            return {
                jcScrapTabData,
                getScrapItemDetails,
                saveScrapData,
                required,
            }
        },
    }
</script>
