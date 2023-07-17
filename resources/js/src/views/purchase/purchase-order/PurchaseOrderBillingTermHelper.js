import axios from '@axios'
import { changeAmountDecimalPoint, changeToRound } from '@core/utils/utils'
import { ref } from '@vue/composition-api'

function getItemNetTotalAmount(itemList, roundingType) {
    let sum = 0
    itemList.forEach(function (item) {
        if (typeof item.itemNetAmount == 'object') {
            sum += getItemNetTotalAmount(item.itemNetAmount)
        } else {
            if (roundingType === 2) {
                sum += changeToRound(parseFloat(item.itemNetAmount))
            } else {
                sum += parseFloat(item.itemNetAmount)
            }
        }
    })
    return changeAmountDecimalPoint(sum, '2')
}

export const generatePurchaseBillingTerm = async (orderId, billingData, itemDetail, deleteUrl, storeUrl, roundingType) => {
    let dynamicCalculation = [],
        newAmount = 0.00
    const newBillingTerm = ref([])
    let netAmount = getItemNetTotalAmount(itemDetail, roundingType)

    if (billingData.length > 0) {
        await axios.delete(deleteUrl)
        await billingData.forEach((item) => {
            let myBillingTerm = {
                purchaseOrderId: orderId,
                calCode: null,
                calDefination: null,
                type: null,
                byValue: 0,
                percentage: 0,
                total_amount: 0,
                narration: null,
                operation: null,
                calculateAmount: null,
            }

            if (roundingType === 0) {
                if (item.calCodeLabel === 'BAS') {
                    dynamicCalculation[item.calCodeLabel] = netAmount
                    myBillingTerm.calCode = item.calCode
                    myBillingTerm.calCodeLabel = item.calCodeLabel
                    myBillingTerm.description = item.description
                    myBillingTerm.calDefination = item.calDefination
                    myBillingTerm.percentage = item.percentage
                    myBillingTerm.byValue = item.byValue
                    myBillingTerm.operation = item.operation
                    myBillingTerm.narration = item.narration
                    myBillingTerm.type = item.type
                    myBillingTerm.calculateAmount = parseFloat(netAmount)
                        .toFixed(2)
                } else {
                    let displayTotal = 0.00
                    dynamicCalculation[item.calCodeLabel] = displayTotal
                    const allCodeData = item.calDefination.split('+')
                    const billingDefLength = allCodeData.length

                    if (billingDefLength > 1) {
                        let CalTotal = 0
                        for (let i = 0; i < allCodeData.length; i++) {
                            CalTotal += parseFloat(dynamicCalculation[allCodeData[i]])
                        }
                        dynamicCalculation[item.calCodeLabel] = CalTotal
                        displayTotal = CalTotal
                    } else {
                        if (item.percentage > 0) {
                            //By Percentage
                            let calculatedPercentage = 0
                            calculatedPercentage = ((parseFloat(item.percentage) / 100) * parseFloat(dynamicCalculation[allCodeData[0]]))
                            dynamicCalculation[item.calCodeLabel] = parseFloat(calculatedPercentage)
                            displayTotal = calculatedPercentage
                        } else if (item.byValue > 0) {
                            //By Value
                            dynamicCalculation[item.calCodeLabel] = parseFloat(item.byValue)
                            displayTotal = parseFloat(item.byValue)
                        }
                    }

                    myBillingTerm.calCode = item.calCode
                    myBillingTerm.calCodeLabel = item.calCodeLabel
                    myBillingTerm.description = item.description
                    myBillingTerm.calDefination = item.calDefination
                    myBillingTerm.percentage = item.percentage
                    myBillingTerm.byValue = item.byValue
                    myBillingTerm.operation = item.operation
                    myBillingTerm.narration = item.narration
                    myBillingTerm.type = item.type
                    myBillingTerm.calculateAmount = parseFloat(displayTotal)
                        .toFixed(2)
                }
            }

            if (roundingType === 1) {
                if (item.calCodeLabel === 'BAS') {
                    dynamicCalculation[item.calCodeLabel] = netAmount
                    myBillingTerm.calCode = item.calCode
                    myBillingTerm.calCodeLabel = item.calCodeLabel
                    myBillingTerm.description = item.description
                    myBillingTerm.calDefination = item.calDefination
                    myBillingTerm.percentage = item.percentage
                    myBillingTerm.byValue = item.byValue
                    myBillingTerm.operation = item.operation
                    myBillingTerm.narration = item.narration
                    myBillingTerm.type = item.type
                    myBillingTerm.calculateAmount = parseFloat(netAmount)
                        .toFixed(2)
                } else {
                    let displayTotal = 0.00
                    dynamicCalculation[item.calCodeLabel] = displayTotal
                    const allCodeData = item.calDefination.split('+')
                    const billingDefLength = allCodeData.length

                    if (billingDefLength > 1) {
                        let CalTotal = 0
                        for (let i = 0; i < allCodeData.length; i++) {
                            CalTotal += parseFloat(dynamicCalculation[allCodeData[i]])
                        }
                        dynamicCalculation[item.calCodeLabel] = CalTotal
                        displayTotal = CalTotal
                    } else {
                        if (item.percentage > 0) {
                            //By Percentage
                            let calculatedPercentage = 0
                            calculatedPercentage = ((parseFloat(item.percentage) / 100) * parseFloat(dynamicCalculation[allCodeData[0]]))
                            dynamicCalculation[item.calCodeLabel] = parseFloat(calculatedPercentage)
                            displayTotal = calculatedPercentage
                        }
                        if (item.byValue > 0) {
                            //By Value
                            dynamicCalculation[item.calCodeLabel] = parseFloat(item.byValue)
                            displayTotal = parseFloat(item.byValue)
                        }
                    }

                    myBillingTerm.calCode = item.calCode
                    myBillingTerm.calCodeLabel = item.calCodeLabel
                    myBillingTerm.description = item.description
                    myBillingTerm.calDefination = item.calDefination
                    myBillingTerm.percentage = item.percentage
                    myBillingTerm.byValue = item.byValue
                    myBillingTerm.operation = item.operation
                    myBillingTerm.narration = item.narration
                    myBillingTerm.type = item.type
                    if (item.calCodeLabel === 'GRD') {
                        myBillingTerm.calculateAmount = changeAmountDecimalPoint(changeToRound(displayTotal), 2)
                    } else {
                        myBillingTerm.calculateAmount = parseFloat(displayTotal)
                            .toFixed(2)
                    }
                }
            }

            if (roundingType === 2) {
                if (item.calCodeLabel === 'BAS') {
                    dynamicCalculation[item.calCodeLabel] = changeAmountDecimalPoint(changeToRound(netAmount))
                    myBillingTerm.calCode = item.calCode
                    myBillingTerm.calCodeLabel = item.calCodeLabel
                    myBillingTerm.description = item.description
                    myBillingTerm.calDefination = item.calDefination
                    myBillingTerm.percentage = item.percentage
                    myBillingTerm.byValue = item.byValue
                    myBillingTerm.operation = item.operation
                    myBillingTerm.narration = item.narration
                    myBillingTerm.type = item.type
                    myBillingTerm.calculateAmount = changeAmountDecimalPoint(changeToRound(netAmount), 2)
                } else {
                    let displayTotal = 0.00
                    dynamicCalculation[item.calCodeLabel] = displayTotal
                    const allCodeData = item.calDefination.split('+')
                    const billingDefLength = allCodeData.length

                    if (billingDefLength > 1) {
                        let CalTotal = 0
                        for (let i = 0; i < allCodeData.length; i++) {
                            CalTotal += changeAmountDecimalPoint(changeToRound(dynamicCalculation[allCodeData[i]]), 2)
                        }
                        dynamicCalculation[item.calCodeLabel] = CalTotal
                        displayTotal = CalTotal
                    } else {
                        if (item.percentage > 0) {
                            //By Percentage
                            let calculatedPercentage = 0
                            calculatedPercentage = changeAmountDecimalPoint(changeToRound((parseFloat(item.percentage) / 100) * parseFloat(dynamicCalculation[allCodeData[0]])), 2)
                            dynamicCalculation[item.calCodeLabel] = parseFloat(calculatedPercentage)
                            displayTotal = calculatedPercentage
                        } else if (item.byValue > 0) {
                            //By Value
                            dynamicCalculation[item.calCodeLabel] = changeAmountDecimalPoint(changeToRound(parseFloat(item.byValue)), 2)
                            displayTotal = changeAmountDecimalPoint(changeToRound(parseFloat(item.byValue)), 2)
                        }
                    }

                    myBillingTerm.calCode = item.calCode
                    myBillingTerm.calCodeLabel = item.calCodeLabel
                    myBillingTerm.description = item.description
                    myBillingTerm.calDefination = item.calDefination
                    myBillingTerm.percentage = item.percentage
                    myBillingTerm.byValue = item.byValue
                    myBillingTerm.operation = item.operation
                    myBillingTerm.narration = item.narration
                    myBillingTerm.type = item.type
                    myBillingTerm.calculateAmount = changeAmountDecimalPoint(changeToRound(displayTotal), 2)
                }
            }

            newBillingTerm.value.push(myBillingTerm)

        })
        await axios.post(storeUrl, {
            billingTerm: newBillingTerm.value
        })
    }
}
