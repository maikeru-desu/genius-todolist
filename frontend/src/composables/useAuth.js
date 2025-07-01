import { useMutation, useQuery, useQueryClient } from '@tanstack/vue-query';
import { ref, computed } from 'vue';
import { useRouter } from 'vue-router';
import { authService } from '../services/api';

export default function useAuth() {
  const router = useRouter();
  const queryClient = useQueryClient();
  const authError = ref('');
  const isLoading = ref(false);
  
  // Check if user is authenticated based on localStorage
  const isAuthenticated = computed(() => {
    return !!localStorage.getItem('isAuthenticated');
  });
  
  // Query for current user data
  const { data: user, isLoading: isUserLoading } = useQuery({
    queryKey: ['user'],
    queryFn: () => authService.getUser().then(res => res.data),
    enabled: computed(() => isAuthenticated.value),
    staleTime: 300000, // 5 minutes
    retry: (failureCount, error) => {
      // Don't retry if error is 401 Unauthorized
      if (error.response?.status === 401) {
        localStorage.removeItem('isAuthenticated');
        return false;
      }
      return failureCount < 3;
    },
  });
  
  // Login mutation
  const loginMutation = useMutation({
    mutationFn: (credentials) => {
      authError.value = '';
      isLoading.value = true;
      return authService.login(credentials);
    },
    onSuccess: () => {
      localStorage.setItem('isAuthenticated', 'true');
      queryClient.invalidateQueries({ queryKey: ['user'] });
      isLoading.value = false;
      router.push({ name: 'dashboard' });
    },
    onError: (error) => {
      authError.value = error.response?.data?.message || 'Login failed. Please try again.';
      isLoading.value = false;
    },
  });
  
  // Logout mutation
  const logoutMutation = useMutation({
    mutationFn: () => {
      return authService.logout();
    },
    onSuccess: () => {
      localStorage.removeItem('isAuthenticated');
      queryClient.clear();
      router.push({ name: 'login' });
    },
  });
  
  // Login function
  const login = (credentials) => {
    loginMutation.mutate(credentials);
  };
  
  // Logout function
  const logout = () => {
    logoutMutation.mutate();
  };
  
  return {
    user,
    isUserLoading,
    isAuthenticated,
    login,
    logout,
    authError,
    isLoading,
  };
}
