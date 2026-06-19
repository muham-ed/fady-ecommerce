// add auth routes
import Home from '../components/Home.vue'
import ProductList from '../components/ProductList.vue'
import ProductDetail from '../components/ProductDetail.vue'
import Cart from '../components/Cart.vue'
import AdminDashboard from '../components/AdminDashboard.vue'
import Login from '../components/auth/Login.vue'
import Register from '../components/auth/Register.vue'

const routes = [
  { path: '/', name: 'Home', component: Home },
  { path: '/category/:slug', name: 'Category', component: ProductList },
  { path: '/product/:id', name: 'Product', component: ProductDetail },
  { path: '/cart', name: 'Cart', component: Cart },
  { path: '/admin', name: 'Admin', component: AdminDashboard },
  { path: '/login', name: 'Login', component: Login },
  { path: '/register', name: 'Register', component: Register },
]
