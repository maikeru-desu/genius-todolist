import { useQuery, useMutation, useQueryClient } from '@tanstack/vue-query';
import { todoService } from '../services/api';

export default function useTodos() {
  const queryClient = useQueryClient();
  
  // Query for todos list
  const { 
    data,
    isLoading: isLoadingTodos,
    error: todosError,
    refetch: refreshTodos
  } = useQuery({
    queryKey: ['todos'],
    queryFn: async () => {
      const response = await todoService.getAll();
      // Laravel API returns {data: [...], success: true, message: "..."}
      return response.data.data; // Extract the actual todos array
    },
    staleTime: 60000, // 1 minute
  });
  
  // Create todo mutation
  const createTodoMutation = useMutation({
    mutationFn: (newTodo) => todoService.create(newTodo),
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['todos'] });
    },
  });
  
  // Update todo mutation
  const updateTodoMutation = useMutation({
    mutationFn: ({ id, data }) => todoService.update(id, data),
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['todos'] });
    },
  });
  
  // Delete todo mutation
  const deleteTodoMutation = useMutation({
    mutationFn: (id) => todoService.delete(id),
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['todos'] });
    },
  });

  return {
    todos: data, // Now returning the properly extracted todos directly
    isLoadingTodos,
    todosError,
    refreshTodos,
    createTodo: createTodoMutation.mutateAsync,
    isCreatingTodo: createTodoMutation.isPending,
    updateTodo: updateTodoMutation.mutateAsync,
    isUpdatingTodo: updateTodoMutation.isPending,
    deleteTodo: deleteTodoMutation.mutateAsync,
    isDeletingTodo: deleteTodoMutation.isPending
  };
}
