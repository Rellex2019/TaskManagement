<template>
  <div>
    <input v-model="title" placeholder="Название задачи" />
    <button @click="createTask">Добавить задачу</button>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import { api } from '@/api/axios';
import type { Task } from '@/models/Task';

export default defineComponent({
  setup(props, { emit }) {
    const title = ref<string>('');
    const createTask = async () => {
      try {
        await api.post('/task/create', { title: title.value }); 
        emit('task-created'); 
        title.value = ''; 
      } catch (error) {
        console.error('Ошибка при создании задачи:', error);
      }
    };

    return {
      title,
      createTask
    };
  }
});
</script>