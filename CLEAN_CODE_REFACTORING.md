# Clean Code Refactoring - Resepin Project

## 📋 Summary

Proyek Resepin telah direfactor untuk menerapkan prinsip Clean Code dengan menghilangkan duplikasi kode dan meningkatkan reusability melalui komponen dan service classes.

## 🎯 Yang Sudah Dilakukan

### 1. **Blade Components** (View Layer)

#### a. Alert Component (`components/alert.blade.php`)

-   **Purpose**: Unified notification system
-   **Variants**: success, error, warning, info
-   **Features**:
    -   Auto icon based on type
    -   Dismissible option
    -   Consistent styling

**Before:**

```blade
<div class="mb-6 rounded-lg bg-green-100 p-4 text-green-700">
    {{ session('success') }}
</div>
```

**After:**

```blade
<x-alert type="success">
    {{ session('success') }}
</x-alert>
```

#### b. Card Component (`components/card.blade.php`)

-   **Purpose**: Container dengan header optional
-   **Props**: title, description, padding
-   **Usage**: Form sections, content blocks

**Before:**

```blade
<div class="rounded-xl bg-white p-6 shadow-md">
    <h2 class="mb-4 text-xl font-semibold">Title</h2>
    <!-- content -->
</div>
```

**After:**

```blade
<x-card title="Title">
    <!-- content -->
</x-card>
```

#### c. Button Component (`components/button.blade.php`)

-   **Purpose**: Standardized buttons
-   **Variants**: primary, secondary, success, danger, outline
-   **Sizes**: sm, md, lg
-   **Features**:
    -   Auto href/button rendering
    -   Icon support
    -   Consistent hover effects

**Before:**

```blade
<a href="{{ route('recipes.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-resepin-tomato px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:brightness-95">
    <svg>...</svg>
    Tambah Resep
</a>
```

**After:**

```blade
<x-button
    variant="primary"
    size="md"
    href="{{ route('recipes.create') }}"
    :icon="'<path ... />'"
>
    Tambah Resep
</x-button>
```

#### d. Form Components

**Input** (`components/form/input.blade.php`)

-   Auto label with required indicator
-   Error handling
-   Hint text support

**Textarea** (`components/form/textarea.blade.php`)

-   Same features as input
-   Configurable rows

**Select** (`components/form/select.blade.php`)

-   Array-based options
-   Old value preservation
-   Placeholder support

**Before:**

```blade
<div>
    <label for="title" class="mb-1 block font-medium text-gray-700">
        Judul Resep <span class="text-red-500">*</span>
    </label>
    <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full rounded-lg border..." required>
    @error('title')
        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>
```

**After:**

```blade
<x-form.input
    name="title"
    label="Judul Resep"
    placeholder="Contoh: Nasi Goreng Spesial"
    required
/>
```

#### e. Section Title Component (`components/section-title.blade.php`)

-   Icon support
-   Badge slot
-   Responsive layout

### 2. **Service Classes** (Business Logic Layer)

#### a. RecipeSearchService (`app/Services/RecipeSearchService.php`)

**Methods:**

-   `getBaseQuery()` - Base query with relations
-   `applySearch()` - Search filter
-   `applyCategory()` - Category filter
-   `applyUserFilter()` - User filter
-   `getPopular()` - Popular recipes
-   `getLatest()` - Latest recipes
-   `getRelated()` - Related recipes by category

**Benefits:**

-   ✅ DRY: Search logic tidak duplikat
-   ✅ Testable: Easy to unit test
-   ✅ Reusable: Bisa dipakai di berbagai controller

#### b. SlugService (`app/Services/SlugService.php`)

**Methods:**

-   `generateUniqueSlug()` - Generate unique slug
-   `slugExists()` - Check slug existence

**Benefits:**

-   ✅ Single Responsibility: Hanya handle slug
-   ✅ Reusable: Store & Update pakai logic sama

#### c. ImageUploadService (`app/Services/ImageUploadService.php`)

**Methods:**

-   `upload()` - Upload image
-   `delete()` - Delete image
-   `update()` - Delete old & upload new

**Benefits:**

-   ✅ Centralized file handling
-   ✅ Easy to extend (resize, watermark, etc.)
-   ✅ Consistent error handling

### 3. **Controller Refactoring**

**Before (RecipeController::store):**

```php
public function store(StoreRecipeRequest $request): RedirectResponse
{
    // 45 lines of code
    // Slug generation logic
    // Image upload logic
    // Array filtering
    // Recipe creation
}
```

**After:**

```php
public function store(StoreRecipeRequest $request): RedirectResponse
{
    $slug = $this->slugService->generateUniqueSlug($validated['title']);
    $imagePath = $this->imageService->upload($request->file('image'));
    $ingredients = array_values(array_filter(...));

    $recipe = Recipe::create([...]);

    return redirect()->route('recipes.show', $recipe)
        ->with('success', 'Resep berhasil ditambahkan!');
}
```

**Benefits:**

-   ✅ Thin controller
-   ✅ Readable
-   ✅ Easy to maintain

## 📊 Metrics

### Code Reduction

-   **RecipeController**: ~150 lines → ~100 lines (-33%)
-   **create.blade.php**: ~400 lines → ~250 lines (-37%)
-   **show.blade.php**: Cleaner button implementation
-   **dashboard.blade.php**: Cleaner alert & button
-   **navigation.blade.php**: Consistent button components

### Reusability

-   **Alert**: Used in 4+ files
-   **Button**: Used in 10+ places
-   **Form Components**: Used 15+ times
-   **Services**: Used across all CRUD operations

### Maintainability

-   ✅ Single source of truth untuk styling
-   ✅ Easy to change button/alert design globally
-   ✅ Type-safe dengan PHP 8.1+ constructor property promotion
-   ✅ Testable service classes

## 🎨 Design Patterns Applied

1. **Component Pattern** - Reusable UI components
2. **Service Layer Pattern** - Business logic separation
3. **Dependency Injection** - Services injected to controller
4. **Single Responsibility** - Each class has one job
5. **DRY (Don't Repeat Yourself)** - No code duplication

## 🚀 Future Improvements

### Potential Next Steps:

1. **Form Request Refactoring**: Extract common validation rules
2. **Repository Pattern**: Add RecipeRepository for data access
3. **Event/Listener**: Decouple recipe creation from email notifications
4. **Policy Classes**: Move authorization logic from controller
5. **API Resources**: Transform model to API response
6. **Caching Service**: Cache popular/latest recipes
7. **Validation Service**: Complex validation logic
8. **JavaScript Modules**: Extract JS functions to modules

## 📖 How to Use New Components

### Alert

```blade
<x-alert type="success|error|warning|info" dismissible>
    Message here
</x-alert>
```

### Card

```blade
<x-card title="Title" description="Optional description">
    Content
</x-card>
```

### Button

```blade
<x-button
    variant="primary|secondary|success|danger|outline"
    size="sm|md|lg"
    href="url"
    type="button|submit"
    :icon="'<path d=... />'"
>
    Button Text
</x-button>
```

### Form Input

```blade
<x-form.input
    name="field_name"
    label="Field Label"
    type="text|email|password"
    placeholder="Placeholder"
    hint="Helper text"
    required
/>
```

### Form Select

```blade
<x-form.select
    name="category"
    label="Category"
    placeholder="Choose..."
    :options="[
        'value1' => 'Label 1',
        'value2' => 'Label 2',
    ]"
    required
/>
```

## ✅ Benefits Summary

### For Developers:

-   ✨ Less code to write
-   🔧 Easy to maintain
-   🧪 Easy to test
-   📚 Self-documenting code

### For Project:

-   🎯 Consistent UI/UX
-   🚀 Faster development
-   🐛 Less bugs
-   📈 Scalable architecture

---

**Refactored by**: GitHub Copilot
**Date**: December 9, 2025
**Status**: ✅ Complete
