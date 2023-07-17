<template>
    <b-form  @submit.prevent="saveFormData">
        <hr>
        <b-row>
            <b-col>
                <b-form-group
                    label="Remark"
                    label-for="remark"
                >
                    <b-form-textarea
                        id="remark"
                        rows="2"
                        v-model="formData.remark"
                    />
                </b-form-group>
                <b-form-group
                    label="Transporter/Vehicle No."
                    label-for="transporterVehicleNo"
                >
                    <b-form-textarea
                        id="transporterVehicleNo"
                        rows="2"
                        v-model="formData.transporterVehicleNo"
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
    import {computed} from '@vue/composition-api'
    import {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormTextarea,
        BButton
    } from 'bootstrap-vue'
    import {useToast} from "vue-toastification/composition";
    import inventoryStoreModule from "../../inventoryStoreModule";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import router from '@/router'
    import store from '@/store'

    export default {
        components: {
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormTextarea,
            BButton
        },
        props: {
            remarkDetails: {
                type: Object,
                required: true,
            }
        },
        setup(props) {
            const toast = useToast()
            const ITEMADDON_APP_STORE_MODULE_NAME = 'inventory-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, inventoryStoreModule)

            const formData = computed(() => props.remarkDetails)
            const saveFormData = async () => {
                let submitData = {
                    _id: router.currentRoute.params.id,
                    remarkDetails: formData.value
                }
                await store.dispatch('inventory-store-module/updateGoodsReceiptNote', submitData).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Goods Receipt Note Remark Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Updated Goods Receipt Note Remark.',
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
                })
            }
            return {
                formData,
                saveFormData,
            }
        }
    }
</script>
