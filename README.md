# EduVerse

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-38B2AC?style=flat-square&logo=tailwind-css&logoColor=white" alt="TailwindCSS">
  <img src="https://img.shields.io/badge/License-MIT-green?style=flat-square" alt="License">
</p>

**EduVerse** is a modern educational material management system built with Laravel. It enables students to upload, organize, and share learning materials with an intuitive approval workflow and course-based organization.

---

## Features

- **Material Management**: Upload, edit, and organize educational materials (PDF, DOC, DOCX, JPG, PNG)
- **Course Association**: Link materials to specific courses and semesters
- **Approval Workflow**: Materials require approval before being visible to others
- **Soft Deletes**: Recover accidentally deleted materials from the trash
- **Search Functionality**: Quickly find materials by title or description
- **User Roles**: Role-based access control for different user types
- **Statistics Dashboard**: View insights on materials, courses, and users
- **Responsive Design**: Clean, modern UI built with Tailwind CSS

---

## Tech Stack

| Component | Technology |
|-----------|------------|
| Framework | Laravel 12.x |
| Language | PHP 8.2+ |
| Frontend | Tailwind CSS 3.x, Alpine.js |
| Auth | Laravel Breeze |
| Database | SQLite (default), MySQL/PostgreSQL supported |
| Build Tool | Vite |
| Testing | Pest PHP |

---

## Requirements

- PHP >= 8.2
- Composer
- Node.js & NPM
- SQLite (or MySQL/PostgreSQL)

---

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd EduVerse
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database setup**
   ```bash
   touch database/database.sqlite
   php artisan migrate
   ```

6. **Build assets**
   ```bash
   npm run build
   ```

7. **Start the development server**
   ```bash
   composer run dev
   ```

   Or run services individually:
   ```bash
   php artisan serve
   npm run dev
   ```

---

## Usage

1. **Register an account** at `/register`
2. **Login** at `/login`
3. **Upload materials** via the dashboard
4. **Manage materials**: Edit, delete (soft delete), or restore from trash
5. **Approve materials** (admin/approver role required)
6. **View statistics** at `/stats`

---

## Project Structure

```
EduVerse/
├── app/
│   ├── Http/Controllers/    # Controllers (MaterialController, etc.)
│   ├── Models/              # Eloquent models (User, Material, Course)
│   └── ...
├── database/
│   └── migrations/          # Database migrations
├── resources/
│   └── views/               # Blade templates
├── routes/
│   └── web.php              # Application routes
└── ...
```

---

## Key Features Explained

### Material Upload
- Supports PDF, DOC, DOCX, JPG, PNG files (max 2MB)
- Associated with course name and semester
- Tracks uploader information

### Soft Delete & Restore
- Materials are soft-deleted (moved to trash)
- Users can restore their own deleted materials
- Permanent deletion removes files from storage

### Approval System
- New materials require approval
- Approved materials are visible to all users
- Only authorized roles can approve materials

### Search
- Full-text search on title and description
- Instant results on the dashboard

---

## Testing

```bash
./vendor/bin/pest
```

---

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'feat: add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

---

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).

---

## Acknowledgments

- Built with [Laravel](https://laravel.com)
- UI powered by [Tailwind CSS](https://tailwindcss.com)
- Authentication by [Laravel Breeze](https://laravel.com/docs/starter-kits#laravel-breeze)
