<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('recipes', function (Blueprint $table) {
            if (! Schema::hasColumn('recipes', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('recipes', function (Blueprint $table) {
            if (Schema::hasColumn('recipes', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};

use Illuminate\Support\Facades\Schema;

public function store(Request $request)
{
    // ...validasi & proses image, normalizeList, slug...
    if (Auth::check() && Schema::hasColumn('recipes', 'user_id')) {
        $data['user_id'] = Auth::id();
    }

    $recipe = Recipe::create($data);

    return redirect()->route('dashboard')->with('success', 'Resep berhasil ditambahkan.');
}
