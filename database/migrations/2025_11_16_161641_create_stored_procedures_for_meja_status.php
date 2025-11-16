<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Hanya untuk MySQL/MariaDB
        if (DB::getDriverName() === 'mysql') {
            // Drop stored procedure jika sudah ada
            DB::unprepared('DROP PROCEDURE IF EXISTS update_meja_status_terisi');
            DB::unprepared('DROP PROCEDURE IF EXISTS update_meja_status_tersedia');
            
            // Stored procedure untuk mengubah status meja menjadi terisi
            DB::unprepared('
                CREATE PROCEDURE update_meja_status_terisi(IN p_id_meja INT)
                BEGIN
                    UPDATE mejas 
                    SET status = "terisi" 
                    WHERE id = p_id_meja;
                END
            ');

            // Stored procedure untuk mengubah status meja menjadi tersedia
            DB::unprepared('
                CREATE PROCEDURE update_meja_status_tersedia(IN p_id_meja INT)
                BEGIN
                    UPDATE mejas 
                    SET status = "tersedia" 
                    WHERE id = p_id_meja;
                END
            ');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hanya untuk MySQL/MariaDB
        if (DB::getDriverName() === 'mysql') {
            DB::unprepared('DROP PROCEDURE IF EXISTS update_meja_status_terisi');
            DB::unprepared('DROP PROCEDURE IF EXISTS update_meja_status_tersedia');
        }
    }
};
