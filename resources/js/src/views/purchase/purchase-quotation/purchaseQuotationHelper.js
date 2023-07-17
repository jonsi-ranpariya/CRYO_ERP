import axios from "@axios";
import { changeToRound } from '@core/utils/utils'

async function getItemNetTotalAmount(itemList) {
    let sum = 0;
    itemList.forEach(function(item) {
        if (typeof item.itemNetAmount == 'object')
            sum += getItemNetTotalAmount(item.itemNetAmount);
        else
            sum += parseFloat(item.itemNetAmount)
    })
    return parseFloat(sum).toFixed(2);
}

export const generatePurchaseBillingTerm = async (quotationId, billingData, itemDetail, deleteUrl, storeUrl, roundingType) => {
    let dynamicCalculation = [], newAmount = 0.00, itemDetails = [];
    await axios.get(`/api/get-purchase-quotation-item/${quotationId}`).then((res) => {
        itemDetails = res.data.data
    })

    let netAmount = await getItemNetTotalAmount(itemDetails)

    if (billingData.length > 0) {
        let newBillingTerm = []
        await axios.delete(deleteUrl)
        await billingData.forEach((item, key) => {
            let myBillingTerm = {
                purchaseQuotationId: quotationId,
                calCode: null,
                calDefination: null,
                type: null,
                byValue: 0,
                percentage: 0,
                total_amount: 0,
                narration: null,
                operation: null,
                calculateAmount: null,
                srNo: key
            }

            let calCode = item.calCodeLabel ?? item.calCode
            if (roundingType === 0){
                if (calCode === "BAS") {
                    dynamicCalculation[calCode] = parseFloat(netAmount).toFixed(2)
                    myBillingTerm.calCode = calCode
                    myBillingTerm.calDefination = item.calDefination
                    myBillingTerm.description = item.description
                    myBillingTerm.type = item.type
                    myBillingTerm.byValue = item.byValue
                    myBillingTerm.percentage = item.percentage
                    myBillingTerm.narration = item.narration
                    myBillingTerm.operation = item.operation
                    myBillingTerm.calculateAmount = parseFloat(netAmount).toFixed(2)
                    myBillingTerm.total_amount = parseFloat(netAmount).toFixed(2)
                    item.calculateAmount = parseFloat(netAmount).toFixed(2)
                } else {
                    dynamicCalculation[calCode] = parseFloat(newAmount).toFixed(2)
                    myBillingTerm.calCode = calCode
                    myBillingTerm.calDefination = item.calDefination
                    myBillingTerm.description = item.description
                    myBillingTerm.type = item.type
                    myBillingTerm.byValue = item.byValue
                    myBillingTerm.percentage = item.percentage
                    myBillingTerm.narration = item.narration
                    myBillingTerm.operation = item.operation
                    myBillingTerm.total_amount = parseFloat(netAmount).toFixed(2)
                    myBillingTerm.calculateAmount = parseFloat(netAmount).toFixed(2)

                    let allCodeData = item.calDefination.split('+'), dispayTotal = 0.00
                    if (allCodeData.length > 1) {
                        let calTotal = 0.00
                        for (let i = 0; i < allCodeData.length; i++) {
                            calTotal += parseFloat(dynamicCalculation[allCodeData[i]])
                        }
                        dynamicCalculation[calCode] = parseFloat(calTotal).toFixed(2)
                        dispayTotal = parseFloat(calTotal).toFixed(2)
                        item.calculateAmount = parseFloat(dispayTotal).toFixed(2)
                        myBillingTerm.calculateAmount = parseFloat(dispayTotal).toFixed(2)
                        myBillingTerm.total_amount = parseFloat(dispayTotal).toFixed(2)
                    } else {
                        if (parseFloat(item.percentage) > 0) {
                            //By Percentage
                            let calculatedPercentage = 0
                            calculatedPercentage = (parseFloat(parseFloat(item.percentage) / 100) * parseFloat(dynamicCalculation[allCodeData[0]]))
                            dynamicCalculation[calCode] = calculatedPercentage
                            dispayTotal = parseFloat(calculatedPercentage).toFixed(2)
                        }

                        if (parseFloat(item.byValue) > 0) {
                            //By Value
                            dynamicCalculation[calCode] = parseFloat(item.byValue)
                            dispayTotal = parseFloat(item.byValue).toFixed(2)
                        }
                        item.calculateAmount = dispayTotal
                        myBillingTerm.calculateAmount = parseFloat(dispayTotal).toFixed(2)
                        myBillingTerm.total_amount = parseFloat(dispayTotal).toFixed(2)
                    }
                }
            }

            if (roundingType === 1){
                if (calCode === "BAS") {
                    dynamicCalculation[calCode] = parseFloat(netAmount).toFixed(2)
                    myBillingTerm.calCode = calCode
                    myBillingTerm.calDefination = item.calDefination
                    myBillingTerm.description = item.description
                    myBillingTerm.type = item.type
                    myBillingTerm.byValue = item.byValue
                    myBillingTerm.percentage = item.percentage
                    myBillingTerm.narration = item.narration
                    myBillingTerm.operation = item.operation
                    myBillingTerm.calculateAmount = parseFloat(netAmount).toFixed(2)
                    myBillingTerm.total_amount = parseFloat(netAmount).toFixed(2)
                    item.calculateAmount = parseFloat(netAmount).toFixed(2)
                } else {
                    dynamicCalculation[calCode] = parseFloat(newAmount).toFixed(2)
                    myBillingTerm.calCode = calCode
                    myBillingTerm.calDefination = item.calDefination
                    myBillingTerm.description = item.description
                    myBillingTerm.type = item.type
                    myBillingTerm.byValue = item.byValue
                    myBillingTerm.percentage = item.percentage
                    myBillingTerm.narration = item.narration
                    myBillingTerm.operation = item.operation
                    myBillingTerm.total_amount = parseFloat(newAmount).toFixed(2)
                    myBillingTerm.calculateAmount = parseFloat(newAmount).toFixed(2)

                    let allCodeData = item.calDefination.split('+'), dispayTotal = 0.00
                    if (allCodeData.length > 1) {
                        let calTotal = 0.00
                        for (let i = 0; i < allCodeData.length; i++) {
                            calTotal += parseFloat(dynamicCalculation[allCodeData[i]])
                        }
                        if (calCode === 'GRD'){
                            dynamicCalculation[calCode] = parseFloat(changeToRound(calTotal)).toFixed(2)
                            dispayTotal = parseFloat(changeToRound(calTotal)).toFixed(2)
                            item.calculateAmount = parseFloat(changeToRound(calTotal)).toFixed(2)
                            myBillingTerm.calculateAmount = parseFloat(changeToRound(calTotal)).toFixed(2)
                            myBillingTerm.total_amount = parseFloat(changeToRound(calTotal)).toFixed(2)
                        }else{
                            dynamicCalculation[calCode] = parseFloat(calTotal).toFixed(2)
                            dispayTotal = parseFloat(calTotal).toFixed(2)
                            item.calculateAmount = parseFloat(dispayTotal).toFixed(2)
                            myBillingTerm.calculateAmount = parseFloat(dispayTotal).toFixed(2)
                            myBillingTerm.total_amount = parseFloat(dispayTotal).toFixed(2)
                        }

                    } else {
                        if (parseFloat(item.percentage) > 0) {
                            //By Percentage
                            let calculatedPercentage = 0
                            calculatedPercentage = (parseFloat(parseFloat(item.percentage) / 100) * parseFloat(dynamicCalculation[allCodeData[0]]))
                            dynamicCalculation[calCode] = calculatedPercentage
                            dispayTotal = parseFloat(calculatedPercentage).toFixed(2)
                        }

                        if (parseFloat(item.byValue) > 0) {
                            //By Value
                            dynamicCalculation[calCode] = parseFloat(item.byValue)
                            dispayTotal = parseFloat(item.byValue).toFixed(2)
                        }
                        item.calculateAmount = dispayTotal
                        myBillingTerm.calculateAmount = parseFloat(dispayTotal).toFixed(2)
                        myBillingTerm.total_amount = parseFloat(dispayTotal).toFixed(2)
                    }
                }
            }

            if (roundingType === 2) {
                if (calCode === "BAS") {
                    dynamicCalculation[calCode] = parseFloat(changeToRound(netAmount)).toFixed(2)
                    myBillingTerm.calCode = calCode
                    myBillingTerm.calDefination = item.calDefination
                    myBillingTerm.description = item.description
                    myBillingTerm.type = item.type
                    myBillingTerm.byValue = item.byValue
                    myBillingTerm.percentage = item.percentage
                    myBillingTerm.narration = item.narration
                    myBillingTerm.operation = item.operation
                    myBillingTerm.calculateAmount = parseFloat(changeToRound(netAmount)).toFixed(2)
                    myBillingTerm.total_amount = parseFloat(changeToRound(netAmount)).toFixed(2)
                    item.calculateAmount = parseFloat(changeToRound(netAmount)).toFixed(2)
                } else {
                    dynamicCalculation[calCode] = parseFloat(changeToRound(newAmount)).toFixed(2)
                    myBillingTerm.calCode = calCode
                    myBillingTerm.calDefination = item.calDefination
                    myBillingTerm.description = item.description
                    myBillingTerm.type = item.type
                    myBillingTerm.byValue = item.byValue
                    myBillingTerm.percentage = item.percentage
                    myBillingTerm.narration = item.narration
                    myBillingTerm.operation = item.operation
                    myBillingTerm.total_amount = parseFloat(changeToRound(newAmount)).toFixed(2)
                    myBillingTerm.calculateAmount = parseFloat(changeToRound(newAmount)).toFixed(2)

                    let allCodeData = item.calDefination.split('+'), dispayTotal = 0.00
                    if (allCodeData.length > 1) {
                        let calTotal = 0.00
                        for (let i = 0; i < allCodeData.length; i++) {
                            calTotal += parseFloat(dynamicCalculation[allCodeData[i]])
                        }
                        dynamicCalculation[calCode] = parseFloat(changeToRound(calTotal)).toFixed(2)
                        dispayTotal = parseFloat(changeToRound(calTotal)).toFixed(2)
                        item.calculateAmount = parseFloat(changeToRound(dispayTotal)).toFixed(2)
                        myBillingTerm.calculateAmount = parseFloat(changeToRound(dispayTotal)).toFixed(2)
                        myBillingTerm.total_amount = parseFloat(changeToRound(dispayTotal)).toFixed(2)
                    } else {
                        if (parseFloat(item.percentage) > 0) {
                            //By Percentage
                            let calculatedPercentage = 0
                            calculatedPercentage = (parseFloat(parseFloat(item.percentage) / 100) * parseFloat(dynamicCalculation[allCodeData[0]]))
                            dynamicCalculation[calCode] = changeToRound(calculatedPercentage)
                            dispayTotal = parseFloat(changeToRound(calculatedPercentage)).toFixed(2)
                        }

                        if (parseFloat(item.byValue) > 0) {
                            //By Value
                            dynamicCalculation[calCode] = parseFloat(item.byValue)
                            dispayTotal = parseFloat(item.byValue).toFixed(2)
                        }
                        item.calculateAmount = changeToRound(dispayTotal)
                        myBillingTerm.calculateAmount = parseFloat(changeToRound(dispayTotal)).toFixed(2)
                        myBillingTerm.total_amount = parseFloat(changeToRound(dispayTotal)).toFixed(2)
                    }
                }
            }

            newBillingTerm.push(myBillingTerm)
        })
        await axios.post(storeUrl, {
            billingTerm: newBillingTerm
        })
    }
}
