<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
        <b-card-code>
            <validation-observer #default="{ handleSubmit }">
                <b-form @submit.prevent="handleSubmit(saveFormData)">
                    <b-row>
                        <b-col md="5">
                            <validation-provider
                                #default="validationContext"
                                name="Item Code"
                                rules="required"
                            >
                                <b-form-group
                                    label="Item Code"
                                    label-for="itemCode"
                                >
                                    <v-select
                                        :clearable="false"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="itemCodeOption"
                                        :reduce="(val) => val.value"
                                        :state="getValidationState(validationContext)"
                                        input-id="itemCode"
                                        placeholder="Select itemCode"
                                        v-model="formData.itemCode"
                                        disabled
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Item Description"
                                rules="required"
                            >
                                <b-form-group
                                    label="Item Description"
                                    label-for="itemDescription"
                                >
                                    <b-form-input
                                        :state="getValidationState(validationContext)"
                                        id="itemDescription"
                                        v-model="formData.itemDescription"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <b-form-group
                                label="Add Description"
                                label-for="addDescription"
                            >
                                <b-form-input
                                    id="addDescription"
                                    v-model="formData.itemAddDescription"
                                />
                            </b-form-group>
                            <b-form-group
                                label="Detail Description"
                                label-for="detailDescription"
                            >
                                <b-form-textarea
                                    id="detailDescription"
                                    rows="2"
                                    v-model="formData.itemDetailDescription"
                                />
                            </b-form-group>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Drawing No."
                                        label-for="itemDrawingNo"
                                    >
                                        <b-form-input
                                            id="itemDrawingNo"
                                            v-model="formData.itemDrawingNo"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Drawing Revision"
                                        label-for="itemRevision"
                                    >
                                        <b-form-input
                                            id="itemRevision"
                                            v-model="formData.itemRevision"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>
                        <b-col md="7">
                            <b-row>
                                <b-col md="4">
                                    <b-form-group
                                        label="Item Cost"
                                        label-for="itemCost"
                                    >
                                        <b-form-input
                                            id="itemCost"
                                            v-model="formData.itemCost"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="MRP"
                                        label-for="itemMrp"
                                    >
                                        <b-form-input
                                            id="itemMrp"
                                            v-model="formData.itemMrp"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Disc(%)"
                                        label-for="itemDiscount"
                                    >
                                        <b-form-input
                                            id="itemDiscount"
                                            v-model="formData.itemDiscount"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Sales Rate"
                                        label-for="salesRate"
                                    >
                                        <b-form-input
                                            id="salesRate"
                                            v-model="formData.salesRate"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Excise (%)"
                                        label-for="excisePercent"
                                    >
                                        <b-form-input
                                            id="excisePercent"
                                            v-model="formData.excisePercent"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Purchase Rate"
                                        label-for="purchaseRate"
                                    >
                                        <b-form-input
                                            id="purchaseRate"
                                            v-model="formData.purchaseRate"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Tax (%)"
                                        label-for="texPercent"
                                    >
                                        <b-form-input
                                            id="texPercent"
                                            v-model="formData.texPercent"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-form-group
                                label="Make"
                                label-for="itemMake"
                            >
                                <b-form-input
                                    id="itemMake"
                                    v-model="formData.itemMake"
                                />
                            </b-form-group>
                            <b-form-group
                                label="Excisable Item"
                                label-for="excisableItem"
                            >
                                <v-select
                                    :clearable="false"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="excisableItemOption"
                                    :reduce="(val) => val.value"
                                    input-id="excisableItem"
                                    placeholder="Select Item"
                                    v-model="formData.excisableItem"
                                />
                            </b-form-group>
                        </b-col>
                        <!--Button-->
                        <b-col md="12">
                            <hr/>
                            <b-button
                                variant="primary"
                                type="submit"
                                class="float-right"
                            >
                                Save
                            </b-button>
                        </b-col>
                    </b-row>
                </b-form>
            </validation-observer>
        </b-card-code>
        </b-overlay>
    </div>
</template>
<script>
    import {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormInvalidFeedback,
        BFormTextarea,
        BButton,
        BOverlay,
    } from 'bootstrap-vue'
    import BCardCode from "../../../@core/components/b-card-code/BCardCode";
    import {ref} from '@vue/composition-api'
    import {ValidationObserver,ValidationProvider} from 'vee-validate'
    import formValidation from "../../../@core/comp-functions/forms/form-validation";
    import axios from '@axios'
    import vSelect from 'vue-select'
    import router from "../../../router";
    import {required} from '@validations'
    import Ripple from "vue-ripple-directive";
    export default {
        components:{
            BCardCode,
            ValidationObserver,
            ValidationProvider,
            vSelect,
            BFormTextarea,
            BForm,
            BCol,
            BRow,
            BFormGroup,
            BFormInput,
            BFormInvalidFeedback,
            BButton,
            BOverlay,
        },
        directives:{
            Ripple,
        },
        setup(){
            const itemCodeOption = ref([]);
            axios.get("/api/get-item-master-options").then((res) => {
                itemCodeOption.value = res.data.data;
            });
            const excisableItemOption = ref ([])
            const showOverlayLoading = ref(false)

            const blankFormData ={
                itemCode:null,
                itemDescription:null,
                itemAddDescription:null,
                itemDetailDescription:null,
                itemDrawingNo:null,
                itemRevision:null,
                itemCost:null,
                itemMrp:null,
                itemDiscount:0,
                salesRate:null,
                excisePercent:0,
                purchaseRate:null,
                texPercent:0,
                itemMake:null,
                excisableItem:null,
            }

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }
            const refetchData = async () => {
                showOverlayLoading.value = true

                showOverlayLoading.value = false
            }
            refetchData()

            const saveFormData = async () => {
            }
            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)
            return{
                formData,
                resetFormData,
                saveFormData,
                required,
                refFormObserver,
                getValidationState,
                resetForm,
                itemCodeOption,
                excisableItemOption,
                refetchData,
                showOverlayLoading,
            }
        }
    }
</script>
