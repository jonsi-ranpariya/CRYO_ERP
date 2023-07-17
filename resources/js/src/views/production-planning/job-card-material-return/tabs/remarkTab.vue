<template>
    <div>
        <b-form @submit.prevent="saveData">
            <b-row>
                <b-col md="12">
                    <b-form-group
                        label="Remark"
                        label-for="remark"
                    >
                        <b-form-textarea
                            id="remark"
                            rows="3"
                            v-model="remarkFormData.remark"
                        />
                    </b-form-group>
                    <hr>
                    <b-button
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
    import {BRow, BCol, BFormGroup, BFormTextarea, BButton, BForm} from 'bootstrap-vue'
    import Ripple from 'vue-ripple-directive'
    import {onUnmounted, ref, computed} from "@vue/composition-api";
    import store from '@/store'
    import {useToast} from 'vue-toastification/composition'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import router from '@/router'
    import productionPlanningStoreModule from '../../productionPlanningStoreModule'

    export default {
        components: {
            BRow,
            BCol,
            BFormGroup,
            BFormTextarea,
            BButton,
            BForm,
        },
        directives: {
            Ripple,
        },
        props: {
            remarkData: {
                type: Object
            }
        },
        setup(props) {
            const ITEMADDON_APP_STORE_MODULE_NAME = 'production-planning'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, productionPlanningStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const toast = useToast()

            const remarkFormData = computed(() => props.remarkData)

            const saveData = async () => {
                let formData = {
                    id: router.currentRoute.params.id,
                    remarkData: {
                        remark: remarkFormData.value.remark
                    }
                }
                await store.dispatch('production-planning/updateJobCardReturnShop', formData).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Job Card Return Shop Remark Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Added Job Card Return Shop Remark.`,
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
                remarkFormData,
                saveData
            }
        }
    }
</script>
