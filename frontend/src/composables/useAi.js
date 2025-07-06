import { useQuery } from '@tanstack/vue-query';
import { todoService } from '../services/api';

export default function useAi() {
  // Query for AI insights
  const { 
    data,
    isLoading: isLoadingInsight,
    error: insightError,
    refetch: refreshInsight,
  } = useQuery({
    queryKey: ['aiInsight'],
    queryFn: async () => {
      const response = await todoService.getAiInsight();
      // Extract data from the Laravel response structure
      return response.data.data; 
    },
    staleTime: 300000, // 5 minutes
    retry: 2,
  });

  return {
    aiInsight: data, // Direct access to the insight text
    isLoadingInsight,
    insightError,
    refreshInsight
  };
}
