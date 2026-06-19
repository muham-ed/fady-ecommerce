import { BrowserRouter, Routes, Route } from 'react-router-dom';
import HomePage from '../pages/HomePage';
import LoginPage from '../pages/LoginPage';
import RegisterPage from '../pages/RegisterPage';
import ProductDetails from '../pages/ProductDetails';
import CartPage from '../pages/CartPage';
import AdminDashboard from '../pages/admin/AdminDashboard';
import PrivateRoute from './PrivateRoute';
import AdminRoute from './AdminRoute';

export default function AppRouter() {
    return (
        <BrowserRouter>
            <Routes>
                {/* المسارات العامة */}
                <Route path="/" element={<HomePage />} />
                <Route path="/login" element={<LoginPage />} />
                <Route path="/register" element={<RegisterPage />} />
                <Route path="/product/:slug" element={<ProductDetails />} />
                <Route path="/cart" element={<CartPage />} />

                {/* المسارات المحمية */}
                <Route path="/profile" element={
                    <PrivateRoute>
                        <ProfilePage />
                    </PrivateRoute>
                } />

                {/* مسارات الأدمن */}
                <Route path="/admin/*" element={
                    <AdminRoute>
                        <AdminDashboard />
                    </AdminRoute>
                } />
            </Routes>
        </BrowserRouter>
    );
}
