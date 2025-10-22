export default defineNuxtRouteMiddleware((to, from) => {

    interface MyUser {
        role: string;
    }
    const user = useSanctumUser<MyUser>();

    // Wait until the user data is available
    if (user.value === null || user.value === undefined) {
        console.debug('Waiting for user to load...');
        return navigateTo('/');
    }
    
    if(user.value?.role !== 'admin') {
        console.warn('Access denied. Admins only.');
        return navigateTo('/dashboard');
    }
})