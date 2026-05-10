<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Billing;
use App\Http\Controllers\Controller;
use App\Repositories\BillingRepository;

use DateTime;

class BillingController extends Controller
{
    protected $repoBilling;

    public function __construct(BillingRepository $repoBilling) {
        $this->repoBilling = $repoBilling;
    }

    public function index(Request $request) {
        if (session('role') != 1 && session('role') != 3) {
            return redirect()->route('login');
        }

        $now = new DateTime();
        $endDateTime = clone $now;
        $range = $request->input('range');

        if ($range === null || $range === '') {
            //Año en curso
            $start = (new DateTime('first day of January this year'))->setTime(0, 0, 0);
        } else if ($range == '1') {
            //Mes actual
            $start = (new DateTime('first day of this month'))->setTime(0, 0, 0);
        } else if ($range == '3') {
            //Últimos 3
            $start = (clone $now)->modify('-3 months')->setTime(0, 0, 0);
        } else if ($range == '6') {
            //Últimos 6
            $start = (clone $now)->modify('-6 months')->setTime(0, 0, 0);
        } else if ($range == '12') {
            //Últimos 12
            $start = (clone $now)->modify('-12 months')->setTime(0, 0, 0);
        } else {
            throw new Exception("Rango no válido");
        }

        $sort = $request->input('sort', 'desc');

        $startDate = $start->format('Y-m-d H:i:s');
        $endDate = $endDateTime->format('Y-m-d H:i:s');

        $income = $this->repoBilling->getIncome($startDate, $endDate);
        $expenses = $this->repoBilling->getExpenses($startDate, $endDate);
        $movements = $this->repoBilling->getMovements($startDate, $endDate, $sort);

        $iva = ($income['incomeTotal'] - $expenses['maintenanceExpenses']) * 0.21;
        $benefit = $income['incomeTotal'] - $expenses['maintenanceExpenses'] - $iva;

        $monthly = $this->repoBilling->getMonthlyBilling($startDate, $endDate);
        $chartData = $this->buildChartData($monthly);

        if ($request->ajax()) {
            return response()->json([
                    'html' => view('billing.partialBilling', ['income' => $income,'expenses' => $expenses,'iva' => $iva,'benefit' => $benefit, 'movements'=> $movements])->render(),
                    'chartData' => $chartData
            ]);
        }

        return view('billing.index', ['income' => $income, 'expenses' => $expenses,  'iva' => $iva, 'benefit' => $benefit, 'movements' => $movements, 'chartData'=> $chartData]);
    }

    private function buildChartData(array $monthly): array {
        $months = [];
        $incomeByMonth = [];
        $expensesByMonth = [];

        foreach ($monthly as $row) {
            $month = $row['month'];
            $amount = (float) $row['income'];

            if (!isset($months[$month])) {
                $months[$month] = ['income' => 0, 'expenses' => 0];
            }

            if ($amount >= 0) {
                $months[$month]['income'] += $amount;
            } else {
                $months[$month]['expenses'] += abs($amount);
            }
        }

        return ['labels' => array_keys($months),'income' => array_column($months, 'income'), 'expenses' => array_column($months, 'expenses')];
    }
}