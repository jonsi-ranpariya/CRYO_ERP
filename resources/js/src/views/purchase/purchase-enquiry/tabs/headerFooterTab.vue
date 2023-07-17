<template>
    <b-form @submit.prevent="saveFormData">
        <b-row>
            <b-col md="6">
                <b-form-group
                    label="Header"
                    label-for="header"
                >
                    <v-select
                        v-model="formData.header"
                        placeholder="Select Header"
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="headerOPtion"
                        :reduce="val => val.value"
                        :clearable="false"
                        input-id="header"
                        @input="getHeaderData($event)"
                    />
                    <b-form-textarea
                        class="mt-1"
                        id="header"
                        rows="3"
                        v-model="formData.headerDescription"
                    />
                </b-form-group>
            </b-col>
            <b-col md="6">
                <b-form-group
                    label="Footer"
                    label-for="footer"
                >
                    <v-select
                        v-model="formData.footer"
                        placeholder="Select Footer"
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="footerOPtion"
                        :reduce="val => val.value"
                        :clearable="false"
                        input-id="footer"
                        @input="getFooterData($event)"
                    />
                    <b-form-textarea
                        class="mt-1"
                        id="footer"
                        rows="3"
                        v-model="formData.footerDescription"
                    />
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
</template>
<script>
    import {ref, onUnmounted, computed} from '@vue/composition-api'
    import {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormTextarea,
        BButton
    } from 'bootstrap-vue'
    import vSelect from 'vue-select'
    import axios from '@axios'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {useToast} from 'vue-toastification/composition'
    import purchaseStoreModule from "../../purchaseStoreModule";
    import store from '@/store'
    import router from '@/router'

    export default {
        components: {
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormTextarea,
            BButton,
            vSelect
        },
        props: {
            headerFooterDetails: {
                type: Object,
                required: true
            }
        },
        setup(props) {
            const ITEMADDON_APP_STORE_MODULE_NAME = 'purchase-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, purchaseStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const toast = useToast()

            const headerOPtion = ref([])
            axios.post('/api/document-sales-header-options', {type: 1}).then(res => {
                headerOPtion.value = res.data.data
            })

            const getHeaderData = async (id) => {
                await axios.get(`/api/document-header/${id}`).then(res => {
                    formData.value.headerDescription = res.data.data.header
                })
            }

            const getFooterData = async (id) => {
                await axios.get(`/api/document-footer/${id}`).then(res => {
                    formData.value.footerDescription = res.data.data.footer
                })
            }

            const footerOPtion = ref([])
            axios.post('/api/document-sales-footer-options', {type: 1}).then(res => {
                footerOPtion.value = res.data.data
            })

            const formData = computed(() => props.headerFooterDetails)

            const saveFormData = async () => {
                await store.dispatch('purchase-store-module/updatePurchaseEnquiry', {
                    id: router.currentRoute.params.id,
                    headerFooterDetails: formData.value
                }).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Header/Footer Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Updated Header/Footer.`,
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
                formData,
                headerOPtion,
                footerOPtion,
                getHeaderData,
                getFooterData,
                saveFormData,
            }
        }
    }
</script>
