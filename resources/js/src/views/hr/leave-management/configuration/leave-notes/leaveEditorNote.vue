<template>
    <b-card-code>
        <b-form @submit.prevent="saveFormData">
            <b-row>
                <b-col md="4">
                    <b-form-group
                        label="Select Module"
                        label-for="select_module"
                    >
                        <v-select
                            v-model="formData.select_module"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="moduleOptions"
                            :clearable="false"
                            placeholder="Select Module"
                            :reduce="val => val.value"
                            input-id="select_module"
                        />
                    </b-form-group>
                </b-col>
            </b-row>

            <quill-editor
                v-model="formData.content"
                :options="snowOption"
            />

            <template #code>
                {{ codeSnow }}
            </template>
            <hr>
            <b-col md="12">
                <b-button
                    type="submit"
                    variant="primary"
                    class="float-right"
                >
                    Save
                </b-button>
            </b-col>
        </b-form>
    </b-card-code>
</template>

<script>
    import {
        BCardText,
        BRow,
        BCol,
        BFormGroup,
        BForm,
        BButton
    } from 'bootstrap-vue'
    import BCardCode from '@core/components/b-card-code/BCardCode.vue'
    import {quillEditor} from 'vue-quill-editor'
    import {codeSnow} from './code'
    import {onMounted, onUnmounted, ref} from '@vue/composition-api'
    import vSelect from 'vue-select'
    import {useToast} from "vue-toastification/composition";
    import hrmsStoreModule from "../../../hrmsStoreModule";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import store from '@/store';

    export default {
        components: {
            quillEditor,
            BCardCode,
            BCardText,
            BRow,
            BCol,
            BFormGroup,
            BForm,
            vSelect,
            BButton
        },
        data() {
            return {
                codeSnow,
                snowOption: {
                    theme: 'snow',
                },
                content: ``,
            }
        },
        setup() {
            const toast = useToast();

            const STORE_APP_STORE_MODULE_NAME = 'hr-store-module'
            onMounted(() => {
                if (!store.hasModule(STORE_APP_STORE_MODULE_NAME)) store.registerModule(STORE_APP_STORE_MODULE_NAME, hrmsStoreModule)
            });
            onUnmounted(() => {
                if (store.hasModule(STORE_APP_STORE_MODULE_NAME)) store.unregisterModule(STORE_APP_STORE_MODULE_NAME)
            });

            const moduleOptions = ref([
                {label: 'CO+ Note', value: 1},
                {label: 'Leave Note', value: 2},
                {label: 'OD Note', value: 3}
            ])
            const formData = ref({
                select_module: null,
                content: null,
            })
            const saveFormData = async () => {
                await store.dispatch('hr-store-module/addLeaveNotes', formData.value)
                    .then((res) => {
                        if (res.status === 201) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: "Added",
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Created Leave Notes',
                                },
                            });
                        }
                    }).catch(() => {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: `Error`,
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: 'Internal server error.',
                            },
                        });
                    });
            }

            return {
                moduleOptions,
                formData,
                saveFormData
            }
        },
    }
</script>
