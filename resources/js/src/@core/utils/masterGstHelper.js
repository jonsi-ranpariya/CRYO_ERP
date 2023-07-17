import axios from 'axios'

export const file_get_content = async (url, callback) => {
    let res = await fetch(url),
        ret = await res.text();

    return callback ? callback(ret) : ret;
}

export const MASTER_API_BASE_URL = 'https://api.mastergst.com';
export const MASTER_GST_EMAIL = 'erp@cryogas-equipment.com';
export const MASTER_GST_USERNAME = 'mastergst';//API_24AAACI4408B1ZA
export const MASTER_GST_PASSWORD = 'Malli#123';//Iwicryo@338
export const MASTER_GST_IP_ADDRESS = file_get_content('https://api.ipify.org');
export const MASTER_GST_CLIENT_ID = '6ca99794-5050-4024-801c-eaa5987b3df2';//804239ae-ae03-435e-bc78-8061feea1ca1
export const MASTER_GST_CLIENT_SECRET = '267fe68e-856e-4432-8dd9-14ecb48c97ed';//eef3d116-d50b-499c-ad2a-95d52e3a2160
export const MASTER_GST_GSTIN = '29AABCT1332L000';

export const masterGstAuthenticate = async () => {
    let siteUrl = MASTER_API_BASE_URL + '/einvoice/authenticate?email='+MASTER_GST_EMAIL;

    let headerParam = {
        username: MASTER_GST_USERNAME,
        password: MASTER_GST_PASSWORD,
        ip_address: MASTER_GST_IP_ADDRESS,
        client_id: MASTER_GST_CLIENT_ID,
        client_secret: MASTER_GST_CLIENT_SECRET,
        gstin: MASTER_GST_GSTIN
    }

    return await axios.get(siteUrl, {
        headers: headerParam
    })
}

export const masterGstGetGstDetails = async (authToken, gstNumber) => {
    let siteUrl = MASTER_API_BASE_URL + '/einvoice/type/GSTNDETAILS/version/V1_03?email='+MASTER_GST_EMAIL+'&param1='+gstNumber;

    let headerParam = {
        ip_address: MASTER_GST_IP_ADDRESS,
        client_id: MASTER_GST_CLIENT_ID,
        client_secret: MASTER_GST_CLIENT_SECRET,
        username: MASTER_GST_USERNAME,
        'auth-token': authToken,
        gstin: MASTER_GST_GSTIN,
    }

    return await axios.get(siteUrl, {
        headers: headerParam
    });
}

export const masterGstGenerateIRN = async (authToken, gstNumber,data) => {
    let siteUrl = MASTER_API_BASE_URL + '/einvoice/type/GENERATE/version/V1_03?email='+MASTER_GST_EMAIL;

    let headerParam = {
        ip_address: MASTER_GST_IP_ADDRESS,
        client_id: MASTER_GST_CLIENT_ID,
        client_secret: MASTER_GST_CLIENT_SECRET,
        username: MASTER_GST_USERNAME,
        'auth-token': authToken,
        gstin: gstNumber ?? MASTER_GST_GSTIN,
    }

    return await axios.post(siteUrl, data, {
        headers: headerParam,
    });
}

export const masterGstGenerateEWayBill = async (authToken, gstNumber, data) => {
    let siteUrl = MASTER_API_BASE_URL+ '​/einvoice/type/GENERATE_EWAYBILL/version/V1_03?email='+MASTER_GST_EMAIL

    let headerParam = {
        ip_address: MASTER_GST_IP_ADDRESS,
        client_id: MASTER_GST_CLIENT_ID,
        client_secret: MASTER_GST_CLIENT_SECRET,
        username: MASTER_GST_USERNAME,
        'auth-token': authToken,
        gstin: gstNumber ?? MASTER_GST_GSTIN,
    }

    return await axios.post(siteUrl, data, {
        headers: headerParam
    });
}
