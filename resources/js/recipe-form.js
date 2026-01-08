export class RecipeFormManager {
    constructor() {
        this.ingredientsContainer = document.getElementById('ingredients-container');
        this.stepsContainer = document.getElementById('steps-container');
        
        if (!this.ingredientsContainer || !this.stepsContainer) {
            console.warn('Recipe form containers not found');
            return;
        }
        
        this.init();
    }

    init() {
        // Expose methods to window for onclick handlers
        window.addIngredient = () => this.addIngredient();
        window.removeIngredient = (button) => this.removeIngredient(button);
        window.addStep = () => this.addStep();
        window.removeStep = (button) => this.removeStep(button);
    }

    // ========== INGREDIENTS MANAGEMENT ==========
    
    addIngredient() {
        const items = this.ingredientsContainer.querySelectorAll('.ingredient-item');
        const newIndex = items.length + 1;
        
        const newItem = this.createIngredientElement(newIndex);
        this.ingredientsContainer.appendChild(newItem);
    }

    createIngredientElement(index) {
        const div = document.createElement('div');
        div.className = 'ingredient-item flex items-center gap-2';
        div.innerHTML = `
            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-resepin-green/10 text-sm font-medium text-resepin-green">${index}</span>
            <input
                type="text"
                name="ingredients[]"
                class="flex-1 rounded-lg border border-gray-300 px-4 py-3 focus:border-resepin-green focus:outline-none focus:ring-2 focus:ring-resepin-green/20"
                placeholder="Contoh: 2 butir telur"
                required
            >
            <button type="button" onclick="removeIngredient(this)" class="rounded-lg p-2 text-red-500 hover:bg-red-50" aria-label="Hapus bahan">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        `;
        return div;
    }

    removeIngredient(button) {
        const items = this.ingredientsContainer.querySelectorAll('.ingredient-item');
        
        if (items.length > 1) {
            button.closest('.ingredient-item').remove();
            this.updateIngredientNumbers();
        } else {
            alert('Minimal harus ada 1 bahan');
        }
    }

    updateIngredientNumbers() {
        const items = this.ingredientsContainer.querySelectorAll('.ingredient-item');
        items.forEach((item, index) => {
            const span = item.querySelector('span');
            span.textContent = index + 1;
        });
    }

    // ========== STEPS MANAGEMENT ==========
    
    addStep() {
        const items = this.stepsContainer.querySelectorAll('.step-item');
        const newIndex = items.length + 1;
        
        const newItem = this.createStepElement(newIndex);
        this.stepsContainer.appendChild(newItem);
    }

    createStepElement(index) {
        const div = document.createElement('div');
        div.className = 'step-item flex items-start gap-2';
        div.innerHTML = `
            <span class="mt-3 flex h-8 w-8 items-center justify-center rounded-full bg-resepin-tomato/10 text-sm font-medium text-resepin-tomato">${index}</span>
            <textarea
                name="steps[]"
                rows="2"
                class="flex-1 rounded-lg border border-gray-300 px-4 py-3 focus:border-resepin-green focus:outline-none focus:ring-2 focus:ring-resepin-green/20"
                placeholder="Jelaskan langkah memasak..."
                required
            ></textarea>
            <button type="button" onclick="removeStep(this)" class="mt-3 rounded-lg p-2 text-red-500 hover:bg-red-50" aria-label="Hapus langkah">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        `;
        return div;
    }

    removeStep(button) {
        const items = this.stepsContainer.querySelectorAll('.step-item');
        
        if (items.length > 1) {
            button.closest('.step-item').remove();
            this.updateStepNumbers();
        } else {
            alert('Minimal harus ada 1 langkah');
        }
    }

    updateStepNumbers() {
        const items = this.stepsContainer.querySelectorAll('.step-item');
        items.forEach((item, index) => {
            const span = item.querySelector('span');
            span.textContent = index + 1;
        });
    }
}

// Auto-initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => new RecipeFormManager());
} else {
    new RecipeFormManager();
}
