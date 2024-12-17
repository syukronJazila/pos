<?php

namespace Modules\People\Http\Controllers;

use Modules\People\DataTables\CustomersDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\People\Entities\Customer;

class CustomersController extends Controller
{

    public function index(CustomersDataTable $dataTable) {
        abort_if(Gate::denies('access_customers'), 403);

        return $dataTable->render('people::customers.index');
    }


    public function create() {
        abort_if(Gate::denies('create_customers'), 403);

        return view('people::customers.create');
    }


    public function store(Request $request) {
        abort_if(Gate::denies('create_customers'), 403);

        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_phone' => 'required|max:255',
            'customer_email' => 'nullable|email|max:255', // Email menjadi optional
            'city'           => 'nullable|string|max:255', // City menjadi optional
            'country'        => 'nullable|string|max:255', // Country menjadi optional
            'address'        => 'nullable|string|max:500', // Address menjadi optional
        ]);

        Customer::create([
            'customer_name'  => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email ?? 'N/A',
            'city'           => $request->city ?? 'N/A',
            'country'        => $request->country ?? 'N/A',
            'address'        => $request->address ?? 'N/A',
        ]);

        toast('Customer Created!', 'success');

        return redirect()->route('customers.index');
    }


    public function show(Customer $customer) {
        abort_if(Gate::denies('show_customers'), 403);

        return view('people::customers.show', compact('customer'));
    }


    public function edit(Customer $customer) {
        abort_if(Gate::denies('edit_customers'), 403);

        return view('people::customers.edit', compact('customer'));
    }


    public function update(Request $request, Customer $customer) {
        abort_if(Gate::denies('update_customers'), 403);

        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_phone' => 'required|max:255',
            'customer_email' => 'nullable|email|max:255', // Email menjadi optional
            'city'           => 'nullable|string|max:255', // City menjadi optional
            'country'        => 'nullable|string|max:255', // Country menjadi optional
            'address'        => 'nullable|string|max:500', // Address menjadi optional
        ]);

        Customer::create([
            'customer_name'  => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email ?? 'N/A',
            'city'           => $request->city ?? 'N/A',
            'country'        => $request->country ?? 'N/A',
            'address'        => $request->address ?? 'N/A',
        ]);

        toast('Customer Updated!', 'info');

        return redirect()->route('customers.index');
    }


    public function destroy(Customer $customer) {
        abort_if(Gate::denies('delete_customers'), 403);

        $customer->delete();

        toast('Customer Deleted!', 'warning');

        return redirect()->route('customers.index');
    }
}
