<template>
  <div>
    <h2>Статистика</h2>
    <p>Всего задач: {{ stats.totalTasks }}</p>
    <p>Завершено задач: {{ stats.completedTasks }}</p>
    <p>В работе: {{ stats.workingTasks }}</p>
    <p>Новых задач: {{ stats.newTasks }}</p>
  </div>
</template>

<script lang="ts">
import { api } from '@/api/axios';
import { computed, defineComponent, onMounted, ref } from 'vue';
import type { Task } from '@/models/Task';
import type { Stats } from '@/models/Stats';

export default defineComponent({
  setup() {

    const tasks = ref<Task[]>([]);
    const stats = ref<Stats>({
      totalTasks: 0,
      completedTasks: 0,
      workingTasks: 0,
      newTasks: 0,
    });

    const fetchTasks = async () => {
      try {
        const response = await api.get('/tasks');
        tasks.value = response.data;
        calculateStats();
      } catch (error) {
        console.error('Ошибка при получении задач:', error);
      }
    };

    const calculateStats = () => {
      stats.value.totalTasks = tasks.value.length;
      stats.value.completedTasks = tasks.value.filter(task => task.status === 'completed').length;
      stats.value.workingTasks = tasks.value.filter(task => task.status === 'working').length;
      stats.value.newTasks = tasks.value.filter(task => task.status === 'new').length;
    };


    onMounted(fetchTasks);
    return {
      stats
    };
  },
});
</script>