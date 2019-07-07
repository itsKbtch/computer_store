<?php

namespace App\Http\Controllers\Admin;

use App\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = new Invoice;

        if (isset($_GET['filters'])) {
            foreach ($_GET['filters'] as $filter) {
                if ($filter == 'success') {
                    $invoices = $invoices->where('status', 1);
                }
                if ($filter == 'canceled') {
                    $invoices = $invoices->where('status', 2);
                }
                if ($filter == 'waiting') {
                    $invoices = $invoices->where('status', 0);
                }
                if ($filter == 'confirmed') {
                    $invoices = $invoices->where('status', 3);
                }
            }
        }

        if (isset($_GET['keyword'])) {
            $invoices = $invoices->where(function($query) {
                $query->where('id', $_GET['keyword'])->orWhere('name', 'like', '%'.$_GET['keyword'].'%')->orWhere('phone_number', 'like', '%'.$_GET['keyword'].'%');
            });
        }

        if (isset($_GET['sort'])) {
            if ($_GET['sort'] == 'new') {
                $invoices = $invoices->orderBy('created_at', 'desc');
            };
            if ($_GET['sort'] == 'old') {
                $invoices = $invoices->orderBy('created_at', 'asc');
            };
            if ($_GET['sort'] == 'total-desc') {
                $invoices = $invoices->orderBy('total_with_discount', 'desc');
            };
            if ($_GET['sort'] == 'total-asc') {
                $invoices = $invoices->orderBy('total_with_discount', 'asc');
            };
        } else {
            $invoices = $invoices->orderBy('created_at', 'desc');
        }

        $invoices = $invoices->paginate(10)->appends($_GET);

        return view('admin.invoice.index', ['invoices' => $invoices]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice, $id)
    {
        $invoice = $invoice->with('items')->findOrFail($id);

        return view('admin.invoice.details', ['invoice' => $invoice]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    public function change_status(Request $request, Invoice $invoice, $id)
    {
        $request->validate([
            'status' => 'required|integer|in:0,1,2,3'
        ]);

        $invoice = $invoice->with('items')->findOrFail($id);

        if ($invoice->status != 1) {
            $invoice->status = $request->status;

            if ($invoice->status == 1) {
                foreach ($invoice->items as $item) {
                    $item->in_stock = $item->in_stock - $item->pivot->quantity;

                    if ($item->in_stock < 0) {
                        return back()->with('fail', 'Sửa status thất bại. Không đủ sản phẩm trong kho hàng.');
                    }

                    $item->save();
                }
            }

            $check = $invoice->save();

            if ($check) {
                return back()->with('success', 'Sửa status thành công');
            } 

            return back()->with('fail', 'Sửa status thất bại');
        }

        return back()->with('fail', 'Không thể thay đổi status của đơn hàng đã thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice, $id)
    {
        $invoice = $invoice->findOrFail($id);

        $invoice->items()->detach();

        $check = $invoice->delete();

        if ($check) {
            return response()->json([
                'status' => 'success'
            ]);
        } 

        return response()->json([
            'status' => 'fail'
        ]);
    }

    public function destroyMany(Invoice $invoices, Request $request)
    {
        $invoices = $invoices->whereIn('id', $request->id);

        foreach ($invoices->get() as $invoice) {
            $invoice->items()->detach();
        }

        $check = $invoices->delete();

        if ($check) {
            return response()->json([
                'status' => 'success'
            ]);
        } 

        return response()->json([
            'status' => 'fail'
        ]);
    }
}
