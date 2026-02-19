<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleModel extends Model
{
    protected $table            = 'sales';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'invoice_number', 'user_id', 'customer_name',
        'total_amount', 'discount', 'grand_total',
        'payment_method', 'status', 'note',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getTotalSalesToday(): float
    {
        $today = date('Y-m-d');

        return (float) $this->selectSum('grand_total')
            ->where('DATE(created_at)', $today)
            ->where('status', 'selesai')
            ->get()
            ->getRow()
            ->grand_total ?? 0;
    }

    public function getTotalSalesThisMonth(): float
    {
        $year  = date('Y');
        $month = date('m');

        return (float) $this->selectSum('grand_total')
            ->where('YEAR(created_at)', $year)
            ->where('MONTH(created_at)', $month)
            ->where('status', 'selesai')
            ->get()
            ->getRow()
            ->grand_total ?? 0;
    }

    public function getCountToday(): int
    {
        $today = date('Y-m-d');

        return $this->where('DATE(created_at)', $today)
            ->where('status', 'selesai')
            ->countAllResults();
    }

    public function getRecentSales(int $limit = 10): array
    {
        return $this->select('sales.*, users.name as cashier_name')
            ->join('users', 'users.id = sales.user_id', 'left')
            ->orderBy('sales.created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    public function getSalesChartData(int $days = 7): array
    {
        $db = \Config\Database::connect();

        return $db->query("
            SELECT DATE(created_at) as date, SUM(grand_total) as total
            FROM sales
            WHERE status = 'selesai'
              AND created_at >= DATE_SUB(NOW(), INTERVAL {$days} DAY)
            GROUP BY DATE(created_at)
            ORDER BY date ASC
        ")->getResultArray();
    }

    public function generateInvoiceNumber(): string
    {
        $prefix = 'INV-' . date('Ymd') . '-';
        $last   = $this->like('invoice_number', $prefix, 'after')
            ->orderBy('id', 'DESC')
            ->first();

        $number = 1;
        if ($last) {
            $parts  = explode('-', $last['invoice_number']);
            $number = (int) end($parts) + 1;
        }

        return $prefix . str_pad((string) $number, 4, '0', STR_PAD_LEFT);
    }
}
