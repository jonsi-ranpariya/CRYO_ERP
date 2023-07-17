import axios from '@axios'
import { changeAmountDecimalPoint, changeToRound } from '@core/utils/utils'
import { ref } from '@vue/composition-api'

export const generateBillingTermFromTemplate = async (templateId, jobWorkOrderId, roundingType) => {
    const totalAmount = ref(0.00)
    await axios.delete(`/api/delete-job-work-order-billing-term/${jobWorkOrderId}`)
    await axios.get(`/api/get-job-work-order-item/${jobWorkOrderId}`)
        .then((res) => {
            let itemList = res.data.data
            if (itemList.length > 0) {
                itemList.forEach((item) => {
                    totalAmount.value += item.itemProcessAmt
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
                        jobWorkOrderId: jobWorkOrderId,
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

                    if (roundingType === 0) {
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
                    }

                    if (roundingType === 1) {
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
                            if (billingData.calCodeLabel === 'GRD') {
                                myBillingFormData.total_amount = changeAmountDecimalPoint(changeToRound(parseFloat(displayTotal)
                                    .toFixed(2)), 2)
                            } else {
                                myBillingFormData.total_amount = parseFloat(displayTotal)
                                    .toFixed(2)
                            }
                        }
                    }

                    if (roundingType === 2) {
                        if (billingData.calCodeLabel === 'BAS') {
                            calculationCodes[billingData.calCodeLabel] = changeToRound(totalAmount.value)
                            myBillingFormData.calCode = billingData.calCode
                            myBillingFormData.calCodeLabel = billingData.calCodeLabel
                            myBillingFormData.description = billingData.description
                            myBillingFormData.calDefination = billingData.calDefination
                            myBillingFormData.percentage = billingData.percentage
                            myBillingFormData.byValue = billingData.byValue
                            myBillingFormData.operation = billingData.operation
                            myBillingFormData.narration = billingData.narration
                            myBillingFormData.type = billingData.type
                            myBillingFormData.total_amount = changeToRound(parseFloat(totalAmount.value)
                                .toFixed(2))
                        } else {
                            let displayTotal = 0.00
                            calculationCodes[billingData.calCodeLabel] = displayTotal
                            const decodeData = billingData.calDefination.split('+')
                            const billingDefLength = decodeData.length

                            if (billingDefLength > 1) {
                                let CalTotal = 0
                                for (let i = 0; i < decodeData.length; i++) {
                                    CalTotal += changeAmountDecimalPoint(changeToRound(parseFloat(calculationCodes[decodeData[i]])), 2)
                                }
                                calculationCodes[billingData.calCodeLabel] = CalTotal
                                displayTotal = CalTotal
                            } else {
                                if (billingData.type === 0) {
                                    //By Percentage
                                    let calculatedPercentage = 0
                                    calculatedPercentage = changeAmountDecimalPoint(changeToRound((parseFloat(billingData.percentage) / 100) * parseFloat(calculationCodes[decodeData[0]])), 2)
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
                            myBillingFormData.total_amount = changeAmountDecimalPoint(changeToRound(parseFloat(displayTotal)
                                .toFixed(2)), 2)
                        }
                    }

                    axios.post('/api/job-order-billing-term', myBillingFormData)
                })
            }
        })
}

export const generateBillingTerm = async (jobWorkOrderId, roundingType) => {
    const totalAmount = ref(0.00)
    const billingTerm = ref([])
    await axios.get(`/api/get-job-work-order-billing-term/${jobWorkOrderId}`)
        .then((res) => {
            billingTerm.value = res.data
        })

    await axios.delete(`/api/delete-job-work-order-billing-term/${jobWorkOrderId}`)
    await axios.get(`/api/get-job-work-order-item/${jobWorkOrderId}`)
        .then((res) => {
            let itemList = res.data.data
            if (itemList.length > 0) {
                itemList.forEach((item) => {
                    totalAmount.value += item.itemProcessAmt
                })
            }
        })

    if (billingTerm.value.length > 0) {
        const calculationCodes = []
        await billingTerm.value.forEach((billingData, key) => {
            const myBillingFormData = {
                _id: null,
                jobWorkOrderId: jobWorkOrderId,
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

            if (roundingType === 0) {
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
            }

            if (roundingType === 1) {
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
                    if (billingData.calCodeLabel === 'GRD') {
                        myBillingFormData.total_amount = changeAmountDecimalPoint(changeToRound(parseFloat(displayTotal)
                            .toFixed(2)), 2)
                    } else {
                        myBillingFormData.total_amount = parseFloat(displayTotal)
                            .toFixed(2)
                    }
                }
            }

            if (roundingType === 2) {
                if (billingData.calCodeLabel === 'BAS') {
                    calculationCodes[billingData.calCodeLabel] = changeToRound(totalAmount.value)
                    myBillingFormData.calCode = billingData.calCode
                    myBillingFormData.calCodeLabel = billingData.calCodeLabel
                    myBillingFormData.description = billingData.description
                    myBillingFormData.calDefination = billingData.calDefination
                    myBillingFormData.percentage = billingData.percentage
                    myBillingFormData.byValue = billingData.byValue
                    myBillingFormData.operation = billingData.operation
                    myBillingFormData.narration = billingData.narration
                    myBillingFormData.type = billingData.type
                    myBillingFormData.total_amount = changeToRound(parseFloat(totalAmount.value)
                        .toFixed(2))
                } else {
                    let displayTotal = 0.00
                    calculationCodes[billingData.calCodeLabel] = displayTotal
                    const decodeData = billingData.calDefination.split('+')
                    const billingDefLength = decodeData.length

                    if (billingDefLength > 1) {
                        let CalTotal = 0
                        for (let i = 0; i < decodeData.length; i++) {
                            CalTotal += changeAmountDecimalPoint(changeToRound(parseFloat(calculationCodes[decodeData[i]])), 2)
                        }
                        calculationCodes[billingData.calCodeLabel] = CalTotal
                        displayTotal = CalTotal
                    } else {
                        if (billingData.type === 0) {
                            //By Percentage
                            let calculatedPercentage = 0
                            calculatedPercentage = changeAmountDecimalPoint(changeToRound((parseFloat(billingData.percentage) / 100) * parseFloat(calculationCodes[decodeData[0]])), 2)
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
                    myBillingFormData.total_amount = changeAmountDecimalPoint(changeToRound(parseFloat(displayTotal)
                        .toFixed(2)), 2)
                }
            }

            axios.post('/api/job-order-billing-term', myBillingFormData)
        })
    }
}
