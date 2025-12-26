import { createStore } from 'vuex';
import authStore from './authStore'; 


export interface RootState {
  authStore: ReturnType<typeof authStore.state>;

}

export default createStore<RootState>({
  modules: {
    authStore,
  },
});
