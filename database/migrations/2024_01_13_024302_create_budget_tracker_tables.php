<?php

use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Laravel\Fortify\Fortify;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('country_phone_code', 3)->nullable();
            $table->string('contact_number', 11)->nullable();
            $table->unsignedInteger('role_id')->nullable()->index('user_admin_id_foreign');
            $table->foreign(['role_id'])->references(['id'])->on('roles')->onUpdate('SET NULL')->onDelete('SET NULL');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->text('two_factor_secret')
                ->after('password')
                ->nullable();

            $table->text('two_factor_recovery_codes')
                ->after('two_factor_secret')
                ->nullable();

            if (Fortify::confirmsTwoFactorAuthentication()) {
                $table->timestamp('two_factor_confirmed_at')
                    ->after('two_factor_recovery_codes')
                    ->nullable();
            }
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
        Schema::create('admin_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable()->index('user_admin_id_foreign');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->timestamps();
        });
        Schema::create('client_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable()->index('user_admin_id_foreign');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->date('birthdate')->nullable();
            $table->string('gender')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
        });
        Schema::create('budgets', function (BluePrint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable()->index('user_id_foreign');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->date('start_date');
            $table->date('end_date');
            $table->double('initial_balance', 10, 2)->default(0);
            $table->string('display_name')->nullable();
            $table->text('description')->nullable();
            $table->double('net_disposable_income', 10, 2)->default(0);
            $table->double('total_expenditure', 10, 2)->default(0);
            $table->double('total_budgeted', 10, 2)->default(0);
            $table->timestamps();
        });
        Schema::create('expense_categories', function (BluePrint $table) {
            $table->id();
            $table->unsignedInteger('budget_id')->index('budget_id_foreign');
            $table->foreign(['budget_id'])->references(['id'])->on('budgets')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('name');
            $table->double('budgeted_amount', 10, 2);
            $table->text('note')->nullable();
            $table->timestamps();
        });
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('budget_id')->index('budget_id_foreign');
            $table->foreign(['budget_id'])->references(['id'])->on('budgets')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedInteger('expense_category_id')->index('expense_category_id_foreign');
            $table->foreign(['expense_category_id'])->references(['id'])->on('expense_categories')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->double('amount', 10, 2);
            $table->dateTime('transaction_datetime');
            $table->timestamps();
        });
        Schema::create('income_categories', function (BluePrint $table) {
            $table->id();
            $table->unsignedInteger('budget_id')->index('budget_id_foreign');
            $table->foreign(['budget_id'])->references(['id'])->on('budgets')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('name');
            $table->double('goal_amount', 10, 2);
            $table->text('note')->nullable();
            $table->timestamps();
        });
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('budget_id')->index('budget_id_foreign');
            $table->foreign(['budget_id'])->references(['id'])->on('budgets')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedInteger('income_category_id')->index('income_category_id_foreign');
            $table->foreign(['income_category_id'])->references(['id'])->on('income_categories')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->double('amount', 10, 2);
            $table->dateTime('transaction_datetime');
            $table->timestamps();
        });

        $roles = ['Super Admin', 'Admin', 'Client'];

        foreach ($roles as $key => $role) {
            Role::create([
                'name' => $role
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(array_merge([
                'two_factor_secret',
                'two_factor_recovery_codes',
            ], Fortify::confirmsTwoFactorAuthentication() ? [
                    'two_factor_confirmed_at',
                ] : []));
        });
        Schema::dropIfExists('users');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('admin_details');
        Schema::dropIfExists('client_details');
        Schema::dropIfExists('budgets');
        Schema::dropIfExists('expense_categories');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('income_categories');
        Schema::dropIfExists('incomes');
    }
};
