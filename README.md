# Genius TodoList

![License](https://img.shields.io/badge/license-MIT-blue.svg) ![Version](https://img.shields.io/badge/version-1.0.0-green.svg)

> AI-powered todo list application that helps prioritize tasks intelligently

<p align="center">
  <img src="https://via.placeholder.com/800x400?text=Genius+TodoList+Screenshot" alt="Genius TodoList Screenshot" />
</p>

## 📝 Overview

Genius TodoList is a modern, AI-enhanced task management application that helps users organize and prioritize their tasks efficiently. The application leverages AI to analyze task importance and deadlines, providing intelligent suggestions for task prioritization.

### 🎯 Key Features

- **AI Task Prioritization**: Intelligent algorithms help prioritize tasks based on importance, deadlines, and patterns
- **Clean Interface**: Minimalist design with focus on usability and accessibility
- **Cross-Platform**: Access your tasks from any device with a responsive web interface
- **Smart Reminders**: Get notifications for upcoming and overdue tasks based on priority
- **User Authentication**: Secure login system to protect user data

## 🚀 Tech Stack

### Frontend
- **Vue.js 3**: Latest version with Composition API
- **Vite**: Build tool for fast development
- **TanStack Query**: Data fetching and state management
- **Vue Router**: Client-side routing
- **Tailwind CSS**: Utility-first CSS framework

### Backend
- **Laravel 12**: PHP Framework with RESTful API support
- **Sanctum**: API token authentication
- **MySQL**: Database for storing todo items and user data
- **Redis**: Cache layer for performance

## 🛠️ Project Structure

```
genius-todolist/
├── backend/              # Laravel PHP backend
│   ├── app/             # Application code
│   ├── config/          # Configuration files
│   ├── database/        # Migrations & seeders
│   ├── routes/          # API routes
│   └── ...
│
├── frontend/            # Vue.js 3 frontend
│   ├── public/          # Static files
│   ├── src/
│   │   ├── assets/      # Images, fonts, etc.
│   │   ├── components/  # Vue components
│   │   ├── composables/ # Vue composables/hooks
│   │   ├── layouts/     # Page layout components
│   │   ├── plugins/     # Vue plugins
│   │   ├── router/      # Vue Router configuration
│   │   ├── services/    # API service layer
│   │   ├── views/       # Page components
│   │   ├── App.vue      # Root component
│   │   └── main.js      # App entry point
│   └── ...
│
└── README.md            # Project documentation
```

## 🔧 Setup & Installation

### Prerequisites
- Node.js 18+ and npm
- PHP 8.2+
- Composer
- MySQL or MariaDB

### Backend Setup

1. Navigate to the backend directory:
```bash
cd backend
```

2. Install PHP dependencies:
```bash
composer install
```

3. Copy the environment file and configure your database:
```bash
cp .env.example .env
# Edit .env with your database credentials
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Run database migrations:
```bash
php artisan migrate
```

6. Seed the database (optional):
```bash
php artisan db:seed
```

7. Start the development server:
```bash
php artisan serve
```

### Frontend Setup

1. Navigate to the frontend directory:
```bash
cd frontend
```

2. Install dependencies:
```bash
npm install
```

3. Start the development server:
```bash
npm run dev
```

4. Open your browser and navigate to:
```
http://localhost:5173
```

## 📘 API Documentation

### Authentication

```
POST /sanctum/csrf-cookie  # Get CSRF cookie
POST /login                # Login with credentials
POST /logout               # Logout current user
GET  /user                 # Get authenticated user data
```

### Todo Items

```
GET    /api/todos          # Get all todos
GET    /api/todos/{id}     # Get a specific todo
POST   /api/todos          # Create a new todo
PUT    /api/todos/{id}     # Update a todo
DELETE /api/todos/{id}     # Delete a todo
```

## 📸 Screenshots

### Home Page
<p align="center">
  <img src="https://via.placeholder.com/800x400?text=Home+Page" alt="Home Page" />
</p>

### Dashboard
<p align="center">
  <img src="https://via.placeholder.com/800x400?text=Dashboard" alt="Dashboard" />
</p>

### Task Creation
<p align="center">
  <img src="https://via.placeholder.com/800x400?text=Task+Creation" alt="Task Creation" />
</p>

## 🔍 Usage

1. **Login/Registration**: Create an account or login to existing account
2. **Add Tasks**: Create new tasks with title, description, and due date
3. **Set Priority**: Manually set priority or let the AI suggest priorities
4. **View Dashboard**: See all tasks organized by priority and due date
5. **Mark Complete**: Check off tasks as they're completed
6. **Filter & Sort**: Organize tasks by different criteria

## 🛣️ Roadmap

- [ ] User registration flow
- [ ] Task categories and tags
- [ ] File attachments
- [ ] Calendar integration
- [ ] Mobile applications
- [ ] Advanced AI prioritization algorithms
- [ ] Team collaboration features

## 👥 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 📧 Contact

Project Link: [https://github.com/maikeru-desu/genius-todolist](https://github.com/maikeru-desu/genius-todolist)

---

Built with ❤️ by [Michael Gelvez](https://github.com/maikeru-desu)
