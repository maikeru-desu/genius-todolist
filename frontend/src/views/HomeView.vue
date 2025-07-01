<script setup>
// The HomeView component will simply use our existing App.vue content as the landing page
import { ref } from 'vue';

const features = [
  { 
    title: 'AI Task Prioritization', 
    description: 'Let our AI help you prioritize your tasks efficiently', 
    icon: '🧠' 
  },
  { 
    title: 'Clean Interface', 
    description: 'Simple, intuitive design for the best productivity experience', 
    icon: '✨' 
  },
  { 
    title: 'Cross-Platform', 
    description: 'Access your tasks from anywhere, on any device', 
    icon: '📱' 
  },
  { 
    title: 'Smart Reminders', 
    description: 'Get intelligent notifications for upcoming and overdue tasks', 
    icon: '🔔' 
  },
];
</script>

<template>
  <div>
    <!-- Hero Section -->
    <section class="bg-gradient-to-b from-indigo-50 to-white py-20 flex-grow">
      <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center gap-12">
          <!-- Hero Content -->
          <div class="md:w-1/2 space-y-6">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
              Organize Your Tasks with <span class="text-indigo-600">AI-Powered</span> Intelligence
            </h1>
            <p class="text-xl text-gray-600">
              Genius TodoList helps you manage your tasks efficiently with AI that prioritizes what matters most.
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
              <router-link to="/login" class="bg-indigo-600 text-white px-8 py-4 rounded-lg font-medium text-lg hover:bg-indigo-700 transition-colors text-center">
                Get Started — It's Free
              </router-link>
              <a href="#features" class="bg-white border border-gray-300 text-gray-700 px-8 py-4 rounded-lg font-medium text-lg hover:bg-gray-50 transition-colors flex items-center justify-center gap-2">
                <span>How It Works</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
              </a>
            </div>
          </div>

          <!-- Hero Image/Illustration -->
          <div class="md:w-1/2 relative">
            <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
              <div class="flex items-center justify-between mb-6">
                <div>
                  <h3 class="font-semibold text-lg">My Tasks</h3>
                  <p class="text-gray-500 text-sm">Monday, June 30</p>
                </div>
                <div class="bg-indigo-600 text-white h-8 w-8 rounded-full flex items-center justify-center">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                  </svg>
                </div>
              </div>

              <!-- Task items -->
              <div class="space-y-3">
                <div class="bg-indigo-50 p-4 rounded-lg border-l-4 border-indigo-600">
                  <div class="flex items-start">
                    <div class="bg-indigo-600 text-white rounded-full h-5 w-5 flex items-center justify-center mr-3 mt-0.5">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                      </svg>
                    </div>
                    <div>
                      <h4 class="font-medium">Finish project presentation</h4>
                      <div class="flex items-center text-sm text-gray-500 mt-1">
                        <span class="bg-red-100 text-red-800 rounded-full px-2 py-0.5 text-xs font-medium">High Priority</span>
                        <span class="mx-2">·</span>
                        <span>Today, 5:00 PM</span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="p-4 rounded-lg border border-gray-200">
                  <div class="flex items-start">
                    <div class="border-2 border-gray-300 rounded-full h-5 w-5 flex items-center justify-center mr-3 mt-0.5"></div>
                    <div>
                      <h4 class="font-medium">Review marketing strategy</h4>
                      <div class="flex items-center text-sm text-gray-500 mt-1">
                        <span class="bg-yellow-100 text-yellow-800 rounded-full px-2 py-0.5 text-xs font-medium">Medium Priority</span>
                        <span class="mx-2">·</span>
                        <span>Tomorrow, 10:00 AM</span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="p-4 rounded-lg border border-gray-200">
                  <div class="flex items-start">
                    <div class="border-2 border-gray-300 rounded-full h-5 w-5 flex items-center justify-center mr-3 mt-0.5"></div>
                    <div>
                      <h4 class="font-medium">Send weekly newsletter</h4>
                      <div class="flex items-center text-sm text-gray-500 mt-1">
                        <span class="bg-green-100 text-green-800 rounded-full px-2 py-0.5 text-xs font-medium">Low Priority</span>
                        <span class="mx-2">·</span>
                        <span>July 2, 9:00 AM</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- AI suggestion -->
              <div class="mt-6 bg-indigo-50 p-4 rounded-lg border border-indigo-100 flex items-start">
                <div class="text-2xl mr-3">🧠</div>
                <div>
                  <h4 class="font-medium text-indigo-800">AI Suggestion</h4>
                  <p class="text-indigo-700 text-sm">I've prioritized the presentation as high since it's due today and seems critical for your project timeline.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
      <div class="container mx-auto px-4">
        <div class="text-center mb-16">
          <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Powerful Features</h2>
          <p class="text-xl text-gray-600 max-w-2xl mx-auto">
            Genius TodoList comes packed with tools to make task management both simple and powerful.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          <div v-for="(feature, index) in features" :key="index" class="bg-gray-50 rounded-xl p-6 border border-gray-100 hover:shadow-md transition duration-300 ease-in-out transform hover:-translate-y-1">
            <div class="text-4xl mb-4">{{ feature.icon }}</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ feature.title }}</h3>
            <p class="text-gray-600">{{ feature.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
      <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to boost your productivity?</h2>
        <p class="text-xl mb-8 max-w-2xl mx-auto">Join thousands of users who have transformed their task management with Genius TodoList.</p>
        <router-link to="/login" class="bg-white text-indigo-600 px-8 py-4 rounded-lg font-medium text-lg hover:bg-gray-50 transition-colors inline-block">
          Get Started For Free
        </router-link>
      </div>
    </section>


  </div>
</template>
