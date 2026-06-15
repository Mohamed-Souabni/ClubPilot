<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use App\Models\BudgetTransaction;

class BudgetTransactionController extends Controller
{
    public function index(Request $request, Club $club)
    {
        abort_unless($request->user()->canManageBudget($club), 403);

        $transactions = $club->budgetTransactions()
            ->latest('transaction_date')
            ->get();

        $totalIncome = $club->budgetTransactions()
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = $club->budgetTransactions()
            ->where('type', 'expense')
            ->sum('amount');

        $balance = $totalIncome - $totalExpense;

        return view('budget.index', compact(
            'club',
            'transactions',
            'totalIncome',
            'totalExpense',
            'balance'
        ));
    }

    public function create(Request $request, Club $club)
    {
        abort_unless($request->user()->canManageBudget($club), 403);

        return view('budget.create', compact('club'));
    }

    public function store(Request $request, Club $club)
    {
        abort_unless($request->user()->canManageBudget($club), 403);

        $data = $request->validate([
            'type' => ['required', 'in:income,expense'],
            'category' => ['required', 'in:event,material,sponsorship,transport,other'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'description' => ['nullable', 'string'],
            'transaction_date' => ['required', 'date'],
        ]);

        $club->budgetTransactions()->create([
            'created_by' => $request->user()->id,
            'type' => $data['type'],
            'category' => $data['category'],
            'amount' => $data['amount'],
            'description' => $data['description'] ?? null,
            'transaction_date' => $data['transaction_date'],
        ]);

        return redirect()
            ->route('clubs.budget.index', $club)
            ->with('success', 'Transaction budgetaire ajoutee.');
    }

    
public function edit(Request $request, Club $club, BudgetTransaction $budgetTransaction)
{
    abort_unless($request->user()->canManageBudget($club), 403);
    abort_unless($budgetTransaction->club_id === $club->id, 404);

    return view('budget.edit', compact('club', 'budgetTransaction'));
}

public function update(Request $request, Club $club, BudgetTransaction $budgetTransaction)
{
    abort_unless($request->user()->canManageBudget($club), 403);
    abort_unless($budgetTransaction->club_id === $club->id, 404);

    $data = $request->validate([
        'type' => ['required', 'in:income,expense'],
        'category' => ['required', 'in:event,material,sponsorship,transport,other'],
        'amount' => ['required', 'numeric', 'min:0.01'],
        'description' => ['nullable', 'string'],
        'transaction_date' => ['required', 'date'],
    ]);

    $budgetTransaction->update($data);

    return redirect()
        ->route('clubs.budget.index', $club)
        ->with('success', 'Transaction mise a jour avec succes.');
}

public function destroy(Request $request, Club $club, BudgetTransaction $budgetTransaction)
{
    abort_unless($request->user()->canManageBudget($club), 403);
    abort_unless($budgetTransaction->club_id === $club->id, 404);

    $budgetTransaction->delete();

    return redirect()
        ->route('clubs.budget.index', $club)
        ->with('success', 'Transaction supprimee avec succes.');
}
    
}