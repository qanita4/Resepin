<?php

use App\Services\ImageUploadService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('uploads an image to the public disk', function () {
    Storage::fake('public');
    $service = app(ImageUploadService::class);

    $path = $service->upload(UploadedFile::fake()->create('photo.jpg', 10, 'image/jpeg'));

    expect($path)->toStartWith('recipes/');
    Storage::disk('public')->assertExists($path);
});

it('returns null for invalid upload', function () {
    Storage::fake('public');
    $service = app(ImageUploadService::class);
    $file = Mockery::mock(UploadedFile::class);
    $file->shouldReceive('isValid')->andReturnFalse();

    $path = $service->upload($file);

    expect($path)->toBeNull();
});

it('deletes an image path when provided', function () {
    Storage::fake('public');
    $service = app(ImageUploadService::class);
    $path = $service->upload(UploadedFile::fake()->create('photo.jpg', 10, 'image/jpeg'));

    $deleted = $service->delete($path);

    expect($deleted)->toBeTrue();
    Storage::disk('public')->assertMissing($path);
});

it('updates an image by deleting old and uploading new', function () {
    Storage::fake('public');
    $service = app(ImageUploadService::class);

    $oldPath = $service->upload(UploadedFile::fake()->create('old.jpg', 10, 'image/jpeg'));
    $newPath = $service->update($oldPath, UploadedFile::fake()->create('new.jpg', 10, 'image/jpeg'));

    expect($newPath)->not()->toBeNull();
    Storage::disk('public')->assertMissing($oldPath);
    Storage::disk('public')->assertExists($newPath);
});
