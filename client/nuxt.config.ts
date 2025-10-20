import tailwindcss from "@tailwindcss/vite";

// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2025-07-15',
  devtools: { enabled: true },

  runtimeConfig: {
    public: {
      apiBase: 'http://localhost:8000', // Laravel API
    },
  },

  vite: {
    plugins: [tailwindcss()],
  },
  css: ["./app/tailwind.css"],

  modules: ["nuxt-auth-sanctum"],
  sanctum: {
    baseUrl: 'http://localhost:8000', // Laravel API
    endpoints: {
      login: '/api/login',
      logout: '/api/logout',
    },
    redirect: {
      onLogin: '/dashboard',
      onLogout: '/',
    }
  },
})