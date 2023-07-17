import axios from "@axios";
import {changeAmountDecimalPoint, changeToRound} from "@core/utils/utils";

async function getItemNetTotalAmount(itemList, calculateName) {
    let sum = 0;
    await itemList.forEach(function (item) {
        switch (calculateName) {
            case 'itemNetAmount':
                if (typeof item.itemNetAmount == 'object'){
                    sum += getItemNetTotalAmount(item.itemNetAmount);
                } else {
                    sum += parseFloat(item.itemNetAmount)
                }
                break
            case 'cgstAmount':
                if (typeof item.itemNetAmount == 'object'){
                    sum += getItemNetTotalAmount(item.cgstAmount);
                } else {
                    sum += parseFloat(item.cgstAmount)
                }
                break
            case 'sgstAmount':
                if (typeof item.itemNetAmount == 'object'){
                    sum += getItemNetTotalAmount(item.sgstAmount);
                } else {
                    sum += parseFloat(item.sgstAmount)
                }
                break
            case 'igstAmount':
                if (typeof item.itemNetAmount == 'object'){
                    sum += getItemNetTotalAmount(item.igstAmount);
                } else {
                    sum += parseFloat(item.igstAmount)
                }
                break
            default:
                if (typeof item.itemNetAmount == 'object'){
                    sum += getItemNetTotalAmount(item.itemNetAmount);
                } else {
                    sum += parseFloat(item.itemNetAmount)
                }
                break
        }
    })
    return parseFloat(sum).toFixed(2);
}

export const generateBillingTerm = async (
    challanInvoiceId,
    billingData,
    itemDetail,
    deleteUrl,
    storeUrl,
    isRound,
    calculationType = 0,
) => {
    let dynamicCalculation = [], newAmount = 0.00, newBillingTerm = []
    let netAmount = await getItemNetTotalAmount(itemDetail, 'itemNetAmount')

    if (billingData.length > 0) {
        await axios.delete(deleteUrl)

        let countOrder = 1;

        await billingData.forEach((item) => {
            let myBillingTerm = {
                challanInvoiceId: challanInvoiceId,
                calCode: null,
                calDefination: null,
                description: null,
                type: null,
                byValue: 0,
                percentage: 0,
                total_amount: 0,
                narration: null,
                operation: null,
                calculateAmount: null,
                srNo: null,
            }

            let calCode = item.calCodeLabel ?? item.calCode

            myBillingTerm.srNo = countOrder;

            if (isRound === 0) {
                if (calCode === "BAS") {
                    dynamicCalculation[calCode] = parseFloat(parseFloat(netAmount).toFixed(2))
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
                    dynamicCalculation[calCode] = parseFloat(parseFloat(newAmount).toFixed(2))
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

                    let allCodeData = item.calDefination.split('+'), displayTotal = 0.00
                    if (allCodeData.length > 1) {
                        let calTotal = 0.00
                        for (let i = 0; i < allCodeData.length; i++) {
                            calTotal += parseFloat(dynamicCalculation[allCodeData[i]])
                        }
                        dynamicCalculation[calCode] = parseFloat(parseFloat(calTotal).toFixed(2))
                        displayTotal = parseFloat(parseFloat(calTotal).toFixed(2))
                        item.calculateAmount = parseFloat(parseFloat(displayTotal).toFixed(2))
                        myBillingTerm.calculateAmount = parseFloat(parseFloat(displayTotal).toFixed(2))
                        myBillingTerm.total_amount = parseFloat(parseFloat(displayTotal).toFixed(2))
                    } else {
                        if (parseFloat(item.percentage) > 0) {
                            //By Percentage
                            let calculatedPercentage = 0
                            calculatedPercentage = (parseFloat(parseFloat(item.percentage) / 100) * parseFloat(dynamicCalculation[allCodeData[0]]))
                            dynamicCalculation[calCode] = parseFloat(parseFloat(calculatedPercentage).toFixed(2))
                            displayTotal = parseFloat(calculatedPercentage).toFixed(2)
                        }

                        if (parseFloat(item.byValue) > 0) {
                            //By Value
                            dynamicCalculation[calCode] = parseFloat(item.byValue)
                            displayTotal = parseFloat(item.byValue).toFixed(2)
                        }
                        item.calculateAmount = displayTotal
                        myBillingTerm.calculateAmount = parseFloat(displayTotal).toFixed(2)
                        myBillingTerm.total_amount = parseFloat(displayTotal).toFixed(2)
                    }
                }
            }

            if (isRound === 1) {
                if (calCode === "BAS") {
                    dynamicCalculation[calCode] = parseFloat(parseFloat(netAmount).toFixed(2))
                    myBillingTerm.calCode = calCode
                    myBillingTerm.calDefination = item.calDefination
                    myBillingTerm.description = item.description
                    myBillingTerm.type = item.type
                    myBillingTerm.byValue = item.byValue
                    myBillingTerm.percentage = item.percentage
                    myBillingTerm.narration = item.narration
                    myBillingTerm.operation = item.operation
                    myBillingTerm.calculateAmount = parseFloat(parseFloat(netAmount).toFixed(2))
                    myBillingTerm.total_amount = parseFloat(parseFloat(netAmount).toFixed(2))
                    item.calculateAmount = parseFloat(parseFloat(netAmount).toFixed(2))
                } else {
                    dynamicCalculation[calCode] = parseFloat(parseFloat(newAmount).toFixed(2))
                    myBillingTerm.calCode = calCode
                    myBillingTerm.calDefination = item.calDefination
                    myBillingTerm.description = item.description
                    myBillingTerm.type = item.type
                    myBillingTerm.byValue = item.byValue
                    myBillingTerm.percentage = item.percentage
                    myBillingTerm.narration = item.narration
                    myBillingTerm.operation = item.operation
                    myBillingTerm.total_amount = parseFloat(parseFloat(newAmount).toFixed(2))
                    myBillingTerm.calculateAmount = parseFloat(parseFloat(newAmount).toFixed(2))
                    item.calculateAmount = parseFloat(parseFloat(newAmount).toFixed(2))

                    let allCodeData = item.calDefination.split('+'), displayTotal = 0.00
                    if (allCodeData.length > 1) {
                        let calTotal = 0.00
                        for (let i = 0; i < allCodeData.length; i++) {
                            calTotal += parseFloat(dynamicCalculation[allCodeData[i]])
                        }
                        dynamicCalculation[calCode] = parseFloat(parseFloat(calTotal).toFixed(2))
                        if (calCode === "GRD") {
                            displayTotal = changeToRound(calTotal)
                            item.calculateAmount = changeToRound(displayTotal)
                            myBillingTerm.calculateAmount = changeToRound(displayTotal)
                            myBillingTerm.total_amount = changeToRound(displayTotal)
                        } else {
                            displayTotal = parseFloat(parseFloat(calTotal).toFixed(2))
                            item.calculateAmount = parseFloat(parseFloat(displayTotal).toFixed(2))
                            myBillingTerm.calculateAmount = parseFloat(parseFloat(displayTotal).toFixed(2))
                            myBillingTerm.total_amount = parseFloat(parseFloat(displayTotal).toFixed(2))
                        }
                    } else {
                        if (parseFloat(item.percentage) > 0) {
                            //By Percentage
                            let calculatedPercentage = 0
                            calculatedPercentage = (parseFloat(parseFloat(item.percentage) / 100) * parseFloat(dynamicCalculation[allCodeData[0]]))
                            dynamicCalculation[calCode] = parseFloat(parseFloat(calculatedPercentage).toFixed(2))
                            displayTotal = parseFloat(parseFloat(calculatedPercentage).toFixed(2))
                        }

                        if (parseFloat(item.byValue) > 0) {
                            //By Value
                            dynamicCalculation[calCode] = parseFloat(item.byValue)
                            displayTotal = parseFloat(parseFloat(item.byValue).toFixed(2))
                        }
                        if (calCode === "GRD") {
                            item.calculateAmount = changeToRound(displayTotal)
                            myBillingTerm.calculateAmount = changeToRound(displayTotal)
                            myBillingTerm.total_amount = changeToRound(displayTotal)
                        } else {
                            item.calculateAmount = displayTotal
                            myBillingTerm.calculateAmount = parseFloat(parseFloat(displayTotal).toFixed(2))
                            myBillingTerm.total_amount = parseFloat(parseFloat(displayTotal).toFixed(2))
                        }
                    }
                }
            }

            if (isRound === 2) {
                if (calCode === "BAS") {
                    dynamicCalculation[calCode] = parseFloat(changeToRound(netAmount))
                    myBillingTerm.calCode = calCode
                    myBillingTerm.calDefination = item.calDefination
                    myBillingTerm.description = item.description
                    myBillingTerm.type = item.type
                    myBillingTerm.byValue = item.byValue
                    myBillingTerm.percentage = item.percentage
                    myBillingTerm.narration = item.narration
                    myBillingTerm.operation = item.operation
                    myBillingTerm.calculateAmount = parseFloat(changeToRound(netAmount))
                    myBillingTerm.total_amount = parseFloat(changeToRound(netAmount))
                    item.calculateAmount = parseFloat(changeToRound(netAmount))
                } else {
                    dynamicCalculation[calCode] = parseFloat(changeToRound(newAmount))
                    myBillingTerm.calCode = calCode
                    myBillingTerm.calDefination = item.calDefination
                    myBillingTerm.description = item.description
                    myBillingTerm.type = item.type
                    myBillingTerm.byValue = item.byValue
                    myBillingTerm.percentage = item.percentage
                    myBillingTerm.narration = item.narration
                    myBillingTerm.operation = item.operation
                    myBillingTerm.total_amount = parseFloat(changeToRound(newAmount))
                    myBillingTerm.calculateAmount = parseFloat(changeToRound(newAmount))
                    item.calculateAmount = parseFloat(changeToRound(newAmount))

                    let allCodeData = item.calDefination.split('+'), displayTotal = 0.00
                    if (allCodeData.length > 1) {
                        let calTotal = 0.00
                        for (let i = 0; i < allCodeData.length; i++) {
                            calTotal += parseFloat(changeToRound(dynamicCalculation[allCodeData[i]]))
                        }
                        dynamicCalculation[calCode] = parseFloat(changeToRound(calTotal))
                        displayTotal = parseFloat(changeToRound(calTotal))
                        item.calculateAmount = parseFloat(changeToRound(displayTotal))
                        myBillingTerm.calculateAmount = parseFloat(changeToRound(displayTotal))
                        myBillingTerm.total_amount = parseFloat(changeToRound(displayTotal))
                    } else {
                        if (parseFloat(item.percentage) > 0) {
                            //By Percentage
                            let calculatedPercentage = 0
                            calculatedPercentage = changeToRound((item.percentage / 100) * parseFloat(dynamicCalculation[allCodeData[0]])
                        )
                            dynamicCalculation[calCode] = parseFloat(changeToRound(calculatedPercentage))
                            displayTotal = parseFloat(changeToRound(calculatedPercentage))
                        }

                        if (parseFloat(item.byValue) > 0) {
                            //By Value
                            dynamicCalculation[calCode] = parseFloat(changeToRound(item.byValue))
                            displayTotal = parseFloat(changeToRound(item.byValue))
                        }
                        item.calculateAmount = changeAmountDecimalPoint(changeToRound(displayTotal), 2)
                        myBillingTerm.calculateAmount = changeAmountDecimalPoint(changeToRound(displayTotal), 2)
                        myBillingTerm.total_amount = changeAmountDecimalPoint(changeToRound(displayTotal), 2)
                    }
                }
            }

            newBillingTerm.push(myBillingTerm)
            countOrder += 1
        });
        await axios.post('/api/bulk-add-challan-billing-term', {
            billingTerm: newBillingTerm
        });
    }
}
