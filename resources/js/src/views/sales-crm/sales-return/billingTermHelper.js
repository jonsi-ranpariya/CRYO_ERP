import {ref} from "@vue/composition-api";
import axios from '@axios'

const itemDetails = ref([])
const totalAmount = ref(0.00)
export const billingTerm = ref({
    async refetchTermData(currentId, partyId) {
        await axios.get(`/api/get-sales-return-items/${currentId}`).then(res => {
            itemDetails.value = res.data.data
        })

        itemDetails.value.forEach((item) =>  {
            totalAmount.value += item.itemNetAmount
        })

        let billingTermData = []
        await axios.get(`/api/get-sr-billing-terms/${currentId}`).then(res => {
            billingTermData = res.data.data
        })

        await axios.delete(`/api/delete-current-billing-term/${currentId}`)
        const calculationCodes = []

        if (billingTermData.length > 0){
            billingTermData.forEach((billingData) => {
                const myBillingFormData = {
                    id: null,
                    salesReturnId: currentId,
                    calCode: null,
                    calCodeLabel: null,
                    calDefination: null,
                    percentage: null,
                    byValue: null,
                    operation: null,
                    narration: null,
                    type: null,
                    total_amount: null,
                }

                if (billingData.calCodeLabel === 'BAS') {
                    calculationCodes[billingData.calCodeLabel] = totalAmount.value
                    myBillingFormData.calCode = billingData.calCode
                    myBillingFormData.calCodeLabel = billingData.calCodeLabel
                    myBillingFormData.description = billingData.description
                    myBillingFormData.calDefination = billingData.calDefination
                    myBillingFormData.percentage = billingData.percentage
                    myBillingFormData.byValue = billingData.byValue
                    myBillingFormData.operation = billingData.operation
                    myBillingFormData.narration = billingData.narration
                    myBillingFormData.type = billingData.type
                    myBillingFormData.total_amount = totalAmount.value
                } else {
                    let dispayTotal = 0.00
                    calculationCodes[billingData.calCodeLabel] = dispayTotal
                    const AllcodeData = billingData.calDefination.split('+')
                    const billingDefLength = AllcodeData.length;

                    if (billingDefLength > 1) {
                        let CalTotal = 0
                        for (let i = 0; i < AllcodeData.length; i++) {
                            CalTotal += parseFloat(calculationCodes[AllcodeData[i]])
                        }
                        calculationCodes[billingData.calCodeLabel] = CalTotal
                        dispayTotal = CalTotal
                    } else {
                        if (billingData.type === 0) {
                            //By Percentage
                            let calculatedPercentage = 0
                            calculatedPercentage = (( parseFloat(billingData.percentage) / 100) * parseFloat(calculationCodes[AllcodeData[0]]))
                            calculationCodes[billingData.calCodeLabel] = parseFloat(calculatedPercentage)
                            dispayTotal = calculatedPercentage
                        } else if (billingData.type === 1) {
                            //By Value
                            calculationCodes[billingData.calCodeLabel] = parseFloat(billingData.byValue)
                            dispayTotal = parseFloat(billingData.byValue)
                        }
                    }

                    myBillingFormData.calCode = billingData.calCode
                    myBillingFormData.calCodeLabel = billingData.calCodeLabel
                    myBillingFormData.description = billingData.description
                    myBillingFormData.calDefination = billingData.calDefination
                    myBillingFormData.percentage = billingData.percentage
                    myBillingFormData.byValue = billingData.byValue
                    myBillingFormData.operation = billingData.operation
                    myBillingFormData.narration = billingData.narration
                    myBillingFormData.type = billingData.type
                    myBillingFormData.total_amount = dispayTotal
                }
                axios.post('/api/sr-billing-terms', myBillingFormData)
            })
        }else{
            await axios.get(`/api/party/get-party-billing-term/${partyId}`).then(res => {
                billingTermData = res.data.data
            })

            billingTermData.forEach((billingData) => {
                const myBillingFormData = {
                    id: null,
                    salesReturnId: currentId,
                    calCode: null,
                    calCodeLabel: null,
                    calDefination: null,
                    percentage: null,
                    byValue: null,
                    operation: null,
                    narration: null,
                    type: null,
                    total_amount: null,
                }

                if (billingData.calCodeLabel === 'BAS') {
                    calculationCodes[billingData.calCodeLabel] = totalAmount.value
                    myBillingFormData.calCode = billingData.calCode
                    myBillingFormData.calCodeLabel = billingData.calCodeLabel
                    myBillingFormData.description = billingData.description
                    myBillingFormData.calDefination = billingData.calDefination
                    myBillingFormData.percentage = billingData.percentage
                    myBillingFormData.byValue = billingData.byValue
                    myBillingFormData.operation = billingData.operation
                    myBillingFormData.narration = billingData.narration
                    myBillingFormData.type = billingData.type
                    myBillingFormData.total_amount = parseFloat(totalAmount.value).toFixed(2)
                } else {
                    let dispayTotal = 0.00
                    calculationCodes[billingData.calCodeLabel] = dispayTotal
                    const AllcodeData = billingData.calDefination.split('+')
                    const billingDefLength = AllcodeData.length;

                    if (billingDefLength > 1) {
                        let CalTotal = 0
                        for (let i = 0; i < AllcodeData.length; i++) {
                            CalTotal += parseFloat(calculationCodes[AllcodeData[i]])
                        }
                        calculationCodes[billingData.calCodeLabel] = CalTotal
                        dispayTotal = CalTotal
                    } else {
                        if (billingData.type === 0) {
                            //By Percentage
                            let calculatedPercentage = 0
                            calculatedPercentage = (( parseFloat(billingData.percentage) / 100) * parseFloat(calculationCodes[AllcodeData[0]]))
                            calculationCodes[billingData.calCodeLabel] = parseFloat(calculatedPercentage)
                            dispayTotal = calculatedPercentage
                        } else if (billingData.type === 1) {
                            //By Value
                            calculationCodes[billingData.calCodeLabel] = parseFloat(billingData.byValue)
                            dispayTotal = parseFloat(billingData.byValue)
                        }
                    }

                    myBillingFormData.calCode = billingData.calCode
                    myBillingFormData.calCodeLabel = billingData.calCodeLabel
                    myBillingFormData.description = billingData.description
                    myBillingFormData.calDefination = billingData.calDefination
                    myBillingFormData.percentage = billingData.percentage
                    myBillingFormData.byValue = billingData.byValue
                    myBillingFormData.operation = billingData.operation
                    myBillingFormData.narration = billingData.narration
                    myBillingFormData.type = billingData.type
                    myBillingFormData.total_amount = parseFloat(dispayTotal).toFixed(2)
                }
                axios.post('/api/sr-billing-terms', myBillingFormData)
            });
        }
    }
});
