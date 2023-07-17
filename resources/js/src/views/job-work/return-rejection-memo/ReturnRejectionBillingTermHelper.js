import axios from '@axios'
import { ref } from '@vue/composition-api'

export const generateBillingTermFromTemplate = async (templateId, returnRejectMemoId) => {
    const totalAmount = ref(0.00)
    await axios.delete(`/api/new/delete-return-rejection-billing-term/${returnRejectMemoId}`)
    await axios.get(`/api/new/get-rejection-memo-item/${returnRejectMemoId}`)
        .then((res) => {
            let itemList = res.data.data
            if (itemList.length > 0) {
                itemList.forEach((item) => {
                    totalAmount.value += item.itemAmount
                })
            }
        })

    await axios.get(`/api/billing-template-master/${templateId}`)
        .then(res => {
            if (res.data.data.billing_items) {
                const calculationCodes = []
                res.data.data.billing_items.forEach((billingData, key) => {
                    const myBillingFormData = {
                        _id: null,
                        returnRejectMemoId: returnRejectMemoId,
                        calCode: null,
                        calCodeLabel: null,
                        calDefination: null,
                        percentage: null,
                        byValue: null,
                        operation: null,
                        narration: null,
                        type: null,
                        total_amount: null,
                        srNo: key + 1,
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
                        myBillingFormData.total_amount = parseFloat(totalAmount.value)
                            .toFixed(2)
                    } else {
                        let displayTotal = 0.00
                        calculationCodes[billingData.calCodeLabel] = displayTotal
                        const decodeData = billingData.calDefination.split('+')
                        const billingDefLength = decodeData.length

                        if (billingDefLength > 1) {
                            let CalTotal = 0
                            for (let i = 0; i < decodeData.length; i++) {
                                CalTotal += parseFloat(calculationCodes[decodeData[i]])
                            }
                            calculationCodes[billingData.calCodeLabel] = CalTotal
                            displayTotal = CalTotal
                        } else {
                            if (billingData.type === 0) {
                                //By Percentage
                                let calculatedPercentage = 0
                                calculatedPercentage = ((parseFloat(billingData.percentage) / 100) * parseFloat(calculationCodes[decodeData[0]]))
                                calculationCodes[billingData.calCodeLabel] = parseFloat(calculatedPercentage)
                                displayTotal = calculatedPercentage
                            } else if (billingData.type === 1) {
                                //By Value
                                calculationCodes[billingData.calCodeLabel] = parseFloat(billingData.byValue)
                                displayTotal = parseFloat(billingData.byValue)
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
                        myBillingFormData.total_amount = parseFloat(displayTotal)
                            .toFixed(2)
                    }

                    axios.post('/api/new/return-rejection-billing-term', myBillingFormData)
                })
            }
        })
}

export const generateBillingTerm = async (returnRejectMemoId) => {
    const totalAmount = ref(0.00)
    const billingTerm = ref([])
    await axios.get(`/api/new/get-return-rejection-billing-term/${returnRejectMemoId}`)
        .then((res) => {
            billingTerm.value = res.data.data
        })

    await axios.delete(`/api/new/delete-return-rejection-billing-term/${returnRejectMemoId}`)
    await axios.get(`/api/new/get-rejection-memo-item/${returnRejectMemoId}`)
        .then((res) => {
            let itemList = res.data.data
            if (itemList.length > 0) {
                itemList.forEach((item) => {
                    totalAmount.value += item.itemAmount
                })
            }
        })

    if (billingTerm.value.length > 0) {
        const calculationCodes = []
        await billingTerm.value.forEach((billingData, key) => {
            const myBillingFormData = {
                _id: null,
                returnRejectMemoId: returnRejectMemoId,
                calCode: null,
                calCodeLabel: null,
                calDefination: null,
                percentage: null,
                byValue: null,
                operation: null,
                narration: null,
                type: null,
                total_amount: null,
                srNo: key + 1,
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
                myBillingFormData.total_amount = parseFloat(totalAmount.value)
                    .toFixed(2)
            } else {
                let displayTotal = 0.00
                calculationCodes[billingData.calCodeLabel] = displayTotal
                const decodeData = billingData.calDefination.split('+')
                const billingDefLength = decodeData.length

                if (billingDefLength > 1) {
                    let CalTotal = 0
                    for (let i = 0; i < decodeData.length; i++) {
                        CalTotal += parseFloat(calculationCodes[decodeData[i]])
                    }
                    calculationCodes[billingData.calCodeLabel] = CalTotal
                    displayTotal = CalTotal
                } else {
                    if (billingData.type === 0) {
                        //By Percentage
                        let calculatedPercentage = 0
                        calculatedPercentage = ((parseFloat(billingData.percentage) / 100) * parseFloat(calculationCodes[decodeData[0]]))
                        calculationCodes[billingData.calCodeLabel] = parseFloat(calculatedPercentage)
                        displayTotal = calculatedPercentage
                    } else if (billingData.type === 1) {
                        //By Value
                        calculationCodes[billingData.calCodeLabel] = parseFloat(billingData.byValue)
                        displayTotal = parseFloat(billingData.byValue)
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
                myBillingFormData.total_amount = parseFloat(displayTotal)
                    .toFixed(2)
            }

            axios.post('/api/new/return-rejection-billing-term', myBillingFormData)
        })
    }
}
