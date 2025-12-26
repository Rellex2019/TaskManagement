import Cookies from 'js-cookie';

export interface User {
  id: number;
  login: string;
}

interface AuthState {
  isAuthenticated: boolean;
  user: User | null;
}

export const authStore = {
  namespaced: true,
  
  state: (): AuthState => ({
    isAuthenticated: false,
    user: null,
  }),

  mutations: {
    setUser(state: AuthState, user: User): void {
      state.isAuthenticated = true;
      state.user = user;
      Cookies.set('user', JSON.stringify(user), { expires: 3 });
      Cookies.set('isAuthenticated', 'true', { expires: 3 });
    },

    logout(state: AuthState): void {
      state.isAuthenticated = false;
      state.user = null;
      Cookies.remove('user');
      Cookies.remove('isAuthenticated');
    },

    initializeStore(state: AuthState): void {
      const userCookie = Cookies.get('user');
      const isAuthenticatedCookie = Cookies.get('isAuthenticated');

      if (userCookie) {
        state.user = JSON.parse(userCookie);
        state.isAuthenticated = isAuthenticatedCookie === 'true';
      }
    },
  },

  getters: {
    isAuthenticated: (state: AuthState): boolean => state.isAuthenticated,
    user: (state: AuthState): User | null => state.user,
  },
};

export default authStore;
