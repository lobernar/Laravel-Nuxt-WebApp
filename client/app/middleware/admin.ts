export default defineNuxtRouteMiddleware((to, from) => {

    interface MyUser {
        role: string;
    }
    const user = useSanctumUser<MyUser>();
    
    if(user.value?.role !== 'admin') {
        console.warn('Access denied. Admins only.');
        return navigateTo('/dashboard');
    }
})