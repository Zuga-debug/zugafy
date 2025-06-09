<template>
  <div class="container mt-5">
    <h2>Register</h2>
    <form @submit.prevent="register">
      <div class="mb-3">
        <label>Name</label>
        <input type="text" v-model="name" class="form-control" required />
      </div>
      <div class="mb-3">
        <label>Email</label>
        <input type="email" v-model="email" class="form-control" required />
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="password" v-model="password" class="form-control" required />
      </div>
      <div class="mb-3">
        <label>Confirm Password</label>
        <input type="password" v-model="password_confirmation" class="form-control" required />
      </div>
      <button class="btn btn-success">Register</button>
    </form>
    <div v-if="error" class="alert alert-danger mt-2">{{ error }}</div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from '../axios';
import { useRouter } from 'vue-router';

const name = ref('');
const email = ref('');
const password = ref('');
const password_confirmation = ref('');
const error = ref('');
const router = useRouter();

const register = async () => {
  try {
    await axios.get('/sanctum/csrf-cookie');
    await axios.post('/register', {
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value
    });
    router.push('/login');
  } catch (err) {
    error.value = err.response?.data?.message || 'Registration failed';
  }
};
</script>
