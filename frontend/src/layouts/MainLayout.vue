<script setup>
// Main layout with header and footer
</script>

<template>
  <div class="min-h-screen flex flex-col">
    <!-- Header/Navigation -->
    <header class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
      <div class="container mx-auto px-4 py-6 flex items-center justify-between">
        <div class="flex items-center gap-2">
          <div class="text-3xl font-bold">✅</div>
          <router-link to="/" class="text-2xl font-bold text-white hover:text-white">Genius TodoList</router-link>
        </div>
        <nav class="hidden md:flex gap-8 items-center">
          <a href="#features" class="text-white hover:text-indigo-100 transition-colors">Features</a>
          <a href="#" class="text-white hover:text-indigo-100 transition-colors">Pricing</a>
          <a href="#" class="text-white hover:text-indigo-100 transition-colors">About</a>
          <router-link to="/login" class="bg-white text-indigo-600 py-2 px-4 rounded-lg font-medium hover:bg-indigo-50 transition-colors">
            Login
          </router-link>
        </nav>
      </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
      <router-view />
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
      <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between">
          <div class="mb-8 md:mb-0">
            <div class="flex items-center gap-2 mb-4">
              <div class="text-3xl font-bold">✅</div>
              <h2 class="text-2xl font-bold">Genius TodoList</h2>
            </div>
            <p class="text-gray-400 max-w-md">
              Organize your tasks, prioritize with AI assistance, and boost your productivity.
            </p>
          </div>

          <div class="grid grid-cols-2 md:grid-cols-3 gap-8">
            <div>
              <h3 class="text-lg font-semibold mb-4">Product</h3>
              <ul class="space-y-2 text-gray-400">
                <li><a href="#features" class="hover:text-white transition-colors">Features</a></li>
                <li><a href="#" class="hover:text-white transition-colors">Pricing</a></li>
                <li><a href="#" class="hover:text-white transition-colors">Testimonials</a></li>
                <li><a href="#" class="hover:text-white transition-colors">FAQ</a></li>
              </ul>
            </div>

            <div>
              <h3 class="text-lg font-semibold mb-4">Company</h3>
              <ul class="space-y-2 text-gray-400">
                <li><a href="#" class="hover:text-white transition-colors">About</a></li>
                <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
                <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
              </ul>
            </div>

            <div>
              <h3 class="text-lg font-semibold mb-4">Legal</h3>
              <ul class="space-y-2 text-gray-400">
                <li><a href="#" class="hover:text-white transition-colors">Privacy</a></li>
                <li><a href="#" class="hover:text-white transition-colors">Terms</a></li>
                <li><a href="#" class="hover:text-white transition-colors">Security</a></li>
              </ul>
            </div>
          </div>
        </div>

        <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
          <p class="text-gray-500">© 2025 Genius TodoList. All rights reserved.</p>
          <div class="flex space-x-6 mt-4 md:mt-0">
            <a href="#" class="text-gray-400 hover:text-white transition-colors">
              <span class="sr-only">Twitter</span>
              <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
              </svg>
            </a>
            <a href="#" class="text-gray-400 hover:text-white transition-colors">
              <span class="sr-only">GitHub</span>
              <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
              </svg>
            </a>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>
