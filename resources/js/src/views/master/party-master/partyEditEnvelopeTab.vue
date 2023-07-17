<template>
    <div>
        <b-row>
            <b-col md="12">
                <b-form-group
                    label="Envelope Type"
                    label-for="envelopeType"
                >
                    <v-select
                        placeholder="Select company"
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="envelopeTypeOptions"
                        :reduce="val => val.value"
                        :clearable="false"
                        input-id="company"
                        v-model="formData.envelopeType"
                    />
                </b-form-group>
            </b-col>
            <b-col md="12">
                <hr>
                <b-button
                    type="button"
                    variant="primary"
                    @click="envelopePreview"
                    :disabled="previewBtn.isDisabled"
                >
                    {{ previewBtn.text }}
                </b-button>
            </b-col>
        </b-row>
    </div>
</template>
<script>
import {
    BForm,
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BButton,
} from 'bootstrap-vue'
import vSelect from 'vue-select'
import {ref} from "@vue/composition-api";
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
        const toast = useToast();

        const envelopeTypeOptions = ref([
            {label: 'Party Address', value: 1},
            {label: 'Party Work Address', value: 2},
        ]);

        const formData = ref({
            envelopeType: null,
        });

        const previewBtn = ref({
            text: 'Preview',
            isDisabled: false
        });

        const envelopePreview = async () => {
            previewBtn.value.isDisabled = true
            previewBtn.value.text = 'Please wait...'
            if (formData.value.envelopeType) {
                await axios.post('/pdf/party-master-envelope', {
                    type: formData.value.envelopeType,
                    partyId: router.currentRoute.params.id
                }).then(res => {
                    if (res.status === 200) {
                        window.open(res.data.path, '_blank')
                    }
                }).catch(() => {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Server error',
                            icon: 'AlertCircleIcon',
                            variant: 'danger',
                            text: 'Internal server error',
                        },
                    });
                });
            } else {
                toast({
                    component: ToastificationContent,
                    position: 'top-right',
                    props: {
                        title: 'Error',
                        icon: 'AlertCircleIcon',
                        variant: 'danger',
                        text: 'Please select any address type.',
                    },
                });
            }
            previewBtn.value.isDisabled = false
            previewBtn.value.text = 'Preview'
        }

        return {
            envelopeTypeOptions,
            formData,
            envelopePreview,
            previewBtn,
        }
    }
}
</script>
