<script lang="ts">
import { computed, defineComponent } from 'vue';
import { useStore } from 'vuex';
import { authService } from './services/authService';
import { useRoute, useRouter } from 'vue-router';

export default defineComponent({
  setup() {
    const route = useRoute();
    const router = useRouter();
    const store = useStore();
    const isAuth = computed(() => store.getters['authStore/isAuthenticated']);

    router.push
    const logout = async () => {
      await authService.logout();
      router.push({ name: 'login' })
    };
    return {
      isAuth,
      logout,
      route,
      router

    };
  }
})

</script>

<template>
  <div class="head">
    <h1>TaskManagement</h1>

    <div class="button-container">
      <button v-if="route.name != 'tasks' && route.name != 'login'" @click="router.push({ name: 'tasks' })">
        Задачи</button>
      <button v-if="route.name != 'statistic' && route.name != 'login'"
        @click="router.push({ name: 'statistic' })">Статистика</button>
      <button v-if="isAuth" @click="logout">Выход</button>
    </div>

  </div>

  <p>
    <router-view></router-view>
  </p>
</template>

<style scoped>
.head {
  display: flex;
  gap: 20px;
}

.button-container {
  gap: 20px;
  display: flex;
}
</style>
