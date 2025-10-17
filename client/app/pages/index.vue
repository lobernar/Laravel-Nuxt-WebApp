<script setup lang="ts">
import { ref } from 'vue';

const regname = ref('');
const regemail = ref('');
const regpassword = ref('');
const loginname = ref('');
const loginpassword = ref('');

async function register() {
  const res = await $fetch('/submit', {
    method: 'POST',
    body: {
        name: regname.value,
        email: regemail.value,
        password: regpassword.value,
    },
  })
}

async function login() {
    console.log('Logging in as ', loginname.value);
  const res = await $fetch('/login', {
    method: 'POST',
    body: {
        name: regname.value,
        password: regpassword.value,
    },
  })
}
</script>

<template>
    <h1>Welcome to Laravel and Nuxt</h1>
    <div style="border: 1px solid black" id="register">
        <h2>Register</h2>
        <form @submit.prevent="register">
            <input type="text" id="name" v-model="regname" placeholder="name" required>
            <input type="text" id="email" v-model="regemail" placeholder="email" required>
            <input type="password" id="password" v-model="regpassword" placeholder="password" required>
            <button type="submit">Register</button>
        </form>
    </div>

    <div style="border: 1px solid black; margin-top: 5px" id="login">
        <h2>Log in</h2>
        <form @submit.prevent="login">
            <input type="text" id="name" v-model="loginname" placeholder="name" required>
            <input type="password" id="password" v-model="loginpassword" placeholder="password" required>
            <button type="submit">Log in</button>
        </form>
    </div>
</template>