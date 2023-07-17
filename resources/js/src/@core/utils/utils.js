import router from '@/router'
import moment from 'moment'
import { reactive, getCurrentInstance, watch, toRefs } from '@vue/composition-api'
import XLSX from 'xlsx/xlsx.js'
import jsPDF from 'jspdf'
import autoTable from 'jspdf-autotable'
import axios from '@axios'
import { initialAbility } from '../../libs/acl/config'
import useJwt from '@/auth/jwt/useJwt'
import { Ability } from '@casl/ability'

export const isObject = obj => typeof obj === 'object' && obj !== null

export const isToday = date => {
    const today = new Date()
    return (
        /* eslint-disable operator-linebreak */
        date.getDate() === today.getDate() &&
        date.getMonth() === today.getMonth() &&
        date.getFullYear() === today.getFullYear()
        /* eslint-enable */
    )
}

const getRandomFromArray = array => array[Math.floor(Math.random() * array.length)]

// ? Light and Dark variant is not included
// prettier-ignore
export const getRandomBsVariant = () => getRandomFromArray(['primary', 'secondary', 'success', 'warning', 'danger', 'info'])

export const isDynamicRouteActive = route => {
    const { route: resolvedRoute } = router.resolve(route)
    return resolvedRoute.path === router.currentRoute.path
}

// Thanks: https://medium.com/better-programming/reactive-vue-routes-with-the-composition-api-18c1abd878d1
export const useRouter = () => {
    const vm = getCurrentInstance().proxy
    const state = reactive({
        route: vm.$route,
    })

    watch(
        () => vm.$route,
        r => {
            state.route = r
        },
    )

    return {
        ...toRefs(state),
        router: vm.$router
    }
}

/**
 * This is just enhancement over Object.extend [Gives deep extend]
 * @param {target} a Object which contains values to be overridden
 * @param {source} b Object which contains values to override
 */
export const objectExtend = (a, b) => {
    // Don't touch 'null' or 'undefined' objects.
    if (a == null || b == null) {
        return a
    }

    Object.keys(b)
        .forEach(key => {
            if (Object.prototype.toString.call(b[key]) === '[object Object]') {
                if (Object.prototype.toString.call(a[key]) !== '[object Object]') {
                    // eslint-disable-next-line no-param-reassign
                    a[key] = b[key]
                } else {
                    // eslint-disable-next-line no-param-reassign
                    a[key] = objectExtend(a[key], b[key])
                }
            } else {
                // eslint-disable-next-line no-param-reassign
                a[key] = b[key]
            }
        })

    return a
}

export const forMatIndianDate = date => {

    if (!date) return null

    return moment(date)
        .format('DD/MM/YYYY')
}

export const formatSqlDate = date => {
    if (!date) {
        return moment(new Date())
            .format('YYYY-MM-DD')
    } else {
        return moment(date)
            .format('YYYY-MM-DD')
    }
}

export const forMatIndianDateAndTime = date => {

    if (!date) return null

    return moment(date)
        .format('DD/MM/YYYY hh:mm')
}

export const forMatMasterGstDate = date => {

    if (!date) return null

    return moment(date)
        .format('MM/DD/YYYY')
}

export const addExtraDays = (startDate, extraDays) => {
    return moment(startDate, 'DD/MM/YYYY')
        .add(extraDays, 'days')
        .format('DD/MM/YYYY')
}

export const getTcTodayDate = () => (new Date()).toISOString()
    .split('T')[0]

export const getTcTodayDateTime = () => moment(new Date, 'DD/MM/YYYY h:i:s')
    .format('DD/MM/YYYY hh:mm:ss')

const getNestedValue = (object, string) => {

    string = string.replace(/\[(\w+)\]/g, '.$1')
    string = string.replace(/^\./, '')
    const a = string.split('.')
    for (let i = 0, n = a.length; i < n; ++i) {
        let k = a[i]
        if (k in object) {
            object = object[k]
        } else {
            return
        }
    }
    return object
}

export const exportDataToExcel = (columns, rows, fileName, sheetName) => {

    const createXLSLFormatObj = []
    const newXlsHeader = []

    if (columns.length === 0) {
        console.log('Please Add columns!')
        return
    }
    if (rows.length === 0) {
        console.log('Add data!')
        return
    }

    columns.map(column => {
        newXlsHeader.push(column.label)
    })

    createXLSLFormatObj.push(newXlsHeader)

    rows.map(value => {
        const innerRowData = []
        columns.map(val => {

            let fieldValue = value[val.field]

            if (typeof val.field === 'function') {

                fieldValue = val.field(value)

            } else {

                if (val.field.split('.').length > 1) {
                    fieldValue = getNestedValue(value, val.field)
                }
            }

            if (val.formatFn && typeof val.formatFn === 'function') {
                innerRowData.push(val.formatFn(fieldValue))
            } else {
                innerRowData.push(fieldValue)
            }
        })
        createXLSLFormatObj.push(innerRowData)
    })

    const wb = XLSX.utils.book_new(),
        ws = XLSX.utils.aoa_to_sheet(createXLSLFormatObj)
    XLSX.utils.book_append_sheet(wb, ws, sheetName)
    XLSX.writeFile(wb, fileName)

}

export const exportTableDataToPdf = (columns, rows, fileName) => {

    const doc = new jsPDF()

    const newPdfHeader = []

    const newPdfDataRows = []

    if (columns.length === 0) {
        console.log('Please Add columns!')
        return
    }
    if (rows.length === 0) {
        console.log('Add data!')
        return
    }

    columns.map(column => {
        newPdfHeader.push(column.label)
    })

    rows.map(value => {
        const innerRowData = []
        columns.map(val => {
            let fieldValue = value[val.field]
            if (typeof val.field === 'function') {

                fieldValue = val.field(value)

            } else {

                if (val.field.split('.').length > 1) {
                    fieldValue = getNestedValue(value, val.field)
                }
            }
            if (val.formatFn && typeof val.formatFn === 'function') {
                innerRowData.push(val.formatFn(fieldValue))
            } else {
                innerRowData.push(fieldValue)
            }
        })
        newPdfDataRows.push(innerRowData)
    })

    autoTable(doc, {
        head: [newPdfHeader],
        body: newPdfDataRows,
    })

    doc.save(fileName)
}

export const getSalesTypeListOption = () => {
    return [
        {
            label: 'Product Order',
            value: 1
        },
        {
            label: 'Machine Order',
            value: 2
        },
        {
            label: 'Spare Order',
            value: 3
        },
        {
            label: 'Repairing & Service',
            value: 4
        },
    ]
}

export const changeAmountDecimalPoint = (amount, fixed) => {
    return parseFloat(parseFloat(amount)
        .toFixed(fixed))
}

export const changeToRound = (amount) => {
    return Math.round(amount)
}

export const uppercaseInput = {

    inserted: function (el, _, vnode) {
        el.addEventListener('input', async function (e) {
            e.target.value = e.target.value.toUpperCase()
            vnode.componentInstance.$emit('input', e.target.value.toUpperCase())
        })
    }

}

//Browser Local storage helpers
export const getStorageItem = (key) => {
    localStorage.getItem(key)
}

export const addStorageItem = (key, value) => {
    localStorage.setItem(key, value)
}

export const removeStorageItem = (key) => {
    localStorage.removeItem(key)
}

export const logoutUser = async () => {
    return await new Promise((resolve, reject) => {
        axios
            .get('/api/jwt/logout')
            .then(response => resolve(response))
            .catch(error => reject(error))
    })
}

export const clearLocalStorageData = async () => {
    localStorage.removeItem(useJwt.jwtConfig.storageTokenKeyName)
    localStorage.removeItem(useJwt.jwtConfig.storageRefreshTokenKeyName)

    // Remove userData from localStorage
    localStorage.removeItem('userData')

    // Reset ability
    new Ability(initialAbility)

    // Redirect to login page
    await router.push({ name: 'auth-login' })
}
