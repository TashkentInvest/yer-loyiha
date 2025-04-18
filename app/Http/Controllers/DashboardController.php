<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Artisan;
use App\Models\Aktiv;
use App\Models\User;
use App\Models\Street;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        // Кириш ҳуқуқини текшириш
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Вақт оралиғини аниқлаш (охирги 30 кун бўйича)
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        // Асосий статистика маълумотларини олиш
        $totalAktivs = Aktiv::count();
        $totalUsers = User::count();
        $totalComments = 0;



        // Ер майдони бўйича статистика (гектарларда)
        $landAreaStats = [
            '0-0.1' => Aktiv::where('land_area', '<=', 0.1)->count(),
            '0.1-1' => Aktiv::whereBetween('land_area', [0.1, 1])->count(),
            '1-10' => Aktiv::whereBetween('land_area', [1, 10])->count(),
            '10+' => Aktiv::where('land_area', '>', 10)->count(),
        ];

        // Умумий ер майдони (гектарларда)
        $totalLandArea = Aktiv::sum('land_area');

        // Умумий бино майдони (кв.м.)
        $totalBuildingArea = Aktiv::sum('building_area');

        // Аукцион ҳолати бўйича статистика
        $auctionStatusStats = Aktiv::select('auction_status', DB::raw('count(*) as total'))
            ->groupBy('auction_status')
            ->get()
            ->mapWithKeys(function ($item) {
                $label = $item->auction_status ?: 'Номаълум';
                return [$label => $item->total];
            });

        // Коммуникациялар бўйича статистика
        $utilitiesStats = [
            'Газ таъминоти' => [
                'Мавжуд' => Aktiv::where('gas', 'Yes')->count(),
                'Мавжуд эмас' => Aktiv::where('gas', '!=', 'Yes')->count(),
            ],
            'Сув таъминоти' => [
                'Мавжуд' => Aktiv::where('water', 'Yes')->count(),
                'Мавжуд эмас' => Aktiv::where('water', '!=', 'Yes')->count(),
            ],
            'Электр таъминоти' => [
                'Мавжуд' => Aktiv::where('electricity', 'Yes')->count(),
                'Мавжуд эмас' => Aktiv::where('electricity', '!=', 'Yes')->count(),
            ],
        ];

        // Янги қўшилган объектлар (охирги 30 кун)
        $recentActivities = Aktiv::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Ойлик ҳисобот (охирги 12 ой)
        $monthlyStats = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthLabel = $month->format('M Y');
            $monthStats = Aktiv::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            $monthlyStats[$monthLabel] = $monthStats;
        }

        // Инвестиция суммаси бўйича статистика
        $totalInvestmentAmount = Aktiv::sum('investment_amount');
        $avgInvestmentAmount = $totalAktivs > 0 ? $totalInvestmentAmount / $totalAktivs : 0;

        // Иш ўринлари бўйича статистика
        $totalJobCreation = Aktiv::sum('job_creation_count');
        $avgJobCreation = $totalAktivs > 0 ? $totalJobCreation / $totalAktivs : 0;

        // Кўп учрайдиган зоналар (топ-5)
        $topZones = Aktiv::select('zone', DB::raw('count(*) as total'))
            ->whereNotNull('zone')
            ->where('zone', '!=', '')
            ->groupBy('zone')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // Туман ва кўчалар бўйича статистика
        $streetStats = Street::withCount('aktivs')
            ->orderByDesc('aktivs_count')
            ->take(10)
            ->get();

        // Ўтган йил билан солиштириш
        $thisYearAktivs = Aktiv::whereYear('created_at', Carbon::now()->year)->count();
        $lastYearAktivs = Aktiv::whereYear('created_at', Carbon::now()->subYear()->year)->count();
        $aktivsGrowth = $lastYearAktivs > 0 ? (($thisYearAktivs - $lastYearAktivs) / $lastYearAktivs * 100) : 100;

        // View га маълумотларни юбориш
        return view('pages.dashboard', compact(
            'totalAktivs',
            'totalUsers',
            'totalComments',
            'landAreaStats',
            'totalLandArea',
            'totalBuildingArea',
            'auctionStatusStats',
            'utilitiesStats',
            'recentActivities',
            'monthlyStats',
            'totalInvestmentAmount',
            'avgInvestmentAmount',
            'totalJobCreation',
            'avgJobCreation',
            'topZones',
            'streetStats',
            'thisYearAktivs',
            'lastYearAktivs',
            'aktivsGrowth',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Бино турини ўзбек тилига таржима қилиш учун
     *
     * @param string $type
     * @return string
     */

}
