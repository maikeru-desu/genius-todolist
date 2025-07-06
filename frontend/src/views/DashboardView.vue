<script setup>
import { ref, computed } from 'vue';
import { marked } from 'marked';
import useAi from '../composables/useAi';
import useTodos from '../composables/useTodos';

// Get todos data using Vue Query
const { 
  todos,
  isLoadingTodos,
  todosError,
  refreshTodos,
  updateTodo
} = useTodos();

// Get AI insights using Vue Query
const { aiInsight, isLoadingInsight, insightError, refreshInsight } = useAi();

// Formatting functions
const formatDate = (dateString) => {
  const options = { month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric' };
  return new Date(dateString).toLocaleDateString(undefined, options);
};

const getPriorityClass = (priority) => {
  // Handle priority as either string or number (from enum)
  if (typeof priority === 'number') {
    switch (priority) {
      case 2: // HIGH
        return 'bg-red-100 text-red-800';
      case 1: // MEDIUM
        return 'bg-yellow-100 text-yellow-800';
      case 0: // LOW
        return 'bg-green-100 text-green-800';
      default:
        return 'bg-gray-100 text-gray-800';
    }
  } else {
    // Legacy string support
    switch (priority) {
      case 'high':
        return 'bg-red-100 text-red-800';
      case 'medium':
        return 'bg-yellow-100 text-yellow-800';
      case 'low':
        return 'bg-green-100 text-green-800';
      default:
        return 'bg-gray-100 text-gray-800';
    }
  }
};

const formatPriority = (priority) => {
  // Handle priority as either string or number (from enum)
  if (typeof priority === 'number') {
    switch (priority) {
      case 2: return 'High';
      case 1: return 'Medium';
      case 0: return 'Low';
      default: return 'Unknown';
    }
  } else if (typeof priority === 'string') {
    // For string values, capitalize first letter
    return priority.charAt(0).toUpperCase() + priority.slice(1).toLowerCase();
  }
  return 'Unknown';
};

const formatTime = (timeString) => {
  if (!timeString) return '';
  // Handle different time formats
  try {
    const date = new Date(`1970-01-01T${timeString}`);
    return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
  } catch (e) {
    return timeString;
  }
};
</script>

<style scoped>
.markdown-content :deep(strong) {
  font-weight: 600;
}

.markdown-content :deep(ul) {
  list-style-type: disc;
  padding-left: 1.5rem;
  margin: 0.5rem 0;
}

.markdown-content :deep(li) {
  margin-bottom: 0.25rem;
}
</style>

<template>
  <div class="min-h-screen bg-gray-50">

    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
      <!-- Loading state -->
      <div v-if="isUserLoading" class="flex justify-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-indigo-600"></div>
      </div>

      <div v-else>
        <div class="sm:flex sm:items-center sm:justify-between mb-8">
          <h2 class="text-2xl font-bold text-gray-900">My Tasks</h2>
          <button
            class="mt-4 sm:mt-0 inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
          >
            <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
            </svg>
            Add New Task
          </button>
        </div>

        <!-- AI Insight Box -->
        <div class="mb-8 bg-indigo-50 p-4 rounded-lg border border-indigo-100 flex items-start">
          <div class="text-2xl mr-3">🧠</div>
          <div class="w-full">
            <div class="flex justify-between items-center">
              <h4 class="font-medium text-indigo-800">AI Insights</h4>
              <button 
                v-if="!isLoadingInsight" 
                @click="refreshInsight()" 
                class="text-xs text-indigo-600 hover:text-indigo-800"
                title="Refresh insights"
              >
                ↻ Refresh
              </button>
            </div>
            
            <!-- Loading state -->
            <div v-if="isLoadingInsight" class="flex items-center space-x-2 py-2">
              <div class="animate-spin h-4 w-4 border-t-2 border-b-2 border-indigo-600 rounded-full"></div>
              <p class="text-indigo-700 text-sm">Generating insights...</p>
            </div>
            
            <!-- Error state -->
            <p v-else-if="insightError" class="text-red-600 text-sm">{{ insightError }}</p>
            
            <!-- Success state -->
            <div v-else-if="aiInsight" class="text-indigo-700 text-sm markdown-content" v-html="marked(aiInsight)"></div>
            
            <!-- Empty state -->
            <p v-else class="text-indigo-700 text-sm">No insights available.</p>
          </div>
        </div>

        <!-- Todo List Header with Refresh Button -->
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-medium text-gray-900">Your Tasks</h3>
          <button 
            v-if="!isLoadingTodos" 
            @click="refreshTodos()" 
            class="text-xs text-indigo-600 hover:text-indigo-800"
            title="Refresh todos"
          >
            ↻ Refresh
          </button>
        </div>
        
        <!-- Todo List -->
        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
          <!-- Loading state -->
          <div v-if="isLoadingTodos" class="flex justify-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-indigo-600"></div>
          </div>
          
          <!-- Error state -->
          <div v-else-if="todosError" class="p-4 text-center">
            <p class="text-red-600">Failed to load tasks. Please try again.</p>
            <button @click="refreshTodos()" class="mt-2 text-indigo-600 hover:text-indigo-800">Retry</button>
          </div>
          
          <!-- Empty state -->
          <div v-else-if="todos.length === 0" class="p-8 text-center">
            <p class="text-gray-500">No tasks found. Add your first task to get started!</p>
          </div>
          
          <!-- Tasks list -->
          <ul v-else role="list" class="divide-y divide-gray-200">
            <li v-for="todo in todos" :key="todo.id" class="px-4 py-4 sm:px-6 hover:bg-gray-50">
              <div class="flex items-start gap-4">
                <input
                  type="checkbox"
                  :checked="todo.is_completed"
                  @change="updateTodo({ id: todo.id, data: { is_completed: !todo.is_completed } })"
                  class="h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 mt-1"
                />
                <div class="min-w-0 flex-1">
                  <p :class="['text-sm font-medium', todo.is_completed ? 'text-gray-400 line-through' : 'text-gray-900']">{{ todo.title }}</p>
                  <div class="mt-1 flex items-center gap-2 text-xs">
                    <span :class="['inline-flex rounded-full px-2 py-1 font-medium', getPriorityClass(todo.priority)]">
                      {{ formatPriority(todo.priority) }}
                    </span>
                    <span class="text-gray-500">Due {{ formatDate(todo.due_date) }}</span>
                    <span v-if="todo.target_time" class="text-gray-500">at {{ formatTime(todo.target_time) }}</span>
                  </div>
                </div>
                <div class="flex gap-2">
                  <button class="rounded p-1 text-gray-500 hover:bg-gray-100 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                  </button>
                  <button class="rounded p-1 text-gray-500 hover:bg-gray-100 hover:text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                  </button>
                </div>
              </div>
            </li>
          </ul>
        </div>
        
        <!-- Pagination would go here if needed -->
        
      </div>
    </main>
  </div>
</template>
