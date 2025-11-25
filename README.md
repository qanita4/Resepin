# Resepin

Resepin is a modern Indonesian recipe companion that helps home cooks discover, save, and discuss dishes in a welcoming, social cooking experience. It blends a curated recipe catalog with community-powered likes and comments, wrapped in a bright Tailwind-powered interface that matches the brand’s signature tomato palette.

## ✨ Features

- **Curated recipe library** – Browse chef-approved dishes with imagery, difficulty, duration, and servings pulled from seeded data.
- **Responsive dashboard grid** – Tailwind-driven `grid grid-cols-3 gap-4` layout keeps cards tidy across desktop and mobile breakpoints.
- **Reusable Blade components** – Cards, buttons, search bar, and like controls live in `resources/views/components` for consistent styling and rapid iteration.
- **Heart-based likes** – Users can toggle a heart icon to like recipes; counts update instantly and persist through the `recipe_likes` table.
- **Conversation-friendly comments** – Authenticated cooks can share tips, feedback, and remove their own notes through the `recipe_comments` feature.
- **Rich recipe detail pages** – High-quality imagery, badges, ingredient lists, cooking steps, and related recipe suggestions keep cooks inspired.

## 🧱 Technology Stack

- **Backend:** Laravel 10, PHP 8.2+
- **Frontend:** Blade templates, Tailwind CSS, Vite bundler, a sprinkle of Alpine-ready scaffolding
- **Database:** Eloquent ORM with migrations, seeders, and factories
- **Tooling:** Pest for tests, Laravel Breeze-style auth scaffolding, npm for asset compilation

## 📁 Key Directories

| Path | Purpose |
| --- | --- |
| `app/Http/Controllers` | Web controllers including `RecipeController`, `RecipeLikeController`, and `RecipeCommentController`. |
| `app/Models` | Eloquent models such as `Recipe`, `RecipeLike`, and `RecipeComment`. |
| `resources/views` | Blade templates for dashboard, recipe detail pages, and reusable components. |
| `database/migrations` | Schema definitions for recipes, likes, comments, jobs, and cache tables. |
| `database/seeders` | Seeds the recipe catalog and supporting data for local development. |
| `tests/Feature` | Pest-powered feature tests covering auth and profile flows. |

## 🚀 Getting Started on a New Device

Follow the steps below to clone, configure, and run Resepin on any macOS, Linux, or Windows machine.

### 1. Prerequisites

Make sure the following tools are installed:

- PHP 8.2 or higher with `pdo_mysql` or `pdo_sqlite`
- [Composer](https://getcomposer.org/)
- Node.js 18+ and npm 9+
- A database (MySQL, MariaDB, or SQLite). SQLite works out of the box for quick trials.

### 2. Clone the Repository

```bash
git clone https://github.com/nitashaf/resepin.git
cd resepin
```

### 3. Install PHP Dependencies

```bash
composer install
```

### 4. Configure Environment

```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` with your database connection. For SQLite, point `DB_DATABASE` to an absolute path (for example `database/database.sqlite`) and create the file if it doesn’t exist.

### 5. Run Migrations & Seeders

```bash
php artisan migrate --seed
```

This creates the recipes, likes, comments, and supporting tables, then seeds demo content so the dashboard has rich sample data immediately.

### 6. Install Frontend Dependencies

```bash
npm install
```

### 7. Build or Watch Assets

- Development (hot reload):

	```bash
	npm run dev
	```

- Production build:

	```bash
	npm run build
	```

### 8. Start the Application

```bash
php artisan serve
```

Visit `http://localhost:8000` and log in or register to explore featured recipes, leave hearts, and drop comments.

## ✅ Verification & Testing

Run the automated test suite anytime to confirm the application is healthy:

```bash
php artisan test
```

## 🧭 Tips for Team Members

- UI colors live in `resources/css/app.css` and `tailwind.config.js` under the `resepin-*` palette.
- Reusable Blade components (cards, buttons, like buttons) sit in `resources/views/components` to keep markup consistent.
- Comment and like logic is centralized in dedicated controllers and request classes so behavior stays predictable.

Happy cooking and coding! 🍲❤️
