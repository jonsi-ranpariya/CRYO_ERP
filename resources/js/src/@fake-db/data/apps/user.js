import mock from '@/@fake-db/mock'
import {paginateArray, sortCompare} from '@/@fake-db/utils'

/* eslint-disable global-require */
const data = {
    users: [
        {
            id: 1,
            fullName: 'Galen Slixby',
            sales: 'Yotz PVT LTD',
            role: 'editor',
            username: 'gslixby0',
            country: 'El Salvador',
            contact: '(479) 232-9151',
            email: 'gslixby0@abc.net.au',
            currentDepartment: 'account',
            status: 'inactive',
            avatar: '',
        },
        {
            id: 2,
            fullName: 'Halsey Redmore',
            sales: 'Skinder PVT LTD',
            role: 'author',
            username: 'hredmore1',
            country: 'Albania',
            contact: '(472) 607-9137',
            email: 'hredmore1@imgur.com',
            currentDepartment: 'marketing',
            status: 'pending',
            avatar: require('@/assets/images/avatars/10.png'),
        },
        {
            id: 3,
            fullName: 'Marjory Sicely',
            sales: 'Oozz PVT LTD',
            role: 'maintainer',
            username: 'msicely2',
            country: 'Russia',
            contact: '(321) 264-4599',
            email: 'msicely2@who.int',
            currentDepartment: 'account',
            status: 'active',
            avatar: require('@/assets/images/avatars/1.png'),
        },
        {
            id: 4,
            fullName: 'Cyrill Risby',
            sales: 'Oozz PVT LTD',
            role: 'maintainer',
            username: 'crisby3',
            country: 'China',
            contact: '(923) 690-6806',
            email: 'crisby3@wordpress.com',
            currentDepartment: 'marketing',
            status: 'inactive',
            avatar: require('@/assets/images/avatars/9.png'),
        },
        {
            id: 5,
            fullName: 'Maggy Hurran',
            sales: 'Aimbo PVT LTD',
            role: 'subscriber',
            username: 'mhurran4',
            country: 'Pakistan',
            contact: '(669) 914-1078',
            email: 'mhurran4@yahoo.co.jp',
            currentDepartment: 'account',
            status: 'pending',
            avatar: require('@/assets/images/avatars/10.png'),
        },
        {
            id: 6,
            fullName: 'Silvain Halstead',
            sales: 'Jaxbean PVT LTD',
            role: 'author',
            username: 'shalstead5',
            country: 'China',
            contact: '(958) 973-3093',
            email: 'shalstead5@shinystat.com',
            currentDepartment: 'sales',
            status: 'active',
            avatar: '',
        },
        {
            id: 7,
            fullName: 'Breena Gallemore',
            sales: 'Jazzy PVT LTD',
            role: 'subscriber',
            username: 'bgallemore6',
            country: 'Canada',
            contact: '(825) 977-8152',
            email: 'bgallemore6@boston.com',
            currentDepartment: 'sales',
            status: 'pending',
            avatar: '',
        },
        {
            id: 8,
            fullName: 'Kathryne Liger',
            sales: 'Pixoboo PVT LTD',
            role: 'author',
            username: 'kliger7',
            country: 'France',
            contact: '(187) 440-0934',
            email: 'kliger7@vinaora.com',
            currentDepartment: 'account',
            status: 'pending',
            avatar: require('@/assets/images/avatars/9.png'),
        },
        {
            id: 9,
            fullName: 'Franz Scotfurth',
            sales: 'Tekfly PVT LTD',
            role: 'subscriber',
            username: 'fscotfurth8',
            country: 'China',
            contact: '(978) 146-5443',
            email: 'fscotfurth8@dailymotion.com',
            currentDepartment: 'marketing',
            status: 'pending',
            avatar: require('@/assets/images/avatars/2.png'),
        },
        {
            id: 10,
            fullName: 'Jillene Bellany',
            sales: 'Gigashots PVT LTD',
            role: 'maintainer',
            username: 'jbellany9',
            country: 'Jamaica',
            contact: '(589) 284-6732',
            email: 'jbellany9@kickstarter.com',
            currentDepartment: 'sales',
            status: 'inactive',
            avatar: require('@/assets/images/avatars/9.png'),
        },
        {
            id: 11,
            fullName: 'Jonah Wharlton',
            sales: 'Eare PVT LTD',
            role: 'subscriber',
            username: 'jwharltona',
            country: 'United States',
            contact: '(176) 532-6824',
            email: 'jwharltona@oakley.com',
            currentDepartment: 'marketing',
            status: 'inactive',
            avatar: require('@/assets/images/avatars/4.png'),
        },
        {
            id: 12,
            fullName: 'Seth Hallam',
            sales: 'Yakitri PVT LTD',
            role: 'subscriber',
            username: 'shallamb',
            country: 'Peru',
            contact: '(234) 464-0600',
            email: 'shallamb@hugedomains.com',
            currentDepartment: 'marketing',
            status: 'pending',
            avatar: require('@/assets/images/avatars/5.png'),
        },
        {
            id: 13,
            fullName: 'Yoko Pottie',
            sales: 'Leenti PVT LTD',
            role: 'subscriber',
            username: 'ypottiec',
            country: 'Philippines',
            contact: '(907) 284-5083',
            email: 'ypottiec@privacy.gov.au',
            currentDepartment: 'administration',
            status: 'inactive',
            avatar: require('@/assets/images/avatars/7.png'),
        },
        {
            id: 14,
            fullName: 'Maximilianus Krause',
            sales: 'Digitube PVT LTD',
            role: 'author',
            username: 'mkraused',
            country: 'Democratic Republic of the Congo',
            contact: '(167) 135-7392',
            email: 'mkraused@stanford.edu',
            currentDepartment: 'marketing',
            status: 'active',
            avatar: require('@/assets/images/avatars/9.png'),
        },
        {
            id: 15,
            fullName: 'Zsazsa McCleverty',
            sales: 'Kaymbo PVT LTD',
            role: 'maintainer',
            username: 'zmcclevertye',
            country: 'France',
            contact: '(317) 409-6565',
            email: 'zmcclevertye@soundcloud.com',
            currentDepartment: 'account',
            status: 'active',
            avatar: require('@/assets/images/avatars/2.png'),
        },
        {
            id: 16,
            fullName: 'Bentlee Emblin',
            sales: 'Yambee PVT LTD',
            role: 'author',
            username: 'bemblinf',
            country: 'Spain',
            contact: '(590) 606-1056',
            email: 'bemblinf@wired.com',
            currentDepartment: 'sales',
            status: 'active',
            avatar: require('@/assets/images/avatars/6.png'),
        },
        {
            id: 17,
            fullName: 'Brockie Myles',
            sales: 'Wikivu PVT LTD',
            role: 'maintainer',
            username: 'bmylesg',
            country: 'Poland',
            contact: '(553) 225-9905',
            email: 'bmylesg@amazon.com',
            currentDepartment: 'administration',
            status: 'active',
            avatar: '',
        },
        {
            id: 18,
            fullName: 'Bertha Biner',
            sales: 'Twinte PVT LTD',
            role: 'editor',
            username: 'bbinerh',
            country: 'Yemen',
            contact: '(901) 916-9287',
            email: 'bbinerh@mozilla.com',
            currentDepartment: 'marketing',
            status: 'active',
            avatar: require('@/assets/images/avatars/7.png'),
        },
        {
            id: 19,
            fullName: 'Travus Bruntjen',
            sales: 'Cogidoo PVT LTD',
            role: 'admin',
            username: 'tbruntjeni',
            country: 'France',
            contact: '(524) 586-6057',
            email: 'tbruntjeni@sitemeter.com',
            currentDepartment: 'account',
            status: 'active',
            avatar: '',
        },
        {
            id: 20,
            fullName: 'Wesley Burland',
            sales: 'Bubblemix PVT LTD',
            role: 'editor',
            username: 'wburlandj',
            country: 'Honduras',
            contact: '(569) 683-1292',
            email: 'wburlandj@uiuc.edu',
            currentDepartment: 'marketing',
            status: 'inactive',
            avatar: require('@/assets/images/avatars/6.png'),
        },
        {
            id: 21,
            fullName: 'Selina Kyle',
            sales: 'Wayne accounts',
            role: 'admin',
            username: 'catwomen1940',
            country: 'USA',
            contact: '(829) 537-0057',
            email: 'irena.dubrovna@wayne.com',
            currentDepartment: 'marketing',
            status: 'active',
            avatar: require('@/assets/images/avatars/1.png'),
        },
        {
            id: 22,
            fullName: 'Jameson Lyster',
            sales: 'Quaxo PVT LTD',
            role: 'editor',
            username: 'jlysterl',
            country: 'Ukraine',
            contact: '(593) 624-0222',
            email: 'jlysterl@guardian.co.uk',
            currentDepartment: 'sales',
            status: 'inactive',
            avatar: require('@/assets/images/avatars/8.png'),
        },
        {
            id: 23,
            fullName: 'Kare Skitterel',
            sales: 'Ainyx PVT LTD',
            role: 'maintainer',
            username: 'kskitterelm',
            country: 'Poland',
            contact: '(254) 845-4107',
            email: 'kskitterelm@washingtonpost.com',
            currentDepartment: 'administration',
            status: 'pending',
            avatar: require('@/assets/images/avatars/3.png'),
        },
        {
            id: 24,
            fullName: 'Cleavland Hatherleigh',
            sales: 'Flipopia PVT LTD',
            role: 'admin',
            username: 'chatherleighn',
            country: 'Brazil',
            contact: '(700) 783-7498',
            email: 'chatherleighn@washington.edu',
            currentDepartment: 'marketing',
            status: 'pending',
            avatar: require('@/assets/images/avatars/2.png'),
        },
        {
            id: 25,
            fullName: 'Adeline Micco',
            sales: 'Topicware PVT LTD',
            role: 'admin',
            username: 'amiccoo',
            country: 'France',
            contact: '(227) 598-1841',
            email: 'amiccoo@whitehouse.gov',
            currentDepartment: 'account',
            status: 'pending',
            avatar: '',
        },
        {
            id: 26,
            fullName: 'Hugh Hasson',
            sales: 'Skinix PVT LTD',
            role: 'admin',
            username: 'hhassonp',
            country: 'China',
            contact: '(582) 516-1324',
            email: 'hhassonp@bizjournals.com',
            currentDepartment: 'administration',
            status: 'inactive',
            avatar: require('@/assets/images/avatars/4.png'),
        },
        {
            id: 27,
            fullName: 'Germain Jacombs',
            sales: 'Youopia PVT LTD',
            role: 'editor',
            username: 'gjacombsq',
            country: 'Zambia',
            contact: '(137) 467-5393',
            email: 'gjacombsq@jigsy.com',
            currentDepartment: 'account',
            status: 'active',
            avatar: require('@/assets/images/avatars/10.png'),
        },
        {
            id: 28,
            fullName: 'Bree Kilday',
            sales: 'Jetpulse PVT LTD',
            role: 'maintainer',
            username: 'bkildayr',
            country: 'Portugal',
            contact: '(412) 476-0854',
            email: 'bkildayr@mashable.com',
            currentDepartment: 'marketing',
            status: 'active',
            avatar: '',
        },
        {
            id: 29,
            fullName: 'Candice Pinyon',
            sales: 'Kare PVT LTD',
            role: 'maintainer',
            username: 'cpinyons',
            country: 'Sweden',
            contact: '(170) 683-1520',
            email: 'cpinyons@behance.net',
            currentDepartment: 'marketing',
            status: 'active',
            avatar: require('@/assets/images/avatars/7.png'),
        },
        {
            id: 30,
            fullName: 'Isabel Mallindine',
            sales: 'Voomm PVT LTD',
            role: 'subscriber',
            username: 'imallindinet',
            country: 'Slovenia',
            contact: '(332) 803-1983',
            email: 'imallindinet@shinystat.com',
            currentDepartment: 'marketing',
            status: 'pending',
            avatar: '',
        },
        {
            id: 31,
            fullName: 'Gwendolyn Meineken',
            sales: 'Oyondu PVT LTD',
            role: 'admin',
            username: 'gmeinekenu',
            country: 'Moldova',
            contact: '(551) 379-7460',
            email: 'gmeinekenu@hc360.com',
            currentDepartment: 'administration',
            status: 'pending',
            avatar: require('@/assets/images/avatars/1.png'),
        },
        {
            id: 32,
            fullName: 'Rafaellle Snowball',
            sales: 'Fivespan PVT LTD',
            role: 'editor',
            username: 'rsnowballv',
            country: 'Philippines',
            contact: '(974) 829-0911',
            email: 'rsnowballv@indiegogo.com',
            currentDepartment: 'administration',
            status: 'pending',
            avatar: require('@/assets/images/avatars/5.png'),
        },
        {
            id: 33,
            fullName: 'Rochette Emer',
            sales: 'Thoughtworks PVT LTD',
            role: 'admin',
            username: 'remerw',
            country: 'North Korea',
            contact: '(841) 889-3339',
            email: 'remerw@blogtalkradio.com',
            currentDepartment: 'administration',
            status: 'active',
            avatar: require('@/assets/images/avatars/8.png'),
        },
        {
            id: 34,
            fullName: 'Ophelie Fibbens',
            sales: 'Jaxbean PVT LTD',
            role: 'subscriber',
            username: 'ofibbensx',
            country: 'Indonesia',
            contact: '(764) 885-7351',
            email: 'ofibbensx@booking.com',
            currentDepartment: 'sales',
            status: 'active',
            avatar: require('@/assets/images/avatars/4.png'),
        },
        {
            id: 35,
            fullName: 'Stephen MacGilfoyle',
            sales: 'Browseblab PVT LTD',
            role: 'maintainer',
            username: 'smacgilfoyley',
            country: 'Japan',
            contact: '(350) 589-8520',
            email: 'smacgilfoyley@bigcartel.com',
            currentDepartment: 'sales',
            status: 'pending',
            avatar: '',
        },
        {
            id: 36,
            fullName: 'Bradan Rosebotham',
            sales: 'Agivu PVT LTD',
            role: 'subscriber',
            username: 'brosebothamz',
            country: 'Belarus',
            contact: '(882) 933-2180',
            email: 'brosebothamz@tripadvisor.com',
            currentDepartment: 'marketing',
            status: 'inactive',
            avatar: '',
        },
        {
            id: 37,
            fullName: 'Skip Hebblethwaite',
            sales: 'Katz PVT LTD',
            role: 'admin',
            username: 'shebblethwaite10',
            country: 'Canada',
            contact: '(610) 343-1024',
            email: 'shebblethwaite10@arizona.edu',
            currentDepartment: 'sales',
            status: 'inactive',
            avatar: require('@/assets/images/avatars/9.png'),
        },
        {
            id: 38,
            fullName: 'Moritz Piccard',
            sales: 'Twitternation PVT LTD',
            role: 'maintainer',
            username: 'mpiccard11',
            country: 'Croatia',
            contact: '(365) 277-2986',
            email: 'mpiccard11@vimeo.com',
            currentDepartment: 'account',
            status: 'inactive',
            avatar: require('@/assets/images/avatars/1.png'),
        },
        {
            id: 39,
            fullName: 'Tyne Widmore',
            sales: 'Yombu PVT LTD',
            role: 'subscriber',
            username: 'twidmore12',
            country: 'Finland',
            contact: '(531) 731-0928',
            email: 'twidmore12@bravesites.com',
            currentDepartment: 'marketing',
            status: 'pending',
            avatar: '',
        },
        {
            id: 40,
            fullName: 'Florenza Desporte',
            sales: 'Kamba PVT LTD',
            role: 'author',
            username: 'fdesporte13',
            country: 'Ukraine',
            contact: '(312) 104-2638',
            email: 'fdesporte13@omniture.com',
            currentDepartment: 'sales',
            status: 'active',
            avatar: require('@/assets/images/avatars/6.png'),
        },
        {
            id: 41,
            fullName: 'Edwina Baldetti',
            sales: 'Dazzlesphere PVT LTD',
            role: 'maintainer',
            username: 'ebaldetti14',
            country: 'Haiti',
            contact: '(315) 329-3578',
            email: 'ebaldetti14@theguardian.com',
            currentDepartment: 'marketing',
            status: 'pending',
            avatar: '',
        },
        {
            id: 42,
            fullName: 'Benedetto Rossiter',
            sales: 'Mybuzz PVT LTD',
            role: 'editor',
            username: 'brossiter15',
            country: 'Indonesia',
            contact: '(323) 175-6741',
            email: 'brossiter15@craigslist.org',
            currentDepartment: 'marketing',
            status: 'inactive',
            avatar: '',
        },
        {
            id: 43,
            fullName: 'Micaela McNirlan',
            sales: 'Tambee PVT LTD',
            role: 'admin',
            username: 'mmcnirlan16',
            country: 'Indonesia',
            contact: '(242) 952-0916',
            email: 'mmcnirlan16@hc360.com',
            currentDepartment: 'administration',
            status: 'inactive',
            avatar: '',
        },
        {
            id: 44,
            fullName: 'Vladamir Koschek',
            sales: 'Centimia PVT LTD',
            role: 'author',
            username: 'vkoschek17',
            country: 'Guatemala',
            contact: '(531) 758-8335',
            email: 'vkoschek17@abc.net.au',
            currentDepartment: 'marketing',
            status: 'active',
            avatar: '',
        },
        {
            id: 45,
            fullName: 'Corrie Perot',
            sales: 'Flipopia PVT LTD',
            role: 'subscriber',
            username: 'cperot18',
            country: 'China',
            contact: '(659) 385-6808',
            email: 'cperot18@goo.ne.jp',
            currentDepartment: 'marketing',
            status: 'pending',
            avatar: require('@/assets/images/avatars/3.png'),
        },
        {
            id: 46,
            fullName: 'Saunder Offner',
            sales: 'Skalith PVT LTD',
            role: 'maintainer',
            username: 'soffner19',
            country: 'Poland',
            contact: '(200) 586-2264',
            email: 'soffner19@mac.com',
            currentDepartment: 'account',
            status: 'pending',
            avatar: '',
        },
        {
            id: 47,
            fullName: 'Karena Courtliff',
            sales: 'Feedfire PVT LTD',
            role: 'admin',
            username: 'kcourtliff1a',
            country: 'China',
            contact: '(478) 199-0020',
            email: 'kcourtliff1a@bbc.co.uk',
            currentDepartment: 'administration',
            status: 'active',
            avatar: require('@/assets/images/avatars/1.png'),
        },
        {
            id: 48,
            fullName: 'Onfre Wind',
            sales: 'Thoughtmix PVT LTD',
            role: 'admin',
            username: 'owind1b',
            country: 'Ukraine',
            contact: '(344) 262-7270',
            email: 'owind1b@yandex.ru',
            currentDepartment: 'administration',
            status: 'pending',
            avatar: '',
        },
        {
            id: 49,
            fullName: 'Paulie Durber',
            sales: 'Babbleblab PVT LTD',
            role: 'subscriber',
            username: 'pdurber1c',
            country: 'Sweden',
            contact: '(694) 676-1275',
            email: 'pdurber1c@gov.uk',
            currentDepartment: 'marketing',
            status: 'inactive',
            avatar: '',
        },
        {
            id: 50,
            fullName: 'Beverlie Krabbe',
            sales: 'Kaymbo PVT LTD',
            role: 'editor',
            username: 'bkrabbe1d',
            country: 'China',
            contact: '(397) 294-5153',
            email: 'bkrabbe1d@home.pl',
            currentDepartment: 'sales',
            status: 'active',
            avatar: require('@/assets/images/avatars/9.png'),
        },
        {
            id: 51,
            fullName: 'Alpesh Prajapati',
            sales: 'Teacode Technology PVT LTD',
            role: 'admin',
            username: 'alpesh48602',
            country: 'India',
            contact: '(91) 9825548602',
            email: 'alpesh48602@gmail.com',
            currentDepartment: 'administration',
            status: 'active',
            avatar: '',
        },
        {
            id: 52,
            fullName: 'Hiren Buhecha',
            sales: 'Teacode Technology PVT LTD',
            role: 'admin',
            username: 'hiren9898',
            country: 'India',
            contact: '(91) 9898088759',
            email: 'hirenbuhecha@gmail.com',
            currentDepartment: 'administration',
            status: 'active',
            avatar: '',
        },
    ],
}
/* eslint-enable */

// ------------------------------------------------
// GET: Return Users
// ------------------------------------------------
mock.onGet('/apps/user/users').reply(config => {
    // eslint-disable-next-line object-curly-newline
    const {
        q = '',
        perPage = 10,
        page = 1,
        sortBy = 'id',
        sortDesc = false,
        role = null,
        plan = null,
        status = null,
    } = config.params
    /* eslint-enable */

    const queryLowered = q.toLowerCase()
    const filteredData = data.users.filter(
        user =>
            /* eslint-disable operator-linebreak, implicit-arrow-linebreak */
            (user.username.toLowerCase().includes(queryLowered) || user.fullName.toLowerCase().includes(queryLowered)) &&
            user.role === (role || user.role) &&
            user.currentDepartment === (plan || user.currentDepartment) &&
            user.status === (status || user.status),
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
mock.onPost('/apps/user/users').reply(config => {
    // Get event from post data
    const {user} = JSON.parse(config.data)

    // Assign Status
    user.status = 'active'

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
mock.onGet(/\/apps\/user\/users\/\d+/).reply(config => {
    // Get event id from URL
    let userId = config.url.substring(config.url.lastIndexOf('/') + 1)

    // Convert Id to number
    userId = Number(userId)

    const userIndex = data.users.findIndex(e => e.id === userId)
    const user = data.users[userIndex]

    if (user) return [200, user]
    return [404]
})