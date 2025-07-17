<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Hanafalah\ModulePayment\Models\{
    CoaEntry
};
use Hanafalah\ModulePayment\Models\Accounting\Coa;
use Hanafalah\ModulePayment\Models\Accounting\JournalEntry;

return new class extends Migration
{
    use Hanafalah\LaravelSupport\Concerns\NowYouSeeMe;

    private $__table;

    public function __construct()
    {
        $this->__table = app(config('database.models.CoaEntry', CoaEntry::class));
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $table_name = $this->__table->getTable();
        if (!$this->isTableExists()) {
            Schema::create($table_name, function (Blueprint $table) {
                $coa = app(config('database.models.Coa', Coa::class));
                $journal_entry = app(config('database.models.JournalEntry', JournalEntry::class));

                $table->ulid('id')->primary();

                $table->foreignIdFor($coa::class)->nullable(false)
                      ->index()->constrained()->cascadeOnUpdate()->restrictOnDelete();

                $table->foreignIdFor($journal_entry::class)->nullable(false)
                      ->index()->constrained()->cascadeOnUpdate()->restrictOnDelete();

                $table->string('balance_type', 10)->nullable(true)->comment('DEBIT, CREDIT');
                $table->unsignedBigInteger('value')->nullable(false);
                $table->json('props')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->__table->getTable());
    }
};
