<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecipeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'badge' => ['nullable', 'string', 'max:100'],
            'duration' => ['nullable', 'string', 'max:100'],
            'servings' => ['nullable', 'integer', 'min:1'],
            'difficulty' => ['nullable', 'string', 'in:Mudah,Sedang,Sulit'],
            'category' => ['nullable', 'string', 'in:sarapan,makan siang,makan malam,minuman,camilan,dessert'],
            'ingredients' => ['required', 'array', 'min:1'],
            'ingredients.*' => ['required', 'string'],
            'steps' => ['required', 'array', 'min:1'],
            'steps.*' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul resep wajib diisi.',
            'title.max' => 'Judul resep maksimal 255 karakter.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'difficulty.in' => 'Tingkat kesulitan harus Mudah, Sedang, atau Sulit.',
            'servings.integer' => 'Porsi harus berupa angka.',
            'servings.min' => 'Porsi minimal 1.',
            'category.in' => 'Kategori tidak valid.',
            'ingredients.required' => 'Bahan-bahan wajib diisi.',
            'ingredients.min' => 'Minimal harus ada 1 bahan.',
            'ingredients.*.required' => 'Setiap bahan tidak boleh kosong.',
            'steps.required' => 'Langkah-langkah wajib diisi.',
            'steps.min' => 'Minimal harus ada 1 langkah.',
            'steps.*.required' => 'Setiap langkah tidak boleh kosong.',
        ];
    }
}
