<template>
    <b-card-code>
        <validation-observer ref="simpleRules">
            <b-form>
                <b-row>
                    <b-col md="12">
                        <b-form-group
                            label="Description"
                            label-for="description"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Description"
                                rules="required"
                            >
                                <b-form-input
                                    id="description"
                                    v-model="partyFormData.description"
                                    placeholder="Description"
                                    :state="errors.length > 0 ? false:null"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>

                    <b-col md="6">
                        <b-form-group
                            label="SO Initial"
                            label-for="soInitial"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Prefix"
                                rules="required"
                            >
                                <b-form-input
                                    id="prefix"
                                    v-model="partyFormData.soInitial"
                                    placeholder="SO Initial"
                                    :state="errors.length > 0 ? false:null"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>

                    <b-col md="6">
                        <b-form-group
                            label="SO Current No"
                            label-for="soCurrentNo"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="SO Current No"
                                rules="required"
                            >
                                <b-form-input
                                    id="soCurrentNo"
                                    v-model="partyFormData.soCurrentNo"
                                    type="number"
                                    placeholder="SO Current No"
                                    :state="errors.length > 0 ? false:null"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>


                    <b-col md="6">
                        <b-form-group
                            label="WO Initial"
                            label-for="woInitial"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="WO Initial"
                                rules="required"
                            >
                                <b-form-input
                                    id="woInitial"
                                    v-model="partyFormData.woInitial"
                                    placeholder="WO Initial"
                                    :state="errors.length > 0 ? false:null"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>

                    <b-col md="6">
                        <b-form-group
                            label="WO Current No"
                            label-for="woCurrentNo"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="WO Current No"
                                rules="required"
                            >
                                <b-form-input
                                    id="woCurrentNo"
                                    v-model="partyFormData.woCurrentNo"
                                    type="number"
                                    placeholder="WO Current No"
                                    :state="errors.length > 0 ? false:null"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
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
                            Create SO Type
                        </b-button>

                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>
    </b-card-code>
</template>

<script>
    import BCardCode from '@core/components/b-card-code'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {
        BRow, BCol, BFormGroup, BFormInput, BFormTextarea, BForm, BButton,
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {ref, onUnmounted} from '@vue/composition-api'
    import masterStoreModule from '../masterStoreModule'

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
            vSelect
        },
        directives: {
            Ripple,
        },
        methods: {
            validationForm() {
                this.$refs.simpleRules.validate().then(success => {
                    if (success) {

                        store.dispatch('so-type-module/addSalesOrderTypeMaster', this.partyFormData).then(response => {

                            if (response.status = 200) {

                                this.$router.push({name: 'sales-order-type-master'})

                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'SO Type Created',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Created New Type ${this.partyFormData.description}.`,
                                    },
                                })
                            }

                        })


                    }
                })
            },

        },
        setup() {

            const SOTYPE_APP_STORE_MODULE_NAME = 'so-type-module'

            // Register module
            if (!store.hasModule(SOTYPE_APP_STORE_MODULE_NAME)) store.registerModule(SOTYPE_APP_STORE_MODULE_NAME, masterStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(SOTYPE_APP_STORE_MODULE_NAME)) store.unregisterModule(SOTYPE_APP_STORE_MODULE_NAME)
            })


            const partyFormData = ref({
                id: null,
                description: null,
                soInitial: '',
                soCurrentNo: '0000',
                woInitial: '',
                woCurrentNo: '0000',
            })

            return {
                partyFormData,
                required,
            }
        },
    }
</script>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
