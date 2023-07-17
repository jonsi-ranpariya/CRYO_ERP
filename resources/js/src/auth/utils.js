import useJwt from '@/auth/jwt/useJwt'

/**
 * Return if user is logged in
 * This is completely up to you and how you want to store the token in your frontend application
 * e.g. If you are using cookies to store the application please update this function
 */
// eslint-disable-next-line arrow-body-style
export const isUserLoggedIn = () => {
    return localStorage.getItem('userData') && localStorage.getItem(useJwt.jwtConfig.storageTokenKeyName)
}

export const getUserData = () => JSON.parse(localStorage.getItem('userData'))

export const getCsrfToken = () => document.querySelector('meta[name="csrf-token"]')
    .getAttribute('content')

/**
 * This function is used for route navigation
 * NOTE: If you have different pages to navigate based on user ability then this function can be useful. However, you need to update it.
 * @param {String} userRole Role of user
 */
export const getHomeRouteForLoggedInUser = userRole => {
    if (userRole === 'SUPER-ADMIN') return '/'
    if (userRole === 'ADMIN') return '/'
    if (userRole === 'USER') return '/'
    if (userRole === 'client') return { name: 'access-control' }
    return { name: 'auth-login' }
}
