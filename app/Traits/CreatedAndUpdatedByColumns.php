<?php

namespace App\Traits;

use Illuminate\Database\Schema\Blueprint;

trait CreatedAndUpdatedByColumns
{
    public static function defineUserActionsColumns(Blueprint $table)
    {
        $table->foreignId('created_by')
            ->nullable()
            ->constrained('users')
            ->onDelete('cascade');
            
        $table->foreignId('updated_by')
            ->nullable()
            ->constrained('users')
            ->onDelete('cascade');
    }

    // public function createdBy()
    // {
    //     return $this->belongsTo(User::class, 'created_by')->select('id', 'name', 'email');
    // }

    // public function updatedBy()
    // {
    //     return $this->belongsTo(User::class, 'updated_by')->select('id', 'name', 'email');
    // }
}
