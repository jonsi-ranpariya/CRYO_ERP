import {ref} from "@vue/composition-api";
import router from '@/router';
import axios from "@axios";

const itemDetails = ref([])

export const billingTerm = ref({
    formData: {
        id: null,
        pInvoiceId: router.currentRoute.params.id,
        calCode: null,
        calCodeLabel: null,
        calDefination: null,
        billingId: null,
        billingName: null,
        billingType: null,
        billingPercentage: null,
        billingValue: null,
        billingNarration: null,
        calculatedAmount: null,
    },
    async refetchBillingTerm(customerId) {
        await axios.get('/api/get-proforma-invoice-items/'.concat(router.currentRoute.params.id)).then(res => {
            itemDetails.value = res.data.data
        })
        let netAmount = 0.00
        itemDetails.value.forEach((item) => {
            netAmount += parseFloat(item.itemNetAmount)
        })
        let dynamicCalculation = []
        let billingTerms = []
        await axios.get('/api/get-pi-billing-terms/'.concat(router.currentRoute.params.id)).then(res => {
            billingTerms = res.data.data
        })
        await axios.delete('/api/delete-old-proforma-billing-terms/'.concat(router.currentRoute.params.id))
        if (billingTerms.length > 0) {
            billingTerms.forEach((item) => {
                let newAmount = 0.00
                if (item.calCodeLabel === "BAS") {
                    dynamicCalculation[item.calCodeLabel] = netAmount
                    item.calculateAmount = parseFloat(netAmount).toFixed(2)
                    this.formData.pInvoiceId = router.currentRoute.params.id
                    this.formData.calCode = item.calCode
                    this.formData.calCodeLabel = item.calCodeLabel
                    this.formData.calDefination = item.calDefination
                    this.formData.billingName = item.billingName
                    this.formData.billingNarration = item.billingNarration
                    this.formData.billingType = item.billingType
                    this.formData.billingPercentage = item.billingPercentage
                    this.formData.billingValue = item.billingValue
                    this.formData.calculatedAmount = parseFloat(netAmount).toFixed(2)
                } else {
                    dynamicCalculation[item.calCodeLabel] = newAmount
                    this.formData.pInvoiceId = router.currentRoute.params.id
                    this.formData.calCode = item.calCode
                    this.formData.calCodeLabel = item.calCodeLabel
                    this.formData.calDefination = item.calDefination
                    this.formData.billingName = item.billingName
                    this.formData.billingNarration = item.billingNarration
                    this.formData.billingType = item.billingType
                    this.formData.billingPercentage = item.billingPercentage
                    this.formData.billingValue = item.billingValue
                    this.formData.calculatedAmount = parseFloat(netAmount).toFixed(2)

                    let allCodeData = item.calDefination.split('+'), dispayTotal = 0.00
                    if (allCodeData.length > 1) {
                        let calTotal = 0.00
                        for (let i = 0; i < allCodeData.length; i++) {
                            calTotal += dynamicCalculation[allCodeData[i]]
                        }
                        dynamicCalculation[item.calCodeLabel] = calTotal
                        dispayTotal = parseFloat(calTotal).toFixed(2)
                        this.formData.calculatedAmount = parseFloat(dispayTotal).toFixed(2)
                    } else {
                        if (item.billingType === 0) {
                            //By Percentage
                            let calculatedPercentage = 0
                            calculatedPercentage = (parseFloat(item.billingPercentage / 100) * parseFloat(dynamicCalculation[allCodeData[0]]))
                            dynamicCalculation[item.calCodeLabel] = calculatedPercentage
                            dispayTotal = parseFloat(calculatedPercentage).toFixed(2)
                        }

                        if (item.billingType === 1) {
                            //By Value
                            dynamicCalculation[item.calCodeLabel] = parseFloat(item.billingValue)
                            dispayTotal = parseFloat(item.billingValue).toFixed(2)
                        }
                        this.formData.calculatedAmount = dispayTotal
                    }
                }
                axios.post('/api/pi-billing-terms', this.formData)
            })
        }else{
            await axios.get('/api/party/get-party-billing-term/'.concat(customerId)).then(res => {
                if (res.data.data.length > 0) {
                    res.data.data.forEach((item) => {
                        let newAmount = 0.00
                        if (itemDetails.value.length > 0) {
                            if (item.calCodeLabel === "BAS") {
                                dynamicCalculation[item.calCodeLabel] = netAmount
                                item.calculateAmount = parseFloat(netAmount).toFixed(2)
                                this.formData.pInvoiceId = router.currentRoute.params.id
                                this.formData.calCode = item.calCode
                                this.formData.calCodeLabel = item.calCodeLabel
                                this.formData.calDefination = item.calDefination
                                this.formData.billingName = item.description
                                this.formData.billingNarration = item.narration
                                this.formData.billingType = item.type
                                this.formData.billingPercentage = item.percentage
                                this.formData.billingValue = item.byValue
                                this.formData.calculatedAmount = parseFloat(netAmount).toFixed(2)
                            } else {
                                dynamicCalculation[item.calCodeLabel] = newAmount
                                this.formData.pInvoiceId = router.currentRoute.params.id
                                this.formData.calCode = item.calCode
                                this.formData.calCodeLabel = item.calCodeLabel
                                this.formData.calDefination = item.calDefination
                                this.formData.billingName = item.description
                                this.formData.billingNarration = item.narration
                                this.formData.billingType = item.type
                                this.formData.billingPercentage = item.percentage
                                this.formData.billingValue = item.byValue
                                this.formData.calculatedAmount = parseFloat(netAmount).toFixed(2)

                                let allCodeData = item.calDefination.split('+'), dispayTotal = 0.00
                                if (allCodeData.length > 1) {
                                    let calTotal = 0.00
                                    for (let i = 0; i < allCodeData.length; i++) {
                                        calTotal += dynamicCalculation[allCodeData[i]]
                                    }
                                    dynamicCalculation[item.calCodeLabel] = calTotal
                                    dispayTotal = parseFloat(calTotal).toFixed(2)
                                    this.formData.calculatedAmount = parseFloat(dispayTotal).toFixed(2)
                                } else {
                                    if (item.type === 0) {
                                        //By Percentage
                                        let calculatedPercentage = 0
                                        calculatedPercentage = (parseFloat(item.percentage / 100) * parseFloat(dynamicCalculation[allCodeData[0]]))
                                        dynamicCalculation[item.calCodeLabel] = calculatedPercentage
                                        dispayTotal = parseFloat(calculatedPercentage).toFixed(2)
                                    }

                                    if (item.type === 1) {
                                        //By Value
                                        dynamicCalculation[item.calCodeLabel] = parseFloat(item.byValue)
                                        dispayTotal = parseFloat(item.byValue).toFixed(2)
                                    }
                                    this.formData.calculatedAmount = dispayTotal
                                }
                            }
                        } else {
                            this.formData.pInvoiceId = router.currentRoute.params.id
                            this.formData.calCode = item.calCode
                            this.formData.calCodeLabel = item.calCodeLabel
                            this.formData.calDefination = item.calDefination
                            this.formData.billingName = item.description
                            this.formData.billingNarration = item.narration
                            this.formData.billingType = item.type
                            this.formData.billingPercentage = item.percentage
                            this.formData.billingValue = item.byValue
                            this.formData.calculatedAmount = parseFloat(newAmount).toFixed(2)
                        }
                        axios.post('/api/pi-billing-terms', this.formData)
                    })
                }
            })
        }
    }
})
