import { defineStore } from 'pinia'
import api from '../api'

export const useAuthStore = defineStore('auth', {
  state: () => ({ user: null, token: localStorage.getItem('token') || null }),
  actions: {
    setUser(user) { this.user = user },
    setToken(token) { this.token = token; localStorage.setItem('token', token); api.defaults.headers.common['Authorization'] = `Bearer ${token}` },
    logout() { this.user = null; this.token = null; localStorage.removeItem('token'); delete api.defaults.headers.common['Authorization'] }
  }
})
