import mock from '@/@fake-db/mock'

/* eslint-disable global-require */
const data = {
    invoicesData: [
        {
            id: 1,
            partyCode: 'A0002',
            invoiceNo: '2021-22/00002',
            invoiceDate: '07/03/2022',
            challanNo: 'CHN002',
            orderNo: 'ORD0002',
            billToPartyGst: null,
            billToPartyName: 'Party One',
            billToPartyAddress: null,
            billToPartyState: null,
            billToPartyCountry: null,
            billToPartyPanNo: null,
            billToPartyAttn: null,
            shipToPartyGst: null,
            shipToPartyName: null,
            shipToPartyAddress: null,
            shipToPartyState: null,
            shipToPartyCountry: null,
            shipToPartyPanNo: null,
            invoiceItemList: [
                {
                    id: 1,
                    item_detail: 'ITEM ONE',
                    hsn_sac: 'HSN1',
                    uom: 'nos',
                    cost: '100.00',
                    qty: '5',
                    total_amount: '500.00',
                },
                {
                    id: 2,
                    item_detail: 'ITEM TWO',
                    hsn_sac: 'HSN2',
                    uom: 'nos',
                    cost: '500.00',
                    qty: '5',
                    total_amount: '5000.00',
                },
            ],
            cgstTax: '9',
            sgstTax: '9',
            igstTax: 0,
            ugstTax: 0,
            transporter: null,
            vehicleNo: null,
            lrNo: null,
            paymentTerm: 'Price Basis : The Price is Ex Works, Basis. \nPayment Terms : Within 30 Days Direct Credit',
            basicTotalAmount: '5500.00',
            subTotalAmount: '5500.00',
            cgstTotalAmount: '495.00',
            sgstTotalAmount: '495.00',
            igstTotalAmount: null,
            ugstTotalAmount: null,
            subTotalAmount1: '6490.00',
            grandTotalAmount: '6490.00',
        },
        {
            id: 2,
            partyCode: 'A0001',
            invoiceNo: '2021-22/00001',
            invoiceDate: '07/03/2022',
            challanNo: 'CHN001',
            orderNo: 'ORD0001',
            billToPartyGst: null,
            billToPartyName: 'Party Two',
            billToPartyAddress: null,
            billToPartyState: null,
            billToPartyCountry: null,
            billToPartyPanNo: null,
            billToPartyAttn: null,
            shipToPartyGst: null,
            shipToPartyName: null,
            shipToPartyAddress: null,
            shipToPartyState: null,
            shipToPartyCountry: null,
            shipToPartyPanNo: null,
            invoiceItemList: [
                {
                    id: 1,
                    item_detail: 'ITEM ONE',
                    hsn_sac: 'HSN1',
                    uom: 'nos',
                    cost: '100.00',
                    qty: '5',
                    total_amount: '500.00',
                },
                {
                    id: 2,
                    item_detail: 'ITEM TWO',
                    hsn_sac: 'HSN2',
                    uom: 'nos',
                    cost: '500.00',
                    qty: '5',
                    total_amount: '5000.00',
                },
            ],
            cgstTax: '9',
            sgstTax: '9',
            igstTax: 0,
            ugstTax: 0,
            transporter: null,
            vehicleNo: null,
            lrNo: null,
            paymentTerm: 'Price Basis : The Price is Ex Works, Basis. \nPayment Terms : Within 30 Days Direct Credit',
            basicTotalAmount: '5500.00',
            subTotalAmount: '5500.00',
            cgstTotalAmount: '495.00',
            sgstTotalAmount: '495.00',
            igstTotalAmount: null,
            ugstTotalAmount: null,
            subTotalAmount1: '6490.00',
            grandTotalAmount: '6490.00',
        },
    ],
}

mock.onGet('/apps/dispatch/invoiceslist').reply(() => [200, data.invoicesData])

mock.onPost('dispatch/invoice/addinvoices').reply(config => {
    // Get event from post data
    const { user } = JSON.parse(config.data)

    const { length } = data.invoicesData
    let lastIndex = 0
    if (length) {
        lastIndex = data.invoicesData[length - 1].id
    }
    user.id = lastIndex + 1

    data.invoicesData.push(user)

    return [201, { invoice_id: user.id }]
})

mock.onGet(/\/dispatch\/invoice\/detail\/\d+/).reply(config => {
    // Get event id from URL
    let userId = config.url.substring(config.url.lastIndexOf('/') + 1)

    // Convert Id to number
    userId = Number(userId)

    const userIndex = data.invoicesData.findIndex(e => e.id === userId)
    const user = data.invoicesData[userIndex]

    if (user) return [200, user]
    return [404]
})

mock.onPost('dispatch/invoice/editinvoices').reply(config => {
    // Get event from post data
    const { user } = JSON.parse(config.data)

    let userId = user.id

    userId = Number(userId)

    const userIndex = data.invoicesData.findIndex(e => e.id === userId)

    data.invoicesData[userIndex] = user

    return [201, { invoice_id: user.id }]
})
