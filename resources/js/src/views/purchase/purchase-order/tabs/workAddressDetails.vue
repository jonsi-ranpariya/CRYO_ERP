<template>
<div>
    <b-row>
        <b-col md="12">
            <b-form-group
                label="Party Address"
                label-for="party-work-address"
            >
                <b-form-textarea
                    id="party-work-address"
                    placeholder="Party Address"
                    rows="2"
                    v-model="formData.partyAddress"
                />
            </b-form-group>
        </b-col>
        <b-col md="6">
            <b-form-group
                label="Area"
                label-for="party-work-area"
            >
                <b-form-input
                    id="party-work-area"
                    placeholder="Party Area"
                    v-model="formData.partyArea"
                />
            </b-form-group>
        </b-col>
        <b-col md="6">
            <b-form-group
                label="District‌"
                label-for="party-work-city"
            >
                <v-select
                    placeholder="Select District‌"
                    v-model="formData.partyCity"
                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                    :options="cityOptions"
                    :reduce="val => val.value"
                    :clearable="false"
                    input-id="party-city"
                    @input="getCityDetails($event)"
                />
            </b-form-group>
        </b-col>
        <b-col md="4">
            <b-form-group
                label="State"
                label-for="party-work-state"
            >
                <v-select
                    placeholder="Select State"
                    v-model="formData.partyState"
                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                    :options="stateOptions"
                    :reduce="val => val.value"
                    :clearable="false"
                    input-id="party-state"
                />
            </b-form-group>
        </b-col>
        <b-col md="4">
            <b-form-group
                label="Country"
                label-for="party-work-country"
            >
                <v-select
                    placeholder="Select Country"
                    v-model="formData.partyCountry"
                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                    :options="countryOptions"
                    :reduce="val => val.value"
                    :clearable="false"
                    input-id="party-country"
                />
            </b-form-group>
        </b-col>
        <b-col md="4">
            <b-form-group
                label="Pin-Code"
                label-for="party-work-pincode"
            >
                <b-form-input
                    id="party-work-pincode"
                    placeholder="Party Pin Code"
                    v-model="formData.partyPinCode"
                />
            </b-form-group>
        </b-col>
        <b-col md="12">
            <b-form-group
                label="Phone No."
                label-for="party-work-phone"
            >
                <b-input-group>
                    <b-input-group-prepend>
                        <b-form-input
                            id="stdCode"
                            placeholder="STD code"
                            type="number"
                            v-model="formData.partyPhoneNoCode"
                        />
                    </b-input-group-prepend>
                    <b-form-input
                        id="party-work-phone"
                        placeholder="Party Phone"
                        v-model="formData.partyPhoneNo"
                    />
                </b-input-group>
            </b-form-group>
        </b-col>
        <b-col md="4">
            <b-form-group
                label="Fax No."
                label-for="party-work-fax"
            >
                <b-form-input
                    id="party-work-fax"
                    placeholder="Party Fax"
                    v-model="formData.partyFaxNo"
                />
            </b-form-group>
        </b-col>
        <b-col md="4">
            <b-form-group
                label="Email ID"
                label-for="party-work-email"
            >
                <b-form-input
                    id="party-work-email"
                    placeholder="Party Email"
                    v-model="formData.partyEmilId"
                />
            </b-form-group>
        </b-col>
        <b-col md="4">
            <b-form-group
                label="Website"
                label-for="party-work-website"
            >
                <b-form-input
                    id="party-work-website"
                    placeholder="Party Website"
                    v-model="formData.partyWebsite"
                />
            </b-form-group>
        </b-col>
    </b-row>
</div>
</template>
<script>
import {
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BFormTextarea,
    BInputGroup,
    BInputGroupPrepend,
} from 'bootstrap-vue'
import {ref, computed} from '@vue/composition-api'
import axios from '@axios'
import vSelect from 'vue-select'
export default {
    components:{
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormTextarea,
        vSelect,
        BInputGroup,
        BInputGroupPrepend
    },
    props: {
        workAddressDetails: {
            type: Object,
            required: true,
        }
    },
    setup(props) {
        const formData = computed(() => props.workAddressDetails)

        const cityOptions = ref([])
        axios.get('/api/get-city-options').then(res => {
            cityOptions.value = res.data.data
        })

        const stateOptions = ref([])
        axios.get('/api/get-state-options').then(res => {
            stateOptions.value = res.data.data
        })

        const countryOptions = ref([])
        axios.get('/api/get-country-options').then(res => {
            countryOptions.value = res.data.data
        })
        // const formData = ref({
        // })

        const getCityDetails = async (id) => {
            await axios.get(`/api/city-master/${id}`).then(res => {
                formData.value.partyState = res.data.data.state
                formData.value.partyCountry = res.data.data.country
            });
        }
        return{
            formData,
            getCityDetails,
            cityOptions,
            stateOptions,
            countryOptions
        }
    }
}
</script>
