import tailwindcss from "@tailwindcss/vite";

// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2025-07-15',
  devtools: { enabled: true },

  runtimeConfig: {
    public: {
      apiBase: 'http://localhost', // Laravel API
    },
  },

  vite: {
    plugins: [tailwindcss()],
  },
  css: ["./app/tailwind.css"],

  modules: ["nuxt-auth-sanctum", "nuxt-permissions"],
  sanctum: {
    baseUrl: 'http://localhost', // Laravel API
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