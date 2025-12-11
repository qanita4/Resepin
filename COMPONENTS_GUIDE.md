# Reusable Components Guide

## 📦 Available Components

This project includes reusable Blade components and service classes to maintain clean, DRY code.

## 🎨 UI Components

### 1. Alert Component

**Location**: `resources/views/components/alert.blade.php`

**Usage**:

```blade
<!-- Success Message -->
<x-alert type="success">
    Recipe created successfully!
</x-alert>

<!-- Error Message -->
<x-alert type="error">
    <div class="font-medium">Validation errors:</div>
    <ul class="mt-2 list-disc list-inside">
        <li>Title is required</li>
        <li>Invalid image format</li>
    </ul>
</x-alert>

<!-- Warning with dismiss button -->
<x-alert type="warning" dismissible>
    This action cannot be undone
</x-alert>

<!-- Info Message -->
<x-alert type="info">
    Tips: Use high-quality images for better results
</x-alert>
```

**Props**:

-   `type`: success|error|warning|info (default: success)
-   `dismissible`: boolean (default: false)

---

### 2. Card Component

**Location**: `resources/views/components/card.blade.php`

**Usage**:

```blade
<!-- Card with title -->
<x-card title="Basic Information">
    <p>Your content here</p>
</x-card>

<!-- Card with title and description -->
<x-card title="Recipe Details" description="Fill in the information below">
    <form>...</form>
</x-card>

<!-- Card with custom padding -->
<x-card title="Ingredients" padding="p-4">
    <ul>...</ul>
</x-card>

<!-- Card without title -->
<x-card>
    <div class="custom-content">...</div>
</x-card>
```

**Props**:

-   `title`: string|null
-   `description`: string|null
-   `padding`: string (default: p-6)

---

### 3. Button Component

**Location**: `resources/views/components/button.blade.php`

**Usage**:

```blade
<!-- Primary Button (link) -->
<x-button
    variant="primary"
    size="md"
    href="{{ route('recipes.create') }}"
>
    Create Recipe
</x-button>

<!-- Submit Button -->
<x-button
    variant="primary"
    size="lg"
    type="submit"
>
    Save Recipe
</x-button>

<!-- Button with Icon -->
<x-button
    variant="success"
    size="sm"
    href="{{ route('recipes.edit', $recipe) }}"
    :icon="'<path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z\' />'"
>
    Edit
</x-button>

<!-- Danger Button -->
<x-button
    variant="danger"
    size="md"
    type="submit"
    onclick="return confirm('Are you sure?')"
>
    Delete
</x-button>

<!-- Outline Button -->
<x-button
    variant="outline"
    size="lg"
    href="{{ route('dashboard') }}"
>
    Cancel
</x-button>

<!-- Secondary Button -->
<x-button variant="secondary" size="sm">
    Secondary Action
</x-button>
```

**Props**:

-   `variant`: primary|secondary|success|danger|outline (default: primary)
-   `size`: sm|md|lg (default: md)
-   `href`: string|null (if provided, renders as <a>, otherwise <button>)
-   `type`: button|submit (default: button, only for button element)
-   `icon`: SVG path string|null

**Variants**:

-   `primary`: Red tomato color (main CTA)
-   `secondary`: Gray color
-   `success`: Green color
-   `danger`: Red color for destructive actions
-   `outline`: Border with no background

---

### 4. Form Input Component

**Location**: `resources/views/components/form/input.blade.php`

**Usage**:

```blade
<!-- Required Input -->
<x-form.input
    name="title"
    label="Recipe Title"
    placeholder="e.g., Nasi Goreng Special"
    required
/>

<!-- Email Input with hint -->
<x-form.input
    name="email"
    type="email"
    label="Email Address"
    hint="We'll never share your email"
/>

<!-- Password Input -->
<x-form.input
    name="password"
    type="password"
    label="Password"
    required
/>

<!-- Input with default value -->
<x-form.input
    name="chef"
    label="Chef Name"
    value="{{ Auth::user()->name }}"
/>
```

**Props**:

-   `name`: string (required)
-   `label`: string|null
-   `type`: text|email|password|number|url (default: text)
-   `required`: boolean (default: false)
-   `error`: string|null (manual error message)
-   `hint`: string|null (helper text)
-   `value`: string (default value)
-   `placeholder`: string|null

---

### 5. Form Textarea Component

**Location**: `resources/views/components/form/textarea.blade.php`

**Usage**:

```blade
<!-- Basic Textarea -->
<x-form.textarea
    name="description"
    label="Description"
    placeholder="Tell us about this recipe..."
    rows="3"
/>

<!-- Required Textarea with hint -->
<x-form.textarea
    name="ingredients"
    label="Ingredients"
    hint="One ingredient per line"
    rows="5"
    required
/>

<!-- Textarea with default value -->
<x-form.textarea
    name="notes"
    label="Notes"
    value="{{ $recipe->notes }}"
    rows="4"
/>
```

**Props**:

-   `name`: string (required)
-   `label`: string|null
-   `required`: boolean (default: false)
-   `error`: string|null
-   `hint`: string|null
-   `rows`: number (default: 3)
-   `value`: string (default value)
-   `placeholder`: string|null

---

### 6. Form Select Component

**Location**: `resources/views/components/form/select.blade.php`

**Usage**:

```blade
<!-- Basic Select -->
<x-form.select
    name="difficulty"
    label="Difficulty Level"
    placeholder="Choose difficulty"
    :options="[
        'Mudah' => 'Easy',
        'Sedang' => 'Medium',
        'Sulit' => 'Hard',
    ]"
/>

<!-- Required Select with hint -->
<x-form.select
    name="category"
    label="Category"
    placeholder="Choose category"
    :options="[
        'sarapan' => '🌅 Breakfast',
        'makan siang' => '☀️ Lunch',
        'makan malam' => '🌙 Dinner',
    ]"
    hint="Select the meal type"
    required
/>

<!-- Select with default value -->
<x-form.select
    name="status"
    label="Status"
    :options="['draft' => 'Draft', 'published' => 'Published']"
    value="draft"
/>
```

**Props**:

-   `name`: string (required)
-   `label`: string|null
-   `required`: boolean (default: false)
-   `error`: string|null
-   `hint`: string|null
-   `options`: array (required) - ['value' => 'label']
-   `value`: string (default selected value)
-   `placeholder`: string|null

---

### 7. Section Title Component

**Location**: `resources/views/components/section-title.blade.php`

**Usage**:

```blade
<!-- Basic Section Title -->
<x-section-title>
    Popular Recipes
</x-section-title>

<!-- Section Title with Icon -->
<x-section-title :icon="'<svg>...</svg>'">
    My Recipes
</x-section-title>

<!-- Section Title with Badge -->
<x-section-title>
    Latest Recipes
    <x-slot:badge>
        <span class="text-sm text-gray-500">6 items</span>
    </x-slot:badge>
</x-section-title>
```

**Props**:

-   `icon`: SVG string|null
-   `badge`: slot|null

---

## 🔧 Service Classes

### 1. RecipeSearchService

**Location**: `app/Services/RecipeSearchService.php`

**Methods**:

```php
// Get base query with relations
$query = $this->searchService->getBaseQuery();

// Apply search filter
$this->searchService->applySearch($query, $searchTerm);

// Apply category filter
$this->searchService->applyCategory($query, 'sarapan');

// Apply user filter
$this->searchService->applyUserFilter($query, Auth::id());

// Get popular recipes
$popular = $this->searchService->getPopular(6);

// Get latest recipes
$latest = $this->searchService->getLatest(6);

// Get related recipes
$related = $this->searchService->getRelated($recipe, 3);
```

---

### 2. SlugService

**Location**: `app/Services/SlugService.php`

**Methods**:

```php
// Generate unique slug (for new recipe)
$slug = $this->slugService->generateUniqueSlug($title);

// Generate unique slug (for update, exclude current recipe)
$slug = $this->slugService->generateUniqueSlug($title, $recipeId);
```

---

### 3. ImageUploadService

**Location**: `app/Services/ImageUploadService.php`

**Methods**:

```php
// Upload new image
$path = $this->imageService->upload($file);
$path = $this->imageService->upload($file, 'custom-directory');

// Delete image
$this->imageService->delete($imagePath);

// Update image (delete old, upload new)
$newPath = $this->imageService->update($oldPath, $newFile);
```

---

## 💡 Best Practices

### 1. **Use Components Consistently**

```blade
<!-- ❌ Bad -->
<div class="mb-6 rounded-lg bg-green-100 p-4 text-green-700">
    Success!
</div>

<!-- ✅ Good -->
<x-alert type="success">
    Success!
</x-alert>
```

### 2. **Inject Services in Controller**

```php
// ✅ Good - Use dependency injection
public function __construct(
    private RecipeSearchService $searchService,
    private SlugService $slugService,
    private ImageUploadService $imageService
) {}
```

### 3. **Keep Controllers Thin**

```php
// ❌ Bad
public function store(Request $request) {
    // 50 lines of business logic
}

// ✅ Good
public function store(Request $request) {
    $slug = $this->slugService->generateUniqueSlug($title);
    $image = $this->imageService->upload($file);
    Recipe::create([...]);
}
```

### 4. **Use Form Components**

```blade
<!-- ❌ Bad -->
<div>
    <label>Title</label>
    <input name="title" type="text">
    @error('title')<span>{{ $message }}</span>@enderror
</div>

<!-- ✅ Good -->
<x-form.input name="title" label="Title" required />
```

---

## 🎯 Component Props Cheat Sheet

| Component         | Key Props             | Example                         |
| ----------------- | --------------------- | ------------------------------- |
| `x-alert`         | type, dismissible     | `<x-alert type="success">`      |
| `x-card`          | title, padding        | `<x-card title="Form">`         |
| `x-button`        | variant, size, href   | `<x-button variant="primary">`  |
| `x-form.input`    | name, label, required | `<x-form.input name="email">`   |
| `x-form.textarea` | name, rows            | `<x-form.textarea rows="5">`    |
| `x-form.select`   | name, :options        | `<x-form.select :options="[]">` |

---

## 📚 Further Reading

-   [Laravel Blade Components](https://laravel.com/docs/blade#components)
-   [Service Layer Pattern](https://martinfowler.com/eaaCatalog/serviceLayer.html)
-   [Clean Code Principles](https://github.com/ryanmcdermott/clean-code-javascript)

---

**Last Updated**: December 9, 2025
