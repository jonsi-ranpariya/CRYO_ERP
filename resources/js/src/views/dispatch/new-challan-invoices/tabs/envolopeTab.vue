<template>
    <div>
        <b-row>
            <b-col md="12">
                <b-form-group
                    label="Envolope Type"
                    label-for="envolopeType"
                >
                    <v-select
                        placeholder="Select company"
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="envelopeTypeOptions"
                        :reduce="val => val.value"
                        :clearable="false"
                        input-id="company"
                        v-model="formData.envolopeType"
                    />
                </b-form-group>
            </b-col>
            <b-col md="12">
                <hr>
                <b-button
                    type="button"
                    variant="primary"
                    @click="envolopePreview"
                >
                    Preview
                </b-button>
            </b-col>
        </b-row>
    </div>
</template>
<script>
    import formValidation from "@core/comp-functions/forms/form-validation";
    import {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BButton,
    } from 'bootstrap-vue'
    import vSelect from 'vue-select'
    import {ref, onUnmounted} from "@vue/composition-api";
    import router from "@/router";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {useToast} from 'vue-toastification/composition'
    import axios from '@axios'

    export default {
        components: {
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BButton,
            vSelect
        },
        setup() {
            const toast = useToast()

            const envelopeTypeOptions = ref([
                {label: 'Party', value: 1},
                {label: 'Buyer', value: 2},
                {label: 'Consignee', value: 3},
                {label: 'Dispatch', value: 4},
            ])

            const formData = ref({
                envolopeType: null,
            })

            const envolopePreview = async () => {
                if (formData.value.envolopeType) {
                    await axios.post('/pdf/get-challan-invoice-envelope-preview', {
                        type: formData.value.envolopeType,
                        challanInvoiceId: router.currentRoute.params.id
                    }).then(res => {
                        if (res.status === 200) {
                            window.open(res.data.path, '_blank')
                        }
                    });
                } else {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Error',
                            icon: 'AlertCircleIcon',
                            variant: 'danger',
                            text: 'Please select any envelope type.',
                        },
                    });
                }
            }

            return {
                envelopeTypeOptions,
                formData,
                envolopePreview
            }
        }
    }
</script>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
<style lang="scss" scoped>
    @import '~@core/scss/base/bootstrap-extended/include';
    @import '~@core/scss/base/components/variables-dark';

    .dark-layout {
        div ::v-deep .card .card-body {
            .b-overlay {
                .bg-light {
                    background-color: $theme-dark-body-bg !important;
                }
            }
        }
    }
</style>
