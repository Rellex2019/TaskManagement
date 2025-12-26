import { api } from '@/api/axios';
import store from '@/store';

export interface LoginData {
  login: string;
  password: string;
}

export interface User {
  id: number;
  login: string;
}

export interface AuthResponse {
  message: string;
  user: User;
  token: string;
}

class AuthService {
  async login(credentials: LoginData): Promise<AuthResponse> {
    const response = await api.post<AuthResponse>('/login', credentials);
    const { token, user } = response.data;
    
    if (token) {
      localStorage.setItem('auth_token', token);
      store.commit('authStore/setUser', user);
    }
    
    return response.data;
  }

  async logout(): Promise<{message: string }> {
    try {
        await api.post('/logout');
        localStorage.removeItem('auth_token');
        store.commit('authStore/logout');
        return { 
          message: 'Выход выполнен' 
        };
      } catch (error) {
        console.warn(error);
        return { 
            message: 'Ошибка при выходе' 
          };
      }
  }

  async getUser(): Promise<User | null> {
    try {
      const user = store.getters['authStore/user'];
      if (user) {
        return user; 
      }
      const response = await api.get<User>('/user');
      return response.data;
    } catch (error) {
      console.warn(error); 
      return null; 
    }
  }

  getToken(): string | null {
    return localStorage.getItem('auth_token');
  }

  isAuthenticated(): boolean {
    return !!this.getToken();
  }
}

export const authService = new AuthService();
