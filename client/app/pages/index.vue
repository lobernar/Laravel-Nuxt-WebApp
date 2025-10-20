<script setup lang="ts">
import { ref } from 'vue';

const { login, user } = useSanctumAuth();
const client = useSanctumClient();
const config = useRuntimeConfig();

const mode = ref<'login' | 'register'>('login')
definePageMeta({
    middleware: 'sanctum:guest'
})

const regname = ref('');
const regemail = ref('');
const regpassword = ref('');
const loginname = ref('');
const loginpassword = ref('');

async function handleRegister() {
    try {
        await client(`${config.public.apiBase}/api/register`, {
            method: 'POST',
            body: {
                name: regname.value,
                email: regemail.value,
                password: regpassword.value,
            },
        });

        await login({
            name: regname.value,
            password: regpassword.value,
        });  
    } catch (error) {
        console.error('Registration error:', error);
    }

}

async function handleLogin() {
    try {
        await login({
            name: loginname.value,
            password: loginpassword.value,
        });
    } catch (error) {
        console.error('Login error:', error);
    }
}
</script>

<template>
  <div class="min-h-screen bg-base-200 flex items-center justify-center">
    <div class="w-full max-w-md p-8 shadow-xl rounded-2xl bg-base-100">
      <h1 class="text-2xl font-bold text-center mb-6">Welcome to Laravel + Nuxt</h1>

      <div class="tabs tabs-boxed mb-6 flex justify-center">
        <a
          class="tab"
          :class="{ 'tab-active': mode === 'login' }"
          @click="mode = 'login'"
        >
          Login
        </a>
        <a
          class="tab"
          :class="{ 'tab-active': mode === 'register' }"
          @click="mode = 'register'"
        >
          Register
        </a>
      </div>

      <!-- Register Form -->
      <form v-if="mode === 'register'" @submit.prevent="handleRegister" class="space-y-4">
        <div class="form-control">
          <label class="label"><span class="label-text">Name</span></label>
          <input
            v-model="regname"
            type="text"
            placeholder="Username"
            class="input input-bordered w-full"
            required
          />
        </div>

        <div class="form-control">
          <label class="label"><span class="label-text">Email</span></label>
          <input
            v-model="regemail"
            type="email"
            placeholder="you@example.com"
            class="input input-bordered w-full"
            required
          />
        </div>

        <div class="form-control">
          <label class="label"><span class="label-text">Password</span></label>
          <input
            v-model="regpassword"
            type="password"
            placeholder="********"
            class="input input-bordered w-full"
            required
          />
        </div>

        <button class="btn btn-primary w-full mt-4">Register</button>
      </form>

      <!-- Login Form -->
      <form v-else @submit.prevent="handleLogin" class="space-y-4">
        <div class="form-control">
          <label class="label"><span class="label-text">Name</span></label>
          <input
            v-model="loginname"
            type="text"
            placeholder="Username"
            class="input input-bordered w-full"
            required
          />
        </div>

        <div class="form-control">
          <label class="label"><span class="label-text">Password</span></label>
          <input
            v-model="loginpassword"
            type="password"
            placeholder="********"
            class="input input-bordered w-full"
            required
          />
        </div>

        <button class="btn btn-primary w-full mt-4">Login</button>
      </form>
    </div>
  </div>
</template>