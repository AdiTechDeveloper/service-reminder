<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->string('company')->nullable();
            $t->string('phone', 20)->nullable();
            $t->string('email')->nullable();
            $t->text('address')->nullable();
            $t->timestamps();
        });

        Schema::create('service_types', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->timestamps();
            $t->unique(['user_id', 'name']);
        });

        Schema::create('client_services', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('client_id')->constrained()->cascadeOnDelete();
            $t->foreignId('service_type_id')->constrained()->restrictOnDelete();
            $t->string('title')->nullable();          // e.g. domain name / plan name
            $t->date('start_date');
            $t->date('expiry_date')->index();
            $t->text('notes')->nullable();
            $t->date('last_reminded_on')->nullable();  // ek din mein ek hi reminder
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_services');
        Schema::dropIfExists('service_types');
        Schema::dropIfExists('clients');
    }
};
