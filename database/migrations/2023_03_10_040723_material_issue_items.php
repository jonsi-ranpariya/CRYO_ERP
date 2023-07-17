<?php

use App\Models\Inventory\MaterialIssue;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MaterialIssueItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('material_issue_items', function (Blueprint $table) {
            $table->foreignIdFor(MaterialIssue::class)->constrained('material_issue')->cascadeOnDelete();
            $table->string('itemId');
            $table->string('woId')->nullable();
            $table->string('itemCode')->nullable();
            $table->string('itemDescription')->nullable();
            $table->string('itemUom')->nullable();
            $table->float('itemIssueQty')->nullable();
            $table->string('addedFrom');
            $table->string('updatedFrom');
            $table->string('companyId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('material_issue_item', function (Blueprint $table) {
            $table->string('itemCode')->nullable();
            $table->string('itemDescription')->nullable();
            $table->string('itemUom')->nullable();
            $table->float('itemIssueQty')->nullable();
            $table->string('addedFrom');
            $table->string('updatedFrom');
            $table->string('companyId');
        });
    }
}
