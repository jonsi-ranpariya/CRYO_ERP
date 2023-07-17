import mock from '@/@fake-db/mock'
import {paginateArray, sortCompare} from '@/@fake-db/utils'

/* eslint-disable global-require */
const data = {
    users: [
        {
            id: 1,
            uom: 'Nos.',
            uomEreturn: 'NOS',
            uomEwayBill: 'NOS',
            uomEinvoice: 'NOS',
            uomCalculation : 2,
        },
        {
            id: 2,
            uom: 'Nos1',
            uomEreturn: 'NOS1',
            uomEwayBill: 'NOS1',
            uomEinvoice: 'NOS1',
            uomCalculation : 2,
        },
        {
            id: 3,
            uom: 'Nos3',
            uomEreturn: 'NOS3',
            uomEwayBill: 'NOS3',
            uomEinvoice: 'NOS3',
        },
        {
            id: 4,
            uom: 'Nos.',
            uomEreturn: 'NOS',
            uomEwayBill: 'NOS',
            uomEinvoice: 'NOS',
            uomCalculation : 2,
        },
        {
            id: 5,
            uom: 'Nos.',
            uomEreturn: 'NOS',
            uomEwayBill: 'NOS',
            uomEinvoice: 'NOS',
            uomCalculation : 2,
        },
        {
            id: 6,
            uom: 'Nos.',
            uomEreturn: 'NOS',
            uomEwayBill: 'NOS',
            uomEinvoice: 'NOS',
            uomCalculation : 2,
        },
        {
            id: 7,
            uom: 'Nos.',
            uomEreturn: 'NOS',
            uomEwayBill: 'NOS',
            uomEinvoice: 'NOS',
            uomCalculation : 2,
        },
        {
            id: 8,
            uom: 'Nos.',
            uomEreturn: 'NOS',
            uomEwayBill: 'NOS',
            uomEinvoice: 'NOS',
            uomCalculation : 2,
        },
        {
            id: 9,
            uom: 'Nos.',
            uomEreturn: 'NOS',
            uomEwayBill: 'NOS',
            uomEinvoice: 'NOS',
            uomCalculation : 2,
        },
        {
            id: 10,
            uom: 'Nos.',
            uomEreturn: 'NOS',
            uomEwayBill: 'NOS',
            uomEinvoice: 'NOS',
            uomCalculation : 2,
        },
        {
            id: 11,
            uom: 'Nos.',
            uomEreturn: 'NOS',
            uomEwayBill: 'NOS',
            uomEinvoice: 'NOS',
            uomCalculation : 2,
        },

    ],
}
/* eslint-enable */

// ------------------------------------------------
// GET: Return Users
// ------------------------------------------------
mock.onGet('/general-master/uom/uom-list').reply(config => {
    // eslint-disable-next-line object-curly-newline
    const {
        q = '',
        perPage = 10,
        page = 1,
        sortBy = 'id',
        sortDesc = false,
    } = config.params
    /* eslint-enable */

    const queryLowered = q.toLowerCase()
    const filteredData = data.users.filter(
        user =>
            /* eslint-disable operator-linebreak, implicit-arrow-linebreak */
            user.uom.toLowerCase().includes(queryLowered) || user.uomEreturn.toLowerCase().includes(queryLowered),
    )
    /* eslint-enable  */

    const sortedData = filteredData.sort(sortCompare(sortBy))
    if (sortDesc) sortedData.reverse()

    return [
        200,
        {
            users: paginateArray(sortedData, perPage, page),
            total: filteredData.length,
        },
    ]
})

// ------------------------------------------------
// POST: Add new user
// ------------------------------------------------
mock.onPost('/general-master/uom/add-uom').reply(config => {
    // Get event from post data

    const {user} = JSON.parse(config.data)

    const {length} = data.users
    let lastIndex = 0
    if (length) {
        lastIndex = data.users[length - 1].id
    }
    user.id = lastIndex + 1

    data.users.push(user)

    return [201, {user}]
})

// ------------------------------------------------
// GET: Return Single User
// ------------------------------------------------
mock.onGet(/\/general-master\/uom\/get-uom\/\d+/).reply(config => {
    // Get event id from URL
    let userId = config.url.substring(config.url.lastIndexOf('/') + 1)

    // Convert Id to number
    userId = Number(userId)

    const userIndex = data.users.findIndex(e => e.id === userId)
    const user = data.users[userIndex]

    if (user) return [200, user]
    return [404]
})

mock.onGet('/general-master/uom/uomlistdata').reply(() => [200, data.users])
