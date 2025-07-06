<script setup>
import { ref, computed, watch } from 'vue';

const props = defineProps({
  isOpen: {
    type: Boolean,
    required: true
  },
  isSubmitting: {
    type: Boolean,
    default: false
  },
  todo: {
    type: Object,
    default: () => null
  },
  isEditMode: {
    type: Boolean,
    default: false
  }
});

const emit = defineEmits(['close', 'save']);

// Todo form data
const todoForm = ref({
  title: '',
  description: '',
  due_date: '',
  target_time: '',
  is_completed: false,
  priority: 0 // Default to LOW priority
});

// Form validation
const errors = ref({});
const isFormValid = computed(() => todoForm.value.title.trim() !== '');

// Loading state
const isLoading = ref(false);

// Priority options
const priorityOptions = [
  { value: 0, label: 'Low' },
  { value: 1, label: 'Medium' },
  { value: 2, label: 'High' }
];

// Set current date as min date for due date
const minDate = new Date().toISOString().split('T')[0];

// Reset form when modal is opened or load existing todo data if in edit mode
watch(() => props.isOpen, (newValue) => {
  if (newValue) {
    if (props.isEditMode && props.todo) {
      // Load existing todo data for editing
      todoForm.value = {
        title: props.todo.title || '',
        description: props.todo.description || '',
        due_date: props.todo.due_date || '',
        target_time: props.todo.target_time || '',
        is_completed: props.todo.is_completed || false,
        priority: typeof props.todo.priority === 'number' ? props.todo.priority : 0
      };
    } else {
      // Reset form for new todo
      resetForm();
    }
  }
});

const resetForm = () => {
  todoForm.value = {
    title: '',
    description: '',
    due_date: '',
    target_time: '',
    is_completed: false,
    priority: 0
  };
  errors.value = {};
};

const handleSubmit = () => {
  // Validate form
  errors.value = {};
  
  if (!todoForm.value.title.trim()) {
    errors.value.title = 'Title is required';
    return;
  }
  
  // Set local loading state only if parent isn't controlling it
  if (!props.isSubmitting) {
    isLoading.value = true;
    
    // Reset local loading after some time if parent doesn't close modal
    setTimeout(() => {
      isLoading.value = false;
    }, 2000);
  }
  
  // Emit save event with form data
  emit('save', { ...todoForm.value });
};

const closeModal = () => {
  emit('close');
};
</script>

<template>
  <div v-if="isOpen" class="fixed inset-0 flex items-center justify-center z-50">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black opacity-50" @click="closeModal"></div>
    
    <!-- Modal content -->
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 z-10">
      <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">{{ isEditMode ? 'Edit Task' : 'Add New Task' }}</h3>
      </div>
      
      <form @submit.prevent="handleSubmit" class="px-6 py-4">
        <!-- Title field -->
        <div class="mb-4">
          <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title*</label>
          <input
            id="title"
            v-model="todoForm.title"
            type="text"
            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2.5"
            :class="{'border-red-500': errors.title}"
            placeholder="Enter task title"
            required
          >
          <p v-if="errors.title" class="mt-1 text-sm text-red-600">{{ errors.title }}</p>
        </div>
        
        <!-- Description field -->
        <div class="mb-4">
          <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
          <textarea
            id="description"
            v-model="todoForm.description"
            rows="3"
            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2.5"
            placeholder="Enter task description"
          ></textarea>
        </div>
        
        <!-- Due date and time -->
        <div class="grid grid-cols-2 gap-4 mb-4">
          <div>
            <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">Due Date</label>
            <input
              id="due_date"
              v-model="todoForm.due_date"
              type="date"
              :min="minDate"
              class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            >
          </div>
          <div>
            <label for="target_time" class="block text-sm font-medium text-gray-700 mb-1">Target Time</label>
            <input
              id="target_time"
              v-model="todoForm.target_time"
              type="time"
              class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            >
          </div>
        </div>
        
        <!-- Priority selector -->
        <div class="mb-4">
          <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
          <select
            id="priority"
            v-model="todoForm.priority"
            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
          >
            <option v-for="option in priorityOptions" :key="option.value" :value="option.value">
              {{ option.label }}
            </option>
          </select>
        </div>
        
        <!-- Completed checkbox -->
        <div class="mb-4 flex items-center">
          <input
            id="is_completed"
            v-model="todoForm.is_completed"
            type="checkbox"
            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
          >
          <label for="is_completed" class="ml-2 block text-sm text-gray-900">Mark as completed</label>
        </div>
        
        <!-- Action buttons -->
        <div class="mt-6 flex justify-end space-x-3">
          <button
            type="button"
            @click="closeModal"
            class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
          >
            Cancel
          </button>
          <button
            type="submit"
            :disabled="!isFormValid || isLoading || props.isSubmitting"
            class="inline-flex justify-center items-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 min-w-[85px]"
            :class="{'opacity-75 cursor-not-allowed': !isFormValid || isLoading || props.isSubmitting}"
          >
            <template v-if="isLoading || props.isSubmitting">
              <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              {{ isEditMode ? 'Updating...' : 'Saving...' }}
            </template>
            <template v-else>{{ isEditMode ? 'Update' : 'Save' }}</template>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>
input[type="text"],
input[type="date"],
input[type="time"],
select,
textarea {
  padding: 0.75rem 1rem !important;
}
</style>
