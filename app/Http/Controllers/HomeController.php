<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Sale;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $units = DB::select("
                SELECT u.unit_kode, u.unit_nama, d.nama_db 
                FROM db_accounting.tbl_unit_usaha u 
                INNER JOIN db_accounting.tbl_db d 
                ON u.unit_kode = d.unit_kode
                WHERE u.unit_kode = 'DEW'
                OR u.unit_kode = 'KBW'
            ");

        if (!empty($units)) {
            $firstDbName = $units[0]->nama_db;
            $raw = DB::connection('mysql2')->select("
                    SELECT DISTINCT YEAR(do_date) as year 
                    FROM {$firstDbName}.tr_do_master 
                    ORDER BY year desc    
                ");

            $years = collect($raw)->pluck('year')->toArray();
        } else {
            $years = [];
        }

        return view('pages.home', compact('units', 'years'));
    }

    public function productYearlyReport(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $db = $request->input('nama_db', '');
        // Fetch your sales data from the database
        $yearlySales =  DB::select("
                SELECT 
                    inv.group_nama,
                    SUM(i.item_qty2/1000) AS total_qty,
                    SUM(i.item_price * m.do_curr_rate * i.item_qty2) AS total_rp
                FROM 
                    {$db}.tr_do_master m
                INNER JOIN 
                    {$db}.tr_do_item i ON m.row_id = i.master_id
                INNER JOIN 
                    db_accounting.tbl_inventori inv ON i.item_id = inv.id_inv
                WHERE 
                    YEAR(m.do_date) = ?
                GROUP BY 
                    inv.group_nama
            ", [$year]);

        return response()->json($yearlySales);
    }

    public function productMonthlyReport(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $db = $request->input('nama_db', '');
        // Fetch your sales data from the database
        $yearlySales =  DB::select("
                SELECT  MONTH(m.do_date) AS bulan,
                    SUM(IF(inv.group_nama = 'TEH CTC', i.item_qty2/1000,0)) AS qty_ctc,
                    SUM(IF(inv.group_nama = 'TEH CTC', i.item_price * m.do_curr_rate *  i.item_qty2,0)) AS rp_ctc,
                    SUM(IF(inv.group_nama = 'TEH HITAM', i.item_qty2/1000,0)) AS qty_hitam,
                    SUM(IF(inv.group_nama = 'TEH HITAM', i.item_price * m.do_curr_rate *  i.item_qty2,0)) AS rp_hitam,
                    SUM(IF(inv.group_nama = 'TEH HIJAU', i.item_qty2/1000,0)) AS qty_hijau,
                    SUM(IF(inv.group_nama = 'TEH HIJAU', i.item_price * m.do_curr_rate *  i.item_qty2,0)) AS rp_hijau,
                    SUM(IF(inv.group_nama = 'TEH JEPANG', i.item_qty2/1000,0)) AS qty_jp,
                    SUM(IF(inv.group_nama = 'TEH JEPANG', i.item_price * m.do_curr_rate *  i.item_qty2,0)) AS rp_jp,
                    SUM(i.item_qty2/1000) AS qty_total,
                    SUM(i.item_price * m.do_curr_rate *  i.item_qty2) AS rp_total
                FROM {$db}.tr_do_master m
                    INNER JOIN {$db}.tr_do_item i ON m.row_id = i.master_id
                    INNER JOIN db_accounting.tbl_inventori inv ON i.item_id = inv.id_inv
                WHERE YEAR(m.do_date)= ?
                GROUP BY MONTH(m.do_date);
            ", [$year]);

        return response()->json($yearlySales);
    }
}
