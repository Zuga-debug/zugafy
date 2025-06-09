<template>
  <div class="container mt-5">
    <h2>Login</h2>
    <form @submit.prevent="login">
      <div class="mb-3">
        <label>Email</label>
        <input type="email" v-model="email" class="form-control" required />
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="password" v-model="password" class="form-control" required />
      </div>
      <button class="btn btn-primary">Login</button>
    </form>
    <div v-if="error" class="alert alert-danger mt-2">{{ error }}</div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from '../axios'; // Adjust path as needed
import { useRouter } from 'vue-router';

const email = ref('');
const password = ref('');
const error = ref('');
const router = useRouter();

const login = async () => {
  try {
    await axios.get('/sanctum/csrf-cookie');
    const res = await axios.post('/login', { email: email.value, password: password.value });
    localStorage.setItem('token', res.data.token);
    router.push('/');
  } catch (err) {
    error.value = err.response?.data?.message || 'Login failed';
  }
};
</script>
