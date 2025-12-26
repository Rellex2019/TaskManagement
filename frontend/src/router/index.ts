import store from '@/store';
import LoginView from '@/views/LoginView.vue';
import StatsView from '@/views/StatsView.vue';
import TaskListView from '@/views/TaskListView.vue';
import { createRouter, createWebHistory, type RouteLocationNormalized, type NavigationGuardNext } from 'vue-router';

const isAuthenticated = (to: RouteLocationNormalized, from: RouteLocationNormalized , next:NavigationGuardNext ) => {
  const authenticated = store.getters['authStore/isAuthenticated'];
  if (authenticated) {
    next(); 
  } else {
    next({ name: 'login' }); 
  }
};

const isNotAuthenticated = (to: RouteLocationNormalized, from: RouteLocationNormalized , next:NavigationGuardNext ) => {
  const authenticated = store.getters['authStore/isAuthenticated'];
  const user = store.getters['authStore/user'];
  if (!authenticated) {
    next();
  } else {
    next({ name: `statistic` }); 
  }
};

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      name: 'login',
      component: LoginView,
      beforeEnter: isNotAuthenticated, 
    },
    {
      path: '/',
      name: 'statistic',
      component: StatsView,
      beforeEnter: isAuthenticated, 
    },
    {
      path: '/tasks/list',
      name: 'tasks',
      component: TaskListView,
      beforeEnter: isAuthenticated, 
    },
  ],
});

export default router;
