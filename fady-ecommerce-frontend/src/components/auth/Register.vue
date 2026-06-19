<template>
  <div class="max-w-md mx-auto p-4">
    <h2 class="text-xl font-semibold mb-4">Register</h2>
    <form @submit.prevent="submit">
      <div class="mb-2">
        <input v-model="form.name" placeholder="Name" class="w-full border p-2 rounded" />
      </div>
      <div class="mb-2">
        <input v-model="form.email" placeholder="Email" class="w-full border p-2 rounded" />
      </div>
      <div class="mb-2">
        <input v-model="form.password" type="password" placeholder="Password" class="w-full border p-2 rounded" />
      </div>
      <div class="mb-2">
        <input v-model="form.password_confirmation" type="password" placeholder="Confirm Password" class="w-full border p-2 rounded" />
      </div>
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Register</button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import api from '../api'
import { useRouter } from 'vue-router'

const router = useRouter()
const form = ref({ name: '', email: '', password: '', password_confirmation: '' })

async function submit() {
  try {
    const res = await api.post('/register', form.value)
    localStorage.setItem('token', res.data.token)
    api.defaults.headers.common['Authorization'] = `Bearer ${res.data.token}`
    router.push('/')
  } catch (e) {
    alert(e.response?.data?.message || 'Registration failed')
  }
}
</script>
